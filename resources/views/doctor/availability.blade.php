@extends('layouts.app')
@section('title','Availability')
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
        <h1 class="text-2xl font-bold text-slate-900">Availability</h1>
        <p class="text-slate-400 text-sm mt-1">Set your working hours and generate appointment slots</p>
    </div>

    {{-- Weekly schedule --}}
    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-slate-900">Weekly Schedule</h2>
        </div>

        <form method="POST" action="/doctor/availability" id="avail-form" class="space-y-3">
            @csrf

            <div class="flex items-center gap-3 mb-4">
                <label class="text-sm text-slate-600 font-medium">Slot duration:</label>
                <select name="slot_duration_minutes" class="px-3 py-1.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                    @foreach([15,20,30,45,60] as $d)
                    <option value="{{ $d }}">{{ $d }} min</option>
                    @endforeach
                </select>
            </div>

            @foreach($days as $day)
            @php $avail = $availabilities->get($day); $checked = (bool)$avail; @endphp
            <div class="flex items-center gap-4 p-3.5 rounded-xl transition-colors {{ $checked ? 'bg-brand-50' : 'bg-slate-50' }}" id="row-{{ $day }}">
                <label class="flex items-center gap-2.5 cursor-pointer w-40 flex-shrink-0">
                    <div class="relative">
                        <input type="checkbox" name="days[]" value="{{ $day }}" id="chk-{{ $day }}"
                            {{ $checked ? 'checked' : '' }}
                            class="sr-only peer"
                            onchange="toggleRow('{{ $day }}', this.checked)">
                        <div class="w-10 h-5 bg-slate-300 peer-checked:bg-brand-500 rounded-full transition-colors"></div>
                        <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                    </div>
                    <span class="text-sm font-medium {{ $checked ? 'text-brand-700' : 'text-slate-400' }}" id="label-{{ $day }}">
                        {{ ucfirst(strtolower($day)) }}
                    </span>
                </label>

                <div id="times-{{ $day }}" class="{{ $checked ? '' : 'hidden' }} flex items-center gap-2">
                    <input type="time" name="start_time[{{ $day }}]"
                        value="{{ $avail?->start_time ?? '09:00' }}"
                        class="px-3 py-1.5 rounded-xl border border-slate-200 text-sm w-32 focus:outline-none focus:ring-2 focus:ring-brand-400">
                    <span class="text-slate-400 text-sm">–</span>
                    <input type="time" name="end_time[{{ $day }}]"
                        value="{{ $avail?->end_time ?? '17:00' }}"
                        class="px-3 py-1.5 rounded-xl border border-slate-200 text-sm w-32 focus:outline-none focus:ring-2 focus:ring-brand-400">
                </div>
                @if(!$checked)
                <span id="off-{{ $day }}" class="text-sm text-slate-400 italic">Day off</span>
                @else
                <span id="off-{{ $day }}" class="text-sm text-slate-400 italic hidden">Day off</span>
                @endif
            </div>
            @endforeach

            <div class="flex justify-end pt-2">
                <button type="submit"
                    class="px-8 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all text-sm shadow-sm">
                    Save Schedule
                </button>
            </div>
        </form>
    </div>

    {{-- Generate slots --}}
    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">
        <h2 class="text-lg font-bold text-slate-900 mb-5">Generate Slots</h2>
        <form method="POST" action="/doctor/availability/generate" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">From date</label>
                    <input type="date" name="from_date" min="{{ now()->format('Y-m-d') }}"
                        value="{{ now()->format('Y-m-d') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">To date</label>
                    <input type="date" name="to_date" min="{{ now()->format('Y-m-d') }}"
                        value="{{ now()->addDays(7)->format('Y-m-d') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Slot duration</label>
                <select name="slot_duration_minutes" class="w-40 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                    @foreach([15,20,30,45,60] as $d)
                    <option value="{{ $d }}" {{ $d === 30 ? 'selected' : '' }}>{{ $d }} min</option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all text-sm shadow-sm">
                Generate Slots
            </button>
        </form>
    </div>
</div>

<script>
function toggleRow(day, checked) {
    document.getElementById('times-' + day).classList.toggle('hidden', !checked)
    document.getElementById('off-'   + day).classList.toggle('hidden',  checked)
    document.getElementById('row-'   + day).className =
        'flex items-center gap-4 p-3.5 rounded-xl transition-colors ' + (checked ? 'bg-brand-50' : 'bg-slate-50')
    document.getElementById('label-' + day).className =
        'text-sm font-medium ' + (checked ? 'text-brand-700' : 'text-slate-400')
}
</script>
@endsection
