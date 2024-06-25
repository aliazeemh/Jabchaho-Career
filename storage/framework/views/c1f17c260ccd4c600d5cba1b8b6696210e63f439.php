
<?php $__env->startSection('title', Arr::get($cmsDetail,'title')); ?>
<?php $__env->startSection('meta_keywords', Arr::get($cmsDetail,'meta_keywords')); ?>
<?php $__env->startSection('meta_description', Arr::get($cmsDetail,'meta_description')); ?>
<?php $__env->startSection('content'); ?>

<h3><?php echo e(Arr::get($cmsDetail,'title')); ?><h3>

<div class="content">
    <?php echo Arr::get($cmsDetail,'content'); ?>

</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app-cms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/cms/index.blade.php ENDPATH**/ ?>