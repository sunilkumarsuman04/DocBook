@extends('layouts.app')
@section('title','Doctor Dashboard')

@section('nav')
@php $r = request()->route()->getName(); @endphp
<x-nav-link href="/doctor/dashboard"    :active="$r==='doctor.dashboard'"    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'>Dashboard</x-nav-link>
<x-nav-link href="/doctor/profile"      :active="$r==='doctor.profile'"      icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'>My Profile</x-nav-link>
<x-nav-link href="/doctor/availability" :active="$r==='doctor.availability'" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'>Availability</x-nav-link>
<x-nav-link href="/doctor/appointments" :active="$r==='doctor.appointments'" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'>Appointments</x-nav-link>
<x-nav-link href="/doctor/settings"     :active="$r==='doctor.settings'"     icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'>Settings</x-nav-link>
@endsection

@section('content')
<div class="space-y-8">

    <div>
        <h1 class="text-2xl font-bold text-slate-900">Hello, Dr. {{ $doctor->name }} 👨‍⚕️</h1>
        <p class="text-slate-400 text-sm mt-1">Here's your practice overview</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <x-stat-card label="Today"     :value="$stats['today'] ?? 0"     color="teal"/>
        <x-stat-card label="Pending"   :value="$stats['pending'] ?? 0"   color="amber"/>
        <x-stat-card label="Patients"  :value="$stats['total'] ?? 0"     color="blue"/>
        <x-stat-card label="Completed" :value="$stats['completed'] ?? 0" color="green"/>
        <x-stat-card label="Extra Reqs" :value="$extraRequests->count()" color="red"/>
    </div>

    {{-- Booking type badge --}}
    @php $bookingType = $doctor->doctorProfile?->booking_type ?? 'time'; @endphp
    <div class="flex items-center gap-3 p-4 bg-white rounded-xl border border-slate-100 shadow-sm">
        @if($bookingType === 'token')
        <div class="w-9 h-9 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-800">Token / Queue System</p>
            <p class="text-xs text-slate-400">Max {{ $doctor->doctorProfile?->max_tokens ?? 30 }} tokens/day · Daily limit: {{ $doctor->doctorProfile?->max_patients_per_day ?? 30 }}</p>
        </div>
        @else
        <div class="w-9 h-9 rounded-xl bg-brand-100 text-brand-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-800">Time Slot System</p>
            <p class="text-xs text-slate-400">Patients book specific time slots · Max {{ $doctor->doctorProfile?->max_patients_per_day ?? 30 }}/day</p>
        </div>
        @endif
        <div class="ml-auto flex gap-2">
            @if(!($doctor->doctorProfile?->allow_next_day ?? true))
            <span class="text-xs px-2 py-1 bg-orange-100 text-orange-700 rounded-lg font-medium">Today only</span>
            @endif
            <a href="/doctor/profile" class="text-xs text-brand-600 hover:text-brand-700 font-medium">Change →</a>
        </div>
    </div>

    {{-- Approval warning --}}
    @if($doctor->doctorProfile?->approval_status === 'PENDING')
    <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-sm text-amber-700 flex items-start gap-3">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <div>
            <p class="font-semibold">Account pending approval</p>
            <p class="text-amber-600 mt-0.5">An admin will review your profile. You can still set up your availability in the meantime.</p>
        </div>
    </div>
    @endif

    {{-- ── Extra Booking Requests ────────────────────────────────── --}}
    @if($extraRequests->isNotEmpty())
    <div class="bg-white rounded-2xl shadow border border-orange-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-orange-400 animate-pulse"></span>
                Extra Booking Requests
                <span class="ml-1 px-2 py-0.5 text-xs font-bold bg-orange-100 text-orange-700 rounded-full">{{ $extraRequests->count() }}</span>
            </h2>
            <p class="text-xs text-slate-400">These patients are requesting approval beyond your daily limit</p>
        </div>

        <div class="space-y-3">
            @foreach($extraRequests as $req)
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-4 bg-orange-50 border border-orange-200 rounded-xl">
                <div class="flex items-center gap-3 flex-1">
                    <div class="w-9 h-9 rounded-full bg-orange-200 text-orange-800 flex items-center justify-center text-xs font-bold flex-shrink-0">
                        {{ strtoupper(substr($req->patient->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900 text-sm">{{ $req->patient->name }}</p>
                        <p class="text-xs text-slate-400">📅 {{ $req->appointment_date->format('M d, Y') }}</p>
                        @if($req->patient_note)
                        <p class="text-xs text-slate-500 mt-0.5 italic">"{{ Str::limit($req->patient_note, 80) }}"</p>
                        @endif
                    </div>
                </div>
                <div class="flex gap-2 flex-shrink-0">
                    <form method="POST" action="/doctor/appointments/{{ $req->id }}/approve">
                        @csrf
                        <button class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg transition-colors">
                            ✓ Accept
                        </button>
                    </form>
                    <form method="POST" action="/doctor/appointments/{{ $req->id }}/reject">
                        @csrf
                        <button class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-semibold rounded-lg transition-colors">
                            ✕ Reject
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Upcoming appointments --}}
    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-slate-900">Upcoming Appointments</h2>
            <a href="/doctor/appointments" class="text-sm text-brand-600 font-medium hover:text-brand-700">View all →</a>
        </div>

        @if($appointments->isEmpty())
            <p class="text-center text-slate-400 py-10 text-sm">No upcoming appointments</p>
        @else
        <div class="overflow-x-auto -mx-6">
            <table class="w-full text-sm min-w-[600px]">
                <thead>
                    <tr class="border-b border-slate-100">
                        @foreach(['Patient','Date', ($bookingType === 'token' ? 'Token' : 'Time'),'Status','Actions'] as $h)
                        <th class="text-left py-3 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($appointments as $apt)
                    <tr class="hover:bg-slate-50 transition-colors {{ $apt->is_extra_request ? 'bg-orange-50/50' : '' }}">
                        <td class="py-3.5 px-6">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($apt->patient->name, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="font-medium text-slate-800">{{ $apt->patient->name }}</span>
                                    @if($apt->is_extra_request)
                                    <span class="ml-1 text-[10px] px-1.5 py-0.5 bg-orange-100 text-orange-600 rounded font-medium">Extra</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-6 text-slate-600">{{ $apt->appointment_date->format('M d, Y') }}</td>
                        <td class="py-3.5 px-6 text-slate-600">
                            @if($apt->token_number)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-teal-100 text-teal-700">
                                    #{{ $apt->token_number }}
                                </span>
                            @elseif($apt->is_extra_request && !$apt->token_number)
                                <span class="text-xs text-orange-500 italic">Pending</span>
                            @else
                                {{ \App\Helpers\AppHelper::formatTime($apt->start_time) }}
                            @endif
                        </td>
                        <td class="py-3.5 px-6"><x-badge :status="$apt->status"/></td>
                        <td class="py-3.5 px-6">
                            <div class="flex gap-1.5 flex-wrap">
                                @if($apt->status === 'PENDING')
                                <form method="POST" action="/doctor/appointments/{{ $apt->id }}/approve">
                                    @csrf
                                    <button class="text-xs px-2.5 py-1 bg-brand-100 text-brand-700 rounded-lg hover:bg-brand-200 font-medium transition-colors">Confirm</button>
                                </form>
                                <form method="POST" action="/doctor/appointments/{{ $apt->id }}/reject">
                                    @csrf
                                    <button class="text-xs px-2.5 py-1 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 font-medium transition-colors">Reject</button>
                                </form>
                                @endif
                                @if($apt->status === 'CONFIRMED')
                                <form method="POST" action="/doctor/appointments/{{ $apt->id }}/complete">
                                    @csrf
                                    <button class="text-xs px-2.5 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 font-medium transition-colors">Complete</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 px-6">{{ $appointments->links() }}</div>
        @endif
    </div>

</div>
@endsection
