@props(['status'])
@php
$cls = match($status) {
    'PENDING'   => 'bg-amber-100 text-amber-700',
    'CONFIRMED' => 'bg-blue-100 text-blue-700',
    'COMPLETED' => 'bg-emerald-100 text-emerald-700',
    'CANCELLED','REJECTED' => 'bg-red-100 text-red-700',
    'APPROVED'  => 'bg-emerald-100 text-emerald-700',
    'NO_SHOW'   => 'bg-slate-100 text-slate-600',
    default     => 'bg-slate-100 text-slate-600',
};
@endphp
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $cls }}">
    {{ $status }}
</span>
