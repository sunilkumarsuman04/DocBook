<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'DocBook'); ?> — DocBook</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Sora:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Sora','sans-serif'], display: ['Playfair Display','serif'] },
                    colors: {
                        brand: { 50:'#f0fdfa',100:'#ccfbf1',200:'#99f6e4',300:'#5eead4',400:'#2dd4bf',500:'#14b8a6',600:'#0d9488',700:'#0f766e',800:'#115e59',900:'#134e4a' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Sora', sans-serif; }
        h1,h2,h3 { font-family: 'Playfair Display', serif; }
        .card { @apply bg-white rounded-2xl shadow border border-slate-100 p-6; }
        ::-webkit-scrollbar { width:5px; height:5px; }
        ::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:99px; }
        .fade-in { animation: fadeIn .35s ease both; }
        @keyframes fadeIn { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">

<div class="flex min-h-screen">

    
    <aside class="w-60 bg-white border-r border-slate-100 flex flex-col h-screen sticky top-0 flex-shrink-0">
        
        <div class="flex items-center gap-2.5 px-5 py-5 border-b border-slate-100">
            <div class="w-8 h-8 bg-brand-500 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <span class="font-display font-bold text-slate-900 text-lg">DocBook</span>
        </div>

        
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
            <?php echo $__env->yieldContent('nav'); ?>
        </nav>

        
        <div class="px-3 pb-4 pt-2 border-t border-slate-100">
            <div class="flex items-center gap-2.5 px-2 py-2 mb-1">
                <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center text-xs font-bold flex-shrink-0">
                    <?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?>

                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate leading-tight"><?php echo e(auth()->user()->name); ?></p>
                    <p class="text-[11px] text-slate-400 truncate"><?php echo e(auth()->user()->role); ?></p>
                </div>
            </div>
            <form method="POST" action="/logout">
                <?php echo csrf_field(); ?>
                <button type="submit"
                    class="flex items-center gap-2 w-full px-3 py-2 text-sm text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Sign out
                </button>
            </form>
        </div>
    </aside>

    
    <main class="flex-1 min-w-0 overflow-x-hidden">
        <div class="max-w-6xl mx-auto px-6 lg:px-8 py-8 fade-in">

            
            <?php if(session('success')): ?>
                <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    <ul class="space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex items-center gap-2">
                                <span class="w-1 h-1 rounded-full bg-red-400 flex-shrink-0"></span><?php echo e($error); ?>

                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>
</div>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\User\Downloads\docbook1_final\docbook1\docbook1\resources\views/layouts/app.blade.php ENDPATH**/ ?>