@extends('layouts.app')
@section('title','Manage Users')
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
        <h1 class="text-2xl font-bold text-slate-900">Manage Users</h1>
        <p class="text-slate-400 text-sm mt-1">View and manage all registered users</p>
    </div>

    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <div class="flex gap-2">
            @foreach($roles as $role)
            <a href="?role={{ $role }}&search={{ request('search') }}"
               class="px-4 py-2 rounded-xl text-sm font-medium transition-colors
                      {{ request('role', 'ALL') === $role ? 'bg-brand-500 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                {{ $role }}
            </a>
            @endforeach
        </div>
        <form method="GET" class="sm:ml-auto">
            <input type="hidden" name="role" value="{{ request('role', 'ALL') }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email…"
                class="px-4 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 w-60">
        </form>
    </div>

    @if($users->isEmpty())
        <div class="text-center py-20">
            <p class="text-slate-500 font-semibold">No users found</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[580px]">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            @foreach(['User','Role','Joined','Status','Actions'] as $h)
                            <th class="text-left py-3.5 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ $h }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($users as $u)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0
                                        {{ $u->role === 'DOCTOR' ? 'bg-blue-100 text-blue-700' : 'bg-brand-100 text-brand-700' }}">
                                        {{ strtoupper(substr($u->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $u->name }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $u->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-5">
                                @php
                                $roleCls = match($u->role) { 'DOCTOR' => 'bg-blue-100 text-blue-700', 'ADMIN' => 'bg-purple-100 text-purple-700', default => 'bg-brand-100 text-brand-700' };
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $roleCls }}">{{ $u->role }}</span>
                            </td>
                            <td class="py-3.5 px-5 text-slate-500">{{ $u->created_at->format('M d, Y') }}</td>
                            <td class="py-3.5 px-5">
                                @if($u->is_active)
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Active</span>
                                @else
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">Inactive</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5">
                                @if($u->role !== 'ADMIN')
                                <form method="POST" action="/admin/users/{{ $u->id }}/toggle"
                                      onsubmit="return confirm('{{ $u->is_active ? 'Deactivate' : 'Activate' }} this user?')">
                                    @csrf
                                    <button class="text-xs px-3 py-1.5 rounded-lg font-medium transition-colors flex items-center gap-1
                                        {{ $u->is_active ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-brand-100 text-brand-700 hover:bg-brand-200' }}">
                                        {{ $u->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                @else
                                <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">{{ $users->links() }}</div>
    @endif
</div>
@endsection
