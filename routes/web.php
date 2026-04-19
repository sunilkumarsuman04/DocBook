<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

// Root redirect
Route::get('/', fn() => redirect('/login'));

// =============================================================================
// AUTH — GUEST ONLY
// =============================================================================
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])    ->name('login');
    Route::get('/register', [AuthController::class, 'showRegister']) ->name('register');
    Route::post('/login',    [AuthController::class, 'login'])    ->name('login.submit');
    Route::post('/register', [AuthController::class, 'register']) ->name('register.submit');
    Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('password.request');
});

// OTP
Route::post('/auth/otp/send',   [AuthController::class, 'sendOtp'])   ->name('auth.otp.send');
Route::post('/auth/otp/verify', [AuthController::class, 'verifyOtp']) ->name('auth.otp.verify');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// =============================================================================
// PATIENT ROUTES
// =============================================================================
Route::middleware(['auth', 'role:patient'])
    ->prefix('patient')
    ->name('patient.')
    ->group(function () {
        Route::get('/dashboard',    [PatientController::class, 'dashboard'])    ->name('dashboard');
        Route::get('/appointments', [PatientController::class, 'appointments']) ->name('appointments');
        Route::get('/search',       [PatientController::class, 'searchDoctors'])->name('search');
        Route::get('/profile',      [PatientController::class, 'profile'])      ->name('profile');
        Route::put('/profile',      [PatientController::class, 'updateProfile'])->name('profile.update');

        Route::get('/doctors/{doctor}',       [PatientController::class, 'viewDoctor'])      ->name('doctors.show');
        Route::post('/doctors/{doctor}/book', [PatientController::class, 'bookAppointment']) ->name('doctors.book');

        Route::post('/appointments/{appointment}/cancel', [PatientController::class, 'cancelAppointment'])->name('appointments.cancel');
        Route::get('/appointments/{appointment}/pay',     [PatientController::class, 'showPayment'])      ->name('appointments.pay');
        Route::post('/appointments/{appointment}/pay',    [PatientController::class, 'processPayment'])   ->name('appointments.pay.submit');
        Route::get('/appointments/{appointment}/review',  [PatientController::class, 'showReview'])       ->name('appointments.review');
        Route::post('/appointments/{appointment}/review', [PatientController::class, 'submitReview'])     ->name('appointments.review.submit');
    });

// =============================================================================
// DOCTOR ROUTES
// =============================================================================
Route::middleware(['auth', 'role:doctor'])
    ->prefix('doctor')
    ->name('doctor.')
    ->group(function () {
        Route::get('/dashboard',    [DoctorController::class, 'dashboard'])    ->name('dashboard');
        Route::get('/profile',      [DoctorController::class, 'profile'])      ->name('profile');
        Route::put('/profile',      [DoctorController::class, 'updateProfile'])->name('profile.update');

        // Hospital image delete
        Route::delete('/profile/hospital-image/{id}', [DoctorController::class, 'deleteHospitalImage'])->name('profile.hospital-image.delete');

        Route::get('/settings',     [DoctorController::class, 'settings'])     ->name('settings');
        Route::post('/settings/password', [DoctorController::class, 'changePassword'])->name('settings.password');
        Route::post('/settings/limits',   [DoctorController::class, 'updateSettings'])->name('settings.limits');

        Route::get('/availability', [DoctorController::class, 'availability'])->name('availability');
        Route::post('/availability',          [DoctorController::class, 'updateAvailability'])->name('availability.update');
        Route::post('/availability/generate', [DoctorController::class, 'generateSlots'])    ->name('availability.generate');

        Route::get('/appointments',                [DoctorController::class, 'appointments'])       ->name('appointments');
        Route::get('/appointments/{id}',           [DoctorController::class, 'showAppointment'])    ->name('appointments.show');
        Route::post('/appointments/{id}/approve',  [DoctorController::class, 'approveAppointment']) ->name('appointments.approve');
        Route::post('/appointments/{id}/reject',   [DoctorController::class, 'rejectAppointment'])  ->name('appointments.reject');
        Route::post('/appointments/{id}/complete', [DoctorController::class, 'completeAppointment'])->name('appointments.complete');
    });

// =============================================================================
// ADMIN ROUTES
// =============================================================================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard',    [AdminController::class, 'dashboard'])   ->name('dashboard');
        Route::get('/doctors',      [AdminController::class, 'doctors'])     ->name('doctors');
        Route::post('/doctors/{doctor}/approve', [AdminController::class, 'approveDoctor'])->name('doctors.approve');
        Route::post('/doctors/{doctor}/reject',  [AdminController::class, 'rejectDoctor']) ->name('doctors.reject');
        Route::get('/users',        [AdminController::class, 'users'])       ->name('users');
        Route::post('/users/{user}/toggle', [AdminController::class, 'toggleUser'])->name('users.toggle');
        Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
    });
