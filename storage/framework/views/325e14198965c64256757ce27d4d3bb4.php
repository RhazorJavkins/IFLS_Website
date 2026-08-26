<?php $__env->startSection('title', __('messages.contact')); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h1 class="text-center mb-4"><?php echo e(__('messages.contact')); ?></h1>
    <p class="lead text-center"><?php echo e(__('messages.contact_intro')); ?></p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\if-language-school\resources\views/contact.blade.php ENDPATH**/ ?>