<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status']));

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

foreach (array_filter((['status']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
$cls = match($status) {
    'PENDING'   => 'bg-amber-100 text-amber-700',
    'CONFIRMED' => 'bg-blue-100 text-blue-700',
    'COMPLETED' => 'bg-emerald-100 text-emerald-700',
    'CANCELLED','REJECTED' => 'bg-red-100 text-red-700',
    'APPROVED'  => 'bg-emerald-100 text-emerald-700',
    'NO_SHOW'   => 'bg-slate-100 text-slate-600',
    default     => 'bg-slate-100 text-slate-600',
};
?>
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold <?php echo e($cls); ?>">
    <?php echo e($status); ?>

</span>
<?php /**PATH C:\Users\User\Downloads\docbook1_final\docbook1\docbook1\resources\views/components/badge.blade.php ENDPATH**/ ?>