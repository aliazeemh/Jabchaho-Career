

<?php $__env->startSection('content'); ?>
<div class="container">
   <div class="row justify-content-center">
   </div>
   <div class="row justify-content-center">
      <div class="col-md-7 col-lg-5">
         <div class="login-wrap p-4 p-md-5">
            <div class="icon d-flex align-items-center justify-content-center">
               <span class="fa fa-user-o"></span>
            </div>
            <h3 class="text-center mb-4">Sign In</h3>
            <?php echo $__env->make('backend.layouts.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <form method="post" action="<?php echo e(route('login.perform')); ?>" class="login-form">
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
                <div class="form-group">
                    <input type="text" class="form-control" name="username" value="<?php echo e(old('username')); ?>" placeholder="Username" required="required" autofocus>
                    <?php if($errors->has('username')): ?>
                        <span class="text-danger text-left"><?php echo e($errors->first('username')); ?></span>
                    <?php endif; ?>
                </div>
               <div class="form-group d-flex">
                    <input type="password" class="form-control" name="password" value="<?php echo e(old('password')); ?>" placeholder="Password" required="required">
                    <?php if($errors->has('password')): ?>
                        <span class="text-danger text-left"><?php echo e($errors->first('password')); ?></span>
                    <?php endif; ?>
                </div>
               <div class="form-group">
                  <button type="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
               </div>
               <div class="form-group d-md-flex">
                  <div class="w-50">
                     <label class="checkbox-wrap checkbox-primary">Remember Me
                     <input type="checkbox" name="remember" value="1" checked>
                     <span class="checkmark"></span>
                     </label>
                  </div>
                  <!--<div class="w-50 text-md-right">
                     <a href="#">Forgot Password</a>
                  </div>-->
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.auth-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/backend/auth/login.blade.php ENDPATH**/ ?>