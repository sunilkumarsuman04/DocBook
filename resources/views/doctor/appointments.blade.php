@extends('layouts.app')
@section('title','Appointments')
@section('nav')
    @php $r = request()->route()->getName(); @endphp
    <x-nav-link href="/doctor/dashboard"    :active="$r==='doctor.dashboard'"    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'>Dashboard</x-nav-link>
    <x-nav-link href="/doctor/profile"      :active="$r==='doctor.profile'"      icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'>My Profile</x-nav-link>
    <x-nav-link href="/doctor/availability" :active="$r==='doctor.availability'" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'>Availability</x-nav-link>
    <x-nav-link href="/doctor/appointments" :active="$r==='doctor.appointments'" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'>Appointments</x-nav-link>
    <x-nav-link href="/doctor/settings"     :active="$r==='doctor.settings'"     icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'>Settings</x-nav-link>
@endsection

@section('content')
<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Appointments</h1>
        <p class="text-slate-400 text-sm mt-1">Manage all your patient appointments</p>
    </div>

    {{-- Filter tabs --}}
    <div class="flex gap-2 overflow-x-auto pb-1 mb-6">
        @foreach($statuses as $s)
        <a href="?status={{ $s }}"
           class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-colors
                  {{ request('status', 'ALL') === $s ? 'bg-brand-500 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            {{ $s }}
        </a>
        @endforeach
        <a href="?extra=1"
           class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-colors
                  {{ request('extra') === '1' ? 'bg-orange-500 text-white' : 'bg-white border border-orange-200 text-orange-600 hover:bg-orange-50' }}">
            🔔 Extra Requests
        </a>
    </div>

    @if($appointments->isEmpty())
        <div class="text-center py-20">
            <svg class="w-12 h-12 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-slate-500 font-semibold">No appointments found</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[750px]">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            @foreach(['Patient','Date','Token / Time','Note','Status','Actions'] as $h)
                            <th class="text-left py-3.5 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ $h }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($appointments as $apt)
                        <tr class="hover:bg-slate-50 transition-colors {{ $apt->is_extra_request && $apt->status === 'PENDING' ? 'bg-orange-50/60' : '' }}">
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                        {{ strtoupper(substr($apt->patient->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $apt->patient->name }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $apt->patient->email }}</p>
                                        @if($apt->is_extra_request)
                                        <span class="text-[10px] px-1.5 py-0.5 bg-orange-100 text-orange-600 rounded font-semibold">Extra Request</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-5 text-slate-600">{{ $apt->appointment_date->format('M d, Y') }}</td>
                            <td class="py-3.5 px-5 text-slate-600">
                                @if($apt->token_number)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-teal-100 text-teal-700">
                                        🎫 Token #{{ $apt->token_number }}
                                    </span>
                                @elseif($apt->is_extra_request)
                                    <span class="text-xs text-orange-500 italic">Awaiting token</span>
                                @else
                                    {{ \App\Helpers\AppHelper::formatTime($apt->start_time) }}
                                @endif
                            </td>
                            <td class="py-3.5 px-5">
                                @if($apt->patient_note)
                                <p class="text-slate-500 text-xs max-w-[160px] truncate italic" title="{{ $apt->patient_note }}">
                                    "{{ $apt->patient_note }}"
                                </p>
                                @elseif($apt->notes)
                                <p class="text-slate-400 text-xs max-w-[140px] truncate">{{ $apt->notes }}</p>
                                @else
                                <span class="text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5"><x-badge :status="$apt->status"/></td>
                            <td class="py-3.5 px-5">
                                <div class="flex gap-1.5 flex-wrap">
                                    @if($apt->status === 'PENDING')
                                    <form method="POST" action="/doctor/appointments/{{ $apt->id }}/approve">
                                        @csrf
                                        <button class="text-xs px-2.5 py-1 bg-brand-100 text-brand-700 rounded-lg hover:bg-brand-200 font-medium transition-colors">
                                            {{ $apt->is_extra_request ? '✓ Accept' : 'Confirm' }}
                                        </button>
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
        </div>
        <div class="mt-6">{{ $appointments->links() }}</div>
    @endif
</div>
@endsection
