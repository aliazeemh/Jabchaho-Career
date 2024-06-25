
<?php $__env->startSection('title', 'Tips and Guides'); ?>
<?php $__env->startSection('content'); ?>
<style>
.card img {
    margin-left: -13px !important;
    margin-top: -7px !important;;
}
</style>

<div class="mb-2">
    <div class="card">
        <div class="card-header"><?php echo e(Arr::get($tipAndGuideRow, 'title')); ?></div>
        <div class="card-body">
            <?php echo Arr::get($tipAndGuideRow, 'content'); ?>

            </div>
        </div>
</div>    



    
    <?php if(!empty($tipsAndGuides)): ?>
        
        <?php $counter=0;?>
        
        <div class="row mb-2">

            <?php $__currentLoopData = $tipsAndGuides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-sm-4">
                <div class="card">
                <div class="card-header"><?php echo e(Arr::get($row, 'title')); ?></div>
                <div class="card-body text-start">
                
                    <div class="card-text"><?php echo Arr::get($row, 'summary'); ?></div>
                    
                    <a class="btn btn-primary btn-sm" href="<?php echo e(route('tips-and-guides.index', Arr::get($row, 'slug'))); ?>" >Learn More</a>
                </div>
                </div>
            </div>
                
                <?php $counter++; ?>

                
                <?php if($counter %3==0): ?>
                    <?php if($counter != count($tipsAndGuides)): ?>
                        </div>
                        <div class="row mb-2">
                    <?php endif; ?>
                <?php endif; ?>
                
            
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        </div>
    <?php endif; ?>








<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/candidates/tips_and_guides/index.blade.php ENDPATH**/ ?>