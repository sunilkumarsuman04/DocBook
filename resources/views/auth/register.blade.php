@extends('layouts.auth')
@section('title','Register')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-slate-900 mb-1">Create account</h1>
    <p class="text-slate-400 text-sm">Join thousands managing their health with DocBook</p>
</div>

{{-- 🔴 GLOBAL ERROR DISPLAY --}}
@if ($errors->any()) <div class="mb-4 text-red-500 text-sm">
@foreach ($errors->all() as $error) <p>{{ $error }}</p>
@endforeach </div>
@endif

<form method="POST" action="/register" class="space-y-4">
    @csrf

```
{{-- Role picker --}}
<div class="grid grid-cols-2 gap-3 mb-2">
    @foreach(['patient' => ['Patient','Book appointments & track health'], 'doctor' => ['Doctor','Manage practice & patients']] as $val => [$label, $desc])
    <label class="relative cursor-pointer">
        <input type="radio" name="role" value="{{ $val }}" class="sr-only peer"
            {{ old('role', 'patient') === $val ? 'checked' : '' }}>
        <div class="p-4 rounded-2xl border-2 border-slate-200 peer-checked:border-brand-500 peer-checked:bg-brand-50 hover:border-slate-300 transition-all">
            <p class="text-sm font-semibold text-slate-700 peer-checked:text-brand-700 mb-0.5">{{ $label }}</p>
            <p class="text-[11px] text-slate-400 leading-tight">{{ $desc }}</p>
        </div>
    </label>
    @endforeach
</div>

<div>
    <label class="block text-sm font-medium text-slate-700 mb-1.5">Full name</label>
    <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name"
        placeholder="Jane Smith"
        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm @error('name') border-red-400 @enderror">
    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
    <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
        placeholder="you@example.com"
        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm @error('email') border-red-400 @enderror">
    @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
    <input type="password" name="password" required autocomplete="new-password"
        placeholder="Min. 6 characters"
        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm @error('password') border-red-400 @enderror">
    @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-slate-700 mb-1.5">Confirm password</label>
    <input type="password" name="password_confirmation" required
        placeholder="••••••••"
        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
</div>

<div id="doctor-note" class="hidden p-3.5 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-700 leading-relaxed">
    <strong>Doctor accounts</strong> require admin approval before accepting patients.
</div>

<button type="submit"
    class="w-full flex items-center justify-center gap-2 py-3 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all duration-150 active:scale-[.98] shadow-sm hover:shadow-md mt-1">
    Create account
</button>
```

</form>

<p class="text-center text-sm text-slate-400 mt-6">
    Already have an account? <a href="/login" class="text-brand-600 font-semibold hover:text-brand-700">Sign in</a>
</p>

<script>
    document.querySelectorAll('input[name="role"]').forEach(r => {
        r.addEventListener('change', () => {
            document.getElementById('doctor-note').classList.toggle('hidden', r.value !== 'doctor')
        })
    });

    // Show on load if doctor selected
    if (document.querySelector('input[name="role"]:checked')?.value === 'doctor') {
        document.getElementById('doctor-note').classList.remove('hidden')
    }
</script>

@endsection
