<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /* ── Dashboard ──────────────────────────────────────────────── */
    public function dashboard()
    {
        $stats = [
            'total_users'     => User::where('role', '!=', 'admin')->count(),
            'total_patients'  => User::where('role', 'patient')->count(),
            'total_doctors'   => User::where('role', 'doctor')
                                ->whereHas('doctorProfile', fn($q) => $q->where('approval_status', 'APPROVED'))
                                ->count(),
            'pending_doctors' => DoctorProfile::where('approval_status', 'PENDING')->count(),
            'total_apts'      => Appointment::count(),
            'today_apts'      => Appointment::where('appointment_date', today())->count(),
        ];

        $pendingDoctors = User::where('role', 'doctor')
            ->whereHas('doctorProfile', fn($q) => $q->where('approval_status', 'PENDING'))
            ->with('doctorProfile')
            ->latest()
            ->limit(5)
            ->get();

        $recentApts = Appointment::with(['patient', 'doctor'])
            ->latest()
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingDoctors', 'recentApts'));
    }

    /* ── Doctors ────────────────────────────────────────────────── */
    public function doctors(Request $request)
    {
        $query = User::where('role', 'doctor')->with('doctorProfile');

        if ($request->filled('status') && $request->status !== 'ALL') {
            $query->whereHas('doctorProfile', fn($q) =>
                $q->where('approval_status', $request->status));
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $doctors  = $query->latest()->paginate(12)->withQueryString();
        $statuses = ['ALL', 'PENDING', 'APPROVED', 'REJECTED'];

        return view('admin.doctors', compact('doctors', 'statuses'));
    }

    public function approveDoctor(User $doctor)
    {
        abort_if(strtolower($doctor->role) !== 'doctor', 403);
        $doctor->doctorProfile()->update(['approval_status' => 'APPROVED', 'rejection_reason' => null]);
        return back()->with('success', "Dr. {$doctor->name} approved.");
    }

    public function rejectDoctor(Request $request, User $doctor)
    {
        abort_if(strtolower($doctor->role) !== 'doctor', 403);
        $request->validate(['reason' => 'required|string|max:500']);
        $doctor->doctorProfile()->update([
            'approval_status'  => 'REJECTED',
            'rejection_reason' => $request->reason,
        ]);
        return back()->with('success', "Dr. {$doctor->name} rejected.");
    }

    /* ── Users ──────────────────────────────────────────────────── */
    public function users(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        if ($request->filled('role') && $request->role !== 'ALL') {
            $query->where('role', strtolower($request->role));
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        $roles = ['ALL', 'PATIENT', 'DOCTOR'];

        return view('admin.users', compact('users', 'roles'));
    }

    public function toggleUser(User $user)
    {
        abort_if(strtolower($user->role) === 'admin', 403);
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "{$user->name} has been {$status}.");
    }

    /* ── Appointments ───────────────────────────────────────────── */
    public function appointments(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor.doctorProfile'])
            ->latest('appointment_date');

        if ($request->filled('status') && $request->status !== 'ALL') {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->whereHas('patient', fn($q) =>
                $q->where('name', 'like', '%' . $request->search . '%'));
        }

        $appointments = $query->paginate(15)->withQueryString();
        $statuses     = ['ALL', 'PENDING', 'CONFIRMED', 'COMPLETED', 'CANCELLED'];

        return view('admin.appointments', compact('appointments', 'statuses'));
    }
}
