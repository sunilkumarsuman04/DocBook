@extends('layouts.app')
@section('title','Doctor Profile')

@section('nav')
@php $r = request()->route()->getName(); @endphp
<x-nav-link href="/doctor/dashboard"    :active="$r==='doctor.dashboard'"    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'>Dashboard</x-nav-link>
<x-nav-link href="/doctor/profile"      :active="$r==='doctor.profile'"      icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'>My Profile</x-nav-link>
<x-nav-link href="/doctor/availability" :active="$r==='doctor.availability'" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'>Availability</x-nav-link>
<x-nav-link href="/doctor/appointments" :active="$r==='doctor.appointments'" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'>Appointments</x-nav-link>
<x-nav-link href="/doctor/settings"     :active="$r==='doctor.settings'"     icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'>Settings</x-nav-link>
@endsection

@section('content')
<div class="max-w-2xl">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Doctor Profile</h1>
        <p class="text-slate-400 text-sm mt-1">
            {{ $profile ? 'Update your professional information' : 'Complete your profile to start accepting patients' }}
        </p>
    </div>

    @if(!$profile || $profile->approval_status === 'PENDING')
    <div class="mb-5 p-4 bg-amber-50 border border-amber-200 rounded-xl text-sm text-amber-700">
        ⚠️ Your profile is pending admin approval. Fill in your details below.
    </div>
    @elseif($profile->approval_status === 'REJECTED')
    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
        ❌ Your profile was rejected. Reason: {{ $profile->rejection_reason ?? 'No reason provided.' }}
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">

        {{-- Header with doctor image --}}
        <div class="flex items-center gap-5 pb-6 mb-6 border-b border-slate-100">
            <div class="relative flex-shrink-0">
                @if($profile?->doctor_image)
                    <img src="{{ asset('storage/' . $profile->doctor_image) }}"
                         alt="Dr. {{ $doctor->name }}"
                         class="w-20 h-20 rounded-full object-cover border-2 border-brand-200">
                @else
                    <div class="w-20 h-20 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-2xl font-bold">
                        {{ strtoupper(substr($doctor->name, 0, 2)) }}
                    </div>
                @endif
            </div>
            <div>
                <h2 class="font-semibold text-slate-900 text-lg">Dr. {{ $doctor->name }}</h2>
                <p class="text-slate-400 text-sm">{{ $doctor->email }}</p>
                @if($profile)
                <x-badge :status="$profile->approval_status"/>
                @endif
            </div>
        </div>

        <form method="POST" action="/doctor/profile" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Doctor Profile Image --}}
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                <h3 class="text-sm font-semibold text-slate-700 mb-3">📷 Profile Image</h3>
                <input type="file" name="doctor_image" accept="image/jpeg,image/png,image/jpg"
                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                <p class="text-xs text-slate-400 mt-1.5">JPEG or PNG, max 2MB. Replaces existing image.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                {{-- Specialization --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Specialization *</label>
                    <select name="specialization" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                        <option value="">Select…</option>
                        @foreach($specializations as $s)
                        <option value="{{ $s }}" {{ old('specialization', $profile?->specialization) === $s ? 'selected' : '' }}>
                            {{ $s }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Experience --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Years of Experience</label>
                    <input type="number" name="experience" min="0" max="60"
                        value="{{ old('experience', $profile?->experience) }}"
                        placeholder="e.g. 5"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Phone Number</label>
                    <input type="text" name="phone"
                        value="{{ old('phone', $doctor->phone) }}"
                        placeholder="+91 98765 43210"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                {{-- Consultation Fee --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Consultation Fee (₹)</label>
                    <input type="number" name="consultation_fee" min="0" step="0.01"
                        value="{{ old('consultation_fee', $profile?->consultation_fee) }}"
                        placeholder="500"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                {{-- City --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">City</label>
                    <input type="text" name="city"
                        value="{{ old('city', $profile?->city) }}"
                        placeholder="Mumbai"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                {{-- Clinic Name --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Clinic / Hospital Name</label>
                    <input type="text" name="clinic_name"
                        value="{{ old('clinic_name', $profile?->clinic_name) }}"
                        placeholder="City Health Clinic"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                {{-- Booking Type --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Booking Type</label>
                    <select name="booking_type" id="booking_type_select"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                        <option value="time"  {{ old('booking_type', $profile?->booking_type) === 'time'  ? 'selected' : '' }}>⏰ Time Slot</option>
                        <option value="token" {{ old('booking_type', $profile?->booking_type) === 'token' ? 'selected' : '' }}>🎫 Token / Queue</option>
                    </select>
                </div>

                {{-- Max Tokens (shown for token mode) --}}
                <div id="max_tokens_field" class="{{ old('booking_type', $profile?->booking_type) === 'token' ? '' : 'hidden' }}">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Max Tokens Per Day</label>
                    <input type="number" name="max_tokens" min="1" max="500"
                        value="{{ old('max_tokens', $profile?->max_tokens ?? 30) }}"
                        placeholder="30"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                {{-- Max Patients (shown for time mode) --}}
                <div id="max_patients_field" class="{{ old('booking_type', $profile?->booking_type) !== 'token' ? '' : 'hidden' }}">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Max Patients Per Day</label>
                    <input type="number" name="max_patients_per_day" min="1" max="500"
                        value="{{ old('max_patients_per_day', $profile?->max_patients_per_day ?? 30) }}"
                        placeholder="30"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                {{-- Qualifications --}}
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Qualifications <span class="text-slate-400 font-normal">(comma-separated)</span></label>
                    <input type="text" name="qualifications"
                        value="{{ old('qualifications', is_array($profile?->qualifications) ? implode(', ', $profile->qualifications) : $profile?->qualifications) }}"
                        placeholder="MBBS, MD, DNB"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                {{-- Clinic Address --}}
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Clinic Address</label>
                    <input type="text" name="clinic_address"
                        value="{{ old('clinic_address', $profile?->clinic_address) }}"
                        placeholder="123 Main Street, Mumbai - 400001"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                {{-- Bio --}}
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Bio / About</label>
                    <textarea name="bio" rows="3"
                        placeholder="Brief description about your practice and expertise…"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">{{ old('bio', $profile?->bio) }}</textarea>
                </div>

                {{-- Allow Next Day --}}
                <div class="sm:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <div class="relative">
                            <input type="hidden" name="allow_next_day" value="0">
                            <input type="checkbox" name="allow_next_day" value="1"
                                {{ old('allow_next_day', $profile?->allow_next_day ?? true) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:bg-brand-500 transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">Allow future date bookings</p>
                            <p class="text-xs text-slate-400">When off, patients can only book for today</p>
                        </div>
                    </label>
                </div>

            </div>

            {{-- Hospital Images --}}
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                <h3 class="text-sm font-semibold text-slate-700 mb-3">🏥 Hospital / Clinic Images <span class="text-slate-400 font-normal">(Gallery)</span></h3>

                @if($hospitalImages->isNotEmpty())
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 mb-4">
                    @foreach($hospitalImages as $img)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $img->image_path) }}"
                             alt="Hospital image"
                             class="w-full h-24 object-cover rounded-lg border border-slate-200">
                        <form method="POST" action="/doctor/profile/hospital-image/{{ $img->id }}"
                              onsubmit="return confirm('Delete this image?')"
                              class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-6 h-6 bg-red-500 text-white rounded-full text-xs flex items-center justify-center shadow">✕</button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @endif

                <input type="file" name="hospital_images[]" multiple accept="image/jpeg,image/png,image/jpg"
                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                <p class="text-xs text-slate-400 mt-1.5">Select multiple images. JPEG or PNG, max 2MB each.</p>
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="px-8 py-3 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all text-sm shadow-sm">
                    {{ $profile ? '💾 Update Profile' : '🚀 Create Profile' }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const sel = document.getElementById('booking_type_select');
    const tokenField   = document.getElementById('max_tokens_field');
    const patientField = document.getElementById('max_patients_field');

    function toggleFields() {
        if (sel.value === 'token') {
            tokenField.classList.remove('hidden');
            patientField.classList.add('hidden');
        } else {
            tokenField.classList.add('hidden');
            patientField.classList.remove('hidden');
        }
    }

    sel.addEventListener('change', toggleFields);
    toggleFields();
</script>
@endpush
@endsection
