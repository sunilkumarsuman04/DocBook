<?php $__env->startSection('title','Register'); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-6">
    <h1 class="text-3xl font-bold text-slate-900 mb-1">Create account</h1>
    <p class="text-slate-400 text-sm">Join thousands managing their health with DocBook</p>
</div>


<?php if($errors->any()): ?> <div class="mb-4 text-red-500 text-sm">
<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <p><?php echo e($error); ?></p>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
<?php endif; ?>

<form method="POST" action="/register" class="space-y-4">
    <?php echo csrf_field(); ?>

```

<div class="grid grid-cols-2 gap-3 mb-2">
    <?php $__currentLoopData = ['patient' => ['Patient','Book appointments & track health'], 'doctor' => ['Doctor','Manage practice & patients']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => [$label, $desc]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <label class="relative cursor-pointer">
        <input type="radio" name="role" value="<?php echo e($val); ?>" class="sr-only peer"
            <?php echo e(old('role', 'patient') === $val ? 'checked' : ''); ?>>
        <div class="p-4 rounded-2xl border-2 border-slate-200 peer-checked:border-brand-500 peer-checked:bg-brand-50 hover:border-slate-300 transition-all">
            <p class="text-sm font-semibold text-slate-700 peer-checked:text-brand-700 mb-0.5"><?php echo e($label); ?></p>
            <p class="text-[11px] text-slate-400 leading-tight"><?php echo e($desc); ?></p>
        </div>
    </label>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div>
    <label class="block text-sm font-medium text-slate-700 mb-1.5">Full name</label>
    <input type="text" name="name" value="<?php echo e(old('name')); ?>" required autocomplete="name"
        placeholder="Jane Smith"
        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div>
    <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email"
        placeholder="you@example.com"
        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div>
    <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
    <input type="password" name="password" required autocomplete="new-password"
        placeholder="Min. 6 characters"
        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Downloads\docbook1_final\docbook1\docbook1\resources\views/auth/register.blade.php ENDPATH**/ ?>