<header class="p-3 bg-dark text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
      </a>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <!--<li><a href="<?php echo e(route('home.index')); ?>" class="nav-link px-2 text-white">Home</a></li>-->
        <?php if(auth()->guard()->check()): ?>
        <?php if(Auth::user()->can('users.index') || Auth::user()->can('roles.index') || Auth::user()->can('permissions.index') ): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Users
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <?php if(Auth::user()->can('users.index')): ?>
              <li><a href="<?php echo e(route('users.index')); ?>" class="dropdown-item">Users</a></li>
              <?php endif; ?>
              <?php if(Auth::user()->can('roles.index')): ?>
              <li><a href="<?php echo e(route('roles.index')); ?>" class="dropdown-item">Roles</a></li>
              <?php endif; ?>
              <?php if(Auth::user()->can('permissions.index')): ?>
              <li><a href="<?php echo e(route('permissions.index')); ?>" class="dropdown-item">Permission</a></li>
              <?php endif; ?>
            </ul>
          </li>
          
          <?php endif; ?>
          
          <?php if(Auth::user()->can('candidates.index') || Auth::user()->can('applicants.index')): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Candidates
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <?php if(Auth::user()->can('candidates.index')): ?>  
                <li><a href="<?php echo e(route('candidates.index')); ?>" class="dropdown-item">Candidates</a></li>
              <?php endif; ?>
              <?php if(Auth::user()->can('applicants.index')): ?>  
                <li><a href="<?php echo e(route('applicants.index')); ?>" class="dropdown-item">Applicants</a></li>
              <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

          <?php if(Auth::user()->can('jobs.index') || Auth::user()->can('job_benefits.index')): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Jobs
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">  
              <?php if(Auth::user()->can('jobs.index')): ?>
                 <li><a href="<?php echo e(route('jobs.index')); ?>" class="dropdown-item">Jobs</a></li>
              <?php endif; ?>
              <?php if(Auth::user()->can('job_benefits.index')): ?>
                 <li><a href="<?php echo e(route('job_benefits.index')); ?>" class="dropdown-item">Benefits</a></li>
              <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>  
          
          <?php if(Auth::user()->can('shifts.index') || Auth::user()->can('job_types.index') || Auth::user()->can('skill_sets.index') ): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Configurations
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <?php if(Auth::user()->can('shifts.index')): ?>
              <li><a href="<?php echo e(route('shifts.index')); ?>" class="dropdown-item">Shifts</a></li>
              <?php endif; ?>
              <?php if(Auth::user()->can('job_types.index')): ?>
              <li><a href="<?php echo e(route('job_types.index')); ?>" class="dropdown-item">Job Types</a></li>
              <?php endif; ?>
              <?php if(Auth::user()->can('skill_sets.index')): ?>
              <li><a href="<?php echo e(route('skill_sets.index')); ?>" class="dropdown-item">Skill Sets</a></li>
              <?php endif; ?>
            </ul>
          </li>
          
          <?php endif; ?>
               
          <?php if(Auth::user()->can('area_of_interest_groups.index') || Auth::user()->can('area_of_interest_options.index') ): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Area of Interest
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php if(Auth::user()->can('area_of_interest_groups.index')): ?>
              <li><a class="dropdown-item" href="<?php echo e(route('area_of_interest_groups.index')); ?>">Groups</a></li>
            <?php endif; ?>  
            
            <?php if(Auth::user()->can('area_of_interest_options.index')): ?>
              <li><a class="dropdown-item" href="<?php echo e(route('area_of_interest_options.index')); ?>">Options</a></li>
            <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>


          <?php if(Auth::user()->can('facility_groups.index') || Auth::user()->can('facility_options.index') ): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Facilities
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <?php if(Auth::user()->can('facility_groups.index')): ?>
                <li><a class="dropdown-item" href="<?php echo e(route('facility_groups.index')); ?>">Groups</a></li>
              <?php endif; ?> 
              <?php if(Auth::user()->can('facility_options.index')): ?>
                <li><a class="dropdown-item" href="<?php echo e(route('facility_options.index')); ?>">Options</a></li>
              <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

          <?php if(Auth::user()->can('home_content.index') || Auth::user()->can('tips_and_guides.index') || Auth::user()->can('cms.index') ): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            CMS
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <?php if(Auth::user()->can('home_content.index')): ?>
                <li><a href="<?php echo e(route('home_content.index')); ?>" class="dropdown-item">Home Content</a></li>
              <?php endif; ?> 
              <?php if(Auth::user()->can('tips_and_guides.index')): ?>
              <li><a href="<?php echo e(route('tips_and_guides.index')); ?>" class="dropdown-item">Tips and Guides</a></li>  
              <?php endif; ?> 
              <?php if(Auth::user()->can('cms.index')): ?>
              <li><a class="dropdown-item" href="<?php echo e(route('cms.index')); ?>">Pages</a></li>
              <?php endif; ?> 
            </ul>
          </li>

          <?php endif; ?>

        <?php endif; ?>
      </ul>

      <!--<form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
        <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
      </form>-->

      <?php if(auth()->guard()->check()): ?>
        <?php echo e(auth()->user()->name); ?>&nbsp;
        <div class="text-end">
          <a href="<?php echo e(route('logout.perform')); ?>" class="btn btn-outline-light me-2">Logout</a>
        </div>
      <?php endif; ?>

    </div>
  </div>
</header><?php /**PATH C:\wamp\www\career\resources\views/backend/layouts/includes/navbar.blade.php ENDPATH**/ ?>