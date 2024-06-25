
<?php $__env->startSection('title', 'Jobs'); ?>

<?php $__env->startSection('content'); ?>


<div class="container mb-3 first-child">
    <?php echo $__env->make('frontend.jobs.partials.list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/jobs/auth_list.blade.php ENDPATH**/ ?>