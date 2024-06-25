<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Career</title>

       <script src="<?php echo url('assets/js/jquery.min.js'); ?>"></script>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" media='all'>
    <link rel="stylesheet" href="<?php echo url('assets/bootstrap/css/bootstrap-print.min.css'); ?>" media="print">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .float-right {
        float: right;
      }

      .pagination{
            float: right;
            margin-top: 10px;
        }
    </style>

    
</head>
<body>
    
    <?php echo $__env->make('backend.layouts.includes.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <main class="container mt-5">
       <div class="mt-2">
            <?php echo $__env->make('backend.layouts.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <script src="<?php echo url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo url('assets/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    
    <?php $__env->startSection("scripts"); ?>

    <?php echo $__env->yieldSection(); ?>
  </body>
</html>
<?php /**PATH C:\wamp\www\career\resources\views/backend/layouts/app-master.blade.php ENDPATH**/ ?>