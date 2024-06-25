
<div class="mb-2">
   <div class="card">
      <div class="card-body">
         <div class="col-md-12">        
                <a href="<?php echo e(route('jobs.list')); ?>" >> Back to Jobs</a>
                <div class="mx-auto">
                        <div class="mt-3">
                                <span class="font-normal text-sm text-gray-600">Posted on <?php if(!empty(Arr::get($jobDetail, 'updated_at'))): ?><?php echo e(date("M d, Y", strtotime(Arr::get($jobDetail, 'updated_at')))); ?><?php endif; ?></span>
                                <?php if(empty($alreadyApplied)): ?>
                                <button type="submit" class="btn btn-primary apply la-button float-end">Apply</button>
                                <?php else: ?>
                                <span class="float-end alert alert-danger"> Already applied on this job </span>
                                <?php endif; ?>
                        </div>
                        <p class="mt-4 mb-2 fw-bold">Title</p>  
                        <p class="ms-5 uppercase text-gray-600 f-18px fw-600 tt-capitalize"><?php echo e(Arr::get($jobDetail, 'title')); ?></p>
                        
                        <p class="mt-4 mb-2 fw-bold">Apply before </p>  
                        <p class="ms-5 uppercase text-gray-600"><?php echo e(date('M d, Y',strtotime(Arr::get($jobDetail, 'end_date')))); ?></p>


                        <p class="mt-4 mb-2 fw-bold">City</p> 
                        <p class="ms-5 uppercase text-gray-600"><?php echo e($jobcityName); ?></p>

                        <p class="mt-4 mb-2 fw-bold">Responsibilities</p> 
                        <p class="ms-5 uppercase text-gray-600"><?php echo Arr::get($jobDetail, 'responsibility'); ?></p>

                        <p class="mt-4 mb-2 fw-bold">Requirements</p> 
                        <p class="ms-5 uppercase text-gray-600"><?php echo Arr::get($jobDetail, 'requirement'); ?></p>


                        <p class="mt-4 mb-2 fw-bold">Benefits</p> 
                        <p class="mb-2  uppercase text-gray-600">
                                <?php if(!empty($jobPostedBenefits)): ?>
                                <ul>
                                <?php $__currentLoopData = $jobPostedBenefits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobPostedBenefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li> <?php echo e(Arr::get($jobPostedBenefit->jobBenefit, 'name')); ?></li> 
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <?php endif; ?>
                        </p>
                </div> 
                
        
        </div>
      </div>
   </div>
</div>    


<script>
$('.apply').click(function(){
   window.location.href="<?php echo e(route('apply.job', Arr::get($jobDetail, 'id'))); ?>";
})
</script><?php /**PATH C:\wamp\www\career\resources\views/frontend/jobs/partials/detail.blade.php ENDPATH**/ ?>