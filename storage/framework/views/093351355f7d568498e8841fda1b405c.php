<?php $__env->startSection('title','Doctor Profile'); ?>

<?php $__env->startSection('nav'); ?>
<?php $r = request()->route()->getName(); ?>
<?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => '/doctor/dashboard','active' => $r==='doctor.dashboard','icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => '/doctor/dashboard','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($r==='doctor.dashboard'),'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>']); ?>Dashboard <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => '/doctor/profile','active' => $r==='doctor.profile','icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => '/doctor/profile','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($r==='doctor.profile'),'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>']); ?>My Profile <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => '/doctor/availability','active' => $r==='doctor.availability','icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => '/doctor/availability','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($r==='doctor.availability'),'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>']); ?>Availability <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => '/doctor/appointments','active' => $r==='doctor.appointments','icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => '/doctor/appointments','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($r==='doctor.appointments'),'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>']); ?>Appointments <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => '/doctor/settings','active' => $r==='doctor.settings','icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => '/doctor/settings','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($r==='doctor.settings'),'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>']); ?>Settings <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Doctor Profile</h1>
        <p class="text-slate-400 text-sm mt-1">
            <?php echo e($profile ? 'Update your professional information' : 'Complete your profile to start accepting patients'); ?>

        </p>
    </div>

    <?php if(!$profile || $profile->approval_status === 'PENDING'): ?>
    <div class="mb-5 p-4 bg-amber-50 border border-amber-200 rounded-xl text-sm text-amber-700">
        ⚠️ Your profile is pending admin approval. Fill in your details below.
    </div>
    <?php elseif($profile->approval_status === 'REJECTED'): ?>
    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
        ❌ Your profile was rejected. Reason: <?php echo e($profile->rejection_reason ?? 'No reason provided.'); ?>

    </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow border border-slate-100 p-6">

        
        <div class="flex items-center gap-5 pb-6 mb-6 border-b border-slate-100">
            <div class="relative flex-shrink-0">
                <?php if($profile?->doctor_image): ?>
                    <img src="<?php echo e(asset('storage/' . $profile->doctor_image)); ?>"
                         alt="Dr. <?php echo e($doctor->name); ?>"
                         class="w-20 h-20 rounded-full object-cover border-2 border-brand-200">
                <?php else: ?>
                    <div class="w-20 h-20 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-2xl font-bold">
                        <?php echo e(strtoupper(substr($doctor->name, 0, 2))); ?>

                    </div>
                <?php endif; ?>
            </div>
            <div>
                <h2 class="font-semibold text-slate-900 text-lg">Dr. <?php echo e($doctor->name); ?></h2>
                <p class="text-slate-400 text-sm"><?php echo e($doctor->email); ?></p>
                <?php if($profile): ?>
                <?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => ['status' => $profile->approval_status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($profile->approval_status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <form method="POST" action="/doctor/profile" enctype="multipart/form-data" class="space-y-5">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                <h3 class="text-sm font-semibold text-slate-700 mb-3">📷 Profile Image</h3>
                <input type="file" name="doctor_image" accept="image/jpeg,image/png,image/jpg"
                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                <p class="text-xs text-slate-400 mt-1.5">JPEG or PNG, max 2MB. Replaces existing image.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Specialization *</label>
                    <select name="specialization" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                        <option value="">Select…</option>
                        <?php $__currentLoopData = $specializations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e(old('specialization', $profile?->specialization) === $s ? 'selected' : ''); ?>>
                            <?php echo e($s); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Years of Experience</label>
                    <input type="number" name="experience" min="0" max="60"
                        value="<?php echo e(old('experience', $profile?->experience)); ?>"
                        placeholder="e.g. 5"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Phone Number</label>
                    <input type="text" name="phone"
                        value="<?php echo e(old('phone', $doctor->phone)); ?>"
                        placeholder="+91 98765 43210"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Consultation Fee (₹)</label>
                    <input type="number" name="consultation_fee" min="0" step="0.01"
                        value="<?php echo e(old('consultation_fee', $profile?->consultation_fee)); ?>"
                        placeholder="500"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">City</label>
                    <input type="text" name="city"
                        value="<?php echo e(old('city', $profile?->city)); ?>"
                        placeholder="Mumbai"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Clinic / Hospital Name</label>
                    <input type="text" name="clinic_name"
                        value="<?php echo e(old('clinic_name', $profile?->clinic_name)); ?>"
                        placeholder="City Health Clinic"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Booking Type</label>
                    <select name="booking_type" id="booking_type_select"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                        <option value="time"  <?php echo e(old('booking_type', $profile?->booking_type) === 'time'  ? 'selected' : ''); ?>>⏰ Time Slot</option>
                        <option value="token" <?php echo e(old('booking_type', $profile?->booking_type) === 'token' ? 'selected' : ''); ?>>🎫 Token / Queue</option>
                    </select>
                </div>

                
                <div id="max_tokens_field" class="<?php echo e(old('booking_type', $profile?->booking_type) === 'token' ? '' : 'hidden'); ?>">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Max Tokens Per Day</label>
                    <input type="number" name="max_tokens" min="1" max="500"
                        value="<?php echo e(old('max_tokens', $profile?->max_tokens ?? 30)); ?>"
                        placeholder="30"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                
                <div id="max_patients_field" class="<?php echo e(old('booking_type', $profile?->booking_type) !== 'token' ? '' : 'hidden'); ?>">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Max Patients Per Day</label>
                    <input type="number" name="max_patients_per_day" min="1" max="500"
                        value="<?php echo e(old('max_patients_per_day', $profile?->max_patients_per_day ?? 30)); ?>"
                        placeholder="30"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Qualifications <span class="text-slate-400 font-normal">(comma-separated)</span></label>
                    <input type="text" name="qualifications"
                        value="<?php echo e(old('qualifications', is_array($profile?->qualifications) ? implode(', ', $profile->qualifications) : $profile?->qualifications)); ?>"
                        placeholder="MBBS, MD, DNB"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Clinic Address</label>
                    <input type="text" name="clinic_address"
                        value="<?php echo e(old('clinic_address', $profile?->clinic_address)); ?>"
                        placeholder="123 Main Street, Mumbai - 400001"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                </div>

                
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Bio / About</label>
                    <textarea name="bio" rows="3"
                        placeholder="Brief description about your practice and expertise…"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent"><?php echo e(old('bio', $profile?->bio)); ?></textarea>
                </div>

                
                <div class="sm:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <div class="relative">
                            <input type="hidden" name="allow_next_day" value="0">
                            <input type="checkbox" name="allow_next_day" value="1"
                                <?php echo e(old('allow_next_day', $profile?->allow_next_day ?? true) ? 'checked' : ''); ?>

                                class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:bg-brand-500 transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">Allow future date bookings</p>
                            <p class="text-xs text-slate-400">When off, patients can only book for today</p>
                        </div>
                    </label>
                </div>

            </div>

            
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                <h3 class="text-sm font-semibold text-slate-700 mb-3">🏥 Hospital / Clinic Images <span class="text-slate-400 font-normal">(Gallery)</span></h3>

                <?php if($hospitalImages->isNotEmpty()): ?>
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 mb-4">
                    <?php $__currentLoopData = $hospitalImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="relative group">
                        <img src="<?php echo e(asset('storage/' . $img->image_path)); ?>"
                             alt="Hospital image"
                             class="w-full h-24 object-cover rounded-lg border border-slate-200">
                        <form method="POST" action="/doctor/profile/hospital-image/<?php echo e($img->id); ?>"
                              onsubmit="return confirm('Delete this image?')"
                              class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                class="w-6 h-6 bg-red-500 text-white rounded-full text-xs flex items-center justify-center shadow">✕</button>
                        </form>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <input type="file" name="hospital_images[]" multiple accept="image/jpeg,image/png,image/jpg"
                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                <p class="text-xs text-slate-400 mt-1.5">Select multiple images. JPEG or PNG, max 2MB each.</p>
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="px-8 py-3 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all text-sm shadow-sm">
                    <?php echo e($profile ? '💾 Update Profile' : '🚀 Create Profile'); ?>

                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    const sel = document.getElementById('booking_type_select');
    const tokenField   = document.getElementById('max_tokens_field');
    const patientField = document.getElementById('max_patients_field');

    function toggleFields() {
        if (sel.value === 'token') {
            tokenField.classList.remove('hidden');
            patientField.classList.add('hidden');
        } else {
            tokenField.classList.add('hidden');
            patientField.classList.remove('hidden');
        }
    }

    sel.addEventListener('change', toggleFields);
    toggleFields();
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Downloads\docbook1_final\docbook1\docbook1\resources\views/doctor/profile.blade.php ENDPATH**/ ?>