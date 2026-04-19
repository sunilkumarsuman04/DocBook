<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title','Login') — DocBook</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Sora:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans:['Sora','sans-serif'], display:['Playfair Display','serif'] },
                    colors: {
                        brand: { 50:'#f0fdfa',100:'#ccfbf1',200:'#99f6e4',500:'#14b8a6',600:'#0d9488',700:'#0f766e' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family:'Sora',sans-serif; }
        h1,h2 { font-family:'Playfair Display',serif; }
        .slide-up { animation: slideUp .35s ease both; }
        @keyframes slideUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
        input:focus { outline:none; box-shadow:0 0 0 3px rgba(20,184,166,.2); border-color:#14b8a6; }
    </style>
</head>
<body class="min-h-screen flex antialiased bg-white" style="font-family:'Sora',sans-serif">

    {{-- Left hero --}}
    <div class="hidden lg:flex lg:w-5/12 bg-gradient-to-br from-brand-700 via-brand-600 to-brand-500 flex-col justify-between p-12 relative overflow-hidden">
        {{-- Rings --}}
        @foreach([280,420,560,700] as $s)
        <div class="absolute rounded-full border border-white/10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"
             style="width:{{$s}}px;height:{{$s}}px"></div>
        @endforeach

        {{-- Logo --}}
        <div class="relative flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <span class="font-display font-bold text-white text-xl">DocBook</span>
        </div>

        {{-- Copy --}}
        <div class="relative">
            <blockquote class="text-white font-display text-2xl leading-snug mb-6">
                "Healthcare made <em>simple</em>,<br>appointments made <em>instant</em>."
            </blockquote>
            <div class="flex gap-8">
                @foreach([['500+','Doctors'],['50k+','Patients'],['4.8★','Rating']] as [$n,$l])
                <div>
                    <p class="text-white font-bold text-xl">{{$n}}</p>
                    <p class="text-brand-200 text-xs">{{$l}}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right form --}}
    <div class="flex-1 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-md slide-up">
            {{-- Mobile logo --}}
            <div class="flex items-center gap-2 mb-8 lg:hidden">
                <div class="w-8 h-8 bg-brand-500 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="font-display font-bold text-slate-900">DocBook</span>
            </div>

            @if(session('success'))
                <div class="mb-5 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>
