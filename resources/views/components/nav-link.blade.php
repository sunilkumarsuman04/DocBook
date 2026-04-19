@props(['href', 'active' => false, 'icon' => ''])
<a href="{{ $href }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-100
          {{ $active ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
    {!! $icon !!}
    {{ $slot }}
</a>
