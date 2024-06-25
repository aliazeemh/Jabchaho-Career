
<?php $__env->startSection('title', 'Forgot Password'); ?>
<?php $__env->startSection('content'); ?>

<div class="container-auth">
    <div class="container signin">
        <h2>Forgot Password</h2>
        <form name="reset" onkeypress="return event.keyCode != 13;" method="post" action="<?php echo e(route('forgot.password.perform')); ?>"  class="form-horizontal col-md-12"  >
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
            <div class="form-group col">
                <input type="text" autocomplete="off" class="form-control" id="email"  name="email" maxlength="50" placeholder="Email" value="<?php echo e(old('email')); ?>">
            </div>
            <div class="form-group col form-submit">        
                
                <div><button type="submit" class="btn btn-primary ideas-brand">Send</button></div>  
                <div class="already-user">Already have an account! <a href="<?php echo e(route('signin.show')); ?>">Signin</a></div>
                
                </div>
            </div>
            


        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.auth-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/auth/passwords/forgot.blade.php ENDPATH**/ ?>