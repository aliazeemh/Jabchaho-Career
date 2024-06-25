

<?php $__env->startSection('content'); ?>
    <div class="bg-light p-4 rounded">
        <?php if(auth()->guard()->check()): ?>
        <h1>Dashboard</h1>
        <p class="lead">Only authenticated users can access this section.</p>
        <?php endif; ?>

        <?php if(auth()->guard()->guest()): ?>
        <h1>Homepage</h1>
        <p class="lead">Your viewing the home page. Please login to view the restricted data.</p>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/backend/home/index.blade.php ENDPATH**/ ?>