@extends('layouts.app')
@section('title','Add Review')
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
        <h1 class="text-xl font-bold text-slate-900 mb-2">Add Review</h1>
        <p class="text-slate-400 text-sm mb-6">
            How was your experience with <strong class="text-slate-700">Dr. {{ $appointment->doctor->name }}</strong>?
        </p>

        <form method="POST" action="/patient/appointments/{{ $appointment->id }}/review" class="space-y-5">
            @csrf

            {{-- Star rating --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-3">Your rating</label>
                <div class="flex items-center gap-2" id="star-container">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button" data-star="{{ $i }}"
                        class="star-btn text-3xl transition-transform hover:scale-110 focus:outline-none"
                        aria-label="{{ $i }} star">
                        <span class="star-icon text-slate-200">★</span>
                    </button>
                    @endfor
                    <input type="hidden" name="rating" id="rating-input" value="5" required>
                    <span id="rating-label" class="text-lg font-display font-bold text-slate-800 ml-2">5<span class="text-slate-400 text-sm font-sans">/5</span></span>
                </div>
            </div>

            {{-- Comment --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Your review</label>
                <textarea name="comment" rows="4" required
                    placeholder="Share your experience with this doctor…"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent @error('comment') border-red-400 @enderror">{{ old('comment') }}</textarea>
                @error('comment') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3">
                <a href="/patient/appointments"
                   class="flex-1 text-center py-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold rounded-xl transition-all text-sm">
                    Cancel
                </a>
                <button type="submit"
                    class="flex-1 py-3 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all text-sm shadow-sm">
                    Submit Review
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const stars    = document.querySelectorAll('.star-btn')
    const input    = document.getElementById('rating-input')
    const label    = document.getElementById('rating-label')
    let current    = 5

    function paint(n) {
        stars.forEach((btn, idx) => {
            btn.querySelector('.star-icon').style.color = idx < n ? '#fbbf24' : '#e2e8f0'
        })
        label.innerHTML = `${n}<span class="text-slate-400 text-sm font-sans">/5</span>`
    }

    stars.forEach(btn => {
        const n = +btn.dataset.star
        btn.addEventListener('click', () => { current = n; input.value = n; paint(n) })
        btn.addEventListener('mouseenter', () => paint(n))
        btn.addEventListener('mouseleave', () => paint(current))
    })

    paint(current)
</script>
@endsection
