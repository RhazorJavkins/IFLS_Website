

<?php $__env->startSection('title', 'Home - IF Language School'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4 fw-bold"><?php echo e(__('messages.welcome_title')); ?></h1>
            <p class="lead"><?php echo e(__('messages.welcome_subtitle')); ?></p>
            <a href="<?php echo e(url('/' . app()->getLocale() . '/courses')); ?>" class="btn btn-primary btn-lg mt-3">
                <?php echo e(__('messages.get_started')); ?>

            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\if-language-school\resources\views/home.blade.php ENDPATH**/ ?>