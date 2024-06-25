<header class="p-3 bg-dark tc-white-imp p-absolute w-100 header-blade ff-gothambook ">
  <div class="container jc-left top-header-container">
        <a class="navbar-brand" href="<?php echo e(route('landing.page')); ?>"><img src="<?php echo e(asset('assets/images/ideas-logo.png')); ?>" /></a>
        <ul class="custom-nav">
            <li class="a-s-center "><a href="#_" class="nav-link f-18px px-2 tc-white-imp"><?php echo e(Auth::guard('candidate')->user()->full_name); ?></a></li>  
            <li class="nav-item dropdownt">
                <a class="nav-link px-2 dropdown-toggle profileDiv" href="#" role="button" data-bs-toggle="dropdown">
                    
                    <?php if(!empty(Auth::guard('candidate')->user()->profile_image)): ?>
                        <img src="<?php echo e(asset(config('constants.files.profile'))); ?>/<?php echo e(Auth::guard('candidate')->user()->profile_image); ?>" class="dropdownImage" >
                    <?php else: ?>
                        <img src="<?php echo e(asset('assets/images/default/profile.jpg')); ?>" class="dropdownImage">
                    <?php endif; ?>
                
                </a>
                <div class="dropdown-menu profile-in">
                    <ul class="bg-dark">
                        <li><a href="<?php echo e(route('index')); ?>" class="dropdown-item  tc-white-imp">Home</a></li> 
                        <!--<li><a href="<?php echo e(route('tips-and-guides.index')); ?>" class="dropdown-item  tc-white-imp">Tips And Guides</a></li>-->
                        <li><a class="dropdown-item  tc-white-imp" data-toggle="modal" data-target="#myModal" id="open">Change Password</a></li>
                        <li><a href="<?php echo e(route('signout.perform')); ?>" class="dropdown-item  tc-white-imp">Signout</a></li> 
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</header>
<?php /**PATH C:\wamp\www\career\resources\views/frontend/layouts/top-header.blade.php ENDPATH**/ ?>