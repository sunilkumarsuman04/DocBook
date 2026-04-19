@extends('layouts.app')
@section('title','Admin Dashboard')

@section('nav')
    @php $r = request()->route()->getName(); @endphp
    <x-nav-link href="/admin/dashboard"    :active="$r==='admin.dashboard'"    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'>Dashboard</x-nav-link>
    <x-nav-link href="/admin/doctors"      :active="$r==='admin.doctors'"      icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>'>Doctors</x-nav-link>
    <x-nav-link href="/admin/users"        :active="$r==='admin.users'"        icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>'>Users</x-nav-link>
    <x-nav-link href="/admin/appointments" :active="$r==='admin.appointments'" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'>Appointments</x-nav-link>
@endsection

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Admin Dashboard</h1>
        <p class="text-slate-400 text-sm mt-1">Platform overview and management</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
        <x-stat-card label="Total Patients"  :value="$stats['total_patients']"  color="teal"/>
        <x-stat-card label="Active Doctors"  :value="$stats['total_doctors']"   color="blue"/>
        <x-stat-card label="Pending Approval":value="$stats['pending_doctors']" color="amber"/>
        <x-stat-card label="All Users"       :value="$stats['total_users']"     color="purple"/>
        <x-stat-card label="All Appointments":value="$stats['total_apts']"      color="green"/>
        <x-stat-card label="Today's Bookings":value="$stats['today_apts']"      color="rose"/>
    </div>

    {{-- Pending doctors --}}
    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2">
                <h2 class="text-lg font-bold text-slate-900">Pending Doctor Approvals</h2>
                @if($pendingDoctors->isNotEmpty())
                <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-xs font-bold rounded-full">{{ $pendingDoctors->count() }}</span>
                @endif
            </div>
            <a href="/admin/doctors?status=PENDING" class="text-sm text-brand-600 font-medium hover:text-brand-700">View all →</a>
        </div>

        @if($pendingDoctors->isEmpty())
            <div class="text-center py-8">
                <p class="text-2xl mb-2">✅</p>
                <p class="text-slate-500 font-medium text-sm">All caught up! No pending approvals.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($pendingDoctors as $doc)
                <div class="flex items-center justify-between p-4 bg-amber-50 border border-amber-100 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-sm font-bold flex-shrink-0">
                            {{ strtoupper(substr($doc->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900 text-sm">Dr. {{ $doc->name }}</p>
                            <p class="text-xs text-slate-500">{{ $doc->doctorProfile?->specialization }} · {{ $doc->doctorProfile?->city ?: 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <form method="POST" action="/admin/doctors/{{ $doc->id }}/approve">
                            @csrf
                            <button class="px-3.5 py-1.5 bg-brand-500 hover:bg-brand-600 text-white text-xs font-semibold rounded-xl transition-colors">
                                Approve
                            </button>
                        </form>
                        <button onclick="openReject({{ $doc->id }}, '{{ addslashes($doc->name) }}')"
                            class="px-3.5 py-1.5 bg-white border border-red-200 text-red-600 hover:bg-red-50 text-xs font-semibold rounded-xl transition-colors">
                            Reject
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Recent appointments --}}
    @if($recentApts->isNotEmpty())
    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">
        <h2 class="text-lg font-bold text-slate-900 mb-5">Recent Appointments</h2>
        <div class="overflow-x-auto -mx-6">
            <table class="w-full text-sm min-w-[480px]">
                <thead>
                    <tr class="border-b border-slate-100">
                        @foreach(['Patient','Doctor','Date','Status'] as $h)
                        <th class="text-left py-3 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($recentApts as $apt)
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-6 font-medium text-slate-800">{{ $apt->patient->name }}</td>
                        <td class="py-3 px-6 text-slate-600">Dr. {{ $apt->doctor->name }}</td>
                        <td class="py-3 px-6 text-slate-600">{{ $apt->appointment_date->format('M d, Y') }}</td>
                        <td class="py-3 px-6"><x-badge :status="$apt->status"/></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

{{-- Reject modal --}}
<div id="reject-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeReject()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
        <h3 class="font-bold text-slate-900 text-lg mb-1">Reject Doctor</h3>
        <p class="text-slate-400 text-sm mb-5" id="reject-name"></p>
        <form method="POST" id="reject-form">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Reason for rejection *</label>
                <textarea name="reason" rows="4" required
                    placeholder="Provide a clear reason so the doctor can reapply with corrections…"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeReject()"
                    class="flex-1 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold rounded-xl text-sm transition-all">Cancel</button>
                <button type="submit"
                    class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl text-sm transition-all">Confirm Rejection</button>
            </div>
        </form>
    </div>
</div>

<script>
function openReject(id, name) {
    document.getElementById('reject-form').action = '/admin/doctors/' + id + '/reject'
    document.getElementById('reject-name').textContent = 'Dr. ' + name
    document.getElementById('reject-modal').classList.replace('hidden','flex')
}
function closeReject() {
    document.getElementById('reject-modal').classList.replace('flex','hidden')
}
</script>
@endsection
