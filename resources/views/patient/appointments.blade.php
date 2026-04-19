@extends('layouts.app')
@section('title','My Appointments')

@section('nav')
    @php $r = request()->route()->getName(); @endphp
    <x-nav-link href="/patient/dashboard"    :active="$r==='patient.dashboard'"    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'>Dashboard</x-nav-link>
    <x-nav-link href="/patient/search"       :active="$r==='patient.search'"       icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>'>Find Doctors</x-nav-link>
    <x-nav-link href="/patient/appointments" :active="$r==='patient.appointments'" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'>Appointments</x-nav-link>
    <x-nav-link href="/patient/profile"      :active="$r==='patient.profile'"      icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'>My Profile</x-nav-link>
@endsection

@section('content')
<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">My Appointments</h1>
        <p class="text-slate-400 text-sm mt-1">Track and manage all your visits</p>
    </div>

    {{-- Status tabs --}}
    <div class="flex gap-2 overflow-x-auto pb-1 mb-6">
        @foreach($statuses as $s)
        <a href="?status={{ $s }}"
           class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-colors
                  {{ request('status', 'ALL') === $s ? 'bg-brand-500 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            {{ $s }}
        </a>
        @endforeach
    </div>

    @if($appointments->isEmpty())
        <div class="text-center py-20">
            <svg class="w-12 h-12 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-slate-500 font-semibold">No appointments found</p>
            <a href="/patient/search" class="mt-3 inline-block text-sm text-brand-600 hover:text-brand-700 font-medium">Find a doctor →</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($appointments as $apt)
            <div class="bg-white rounded-2xl shadow border border-slate-100 p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4
                        {{ $apt->is_extra_request && $apt->status === 'PENDING' ? 'border-orange-200 bg-orange-50/30' : '' }}">
                <div class="w-12 h-12 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center text-base font-bold flex-shrink-0">
                    {{ strtoupper(substr($apt->doctor->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-0.5">
                        <h3 class="font-semibold text-slate-900">Dr. {{ $apt->doctor->name }}</h3>
                        <x-badge :status="$apt->status"/>
                        @if($apt->is_extra_request)
                        <span class="text-[10px] px-1.5 py-0.5 bg-orange-100 text-orange-600 rounded font-semibold">Extra Request</span>
                        @endif
                    </div>
                    <p class="text-sm text-brand-600 font-medium">{{ $apt->doctor->doctorProfile?->specialization }}</p>
                    <p class="text-sm text-slate-400 mt-0.5">
                        📅 {{ $apt->appointment_date->format('M d, Y') }}
                        @if($apt->token_number)
                            &nbsp;·&nbsp;
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-teal-100 text-teal-700">
                                🎫 Token #{{ $apt->token_number }}
                            </span>
                        @elseif($apt->is_extra_request && !$apt->token_number)
                            &nbsp;·&nbsp; <span class="text-xs text-orange-500 italic">Awaiting doctor approval</span>
                        @elseif($apt->start_time && $apt->start_time !== '00:00:00')
                            &nbsp;·&nbsp; ⏰ {{ \App\Helpers\AppHelper::formatTime($apt->start_time) }}
                        @endif
                    </p>
                    @if($apt->patient_note)
                    <p class="text-xs text-slate-400 mt-1 truncate max-w-sm italic">Your note: "{{ $apt->patient_note }}"</p>
                    @elseif($apt->notes)
                    <p class="text-xs text-slate-400 mt-1 truncate max-w-sm">Note: {{ $apt->notes }}</p>
                    @endif
                </div>
                <div class="flex flex-wrap gap-2 flex-shrink-0">
                    {{-- Pay --}}
                    @if($apt->status === 'CONFIRMED' && $apt->payment_status === 'UNPAID')
                    <a href="/patient/appointments/{{ $apt->id }}/pay"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand-500 hover:bg-brand-600 text-white text-xs font-semibold rounded-lg transition-colors">
                        💳 Pay
                    </a>
                    @endif
                    {{-- Review --}}
                    @if($apt->canReview())
                    <a href="/patient/appointments/{{ $apt->id }}/review"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                        ⭐ Review
                    </a>
                    @endif
                    {{-- Cancel --}}
                    @if($apt->canCancel())
                    <form method="POST" action="/patient/appointments/{{ $apt->id }}/cancel"
                          onsubmit="return confirm('Cancel this appointment?')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition-colors">
                            ✕ Cancel
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-8">{{ $appointments->links() }}</div>
    @endif
</div>
@endsection
