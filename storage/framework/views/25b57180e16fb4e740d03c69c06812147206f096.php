
   <!--Search Section-->
   <?php if(!Auth::guard('candidate')->user()): ?>
	   <?php echo $__env->make('frontend.jobs.partials.search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php else: ?>
		<?php echo $__env->make('frontend.jobs.partials.ln_search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>

    <!--//Search Section-->

<div class="card-wrapper <?php if(!Auth::guard('candidate')->user()): ?> non-login <?php endif; ?>">
<?php if(is_object($jobs) && count($jobs)>0): ?>  
	<?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<div class="card mb-3" id="job-<?php echo e(Arr::get($job, 'id')); ?>">
			<div class="card-block" jobId="<?php echo e(Arr::get($job, 'id')); ?>">
				<h4 class="card-title"><?php echo e(Arr::get($job, 'title')); ?></h4>
				<p class="card-text"><?php echo e(config('constants.cities.'.Arr::get($job, 'city_id') )); ?>, <?php echo e(config('constants.countries.PK')); ?></p>
				<p class="card-text btn btn-primary"><a href="<?php echo e(route('jobs.detail', Arr::get($job, 'id'))); ?>">Apply Now</a></p>
			</div>
		</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
	 <div>!! No Job Found !!</div>
<?php endif; ?>  
</div>
<div class="d-flex">
	<?php echo $jobs->appends(Request::except('page'))->render(); ?>

</div><?php /**PATH C:\wamp\www\career\resources\views/frontend/jobs/partials/list.blade.php ENDPATH**/ ?>