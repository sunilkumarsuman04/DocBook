@extends('layouts.app')
@section('title','Patient Dashboard')

@section('nav')
    @php $r = request()->route()->getName(); @endphp
    <x-nav-link href="/patient/dashboard"    :active="$r==='patient.dashboard'"    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'>Dashboard</x-nav-link>
    <x-nav-link href="/patient/search"       :active="$r==='patient.search'"       icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>'>Find Doctors</x-nav-link>
    <x-nav-link href="/patient/appointments" :active="$r==='patient.appointments'" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'>Appointments</x-nav-link>
    <x-nav-link href="/patient/profile"      :active="$r==='patient.profile'"      icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'>My Profile</x-nav-link>
@endsection

@section('content')
<div class="space-y-8">
    {{-- Header --}}
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Hello, {{ explode(' ', $user->name)[0] }} 👋</h1>
            <p class="text-slate-400 text-sm mt-1">Here's your health summary</p>
        </div>
        <a href="/patient/search" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all text-sm shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Find a Doctor
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <x-stat-card label="Total Appointments" :value="$stats['total']"     color="teal"/>
        <x-stat-card label="Upcoming"           :value="$stats['upcoming']"  color="blue"/>
        <x-stat-card label="Completed"          :value="$stats['completed']" color="green"/>
    </div>

    {{-- Recent appointments --}}
    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-slate-900">Recent Appointments</h2>
            <a href="/patient/appointments" class="text-sm text-brand-600 font-medium hover:text-brand-700">View all →</a>
        </div>

        @if($appointments->isEmpty())
            <div class="text-center py-12">
                <svg class="w-10 h-10 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-slate-500 font-medium text-sm mb-1">No appointments yet</p>
                <p class="text-slate-400 text-xs mb-5">Book your first appointment today</p>
                <a href="/patient/search" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-500 text-white text-sm font-semibold rounded-xl hover:bg-brand-600 transition-all">Browse Doctors</a>
            </div>
        @else
            <div class="space-y-3">
                @foreach($appointments as $apt)
                <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center text-sm font-bold flex-shrink-0">
                        {{ strtoupper(substr($apt->doctor->name, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-slate-900 text-sm">Dr. {{ $apt->doctor->name }}</p>
                        <p class="text-xs text-slate-400">{{ $apt->doctor->doctorProfile?->specialization }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-sm font-medium text-slate-700">{{ $apt->appointment_date->format('M d, Y') }}</p>
                        @if($apt->token_number)
                        <p class="text-xs text-teal-600 font-semibold">Token #{{ $apt->token_number }}</p>
                        @else
                        <p class="text-xs text-slate-400">{{ \App\Helpers\AppHelper::formatTime($apt->start_time) }}</p>
                        @endif
                    </div>
                    <x-badge :status="$apt->status"/>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
