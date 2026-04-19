<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['label','value','color' => 'teal']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['label','value','color' => 'teal']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
$schemes = [
    'teal'  => 'bg-brand-50  border-brand-100',
    'blue'  => 'bg-blue-50   border-blue-100',
    'amber' => 'bg-amber-50  border-amber-100',
    'green' => 'bg-emerald-50 border-emerald-100',
    'purple'=> 'bg-purple-50 border-purple-100',
    'rose'  => 'bg-rose-50   border-rose-100',
];
$scheme = $schemes[$color] ?? $schemes['teal'];
?>
<div class="rounded-2xl border p-5 <?php echo e($scheme); ?>">
    <p class="text-sm text-slate-500 mb-1"><?php echo e($label); ?></p>
    <p class="text-3xl font-display font-bold text-slate-900"><?php echo e($value ?? '—'); ?></p>
    <?php if(isset($sub)): ?> <p class="text-xs text-slate-400 mt-1"><?php echo e($sub); ?></p> <?php endif; ?>
</div>
<?php /**PATH C:\Users\User\Downloads\docbook1_final\docbook1\docbook1\resources\views/components/stat-card.blade.php ENDPATH**/ ?>