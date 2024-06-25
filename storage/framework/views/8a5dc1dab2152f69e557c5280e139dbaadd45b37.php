
<?php $__env->startSection('title', 'Jobs'); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('frontend.jobs.partials.detail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.auth-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/jobs/detail.blade.php ENDPATH**/ ?>