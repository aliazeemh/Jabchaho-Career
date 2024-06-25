<div class="card sidenav">
    <h6 class="card-header">Fill Application Form</h6>
    <ul class="list-group list-group-flush">
        <li class="list-group-item <?php if(Request::segment(1) =='personal-details'): ?> active <?php endif; ?> "><a href="<?php echo e(route('personal.details.show')); ?>">Personal Information</a></li>
        <li class="list-group-item dropdown <?php if(Request::segment(1) =='educational-qualification' || Request::segment(1) =='diploma'|| Request::segment(1) =='certification'): ?> active <?php endif; ?> ">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"  data-bs-toggle="dropdown">Education</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li class="dropdown-item <?php if(Request::segment(1) =='educational-qualification'): ?> active <?php endif; ?> "><a href="<?php echo e(route('educational.qualification.show')); ?>">Qualification </a></li>
                <li class="dropdown-item <?php if(Request::segment(1) =='diploma'): ?> active <?php endif; ?> "><a href="<?php echo e(route('diploma.show')); ?>">Diploma</a></li> 
                <li class="dropdown-item <?php if(Request::segment(1) =='certification'): ?> active <?php endif; ?> "><a href="<?php echo e(route('certification.show')); ?>">Certification</a></li>    
            </ul>
        </li>
        <li class="list-group-item <?php if(Request::segment(1) =='professional-experience'): ?> active <?php endif; ?> "><a href="<?php echo e(route('professional.experience.show')); ?>">Professional Experience</a></li>
        <li class="list-group-item <?php if(Request::segment(1) =='skill-set'): ?> active <?php endif; ?> "><a href="<?php echo e(route('skillset.show')); ?>">Competencies</a></li>
        <li class="list-group-item <?php if(Request::segment(1) =='referral'): ?> active <?php endif; ?> "><a href="<?php echo e(route('referral.show')); ?>">References & Referrals</a></li>
        <li class="list-group-item <?php if(Request::segment(1) =='family-details'): ?> active <?php endif; ?> "><a href="<?php echo e(route('family.details.show')); ?>">Family Details</a></li>
        <li class="list-group-item <?php if(Request::segment(1) =='upload-documents'): ?> active <?php endif; ?> "><a href="<?php echo e(route('upload.documents.show')); ?>">Resume & Documents Upload</a></li>
        <li class="list-group-item <?php if(Request::segment(1) =='portfolio'): ?> active <?php endif; ?> "><a href="<?php echo e(route('portfolio.show')); ?>">Portfolio & other attachments</a></li>
     
    </ul>
</div><?php /**PATH C:\wamp\www\career\resources\views/frontend/layouts/sidebar.blade.php ENDPATH**/ ?>