@extends('layouts.app')
@section('title','Make Payment')
@section('nav')
    <x-nav-link href="/patient/dashboard" :active="false" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'>Dashboard</x-nav-link>
    <x-nav-link href="/patient/appointments" :active="true" icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'>Appointments</x-nav-link>
@endsection

@section('content')
<div class="max-w-md mx-auto">
    <a href="/patient/appointments" class="flex items-center gap-1.5 text-slate-400 hover:text-slate-700 text-sm mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to appointments
    </a>

    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">
        <h1 class="text-xl font-bold text-slate-900 mb-6">Make Payment</h1>

        {{-- Amount --}}
        <div class="bg-slate-50 rounded-2xl p-6 text-center mb-6">
            <p class="text-xs text-slate-400 mb-1">Amount due</p>
            <p class="text-4xl font-display font-bold text-slate-900">₹{{ number_format($appointment->consultation_fee) }}</p>
            <p class="text-xs text-slate-400 mt-1">
                Dr. {{ $appointment->doctor->name }} · {{ $appointment->appointment_date->format('M d, Y') }}
            </p>
        </div>

        <form method="POST" action="/patient/appointments/{{ $appointment->id }}/pay" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Payment method</label>
                <div class="space-y-2">
                    @foreach(['CARD' => '💳  Credit / Debit Card', 'UPI' => '📱  UPI', 'NET_BANKING' => '🏦  Net Banking'] as $val => $label)
                    <label class="flex items-center gap-3 p-3.5 rounded-xl border-2 border-slate-200 cursor-pointer hover:border-slate-300 transition-all has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50">
                        <input type="radio" name="method" value="{{ $val }}" {{ $val === 'CARD' ? 'checked' : '' }} class="accent-brand-500">
                        <span class="text-sm font-medium text-slate-700">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Dummy card fields --}}
            <div id="card-fields" class="space-y-3">
                <input class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm" placeholder="Card number" maxlength="19">
                <div class="grid grid-cols-2 gap-3">
                    <input class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm" placeholder="MM / YY" maxlength="5">
                    <input class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm" placeholder="CVV" type="password" maxlength="4">
                </div>
                <input class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm" placeholder="Cardholder name">
            </div>

            <button type="submit"
                class="w-full py-3 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all shadow-sm">
                Pay Now
            </button>
            <p class="text-xs text-center text-slate-400">🔒 Demo only — no real transaction</p>
        </form>
    </div>
</div>
@endsection
