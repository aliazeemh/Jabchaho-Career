<header class="p-3 bg-dark text-white header-blade ff-gothambook">
  <div class="container jc-left">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark jc-left">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
        <a class="navbar-brand" href="<?php echo e(route('landing.page')); ?>"><img src="<?php echo e(asset('assets/images/ideas-logo.png')); ?>" /></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <div class="nav-pos">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active"><a href="<?php echo e(route('landing.page')); ?>" class="nav-link px-2 f-14px">Home</a></li>
              <li  class="nav-item"><a href="<?php echo e(route('cms.pages','about-us')); ?>" class="nav-link px-2 f-14px">About us</a></li>
              <li  class="nav-item"><a href="<?php echo e(route('jobs.list')); ?>" class="nav-link px-2 f-14px">Current Job Openings</a></li>
              <?php if(!Auth::guard('candidate')->user()): ?>
                <li class="nav-item"><a href="<?php echo e(route('drop.your.cv')); ?>" class="nav-link px-2 f-14px">DROP YOUR CV</a></li>
              <?php endif; ?>
            </ul>
            <?php if(!Auth::guard('candidate')->user()): ?>
            <ul class="navbar-nav mr-auto">
              <li class="nav-item"><a href="<?php echo e(route('signin.show')); ?>" class="nav-link px-2 f-14px">LOGIN</a></li>
              <span class="mobile-hide"> | </span>  
              <li class="nav-item"><a href="<?php echo e(route('signup.show')); ?>" class="nav-link px-2 f-14px">REGISTER</a></li>
            </ul>
            <?php endif; ?>
          </div>
        </div>
    </nav>    
  </div>
</header>
<div class="p-absolute w-100 h-300px banner-cover"></div>
<script src="<?php echo e(asset('assets/js/navbar-header.js')); ?>"></script><?php /**PATH C:\wamp\www\career\resources\views/frontend/layouts/navbar.blade.php ENDPATH**/ ?>