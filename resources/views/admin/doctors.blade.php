@extends('layouts.app')
@section('title','Manage Doctors')
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
        <h1 class="text-2xl font-bold text-slate-900">Manage Doctors</h1>
        <p class="text-slate-400 text-sm mt-1">Review, approve or reject doctor registrations</p>
    </div>

    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <div class="flex gap-2 overflow-x-auto pb-1">
            @foreach($statuses as $s)
            <a href="?status={{ $s }}"
               class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-colors
                      {{ request('status', 'ALL') === $s ? 'bg-brand-500 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                {{ $s }}
            </a>
            @endforeach
        </div>
        <form method="GET" class="sm:ml-auto">
            <input type="hidden" name="status" value="{{ request('status', 'ALL') }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name…"
                class="px-4 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 w-56">
        </form>
    </div>

    @if($doctors->isEmpty())
        <div class="text-center py-20">
            <p class="text-slate-500 font-semibold">No doctors found</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[680px]">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            @foreach(['Doctor','Specialization','City','Fee','Status','Actions'] as $h)
                            <th class="text-left py-3.5 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ $h }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($doctors as $doc)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                        {{ strtoupper(substr($doc->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900">Dr. {{ $doc->name }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $doc->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-5 text-slate-600">{{ $doc->doctorProfile?->specialization ?: '—' }}</td>
                            <td class="py-3.5 px-5 text-slate-600">{{ $doc->doctorProfile?->city ?: '—' }}</td>
                            <td class="py-3.5 px-5 font-medium text-slate-700">
                                {{ $doc->doctorProfile?->consultation_fee ? '₹'.number_format($doc->doctorProfile->consultation_fee) : '—' }}
                            </td>
                            <td class="py-3.5 px-5">
                                <x-badge :status="$doc->doctorProfile?->approval_status ?? 'PENDING'"/>
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="flex gap-1.5 flex-wrap">
                                    @if(!$doc->doctorProfile || $doc->doctorProfile->approval_status === 'PENDING' || $doc->doctorProfile->approval_status === 'REJECTED')
                                    <form method="POST" action="/admin/doctors/{{ $doc->id }}/approve">
                                        @csrf
                                        <button class="text-xs px-2.5 py-1 bg-brand-100 text-brand-700 rounded-lg hover:bg-brand-200 font-medium transition-colors">Approve</button>
                                    </form>
                                    @endif
                                    @if(!$doc->doctorProfile || $doc->doctorProfile->approval_status !== 'REJECTED')
                                    <button onclick="openReject({{ $doc->id }}, '{{ addslashes($doc->name) }}')"
                                        class="text-xs px-2.5 py-1 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 font-medium transition-colors">
                                        {{ $doc->doctorProfile?->approval_status === 'APPROVED' ? 'Revoke' : 'Reject' }}
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">{{ $doctors->links() }}</div>
    @endif
</div>

{{-- Reject modal --}}
<div id="reject-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeReject()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
        <h3 class="font-bold text-slate-900 text-lg mb-1">Reject / Revoke Doctor</h3>
        <p class="text-slate-400 text-sm mb-5" id="reject-name"></p>
        <form method="POST" id="reject-form">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Reason *</label>
                <textarea name="reason" rows="4" required placeholder="Provide a clear reason…"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeReject()" class="flex-1 py-2.5 bg-white border border-slate-200 text-slate-700 font-semibold rounded-xl text-sm">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl text-sm">Confirm</button>
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
function closeReject() { document.getElementById('reject-modal').classList.replace('flex','hidden') }
</script>
@endsection
