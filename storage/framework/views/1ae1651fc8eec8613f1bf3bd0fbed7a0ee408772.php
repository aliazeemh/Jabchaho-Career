<div class="job-login-search">
    <h2 style="color:#8cc63f">Ideas Job Openings</h2>
    <form method="GET" action="<?php echo e(route('jobs.list')); ?>">
        <div class="row">   
            
            <div class="col">
                <select class="form-control" id="city"  name="city" rel="<?php if(!empty($city)): ?><?php echo e($city); ?><?php endif; ?>" >
                    <option value="">Select City</option>
                    <?php if(!empty($cities) ): ?>
                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!empty($city) && $city == $key): ?>
                                <option  value="<?php echo e(trim($key)); ?>" selected> <?php echo e(trim($value)); ?> </option>  
                            <?php else: ?>    
                                <option  value="<?php echo e(trim($key)); ?>" > <?php echo e(trim($value)); ?> </option>
                            <?php endif; ?>    
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="col">
                <select class="form-control" id="category"  name="category" >
                    <option value="">All Categories</option>
                    <?php if(!empty($areaOfInterestGroups) ): ?>
                        <?php $__currentLoopData = $areaOfInterestGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $areaOfInterestGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!empty($category) && $category== Arr::get($areaOfInterestGroup, 'id')): ?>
                            <option  value="<?php echo e(trim(Arr::get($areaOfInterestGroup, 'id'))); ?>" selected ><?php echo e(trim(Arr::get($areaOfInterestGroup, 'name'))); ?></option>
                            <?php else: ?>   
                                <option  value="<?php echo e(trim(Arr::get($areaOfInterestGroup, 'id'))); ?>" ><?php echo e(trim(Arr::get($areaOfInterestGroup, 'name'))); ?></option>
                            <?php endif; ?>  
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="col">
                <select class="form-control" id="jobType"  name="jobType" >
                    <option value="">Job Types</option>
                    <?php if(!empty($jobTypes) ): ?>
                        <?php $__currentLoopData = $jobTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!empty($jobTypeSelectedId) && $jobTypeSelectedId == Arr::get($jobType, 'id')): ?>
                                <option value="<?php echo e(trim(Arr::get($jobType, 'id'))); ?>" selected><?php echo e(trim(Arr::get($jobType, 'name'))); ?></option> 
                            <?php else: ?>
                                <option  value="<?php echo e(trim(Arr::get($jobType, 'id'))); ?>" ><?php echo e(trim(Arr::get($jobType, 'name'))); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    var selectElem = document.querySelectorAll(".job-login-search select");
    var jobSForm = document.querySelector(".job-login-search form");
    console.log("loaded");
    selectElem.forEach(element => {
        console.log(element);
        element.onchange = function()
        {
            console.log("called");
            jobSForm.submit();
        }
    });
</script><?php /**PATH C:\wamp\www\career\resources\views/frontend/jobs/partials/ln_search.blade.php ENDPATH**/ ?>