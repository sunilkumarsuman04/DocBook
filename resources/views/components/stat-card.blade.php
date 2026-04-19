@props(['label','value','color' => 'teal'])
@php
$schemes = [
    'teal'  => 'bg-brand-50  border-brand-100',
    'blue'  => 'bg-blue-50   border-blue-100',
    'amber' => 'bg-amber-50  border-amber-100',
    'green' => 'bg-emerald-50 border-emerald-100',
    'purple'=> 'bg-purple-50 border-purple-100',
    'rose'  => 'bg-rose-50   border-rose-100',
];
$scheme = $schemes[$color] ?? $schemes['teal'];
@endphp
<div class="rounded-2xl border p-5 {{ $scheme }}">
    <p class="text-sm text-slate-500 mb-1">{{ $label }}</p>
    <p class="text-3xl font-display font-bold text-slate-900">{{ $value ?? '—' }}</p>
    @isset($sub) <p class="text-xs text-slate-400 mt-1">{{ $sub }}</p> @endisset
</div>
