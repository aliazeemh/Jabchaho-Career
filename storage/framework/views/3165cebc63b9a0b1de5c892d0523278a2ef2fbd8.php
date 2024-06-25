<div class="job-search">
    <h2 class="t-white ff-gothambook">Join Ideas to Achieve A Great Career in Fashion Retail</h2>
    <div class="t-white">Find the perfect job to build your future</div>
    <form method="GET" action="<?php echo e(route('jobs.list')); ?>">
        <div class="row">
            
            <div class="col">
                <input type="text" class="form-control" placeholder="Job title" name='title' value="<?php if(!empty($title)): ?><?php echo e($title); ?><?php endif; ?>">
                <label class="f-right hide">
                    <span class="fa fa-search search-icon"></span>
                    <input type="submit" class="btn btn-primary btn-sm" value="Search">
                </label>
            </div>
            
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
            
            <div class="col1-12 hide">
                <label>
                    <span class="fa fa-search search-icon tc-white"></span>
                    <input type="submit" class="btn btn-primary btn-sm" value="Search">
                </label>
            </div>
            <div class="col1-12 hide">
                <label>
                    <span class="fa fa-undo search-icon tc-white"></span>
                    <a href="<?php if($methodName == 'landingPage'): ?><?php echo e(route('landing.page')); ?> <?php else: ?> <?php echo e(route('jobs.list')); ?> <?php endif; ?>" class="btn btn-primary btn-sm">Reset</a>
                </label>
            </div>
            <div class="col1-12 search-icon-wrapper">
                <label class="f-right">
                    <span class="fa fa-search search-icon tc-white"></span>
                    <input type="submit" class="btn btn-primary btn-sm hide-desktop" value="Search">
                </label>
            </div>
        </div>
    </form>
    <div class="popular-search"><span class="tc-white">Popular Searches: </span><div><span class="tc-green">Digital</span><span class="tc-green"> | </span><span class="tc-green">Textile Designer</span><span class="tc-green"> | </span><span class="tc-green">Developer</span><span class="tc-green"> | </span><span class="tc-green">SEO</span></div></div>
</div><?php /**PATH C:\wamp\www\career\resources\views/frontend/jobs/partials/search.blade.php ENDPATH**/ ?>