<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo url('assets/css/app.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('assets/bootstrap/css/font-awesome.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('assets/css/extended.css'); ?>?v=<?php echo e(config('constants.css_version')); ?>" rel="stylesheet">
    <script src="<?php echo url('assets/js/jquery.min.js'); ?>"></script>
</head>
<body>
    <div class="loader"></div>
    <div class="cms-page ff-gothambook">
    <?php echo $__env->make('frontend.layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main class="container">
        <?php echo $__env->yieldContent('content'); ?>
    </main>



    <?php echo $__env->yieldSection(); ?>
    <?php echo $__env->make('frontend.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <script src="<?php echo url('assets/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
  </body>
</html>
<?php /**PATH C:\wamp\www\career\resources\views/frontend/layouts/app-cms.blade.php ENDPATH**/ ?>