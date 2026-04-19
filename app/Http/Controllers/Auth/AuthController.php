<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Mail\RegistrationSuccessMail;


class AuthController extends Controller
{
    // =========================================================================
    // VIEWS
    // =========================================================================

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // =========================================================================
    // STANDARD PASSWORD LOGIN
    // =========================================================================

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = 'login|' . $request->ip() . '|' . strtolower($request->email);

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please wait {$seconds} seconds.",
            ]);
        }

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            RateLimiter::clear($throttleKey);
            // IMPORTANT: use Auth::user() after login — not the $request user
            return redirect($this->getRedirectUrl(Auth::user()));
        }

        RateLimiter::hit($throttleKey, 60);

        throw ValidationException::withMessages([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    // =========================================================================
    // REGISTRATION
    // =========================================================================

    public function register(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'role' => 'required|in:patient,doctor'
    ]);

    $user = \App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'role' => $data['role']
    ]);

    // ✅ SEND EMAIL
    Mail::to($user->email)->send(new RegistrationSuccessMail($user));

    auth()->login($user);

    return redirect('/');
}

    // =========================================================================
    // OTP — STEP 1: SEND
    // =========================================================================

    public function sendOtp(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'No account found with this email address.',
        ]);

        $email = strtolower(trim($validated['email']));

        // Rate limit: 3 sends per 5 min per IP
        $throttleKey = 'otp-send|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please wait ' . RateLimiter::availableIn($throttleKey) . ' seconds.',
            ], 429);
        }

        // Generate 6-digit OTP
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Upsert — one OTP record per email
        Otp::updateOrCreate(
            ['email' => $email],
            [
                'otp'        => $otp,
                'expires_at' => Carbon::now()->addMinutes(5),
            ]
        );

        // Send email
        try {
            Mail::to($email)->send(new OtpMail($otp, $email));
        } catch (\Throwable $e) {
            Log::error('OTP mail failed', ['email' => $email, 'err' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Could not send email. Please check your mail configuration.',
            ], 500);
        }

        RateLimiter::hit($throttleKey, 300);

        return response()->json([
            'success' => true,
            'message' => "OTP sent to {$email}. Valid for 5 minutes.",
        ]);
    }

    // =========================================================================
    // OTP — STEP 2: VERIFY  ← all bugs fixed here
    // =========================================================================

    public function verifyOtp(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'otp'   => ['required', 'string', 'size:6', 'regex:/^\d{6}$/'],
        ], [
            'email.exists' => 'No account found with this email address.',
            'otp.size'     => 'OTP must be exactly 6 digits.',
            'otp.regex'    => 'OTP must contain numbers only.',
        ]);

        $email = strtolower(trim($request->email));
        $otp   = trim($request->otp);

        // Brute-force protection
        $throttleKey = 'otp-verify|' . $request->ip() . '|' . $email;
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return response()->json([
                'success' => false,
                'message' => 'Too many attempts. Please wait ' . RateLimiter::availableIn($throttleKey) . ' seconds.',
            ], 429);
        }

        // 1. Find OTP record
        $otpRecord = Otp::where('email', $email)->latest()->first();

        if (!$otpRecord) {
            return response()->json([
                'success' => false,
                'message' => 'No OTP found. Please request a new one.',
            ], 422);
        }

        // 2. Check expiry
        if (!$otpRecord->isValid()) {
            $otpRecord->delete();
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired. Please request a new one.',
            ], 422);
        }

        // 3. Check value
        if ($otpRecord->otp !== $otp) {
            RateLimiter::hit($throttleKey, 600);
            return response()->json([
                'success' => false,
                'message' => 'Incorrect OTP. Please try again.',
            ], 422);
        }

        // 4. Valid — consume OTP
        $otpRecord->delete();
        RateLimiter::clear($throttleKey);

        // 5. Load user FIRST so we have the model
        $user = User::where('email', $email)->firstOrFail();

        // 6. Log in and regenerate session
        Auth::login($user);
        $request->session()->regenerate();

        // 7. BUG FIX: get redirect URL from Auth::user() AFTER session is set
        //    This guarantees we read the authenticated user's real role
        $redirectUrl = $this->getRedirectUrl(Auth::user());

        Log::info('OTP login success', [
            'user_id'  => $user->id,
            'email'    => $email,
            'role'     => $user->role,
            'redirect' => $redirectUrl,
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Login successful!',
            'redirect' => $redirectUrl,
        ]);
    }

    // =========================================================================
    // LOGOUT
    // =========================================================================

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    // =========================================================================
    // HELPER — role → dashboard URL
    // BUG FIX: handles null role, trims whitespace, lowercases, logs the value
    // =========================================================================

    private function getRedirectUrl(User $user): string
    {
        // Support different column names projects may use
        $role = $user->role
             ?? $user->user_type
             ?? $user->user_role
             ?? 'patient';

        // Normalise
        $role = strtolower(trim((string) $role));

        // Debug log — check this in storage/logs/laravel.log if redirect is wrong
        Log::debug('DocBook login redirect', [
            'user_id' => $user->id,
            'email'   => $user->email,
            'role'    => $role,
        ]);

        return match ($role) {
            'admin'   => '/admin/dashboard',
            'doctor'  => '/doctor/dashboard',
            'patient' => '/patient/dashboard',
            default   => '/patient/dashboard',
        };
    }
}