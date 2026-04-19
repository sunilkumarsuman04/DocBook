@extends('layouts.app')
@section('title','Dr. ' . $doctor->name)

@section('nav')
    @php $r = request()->route()->getName(); @endphp
    <x-nav-link href="/patient/dashboard"    :active="false" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'>Dashboard</x-nav-link>
    <x-nav-link href="/patient/search"       :active="true"  icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>'>Find Doctors</x-nav-link>
    <x-nav-link href="/patient/appointments" :active="false" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'>Appointments</x-nav-link>
    <x-nav-link href="/patient/profile"      :active="false" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'>My Profile</x-nav-link>
@endsection

@section('content')
<div class="max-w-3xl space-y-5">
    <a href="/patient/search" class="flex items-center gap-1.5 text-slate-400 hover:text-slate-700 text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to search
    </a>

    {{-- Doctor info --}}
    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">
        <div class="flex flex-col sm:flex-row gap-5">
            <div class="flex-shrink-0">
                @if($doctor->doctorProfile?->doctor_image)
                    <img src="{{ asset('storage/' . $doctor->doctorProfile->doctor_image) }}"
                         alt="Dr. {{ $doctor->name }}"
                         class="w-24 h-24 rounded-full object-cover border-2 border-brand-200">
                @else
                    <div class="w-24 h-24 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center text-2xl font-bold">
                        {{ strtoupper(substr($doctor->name, 0, 2)) }}
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">Dr. {{ $doctor->name }}</h1>
                        <p class="text-brand-600 font-semibold">{{ $doctor->doctorProfile?->specialization }}</p>
                        <div class="flex flex-wrap gap-x-4 gap-y-1 mt-2 text-xs text-slate-400">
                            @if($doctor->doctorProfile?->city)
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ $doctor->doctorProfile->city }}
                            </span>
                            @endif
                            @if($doctor->doctorProfile?->experience)
                            <span>{{ $doctor->doctorProfile->experience }} yrs exp</span>
                            @endif
                            @if($doctor->phone)
                            <span>{{ $doctor->phone }}</span>
                            @endif
                        </div>
                        <div class="mt-2 flex gap-2 flex-wrap">
                            @if($bookingType === 'token')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-teal-100 text-teal-700">
                                🎫 Token / Queue System
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brand-100 text-brand-700">
                                ⏰ Time Slot Booking
                            </span>
                            @endif
                            @if(!$allowNextDay)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">
                                📅 Today bookings only
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-slate-900">₹{{ number_format($doctor->doctorProfile?->consultation_fee ?? 0) }}</p>
                        <p class="text-xs text-slate-400">per visit</p>
                        <div class="flex items-center gap-1 mt-1 justify-end">
                            @for($i=1;$i<=5;$i++)
                                <svg class="w-3.5 h-3.5 {{ $i <= round($doctor->doctorProfile?->rating ?? 0) ? 'fill-amber-400 text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                            <span class="text-xs text-slate-400 ml-1">({{ $doctor->doctorProfile?->review_count ?? 0 }})</span>
                        </div>
                    </div>
                </div>
                @if($doctor->doctorProfile?->bio)
                <p class="text-slate-500 text-sm mt-4 leading-relaxed">{{ $doctor->doctorProfile->bio }}</p>
                @endif
                @if($doctor->doctorProfile?->qualifications)
                <div class="flex flex-wrap gap-2 mt-3">
                    @foreach($doctor->doctorProfile->qualifications as $q)
                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brand-100 text-brand-700">{{ $q }}</span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Hospital Images Gallery --}}
    @if($hospitalImages->isNotEmpty())
    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">
        <h2 class="text-base font-bold text-slate-900 mb-4">🏥 Clinic / Hospital</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            @foreach($hospitalImages as $img)
            <img src="{{ asset('storage/' . $img->image_path) }}"
                 alt="Hospital image"
                 class="w-full h-32 object-cover rounded-xl border border-slate-200">
            @endforeach
        </div>
    </div>
    @endif

    {{-- Limit full flash message + Extra Request form --}}
    @if(session('limit_full'))
    <div class="bg-orange-50 border border-orange-200 rounded-2xl p-6">
        <div class="flex items-start gap-3 mb-4">
            <span class="text-2xl">⚠️</span>
            <div>
                <h3 class="font-bold text-orange-800">Today's booking limit is full</h3>
                <p class="text-sm text-orange-700 mt-1">You can submit a request for the doctor's approval. The doctor will review and may still accommodate you.</p>
            </div>
        </div>
        <form method="POST" action="/patient/doctors/{{ $doctor->id }}/book" class="space-y-4">
            @csrf
            <input type="hidden" name="appointment_date" value="{{ session('full_date', now()->format('Y-m-d')) }}">
            <input type="hidden" name="request_extra" value="1">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Your message / reason <span class="text-red-500">*</span></label>
                <textarea name="patient_note" rows="3" required
                    placeholder="Please explain your situation or urgency…"
                    class="w-full px-4 py-2.5 rounded-xl border border-orange-300 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent"></textarea>
            </div>
            <button type="submit"
                class="px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl transition-all text-sm shadow-sm">
                📩 Submit Extra Request
            </button>
        </form>
    </div>
    @endif

    {{-- ── BOOKING SECTION ──────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">
        <h2 class="text-lg font-bold text-slate-900 mb-5 flex items-center gap-2">
            <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Book an Appointment
        </h2>

        @if($bookingType === 'time')
        {{-- ─── TIME SLOT BOOKING ─── --}}
        <div class="flex gap-2 overflow-x-auto pb-2 mb-5">
            @foreach($dates as $d)
            <a href="?date={{ $d }}"
               class="flex-shrink-0 flex flex-col items-center px-4 py-3 rounded-xl border-2 transition-all duration-150 min-w-[64px] text-center
                      {{ $d === $selectedDate ? 'border-brand-500 bg-brand-50 text-brand-700' : 'border-slate-200 text-slate-600 hover:border-slate-300' }}">
                <span class="text-[11px] font-medium uppercase">{{ \Carbon\Carbon::parse($d)->format('D') }}</span>
                <span class="text-xl font-bold">{{ \Carbon\Carbon::parse($d)->format('j') }}</span>
                <span class="text-[11px]">{{ \Carbon\Carbon::parse($d)->format('M') }}</span>
            </a>
            @endforeach
        </div>

        @if($slots->isEmpty())
            <p class="text-center text-slate-400 py-8 text-sm">No slots available for this date. Try another date.</p>
        @else
            <form method="POST" action="/patient/doctors/{{ $doctor->id }}/book">
                @csrf
                <input type="hidden" name="appointment_date" value="{{ $selectedDate }}">
                <div class="grid grid-cols-3 sm:grid-cols-5 gap-2 mb-6">
                    @foreach($slots as $slot)
                    <label class="cursor-pointer">
                        <input type="radio" name="slot_id" value="{{ $slot->id }}" class="sr-only peer" required>
                        <div class="py-2.5 rounded-xl text-sm font-medium border-2 text-center transition-all
                                    border-slate-200 text-slate-700 hover:border-brand-400 hover:text-brand-600
                                    peer-checked:bg-brand-500 peer-checked:text-white peer-checked:border-brand-500">
                            {{ \App\Helpers\AppHelper::formatTime($slot->start_time) }}
                        </div>
                    </label>
                    @endforeach
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Notes for doctor <span class="text-slate-400 font-normal">(optional)</span></label>
                    <textarea name="notes" rows="3" placeholder="Describe your symptoms or reason for visit…"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm resize-none focus:ring-2 focus:ring-brand-400 focus:border-transparent"></textarea>
                </div>
                <button type="submit"
                    class="px-8 py-3 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all text-sm shadow-sm">
                    Confirm Booking
                </button>
            </form>
        @endif

        @else
        {{-- ─── TOKEN / QUEUE BOOKING ─── --}}
        @php
            $tokensLeft = $maxTokens - ($tokenCount ?? 0);
            $isFull     = $tokensLeft <= 0;
        @endphp

        <div class="mb-5 p-4 rounded-xl {{ $isFull ? 'bg-red-50 border border-red-200' : 'bg-teal-50 border border-teal-200' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-semibold text-sm {{ $isFull ? 'text-red-700' : 'text-teal-700' }}">
                        {{ $isFull ? '❌ Fully Booked for Selected Date' : '🎫 Token Queue Open' }}
                    </p>
                    <p class="text-xs mt-0.5 {{ $isFull ? 'text-red-500' : 'text-teal-600' }}">
                        {{ $tokenCount ?? 0 }} / {{ $maxTokens }} tokens taken
                        @if(!$isFull) · {{ $tokensLeft }} remaining @endif
                    </p>
                </div>
                @if(!$isFull)
                <div class="text-right">
                    <p class="text-2xl font-bold text-teal-700">{{ ($tokenCount ?? 0) + 1 }}</p>
                    <p class="text-xs text-teal-500">Your token</p>
                </div>
                @endif
            </div>
            <div class="mt-3 w-full bg-white rounded-full h-2 overflow-hidden border border-slate-100">
                <div class="h-2 rounded-full transition-all {{ $isFull ? 'bg-red-400' : 'bg-teal-400' }}"
                     style="width: {{ min(100, round((($tokenCount ?? 0) / max(1, $maxTokens)) * 100)) }}%"></div>
            </div>
        </div>

        @if(!$isFull)
        <form method="POST" action="/patient/doctors/{{ $doctor->id }}/book">
            @csrf
            {{-- Date picker --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Select Date *</label>
                <div class="flex gap-2 overflow-x-auto pb-2">
                    @foreach($dates as $d)
                    <label class="cursor-pointer flex-shrink-0">
                        <input type="radio" name="appointment_date" value="{{ $d }}"
                            {{ $d === $selectedDate ? 'checked' : '' }}
                            class="sr-only peer" required>
                        <div class="flex flex-col items-center px-4 py-3 rounded-xl border-2 transition-all duration-150 min-w-[64px] text-center
                                    border-slate-200 text-slate-600 hover:border-brand-300
                                    peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:text-brand-700">
                            <span class="text-[11px] font-medium uppercase">{{ \Carbon\Carbon::parse($d)->format('D') }}</span>
                            <span class="text-xl font-bold">{{ \Carbon\Carbon::parse($d)->format('j') }}</span>
                            <span class="text-[11px]">{{ \Carbon\Carbon::parse($d)->format('M') }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Notes for doctor <span class="text-slate-400 font-normal">(optional)</span></label>
                <textarea name="notes" rows="3" placeholder="Describe your symptoms or reason for visit…"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm resize-none focus:ring-2 focus:ring-brand-400 focus:border-transparent"></textarea>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit"
                    class="px-8 py-3 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-xl transition-all text-sm shadow-sm">
                    🎫 Get Token #{{ ($tokenCount ?? 0) + 1 }}
                </button>
                <p class="text-xs text-slate-400">You'll receive a token number instantly</p>
            </div>
        </form>

        @else
        {{-- Full — offer extra request --}}
        <div class="mt-4 p-4 bg-orange-50 border border-orange-200 rounded-xl">
            <p class="text-sm font-semibold text-orange-800 mb-1">📩 Request Doctor Approval</p>
            <p class="text-xs text-orange-600 mb-3">Today's tokens are full. You can still send a request — the doctor may approve you as an extra patient.</p>
            <form method="POST" action="/patient/doctors/{{ $doctor->id }}/book" class="space-y-3">
                @csrf
                <input type="hidden" name="appointment_date" value="{{ $selectedDate }}">
                <input type="hidden" name="request_extra" value="1">
                <textarea name="patient_note" rows="2" required
                    placeholder="Briefly explain your situation or urgency…"
                    class="w-full px-4 py-2.5 rounded-xl border border-orange-300 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
                <button type="submit"
                    class="px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl text-sm transition-all">
                    Submit Extra Request
                </button>
            </form>
        </div>
        @endif

        @endif
    </div>

    {{-- Reviews --}}
    @if($reviews->isNotEmpty())
    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">
        <h2 class="text-lg font-bold text-slate-900 mb-4">Patient Reviews</h2>
        <div class="space-y-4">
            @foreach($reviews as $review)
            <div class="pb-4 border-b border-slate-100 last:border-0 last:pb-0">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-semibold text-slate-800">{{ $review->patient->name }}</span>
                    <div class="flex gap-0.5">
                        @for($i=1;$i<=5;$i++)
                        <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-amber-400 text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                </div>
                <p class="text-sm text-slate-500 leading-relaxed">{{ $review->comment }}</p>
                <p class="text-xs text-slate-400 mt-1">{{ $review->created_at->format('M d, Y') }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
