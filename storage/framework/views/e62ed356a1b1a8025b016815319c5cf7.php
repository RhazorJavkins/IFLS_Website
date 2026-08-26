

<?php $__env->startSection('title', __('messages.our_courses')); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h1 class="text-center mb-4"><?php echo e(__('messages.our_courses')); ?></h1>

    <!-- Filter Level -->
    <div class="row mb-4">
        <div class="col-md-6 mx-auto">
            <form method="GET" action="<?php echo e(url('/' . app()->getLocale() . '/courses')); ?>" class="d-flex gap-2">
                <select name="level" class="form-select">
                    <option value=""><?php echo e(__('messages.all_levels')); ?></option>
                    <option value="Pemula" <?php echo e(request('level') == 'Pemula' ? 'selected' : ''); ?>>
                        <?php echo e(__('messages.levels.Pemula')); ?>

                    </option>
                    <option value="Menengah" <?php echo e(request('level') == 'Menengah' ? 'selected' : ''); ?>>
                        <?php echo e(__('messages.levels.Menengah')); ?>

                    </option>
                    <option value="Lanjutan" <?php echo e(request('level') == 'Lanjutan' ? 'selected' : ''); ?>>
                        <?php echo e(__('messages.levels.Lanjutan')); ?>

                    </option>
                </select>
                <button type="submit" class="btn btn-primary"><?php echo e(__('messages.filter')); ?></button>
                <?php if(request('level')): ?>
                    <a href="<?php echo e(url('/' . app()->getLocale() . '/courses')); ?>" class="btn btn-secondary"><?php echo e(__('messages.reset')); ?></a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Level & Materi -->
    <div class="row mb-2">
        <div class="col-12 text-center">
            <h2><?php echo e(__('messages.level_and_materials')); ?></h2>
            <p class="text-muted"><?php echo e(__('messages.level_and_materials_subtitle')); ?></p>
        </div>
    </div>
    <div class="row g-4 mb-5">
        <?php $__currentLoopData = ['Pemula', 'Menengah', 'Lanjutan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lvl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $info = __('messages.levels_info.' . $lvl); ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <span class="badge bg-primary"><?php echo e(__('messages.levels.' . $lvl)); ?></span>
                        </h5>
                        <p class="card-text text-muted"><?php echo e($info['desc']); ?></p>
                        <h6 class="mt-3"><?php echo e(__('messages.materials_taught')); ?></h6>
                        <ul class="list-unstyled mb-3">
                            <?php $__currentLoopData = $info['materials']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><i class="fas fa-check-circle text-success me-2"></i><?php echo e($material); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <a href="<?php echo e(url('/' . app()->getLocale() . '/courses?level=' . $lvl)); ?>" class="btn btn-outline-primary btn-sm">
                            <?php echo e(__('messages.view_level_courses')); ?>

                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Grid Kursus -->
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($course->translated_name); ?></h5>
                        <p class="card-text text-muted">
                            <small>
                                <i class="fas fa-tag"></i> <?php echo e(\Illuminate\Support\Facades\Lang::has('messages.levels.' . $course->level) ? __('messages.levels.' . $course->level) : $course->level); ?> &nbsp;|&nbsp;
                                <i class="fas fa-clock"></i> <?php echo e($course->duration); ?> <?php echo e(__('messages.hours')); ?>

                            </small>
                        </p>
                        <p class="card-text"><?php echo e(Str::limit($course->translated_description, 100)); ?></p>
                        <h6 class="text-primary">Rp <?php echo e(number_format($course->price, 0, ',', '.')); ?></h6>
                        <a href="<?php echo e(route('courses.show', ['locale' => app()->getLocale(), 'course' => $course->id])); ?>" class="btn btn-outline-primary mt-2">
                            <?php echo e(__('messages.read_more')); ?>

                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center">
                <p><?php echo e(__('messages.no_courses')); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\if-language-school\resources\views/courses/index.blade.php ENDPATH**/ ?>