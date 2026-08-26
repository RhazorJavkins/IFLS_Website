

<?php $__env->startSection('title', $course->translated_name); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <!-- Breadcrumb (Navigasi kembali ke daftar kursus) -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(url('/' . app()->getLocale() . '/courses')); ?>"><?php echo e(__('messages.our_courses')); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo e($course->translated_name); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- KOLOM KIRI: Detail Kursus -->
        <div class="col-md-8">
            <h1><?php echo e($course->translated_name); ?></h1>
            <p class="lead"><?php echo e($course->translated_description); ?></p>

            <div class="row mt-4">
                <div class="col-md-3">
                    <strong><?php echo e(__('messages.level')); ?></strong><br>
                    <?php echo e(\Illuminate\Support\Facades\Lang::has('messages.levels.' . $course->level) ? __('messages.levels.' . $course->level) : $course->level); ?>

                </div>
                <div class="col-md-3">
                    <strong><?php echo e(__('messages.duration')); ?></strong><br>
                    <?php echo e($course->duration); ?> <?php echo e(__('messages.hours')); ?>

                </div>
                <div class="col-md-3">
                    <strong><?php echo e(__('messages.price')); ?></strong><br>
                    <span class="text-primary fw-bold">Rp <?php echo e(number_format($course->price, 0, ',', '.')); ?></span>
                </div>
                <div class="col-md-3">
                    <strong><?php echo e(__('messages.max_students')); ?></strong><br>
                    <?php echo e($course->max_students); ?> <?php echo e(__('messages.students')); ?>

                </div>
            </div>

            <hr class="my-4">

            <!-- JADWAL ONLINE -->
            <h4>🖥️ <?php echo e(__('messages.online_schedule')); ?></h4>
            <?php if($onlineSchedules->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><?php echo e(__('messages.day')); ?></th>
                                <th><?php echo e(__('messages.time')); ?></th>
                                <th><?php echo e(__('messages.instructor')); ?></th>
                                <th><?php echo e(__('messages.quota')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $onlineSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(\Illuminate\Support\Facades\Lang::has('messages.days.' . $schedule->day) ? __('messages.days.' . $schedule->day) : $schedule->day); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($schedule->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($schedule->end_time)->format('H:i')); ?></td>
                                    <td><?php echo e($schedule->instructor); ?></td>
                                    <td><?php echo e($schedule->quota); ?> <?php echo e($schedule->is_full ? '(' . __('messages.full') . ')' : ''); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted"><?php echo e(__('messages.no_online_schedule')); ?></p>
            <?php endif; ?>

            <!-- JADWAL OFFLINE -->
            <h4 class="mt-4">🏫 <?php echo e(__('messages.offline_schedule')); ?></h4>
            <?php if($offlineSchedules->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><?php echo e(__('messages.day')); ?></th>
                                <th><?php echo e(__('messages.time')); ?></th>
                                <th><?php echo e(__('messages.instructor')); ?></th>
                                <th><?php echo e(__('messages.room')); ?></th>
                                <th><?php echo e(__('messages.quota')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $offlineSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(\Illuminate\Support\Facades\Lang::has('messages.days.' . $schedule->day) ? __('messages.days.' . $schedule->day) : $schedule->day); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($schedule->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($schedule->end_time)->format('H:i')); ?></td>
                                    <td><?php echo e($schedule->instructor); ?></td>
                                    <td><?php echo e($schedule->room); ?></td>
                                    <td><?php echo e($schedule->quota); ?> <?php echo e($schedule->is_full ? '(' . __('messages.full') . ')' : ''); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted"><?php echo e(__('messages.no_offline_schedule')); ?></p>
            <?php endif; ?>

            <!-- Tombol Daftar (Nanti akan diintegrasikan di Week 2) -->
            <div class="mt-4">
                <a href="#" class="btn btn-primary btn-lg"><?php echo e(__('messages.register_now')); ?></a>
            </div>
        </div>

        <!-- KOLOM KANAN: Sidebar -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5><?php echo e(__('messages.info')); ?></h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check-circle text-success"></i> <?php echo e(__('messages.certificate')); ?></li>
                        <li><i class="fas fa-check-circle text-success"></i> <?php echo e(__('messages.professional_teachers')); ?></li>
                        <li><i class="fas fa-check-circle text-success"></i> <?php echo e(__('messages.small_class', ['count' => $course->max_students])); ?></li>
                        <li><i class="fas fa-check-circle text-success"></i> <?php echo e(__('messages.free_trial')); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\if-language-school\resources\views/courses/show.blade.php ENDPATH**/ ?>