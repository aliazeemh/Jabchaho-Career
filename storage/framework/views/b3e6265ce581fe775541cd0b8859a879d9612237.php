
<?php $__env->startSection('title', 'Login'); ?>
<?php $__env->startSection('content'); ?>


<div class="container-auth">
  <div class="container signin">
    <h2 class="header">Login</h2>
    <div class="desc">Login with your account</div>
      
      <?php echo $__env->make('frontend.includes.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <form class="form-horizontal signin-auth" method="post" action="<?php echo e(route('signin.perform')); ?>" autocomplete="off">
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
      <div class="form-group">
        <div class="col-sm-12">
          <input type="text" autocomplete="off" class="form-control" id="email" name="email" maxlength="50" value="<?php echo e(old('email')); ?>" placeholder="Enter your Phone Number or Email Address">
          <?php if($errors->has('email')): ?>
            <div class="text-danger"><?php echo e($errors->first('email')); ?></div>
          <?php endif; ?>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12">          
          <input type="password" autocomplete="off" class="form-control" name="password" placeholder="Enter your Password" >
          <?php if($errors->has('password')): ?>
            <div class="text-danger"><?php echo e($errors->first('password')); ?></div>
          <?php endif; ?>
        </div>
      </div>
      <div class="form-group">        
        <div class="col-sm-6 remember-pass">
          <span class="checkbox">
            <label class="label-wrap"><input type="checkbox" name="remember" value="1" class="form-check-input" checked> <span class="checkbox-label"> Remember me</span></label>
          </span>
        </div>
        <div class="col-sm-6 t-a-right forget-password">
          <span class="">
                  <a href="<?php echo e(route('forgot.password.show')); ?>">Forgot Password</a>
          </span>
        </div>
      </div>
      <div class="form-group">        
        <div class="col-sm-12 t-a-center">
          <button type="submit" class="btn btn-primary ideas-brand">Login</button>   
        </div>
      </div>
      <div class="form-group">        
        <div class="col-sm-12 t-a-center acc-signup">
          <span>Don't have an account yet?</span>
          <span class="">
            <a href="<?php echo e(route('signup.show')); ?>">Signup</a>
          </span>
        </div>
      </div>
      <div class="form-group text-center social-btn">        
        <div class=" col-sm-12">
              <a href="<?php echo e(route('facebook.login')); ?>" class="btn btn-primary btn-block"><i class="fa fa-facebook"></i><span class="social-login-btn">Sign in with <b>Facebook</b></span></a>
              <a href="<?php echo e(route('google.login')); ?>" class="btn btn-danger btn-block"><i class="fa fa-google"></i><span  class="social-login-btn">Sign in with <b>Google</b></span></a>
              <!--<a href="#" class="btn btn-info btn-block"><i class="fa fa-twitter"></i> Sign in with <b>Twitter</b></a>-->
        </div>
        
      </div>
    
    </form>
  </div>
</div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.auth-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/auth/signin.blade.php ENDPATH**/ ?>