
<?php $__env->startSection('title', 'Reset Password'); ?>
<?php $__env->startSection('content'); ?>

<div class="container-auth">
    <div class="container">
        <h2>Reset Password</h2>
        <?php echo $__env->make('frontend.includes.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <form name="reset" onkeypress="return event.keyCode != 13;" method="post" action="<?php echo e(route('reset.password.perform')); ?>"  class="form-horizontal col-md-12 mt-10p"  >
            <input type="hidden" name="token" value="<?php echo e($token); ?>">
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
            <div class="form-group">
                <div class="col-sm-12">
                    <input  type="password" name="password" class="form-control" placeholder="New Password" maxlength="20">
                    <?php if($errors->has('password')): ?>
                        <div class="text-danger"><?php echo e($errors->first('password')); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input  type="password" name="confirm_password" class="form-control"  placeholder="Confirm password" maxlength="20" >
                    <?php if($errors->has('confirm_password')): ?>
                        <div class="text-danger"><?php echo e($errors->first('confirm_password')); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">        
                <div class="col-sm-offset-2 col-sm-4">
                <button type="submit" class="btn btn-primary">Reset Password</button>  
                </div>
            </div>
            


        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.auth-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/auth/passwords/reset.blade.php ENDPATH**/ ?>