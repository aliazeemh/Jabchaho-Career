
<?php $__env->startSection('title', 'Home'); ?>
<?php $__env->startSection('content'); ?>


<div class="row first-child"> 
    <div class="col-sm-2 mb-2">
        <div class="card">
            <h6 class="card-header">Applicant Summary</h6>
            <ul class="list-group list-group-flush">
                <li class="list-group-item mb-2"><small><span class="fw-bold">Applicant ID: </span><span><?php echo e(Arr::get($candidateData, 'application_id')); ?></span></small></li>
                <li class="list-group-item mb-2"><small><span class="fw-bold">Status: </span><span><?php echo e(Arr::get($candidateData->candidateStatus, 'name')); ?></span></small></li>
                <li class="list-group-item mb-2">
                    <div class="progress mb-3">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo e($profilePercentage); ?>%;" aria-valuenow="<?php echo e($profilePercentage); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div>
                        <p class="mb-3">
                            <small>Progress: <span id="ContentContainer_lblProgressPercentage"><?php echo e($profilePercentage); ?>%</span>
                                <a href="<?php echo e(route('personal.details.show')); ?>" class="pull-right" data-original-title="" title="">Click here to complete</a>
                            </small>
                        </p>
                    </div>    
                </li>
            </ul>
        </div>
    </div>
    <!-- home content -->
    <div class="col-sm-10 ">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="font-weight:600"><?php echo e(Arr::get($homeContent, 'title')); ?></h5>
                <br/>
                <div class="f-18px">
                    <?php echo Helper::replaceHomeContent($homeContent,$candidateData); ?>

                </div>
            </div>
        </div>
    </div>
    <!-- home content -->
</div>
<div class="row">
    <div class="card col-sm-2" >
        <h6 class="card-header">Verify Contact Information</h6>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <p><small>We need to verify your contact information.</small></p>
                <span class="fw-bold">Phone: </span><span><?php echo e(Arr::get($candidateData, 'mobile_number')); ?></span></li>
            <li class="list-group-item"><span class="fw-bold">Email: </span><span><?php echo e(Arr::get($candidateData, 'email')); ?></span></li>
            <li class="list-group-item"></li>
        </ul>
    </div>
</div>






</span>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/candidates/home.blade.php ENDPATH**/ ?>