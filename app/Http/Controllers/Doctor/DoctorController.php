<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentApprovedMail;
use App\Mail\AppointmentRejectedMail;
use App\Models\Appointment;
use App\Models\Availability;
use App\Models\DoctorHospitalImage;
use App\Models\DoctorProfile;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:doctor']);
    }

    // ===================== DASHBOARD =====================
    public function dashboard()
    {
        $doctor = Auth::user();

        $appointments = Appointment::with(['patient'])
            ->where('doctor_id', $doctor->id)
            ->orderBy('appointment_date')
            ->orderByRaw("COALESCE(start_time, '00:00:00')")
            ->paginate(10);

        $stats = [
            'total'     => Appointment::where('doctor_id', $doctor->id)->count(),
            'pending'   => Appointment::where('doctor_id', $doctor->id)->where('status', 'PENDING')->count(),
            'approved'  => Appointment::where('doctor_id', $doctor->id)->whereIn('status', ['CONFIRMED', 'approved'])->count(),
            'completed' => Appointment::where('doctor_id', $doctor->id)->where('status', 'COMPLETED')->count(),
            'today'     => Appointment::where('doctor_id', $doctor->id)
                            ->where('appointment_date', today())
                            ->whereIn('status', ['CONFIRMED', 'PENDING'])
                            ->count(),
        ];

        // Extra booking requests waiting for doctor approval
        $extraRequests = Appointment::with(['patient'])
            ->where('doctor_id', $doctor->id)
            ->where('is_extra_request', true)
            ->where('status', 'PENDING')
            ->orderBy('appointment_date')
            ->get();

        return view('doctor.dashboard', compact('appointments', 'stats', 'doctor', 'extraRequests'));
    }

    // ===================== PROFILE =====================
    public function profile()
    {
        $doctor = Auth::user();
        $profile = DoctorProfile::where('user_id', $doctor->id)->first();
        $specializations = \App\Helpers\AppHelper::specializations();
        $hospitalImages = DoctorHospitalImage::where('doctor_id', $doctor->id)->get();

        return view('doctor.profile', compact('doctor', 'profile', 'specializations', 'hospitalImages'));
    }

    public function updateProfile(Request $request)
    {
        $doctor = Auth::user();

        $data = $request->validate([
            'phone'                => ['nullable', 'string', 'max:20'],
            'specialization'       => ['nullable', 'string'],
            'bio'                  => ['nullable', 'string'],
            'experience'           => ['nullable', 'integer', 'min:0', 'max:60'],
            'consultation_fee'     => ['nullable', 'numeric', 'min:0'],
            'city'                 => ['nullable', 'string', 'max:100'],
            'clinic_name'          => ['nullable', 'string', 'max:200'],
            'clinic_address'       => ['nullable', 'string', 'max:500'],
            'qualifications'       => ['nullable', 'string'],
            'booking_type'         => ['required', 'in:time,token'],
            'max_tokens'           => ['nullable', 'integer', 'min:1', 'max:500'],
            'max_patients_per_day' => ['nullable', 'integer', 'min:1', 'max:500'],
            'allow_next_day'       => ['nullable', 'boolean'],
            'doctor_image'         => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'hospital_images'      => ['nullable', 'array'],
            'hospital_images.*'    => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // Parse qualifications
        if (!empty($data['qualifications'])) {
            $data['qualifications'] = array_values(array_filter(
                array_map('trim', explode(',', $data['qualifications']))
            ));
        } else {
            $data['qualifications'] = null;
        }

        if ($data['booking_type'] === 'token' && empty($data['max_tokens'])) {
            return back()->withErrors(['max_tokens' => 'Max tokens per day is required for token booking.'])->withInput();
        }

        // Handle doctor image upload
        $profileData = array_intersect_key($data, array_flip([
            'specialization', 'bio', 'experience', 'consultation_fee',
            'city', 'clinic_name', 'clinic_address', 'qualifications',
            'booking_type', 'max_tokens', 'max_patients_per_day',
        ]));
        $profileData['allow_next_day'] = $request->boolean('allow_next_day', true);

        if ($request->hasFile('doctor_image')) {
            $existingProfile = DoctorProfile::where('user_id', $doctor->id)->first();
            // Delete old image if exists
            if ($existingProfile && $existingProfile->doctor_image) {
                Storage::disk('public')->delete($existingProfile->doctor_image);
            }
            $profileData['doctor_image'] = $request->file('doctor_image')
                ->store('doctor-images', 'public');
        }

        // Update user phone
        $doctor->update(['phone' => $data['phone'] ?? null]);

        DoctorProfile::updateOrCreate(
            ['user_id' => $doctor->id],
            $profileData
        );

        // Handle hospital images
        if ($request->hasFile('hospital_images')) {
            foreach ($request->file('hospital_images') as $img) {
                $path = $img->store('hospital-images', 'public');
                DoctorHospitalImage::create([
                    'doctor_id'  => $doctor->id,
                    'image_path' => $path,
                ]);
            }
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function deleteHospitalImage(int $id)
    {
        $image = DoctorHospitalImage::where('doctor_id', Auth::id())->findOrFail($id);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return back()->with('success', 'Image deleted.');
    }

    // ===================== AVAILABILITY =====================
    public function availability()
    {
        $doctor = Auth::user();
        $days   = \App\Helpers\AppHelper::days();

        $availabilities = Availability::where('doctor_id', $doctor->id)
            ->get()
            ->keyBy('day_of_week');

        return view('doctor.availability', compact('days', 'availabilities'));
    }

    public function updateAvailability(Request $request)
    {
        $doctor = Auth::user();

        $request->validate([
            'days'                    => ['nullable', 'array'],
            'days.*'                  => ['in:MONDAY,TUESDAY,WEDNESDAY,THURSDAY,FRIDAY,SATURDAY,SUNDAY'],
            'start_time'              => ['nullable', 'array'],
            'end_time'                => ['nullable', 'array'],
            'slot_duration_minutes'   => ['required', 'integer', 'in:15,20,30,45,60'],
        ]);

        $selectedDays = $request->input('days', []);
        $startTimes   = $request->input('start_time', []);
        $endTimes     = $request->input('end_time', []);
        $slotDuration = (int) $request->input('slot_duration_minutes', 30);

        Availability::where('doctor_id', $doctor->id)
            ->whereNotIn('day_of_week', $selectedDays)
            ->delete();

        foreach ($selectedDays as $day) {
            $start = $startTimes[$day] ?? '09:00';
            $end   = $endTimes[$day]   ?? '17:00';
            if ($start >= $end) continue;

            Availability::updateOrCreate(
                ['doctor_id' => $doctor->id, 'day_of_week' => $day],
                ['start_time' => $start, 'end_time' => $end, 'slot_duration_minutes' => $slotDuration]
            );
        }

        return back()->with('success', 'Availability saved.');
    }

    public function generateSlots(Request $request)
    {
        $doctor = Auth::user();

        $request->validate([
            'generate_date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $date      = $request->generate_date;
        $dayOfWeek = strtoupper(\Carbon\Carbon::parse($date)->format('l'));

        $avail = Availability::where('doctor_id', $doctor->id)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        if (!$avail) {
            return back()->withErrors(['generate_date' => 'You have no availability set for that day.']);
        }

        Slot::where('doctor_id', $doctor->id)
            ->where('date', $date)
            ->where('is_available', true)
            ->delete();

        $current = \Carbon\Carbon::createFromFormat('H:i', substr($avail->start_time, 0, 5));
        $end     = \Carbon\Carbon::createFromFormat('H:i', substr($avail->end_time, 0, 5));

        $count = 0;
        while ($current->copy()->addMinutes($avail->slot_duration_minutes)->lte($end)) {
            $slotEnd = $current->copy()->addMinutes($avail->slot_duration_minutes);
            Slot::create([
                'doctor_id'    => $doctor->id,
                'date'         => $date,
                'start_time'   => $current->format('H:i:s'),
                'end_time'     => $slotEnd->format('H:i:s'),
                'is_available' => true,
            ]);
            $current->addMinutes($avail->slot_duration_minutes);
            $count++;
        }

        return back()->with('success', "{$count} slots generated for " . \Carbon\Carbon::parse($date)->format('M d, Y') . '.');
    }

    // ===================== APPOINTMENTS =====================
    public function appointments(Request $request)
    {
        $doctor   = Auth::user();
        $statuses = ['ALL', 'PENDING', 'CONFIRMED', 'COMPLETED', 'CANCELLED'];

        $query = Appointment::with(['patient'])
            ->where('doctor_id', $doctor->id);

        if ($request->filled('status') && $request->status !== 'ALL') {
            $query->where('status', $request->status);
        }

        // Separate filter for extra requests
        if ($request->filled('extra') && $request->extra == '1') {
            $query->where('is_extra_request', true)->where('status', 'PENDING');
        }

        $appointments = $query->orderByDesc('appointment_date')->paginate(15)->withQueryString();

        return view('doctor.appointments', compact('appointments', 'statuses'));
    }

    public function showAppointment(int $id)
    {
        $appointment = Appointment::with(['patient'])
            ->where('doctor_id', Auth::id())
            ->findOrFail($id);

        return view('doctor.appointment-detail', compact('appointment'));
    }

    public function approveAppointment(int $id)
    {
        $doctor = Auth::user();
        $profile = $doctor->doctorProfile;

        $appointment = Appointment::with(['patient', 'doctor'])
            ->where('doctor_id', Auth::id())
            ->where('status', 'PENDING')
            ->findOrFail($id);

        DB::transaction(function () use ($appointment, $doctor, $profile) {
            // If it's an extra request, assign next token
            if ($appointment->is_extra_request && $appointment->token_number === null) {
                $nextToken = Appointment::where('doctor_id', $doctor->id)
                    ->where('appointment_date', $appointment->appointment_date->format('Y-m-d'))
                    ->whereNotNull('token_number')
                    ->lockForUpdate()
                    ->max('token_number');

                $appointment->token_number = ($nextToken ?? 0) + 1;
            }

            $appointment->status      = 'CONFIRMED';
            $appointment->approved_at = now();
            $appointment->save();
        });

        // Load fresh for email
        $appointment->load(['patient', 'doctor']);

        try {
            Mail::to($appointment->patient->email)
                ->send(new AppointmentApprovedMail($appointment));
        } catch (\Throwable $e) {
            Log::error('Approve mail failed', ['apt' => $id, 'err' => $e->getMessage()]);
        }

        return back()->with('success', 'Appointment confirmed and patient notified.');
    }

    public function rejectAppointment(Request $request, int $id)
    {
        $appointment = Appointment::with(['patient', 'doctor'])
            ->where('doctor_id', Auth::id())
            ->findOrFail($id);

        // BUG FIX: was update(['status', 'CANCELLED']) — wrong syntax
        $appointment->update(['status' => 'CANCELLED']);

        // Free the slot if time-based
        if ($appointment->slot_id) {
            Slot::where('id', $appointment->slot_id)->update(['is_available' => true]);
        }

        try {
            Mail::to($appointment->patient->email)
                ->send(new AppointmentRejectedMail($appointment));
        } catch (\Throwable $e) {
            Log::error('Reject mail failed', ['apt' => $id, 'err' => $e->getMessage()]);
        }

        return back()->with('success', 'Appointment rejected and patient notified.');
    }

    public function completeAppointment(int $id)
    {
        $appointment = Appointment::where('doctor_id', Auth::id())
            ->findOrFail($id);

        $appointment->update(['status' => 'COMPLETED']);

        return back()->with('success', 'Appointment marked as completed.');
    }

    // ===================== SETTINGS =====================
    public function settings()
    {
        $doctor  = Auth::user();
        $profile = DoctorProfile::where('user_id', $doctor->id)->first();

        return view('doctor.settings', compact('doctor', 'profile'));
    }

    public function updateSettings(Request $request)
    {
        $doctor  = Auth::user();
        $profile = DoctorProfile::where('user_id', $doctor->id)->firstOrCreate(['user_id' => $doctor->id]);

        $data = $request->validate([
            'max_patients_per_day' => ['required', 'integer', 'min:1', 'max:500'],
            'allow_next_day'       => ['nullable', 'boolean'],
        ]);

        $profile->update([
            'max_patients_per_day' => $data['max_patients_per_day'],
            'allow_next_day'       => $request->boolean('allow_next_day', true),
        ]);

        return back()->with('success', 'Settings updated.');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully.');
    }
}
