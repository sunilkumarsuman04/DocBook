@extends('layouts.app')
@section('title','Find Doctors')

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
        <h1 class="text-2xl font-bold text-slate-900">Find Doctors</h1>
        <p class="text-slate-400 text-sm mt-1">Search from verified specialists</p>
    </div>

    {{-- Filters --}}
    <form method="GET" action="/patient/search" class="bg-white rounded-2xl shadow border border-slate-100 p-5 mb-6">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="name" value="{{ request('name') }}" placeholder="Doctor name…"
                    class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <select name="specialization" class="sm:w-52 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                <option value="">All Specializations</option>
                @foreach($specializations as $s)
                    <option value="{{ $s }}" {{ request('specialization') === $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
            <div class="relative sm:w-36">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                <input type="text" name="city" value="{{ request('city') }}" placeholder="City…"
                    class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all text-sm">
                Search
            </button>
        </div>
    </form>

    {{-- Results --}}
    @if($doctors->isEmpty())
        <div class="text-center py-20">
            <svg class="w-12 h-12 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <p class="text-slate-500 font-semibold">No doctors found</p>
            <p class="text-slate-400 text-sm mt-1">Try adjusting your filters</p>
        </div>
    @else
        <p class="text-sm text-slate-400 mb-4">{{ $doctors->total() }} result{{ $doctors->total() !== 1 ? 's' : '' }} found</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($doctors as $doctor)
            <a href="/patient/doctors/{{ $doctor->id }}"
               class="bg-white rounded-2xl shadow border border-slate-100 p-5 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 block group">
                <div class="flex items-start gap-3 mb-4">
                    <div class="w-14 h-14 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center text-lg font-bold flex-shrink-0">
                        {{ strtoupper(substr($doctor->name, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-slate-900 truncate group-hover:text-brand-700 transition-colors">
                            Dr. {{ $doctor->name }}
                        </h3>
                        <p class="text-sm text-brand-600 font-medium">{{ $doctor->doctorProfile?->specialization }}</p>
                        @if($doctor->doctorProfile?->city)
                        <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $doctor->doctorProfile->city }}
                        </p>
                        @endif
                        {{-- Booking type badge --}}
                        @if($doctor->doctorProfile?->booking_type === 'token')
                        <span class="inline-flex mt-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-teal-100 text-teal-700">🎫 Token Queue</span>
                        @else
                        <span class="inline-flex mt-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-brand-100 text-brand-700">⏰ Time Slots</span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center justify-between pt-4 border-t border-slate-100 text-sm">
                    <div class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 fill-amber-400 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span class="font-semibold text-slate-800">{{ number_format($doctor->doctorProfile?->rating ?? 0, 1) }}</span>
                        <span class="text-slate-400 text-xs">({{ $doctor->doctorProfile?->review_count ?? 0 }})</span>
                    </div>
                    @if($doctor->doctorProfile?->experience)
                    <span class="text-xs text-slate-400">{{ $doctor->doctorProfile->experience }} yrs</span>
                    @endif
                    <span class="font-bold text-slate-900">
                        ₹{{ number_format($doctor->doctorProfile?->consultation_fee ?? 0) }}
                    </span>
                </div>
            </a>
            @endforeach
        </div>
        <div class="mt-8">{{ $doctors->links() }}</div>
    @endif
</div>
@endsection
