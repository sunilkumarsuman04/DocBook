@extends('layouts.app')
@section('title','My Profile')
@section('nav')
    @php $r = request()->route()->getName(); @endphp
    <x-nav-link href="/patient/dashboard"    :active="$r==='patient.dashboard'"    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'>Dashboard</x-nav-link>
    <x-nav-link href="/patient/search"       :active="$r==='patient.search'"       icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>'>Find Doctors</x-nav-link>
    <x-nav-link href="/patient/appointments" :active="$r==='patient.appointments'" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'>Appointments</x-nav-link>
    <x-nav-link href="/patient/profile"      :active="$r==='patient.profile'"      icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'>My Profile</x-nav-link>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">My Profile</h1>
        <p class="text-slate-400 text-sm mt-1">Manage your personal information</p>
    </div>

    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">
        {{-- Avatar row --}}
        <div class="flex items-center gap-5 pb-6 mb-6 border-b border-slate-100">
            <div class="w-20 h-20 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center text-2xl font-bold">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <h2 class="font-semibold text-slate-900 text-lg leading-tight">{{ $user->name }}</h2>
                <p class="text-slate-400 text-sm">{{ $user->email }}</p>
                <span class="inline-flex mt-2 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brand-100 text-brand-700">Patient</span>
            </div>
        </div>

        <form method="POST" action="/patient/profile" class="space-y-5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent @error('name') border-red-400 @enderror">
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Phone</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                        placeholder="+91 XXXXX XXXXX"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Date of Birth</label>
                    <input type="date" name="date_of_birth"
                        value="{{ old('date_of_birth', $user->patientProfile?->date_of_birth?->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Gender</label>
                    <select name="gender" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                        <option value="">Select…</option>
                        @foreach(['MALE','FEMALE','OTHER'] as $g)
                        <option value="{{ $g }}" {{ old('gender', $user->patientProfile?->gender) === $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Blood Group</label>
                    <select name="blood_group" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                        <option value="">Select…</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                        <option value="{{ $bg }}" {{ old('blood_group', $user->patientProfile?->blood_group) === $bg ? 'selected' : '' }}>{{ $bg }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Address</label>
                    <textarea name="address" rows="2"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">{{ old('address', $user->patientProfile?->address) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit"
                    class="px-8 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all text-sm shadow-sm">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
