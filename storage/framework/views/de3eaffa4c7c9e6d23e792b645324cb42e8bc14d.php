

<?php $__env->startSection('content'); ?>
    <div class="bg-light p-4 rounded">
        <h2>Update Shift</h2>
        <div class="lead">
            Edit Shift.
        </div>

        <div class="container mt-4">

            <form method="POST" action="<?php echo e(route('shifts.update', $shift->id)); ?>">
                <?php echo method_field('patch'); ?>
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <div class="col-sm-9">  
                        <input value="<?php if(old('name')): ?><?php echo e(old('name')); ?><?php elseif(empty(old('name')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($shift,'name')); ?><?php endif; ?>" 
                            type="text" 
                            class="form-control" 
                            name="name" 
                            placeholder="Name" 
                            maxlength="100"  onpaste="return false;" onkeydown="return isAlphabatKey(this);"
                            >
                    </div>
                </div>

                <div class="mb-3">
                    <label for="Email" class="form-label">From</label>
                    <div class="col-sm-9">   
                    <select class="form-control form-control-sm" id="from"  name="from" >
                            <option value=''>Select</option>
                            <?php if(!empty($timeSlots) ): ?>
                                <?php $__currentLoopData = $timeSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(old('from') == $key): ?>
                                        <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                    <?php elseif(old('_token') == null && Arr::get($shift, 'from')== $key  ): ?>
                                        <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                    <?php else: ?>
                                        <option  value="<?php echo e(trim($key)); ?>" ><?php echo e(trim($value)); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>     
                </div>


                <div class="mb-3">
                    <label for="Email" class="form-label">To</label>
                    <div class="col-sm-9">   
                    <select class="form-control form-control-sm" id="to"  name="to" >
                            <option value=''>Select</option>
                            <?php if(!empty($timeSlots) ): ?>
                                <?php $__currentLoopData = $timeSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(old('to') == $key): ?>
                                        <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                    <?php elseif(old('_token') == null && Arr::get($shift, 'to')== $key  ): ?>
                                        <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option>     
                                    <?php else: ?>
                                        <option  value="<?php echo e(trim($key)); ?>" ><?php echo e(trim($value)); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>     
                </div>

                <div class="mb-3">
                    <label for="Email" class="form-label">Enable</label>
                    <div class="col-sm-9">   
                        <?php if(!empty($booleanOptions)): ?>
                            <?php $__currentLoopData = $booleanOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input class="form-check-input" type="radio" name="is_enabled" id="is_enabled-<?php echo e($key); ?>" value="<?php echo e($key); ?>" 
                                        
                                <?php if((old('_token') && old('is_enabled') == $key)): ?> 
                                    <?php echo e('checked'); ?>

                                <?php elseif(old('_token') == null && Arr::get($shift, 'is_enabled')): ?>  
                                    <?php echo e(Arr::get($shift, 'is_enabled') == $key ? 'checked' : ''); ?>     
                                <?php else: ?> 
                                    <?php if(old('_token') == null && $key==0): ?>
                                        <?php echo e('checked'); ?>

                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                >
                                <label class="form-check-label" for="position-<?php echo e($key); ?>"><?php echo e($value); ?></label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>     
                </div>
                

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?php echo e(route('shifts.index')); ?>" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/backend/shifts/edit.blade.php ENDPATH**/ ?>