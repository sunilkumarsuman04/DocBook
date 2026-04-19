@extends('layouts.app')
@section('title','All Appointments')
@section('nav')
    @php $r = request()->route()->getName(); @endphp
    <x-nav-link href="/admin/dashboard"    :active="$r==='admin.dashboard'"    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'>Dashboard</x-nav-link>
    <x-nav-link href="/admin/doctors"      :active="$r==='admin.doctors'"      icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>'>Doctors</x-nav-link>
    <x-nav-link href="/admin/users"        :active="$r==='admin.users'"        icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>'>Users</x-nav-link>
    <x-nav-link href="/admin/appointments" :active="$r==='admin.appointments'" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'>Appointments</x-nav-link>
@endsection

@section('content')
<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">All Appointments</h1>
        <p class="text-slate-400 text-sm mt-1">Platform-wide appointment activity</p>
    </div>

    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <div class="flex gap-2 overflow-x-auto pb-1">
            @foreach($statuses as $s)
            <a href="?status={{ $s }}&search={{ request('search') }}"
               class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-colors
                      {{ request('status', 'ALL') === $s ? 'bg-brand-500 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                {{ $s }}
            </a>
            @endforeach
        </div>
        <form method="GET" class="sm:ml-auto">
            <input type="hidden" name="status" value="{{ request('status', 'ALL') }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search patient name…"
                class="px-4 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 w-56">
        </form>
    </div>

    @if($appointments->isEmpty())
        <div class="text-center py-20">
            <p class="text-slate-500 font-semibold">No appointments found</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[640px]">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            @foreach(['Patient','Doctor','Specialization','Date & Time','Fee','Status'] as $h)
                            <th class="text-left py-3.5 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ $h }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($appointments as $apt)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-5 font-medium text-slate-900">{{ $apt->patient->name }}</td>
                            <td class="py-3.5 px-5 text-slate-600">Dr. {{ $apt->doctor->name }}</td>
                            <td class="py-3.5 px-5 text-slate-500">{{ $apt->doctor->doctorProfile?->specialization ?: '—' }}</td>
                            <td class="py-3.5 px-5">
                                <p class="text-slate-700 font-medium">{{ $apt->appointment_date->format('M d, Y') }}</p>
                                <p class="text-xs text-slate-400">{{ \App\Helpers\AppHelper::formatTime($apt->start_time) }}</p>
                            </td>
                            <td class="py-3.5 px-5 text-slate-700">₹{{ number_format($apt->consultation_fee) }}</td>
                            <td class="py-3.5 px-5"><x-badge :status="$apt->status"/></td>
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
