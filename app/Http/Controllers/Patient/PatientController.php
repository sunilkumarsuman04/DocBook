<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorHospitalImage;
use App\Models\Review;
use App\Models\Slot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /* ── Dashboard ─────────────────────────────────────────────── */
    public function dashboard()
    {
        $user = Auth::user()->load('patientProfile');

        $appointments = Appointment::with(['doctor.doctorProfile'])
            ->where('patient_id', $user->id)
            ->orderByDesc('appointment_date')
            ->limit(5)
            ->get();

        $stats = [
            'total'     => Appointment::where('patient_id', $user->id)->count(),
            'upcoming'  => Appointment::where('patient_id', $user->id)
                            ->whereIn('status', ['PENDING', 'CONFIRMED'])->count(),
            'completed' => Appointment::where('patient_id', $user->id)
                            ->where('status', 'COMPLETED')->count(),
        ];

        return view('patient.dashboard', compact('appointments', 'stats', 'user'));
    }

    /* ── Search Doctors ─────────────────────────────────────────── */
    public function searchDoctors(Request $request)
    {
        $query = User::where('role', 'doctor')
            ->whereHas('doctorProfile', fn($q) => $q->where('approval_status', 'APPROVED'))
            ->with('doctorProfile');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('specialization')) {
            $query->whereHas('doctorProfile', fn($q) =>
                $q->where('specialization', $request->specialization));
        }
        if ($request->filled('city')) {
            $query->whereHas('doctorProfile', fn($q) =>
                $q->where('city', 'like', '%' . $request->city . '%'));
        }

        $doctors         = $query->paginate(9)->withQueryString();
        $specializations = \App\Helpers\AppHelper::specializations();

        return view('patient.search', compact('doctors', 'specializations'));
    }

    /* ── Doctor Profile + Slots ─────────────────────────────────── */
    public function viewDoctor(Request $request, User $doctor)
    {
        abort_if(strtolower($doctor->role) !== 'doctor', 404);

        $doctor->load(['doctorProfile', 'availabilities']);

        $reviews = Review::with('patient')
            ->where('doctor_id', $doctor->id)
            ->latest()
            ->limit(10)
            ->get();

        $profile     = $doctor->doctorProfile;
        $bookingType = $profile?->booking_type ?? 'time';
        $allowNextDay = $profile?->allow_next_day ?? true;
        $maxDays     = $allowNextDay ? 7 : 1;

        $selectedDate = $request->get('date', now()->format('Y-m-d'));
        $dates        = collect(range(0, $maxDays - 1))->map(fn($i) => now()->addDays($i)->format('Y-m-d'));

        // If next day is disabled and selected date is future, reset to today
        if (!$allowNextDay && $selectedDate !== now()->format('Y-m-d')) {
            $selectedDate = now()->format('Y-m-d');
        }

        $maxTokens    = $profile?->effectiveDailyLimit() ?? 30;
        $slots        = collect();
        $tokenCount   = null;

        if ($bookingType === 'time') {
            $slots = Slot::where('doctor_id', $doctor->id)
                ->where('date', $selectedDate)
                ->where('is_available', true)
                ->orderBy('start_time')
                ->get();
        } else {
            $tokenCount = Appointment::where('doctor_id', $doctor->id)
                ->where('appointment_date', $selectedDate)
                ->whereNotNull('token_number')
                ->whereNotIn('status', ['CANCELLED'])
                ->count();
        }

        // Hospital images
        $hospitalImages = DoctorHospitalImage::where('doctor_id', $doctor->id)->get();

        return view('patient.doctor-profile', compact(
            'doctor', 'reviews', 'slots', 'selectedDate', 'dates',
            'bookingType', 'tokenCount', 'maxTokens', 'allowNextDay', 'hospitalImages'
        ));
    }

    /* ── Book Appointment ───────────────────────────────────────── */
    public function bookAppointment(Request $request, User $doctor)
    {
        abort_if(strtolower($doctor->role) !== 'doctor', 404);

        $profile     = $doctor->doctorProfile;
        $bookingType = $profile?->booking_type ?? 'time';

        if ($bookingType === 'time') {
            return $this->bookTimeSlot($request, $doctor);
        } else {
            return $this->bookToken($request, $doctor);
        }
    }

    private function bookTimeSlot(Request $request, User $doctor)
    {
        $data = $request->validate([
            'slot_id' => 'required|exists:slots,id',
            'notes'   => 'nullable|string|max:1000',
        ]);

        $slot = Slot::findOrFail($data['slot_id']);

        if (!$slot->is_available || $slot->doctor_id !== $doctor->id) {
            return back()->withErrors(['slot_id' => 'This slot is no longer available.']);
        }

        try {
            DB::transaction(function () use ($slot, $doctor, $data) {
                $slot = Slot::lockForUpdate()->findOrFail($slot->id);

                if (!$slot->is_available) {
                    throw new \Exception('Slot taken');
                }

                Appointment::create([
                    'patient_id'       => Auth::id(),
                    'doctor_id'        => $doctor->id,
                    'slot_id'          => $slot->id,
                    'appointment_date' => $slot->date,
                    'start_time'       => $slot->start_time,
                    'end_time'         => $slot->end_time,
                    'status'           => 'PENDING',
                    'notes'            => $data['notes'] ?? null,
                    'consultation_fee' => $doctor->doctorProfile?->consultation_fee ?? 0,
                    'token_number'     => null,
                    'is_extra_request' => false,
                ]);

                $slot->update(['is_available' => false]);
            });
        } catch (\Exception $e) {
            return back()->withErrors(['slot_id' => 'This slot was just taken. Please choose another.']);
        }

        return redirect('/patient/appointments')
            ->with('success', 'Appointment booked successfully!');
    }

    private function bookToken(Request $request, User $doctor)
    {
        $data = $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'notes'            => 'nullable|string|max:1000',
            'patient_note'     => 'nullable|string|max:1000',
            'request_extra'    => 'nullable|boolean',
        ]);

        $profile     = $doctor->doctorProfile;
        $date        = $data['appointment_date'];
        $maxTokens   = $profile?->effectiveDailyLimit() ?? 30;
        $allowNextDay = $profile?->allow_next_day ?? true;

        // Next day restriction
        if (!$allowNextDay && $date !== now()->format('Y-m-d')) {
            return back()->withErrors(['appointment_date' => 'This doctor only accepts bookings for today.']);
        }

        // Duplicate check
        $exists = Appointment::where('doctor_id', $doctor->id)
            ->where('patient_id', Auth::id())
            ->where('appointment_date', $date)
            ->whereNotIn('status', ['CANCELLED'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['appointment_date' => 'You already have a booking for this date with this doctor.']);
        }

        // Count existing confirmed/pending tokens for the date
        $currentCount = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', $date)
            ->whereNotNull('token_number')
            ->whereNotIn('status', ['CANCELLED'])
            ->count();

        $isExtra = $request->boolean('request_extra', false);

        // If limit NOT full — auto approve with token
        if ($currentCount < $maxTokens) {
            $tokenNumber = DB::transaction(function () use ($doctor, $date, $maxTokens, $data) {
                $locked = Appointment::where('doctor_id', $doctor->id)
                    ->where('appointment_date', $date)
                    ->whereNotNull('token_number')
                    ->whereNotIn('status', ['CANCELLED'])
                    ->lockForUpdate()
                    ->count();

                if ($locked >= $maxTokens) {
                    throw new \Exception('FULL');
                }

                $nextToken = Appointment::where('doctor_id', $doctor->id)
                    ->where('appointment_date', $date)
                    ->whereNotNull('token_number')
                    ->max('token_number');

                $token = ($nextToken ?? 0) + 1;

                Appointment::create([
                    'patient_id'       => Auth::id(),
                    'doctor_id'        => $doctor->id,
                    'slot_id'          => null,
                    'appointment_date' => $date,
                    'start_time'       => '00:00:00',
                    'end_time'         => '00:00:00',
                    'status'           => 'PENDING',
                    'notes'            => $data['notes'] ?? null,
                    'consultation_fee' => $doctor->doctorProfile?->consultation_fee ?? 0,
                    'token_number'     => $token,
                    'is_extra_request' => false,
                    'patient_note'     => null,
                ]);

                return $token;
            });

            return redirect('/patient/appointments')
                ->with('success', "Token #{$tokenNumber} booked for " . Carbon::parse($date)->format('M d, Y') . '!');
        }

        // Limit is full — check if patient explicitly requested extra
        if (!$isExtra) {
            // Show the limit full message; blade will show "request approval" button
            return back()->with('limit_full', true)->with('full_date', $date);
        }

        // Patient submitted extra request
        $patientNote = $request->input('patient_note') ?? $data['notes'] ?? null;

        Appointment::create([
            'patient_id'       => Auth::id(),
            'doctor_id'        => $doctor->id,
            'slot_id'          => null,
            'appointment_date' => $date,
            'start_time'       => '00:00:00',
            'end_time'         => '00:00:00',
            'status'           => 'PENDING',
            'notes'            => $data['notes'] ?? null,
            'consultation_fee' => $doctor->doctorProfile?->consultation_fee ?? 0,
            'token_number'     => null,
            'is_extra_request' => true,
            'patient_note'     => $patientNote,
        ]);

        return redirect('/patient/appointments')
            ->with('success', 'Your extra booking request has been submitted. You will be notified once the doctor reviews it.');
    }

    /* ── My Appointments ────────────────────────────────────────── */
    public function appointments(Request $request)
    {
        $query = Appointment::with(['doctor.doctorProfile'])
            ->where('patient_id', Auth::id())
            ->orderByDesc('appointment_date');

        if ($request->filled('status') && $request->status !== 'ALL') {
            $query->where('status', $request->status);
        }

        $appointments = $query->paginate(8)->withQueryString();
        $statuses     = ['ALL', 'PENDING', 'CONFIRMED', 'COMPLETED', 'CANCELLED'];

        return view('patient.appointments', compact('appointments', 'statuses'));
    }

    /* ── Cancel Appointment ─────────────────────────────────────── */
    public function cancelAppointment(Appointment $appointment)
    {
        abort_if($appointment->patient_id !== Auth::id(), 403);
        abort_if(!$appointment->canCancel(), 422);

        $appointment->update(['status' => 'CANCELLED']);

        if ($appointment->slot_id) {
            Slot::where('id', $appointment->slot_id)->update(['is_available' => true]);
        }

        return back()->with('success', 'Appointment cancelled.');
    }

    /* ── Payment ────────────────────────────────────────────────── */
    public function showPayment(Appointment $appointment)
    {
        abort_if($appointment->patient_id !== Auth::id(), 403);
        return view('patient.payment', compact('appointment'));
    }

    public function processPayment(Request $request, Appointment $appointment)
    {
        abort_if($appointment->patient_id !== Auth::id(), 403);
        $request->validate(['method' => 'required|in:CARD,UPI,NET_BANKING']);

        $appointment->update([
            'payment_status' => 'PAID',
            'payment_method' => $request->method,
        ]);

        return redirect('/patient/appointments')->with('success', 'Payment successful!');
    }

    /* ── Review ─────────────────────────────────────────────────── */
    public function showReview(Appointment $appointment)
    {
        abort_if($appointment->patient_id !== Auth::id(), 403);
        abort_if(!$appointment->canReview(), 422);
        return view('patient.review', compact('appointment'));
    }

    public function submitReview(Request $request, Appointment $appointment)
    {
        abort_if($appointment->patient_id !== Auth::id(), 403);
        abort_if(!$appointment->canReview(), 422);

        $data = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'appointment_id' => $appointment->id,
            'patient_id'     => Auth::id(),
            'doctor_id'      => $appointment->doctor_id,
            'rating'         => $data['rating'],
            'comment'        => $data['comment'],
        ]);

        $appointment->update(['is_reviewed' => true]);

        $doctorProfile = $appointment->doctor->doctorProfile;
        if ($doctorProfile) {
            $avg   = Review::where('doctor_id', $appointment->doctor_id)->avg('rating');
            $count = Review::where('doctor_id', $appointment->doctor_id)->count();
            $doctorProfile->update(['rating' => round($avg, 2), 'review_count' => $count]);
        }

        return redirect('/patient/appointments')->with('success', 'Review submitted!');
    }

    /* ── Profile ────────────────────────────────────────────────── */
    public function profile()
    {
        $user = Auth::user()->load('patientProfile');
        return view('patient.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'phone'         => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender'        => 'nullable|in:MALE,FEMALE,OTHER',
            'blood_group'   => 'nullable|string|max:5',
            'address'       => 'nullable|string|max:500',
        ]);

        $user->update(['name' => $data['name'], 'phone' => $data['phone'] ?? null]);

        $user->patientProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'gender'        => $data['gender']        ?? null,
                'blood_group'   => $data['blood_group']   ?? null,
                'address'       => $data['address']       ?? null,
            ]
        );

        return back()->with('success', 'Profile updated!');
    }
}
