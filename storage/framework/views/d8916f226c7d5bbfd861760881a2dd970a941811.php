<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    

        <script src="<?php echo url('assets/js/jquery.min.js'); ?>"></script>
    <link href="<?php echo url('assets/css/extended.css'); ?>?v=<?php echo e(config('constants.css_version')); ?>" rel="stylesheet">
        <link href="<?php echo url('assets/css/timeline.css'); ?>" rel="stylesheet">
         <!-- Bootstrap core CSS -->
        <link href="<?php echo url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('assets/bootstrap/css/font-awesome.min.css'); ?>" rel="stylesheet">
</head>
<body>
    <div class="loader"></div>

    <div id="container" class="ff-gothambook app-profile">
        <?php echo $__env->make('frontend.layouts.top-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
       
        <?php echo $__env->make('frontend.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <?php echo $__env->make('frontend.includes.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
        
        <?php echo $__env->make('frontend.includes.modals.change-password', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
    <div>
    <div class="mt-5">
    <?php echo $__env->make('frontend.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div> 
     <script src="<?php echo url('assets/js/custom.js'); ?>"></script>
    <script src="<?php echo url('assets/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo url('assets/js/jquery.wallform.js'); ?>"></script>
    <script src="<?php echo url('assets/js/jquery-ui.min.js'); ?>"></script>

    

  </body>
</html>
<?php /**PATH C:\wamp\www\career\resources\views/frontend/layouts/app-master.blade.php ENDPATH**/ ?>