@extends('layouts.app')
@section('title','Settings')

@section('nav')
@php $r = request()->route()->getName(); @endphp
<x-nav-link href="/doctor/dashboard"    :active="$r==='doctor.dashboard'"    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'>Dashboard</x-nav-link>
<x-nav-link href="/doctor/profile"      :active="$r==='doctor.profile'"      icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'>My Profile</x-nav-link>
<x-nav-link href="/doctor/availability" :active="$r==='doctor.availability'" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'>Availability</x-nav-link>
<x-nav-link href="/doctor/appointments" :active="$r==='doctor.appointments'" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'>Appointments</x-nav-link>
<x-nav-link href="/doctor/settings"     :active="$r==='doctor.settings'"     icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'>Settings</x-nav-link>
@endsection

@section('content')
<div class="max-w-2xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Settings</h1>
        <p class="text-slate-400 text-sm mt-1">Manage your booking limits and account preferences</p>
    </div>

    {{-- ── Daily Limit Settings ──────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">
        <h2 class="text-lg font-bold text-slate-900 mb-1 flex items-center gap-2">
            <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Daily Booking Limits
        </h2>
        <p class="text-sm text-slate-400 mb-5">Increase your daily patient limit here. When the limit is full, patients can submit extra requests for your approval.</p>

        <form method="POST" action="/doctor/settings/limits" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Max Patients Per Day</label>
                    <input type="number" name="max_patients_per_day" min="1" max="500" required
                        value="{{ old('max_patients_per_day', $profile?->max_patients_per_day ?? 30) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                    <p class="text-xs text-slate-400 mt-1">
                        Current: <strong>{{ $profile?->max_patients_per_day ?? 30 }}</strong>
                        (booking type: <strong>{{ $profile?->booking_type ?? 'time' }}</strong>)
                    </p>
                </div>
                <div class="flex items-end">
                    <div class="w-full">
                        <label class="flex items-center gap-3 cursor-pointer select-none mb-2">
                            <div class="relative">
                                <input type="hidden" name="allow_next_day" value="0">
                                <input type="checkbox" name="allow_next_day" value="1"
                                    {{ $profile?->allow_next_day ?? true ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:bg-brand-500 transition-colors"></div>
                                <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                            </div>
                            <span class="text-sm font-medium text-slate-700">Allow future date bookings</span>
                        </label>
                        <p class="text-xs text-slate-400">Uncheck to restrict bookings to today only</p>
                    </div>
                </div>
            </div>
            <button type="submit"
                class="px-6 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all text-sm shadow-sm">
                💾 Save Limit Settings
            </button>
        </form>
    </div>

    {{-- ── Change Password ───────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">
        <h2 class="text-lg font-bold text-slate-900 mb-5 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            Change Password
        </h2>

        <form method="POST" action="/doctor/settings/password" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Current password</label>
                <input type="password" name="current_password" required placeholder="••••••••"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent @error('current_password') border-red-400 @enderror">
                @error('current_password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">New password</label>
                <input type="password" name="password" required placeholder="Min. 6 characters"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent @error('password') border-red-400 @enderror">
                @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Confirm new password</label>
                <input type="password" name="password_confirmation" required placeholder="••••••••"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
            </div>
            <button type="submit"
                class="px-6 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all text-sm shadow-sm">
                🔑 Change Password
            </button>
        </form>
    </div>
</div>
@endsection
