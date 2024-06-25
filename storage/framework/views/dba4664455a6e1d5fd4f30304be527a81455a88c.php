
<?php $__env->startSection('title', 'Sign Up'); ?>
<?php $__env->startSection('content'); ?>

<div class="container-auth">
  <div class="container signin signup">
    
  <?php if(Request::segment(1) =='drop-your-cv'): ?>
    <h2 class="header">Drop Your <span class="logo-color">CV</span></h2>
    <div class="desc">If your desired job is not advertised, please fill fields with updated CV and become part of our active database which we checks regularly as a first step when filling a vacancy.</div>
  <?php else: ?>
    <h2 class="header">Sign Up</h2>
    <div class="desc">Please enter the correct contact details for faster job application processing.</div>
  <?php endif; ?>  

    
    
    <?php echo $__env->make('frontend.includes.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <form class="form-horizontal" action="<?php echo e(route('signup.perform')); ?>" method="Post" autocomplete="off" enctype="multipart/form-data">
  <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
  <div class="form-group">
      <div class="col-sm-12">
        <div class="desc show-drop-your-cv">Please enter the correct contact details for faster job application processing.</div>
        <input type="text" autocomplete="off" class="form-control" id="full-name" placeholder="Enter Full Name" name="full_name" maxlength="50" value="<?php echo e(old('full_name')); ?>" onpaste="return false;" onkeydown="return isAlphabatKey(this);">
        <?php if($errors->has('full_name')): ?>
            <div class="text-danger"><?php echo e($errors->first('full_name')); ?></div>
        <?php endif; ?>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-12">
        <input type="text" autocomplete="off" class="form-control" id="email" placeholder="Enter email" name="email" maxlength="50" value="<?php echo e(old('email')); ?>">
        <?php if($errors->has('email')): ?>
            <div class="text-danger"><?php echo e($errors->first('email')); ?></div>
        <?php endif; ?>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-12">
        <select class="form-control c-select" id="country"  name="country_code" rel="<?php echo e(old('country_code')); ?>" onchange="ShowHideCodes();">
            <?php if(!empty($countries) ): ?>
                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(old('country_code') == $key): ?>
                        <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?> </option> 
                    <?php elseif($value == config('constants.countries.PK') && empty(old('country_code'))): ?>
                      <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?> </option> 
                    <?php else: ?>
                        <option  value="<?php echo e(trim($key)); ?>" > <?php echo e(trim($value)); ?> </option>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </select>
        <?php if($errors->has('country_code')): ?>
            <div class="text-danger"><?php echo e($errors->first('country_code')); ?></div>
        <?php endif; ?>
      </div>
    </div>

    <div class="form-group d-elem">
      <div class="row" id="div-local-mobile">
        <div class="col-sm-4">
          <select class="form-control c-select" id="mobileCode"  name="mobile_code" rel="<?php echo e(old('mobile_code')); ?>" >
              <?php if(!empty($mobileCodes) ): ?>
                  <?php $__currentLoopData = $mobileCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if(old('mobile_code') == $value): ?>
                          <option value="<?php echo e(trim($value)); ?>" selected><?php echo e(trim($value)); ?> </option>   
                      <?php else: ?>
                          <option  value="<?php echo e(trim($value)); ?>"><?php echo e(trim($value)); ?></option>
                      <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
          </select>
          <?php if($errors->has('mobile_code')): ?>
            <div class="text-danger"><?php echo e($errors->first('mobile_code')); ?></div>
          <?php endif; ?>
        </div>
        <div class="col-sm-8">
          <input type="text" autocomplete="off" class="form-control" id="mobile" maxlength="7" placeholder="Enter Mobile" name="mobile_number" value="<?php echo e(old('mobile_number')); ?>" onkeydown="return isNumberKey(this);">
          <?php if($errors->has('mobile_number')): ?>
            <div class="text-danger"><?php echo e($errors->first('mobile_number')); ?></div>
          <?php endif; ?>
        </div> 

        
      </div> <!--row-->
        <div class="col-sm-12" id="div-int-mobile" style="display:none">
          <input type="text" autocomplete="off" class="form-control" id="int_mobile" maxlength="12" placeholder="Enter Mobile" name="int_mobile_number" value="<?php echo e(old('int_mobile_number')); ?>" onkeydown="return isNumberKey(this);">
          <?php if($errors->has('int_mobile')): ?>
            <div class="text-danger"><?php echo e($errors->first('int_mobile')); ?></div>
          <?php endif; ?>
        </div> 
    </div>

    <div class="form-group d-elem">
      <div class="row" >
        <div class="col-sm-6">
          <input type="password" autocomplete="off" class="form-control" id="password" placeholder="Enter Password" name="password" maxlength="20">
          <?php if($errors->has('password')): ?>
            <div class="text-danger"><?php echo e($errors->first('password')); ?></div>
          <?php endif; ?>
        </div>
        <div class="col-sm-6">
          <input type="password" autocomplete="off" class="form-control" id="confirm_password" placeholder="Enter Confirm Password" name="confirm_password" maxlength="20">
          <?php if($errors->has('confirm_password')): ?>
            <div class="text-danger"><?php echo e($errors->first('confirm_password')); ?></div>
          <?php endif; ?>
        </div> 

        
      </div> <!--row-->
    </div>

    <div class="form-group d-elem">
      <div class="row">
        <div class="col-sm-12">          
          <select class="form-control c-select" id="area_of_interest_option_id"  name="area_of_interest_option_id" rel="<?php echo e(old('area_of_interest_option_id')); ?>" >
                <option value=''>Select Your Area Of Interest</option>
                <?php if(!empty($areaOfInterests) ): ?>
                    
                  <?php $groupName = ''; ?>
                  <?php $__currentLoopData = $areaOfInterests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $object): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <?php if($groupName != $object['group_name']): ?>
                                <optgroup label="<?php echo e($object['group_name']); ?>">
                                <?php $groupName = $object['group_name']; ?>
                        <?php endif; ?>
                  
                        <?php if(old('area_of_interest_option_id') == $object['id']): ?>
                            <option value="<?php echo e(trim($object['id'])); ?>" selected><?php echo e(trim($object['name'])); ?> </option>   
                        <?php else: ?>
                            <option  value="<?php echo e(trim($object['id'])); ?>" > <?php echo e(trim($object['name'])); ?> </option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
            <?php if($errors->has('area_of_interest_option_id')): ?>
              <div class="text-danger"><?php echo e($errors->first('area_of_interest_option_id')); ?></div>
            <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="form-group upload-resume">
      <div class="col-sm-12">
      <label class="file-wrapper">
        <div class="box__dragndrop">
          <div class="fa fa-cloud-upload t-a-center"></div>
          <h3 class="header">Upload Your Resume</h3> 
          <div class="desc" title="If your desired job is not advertised, please fill fields with updated CV and become part of our active database which we checks regularly as a first step when filling a vacancy.">
            <div class="header">Become Part Of <span class="logo-color">Ideas</span> High Achievers Team!</div>
          </div>
        </div>
        <span class="dropped_file_name"></span>
        <div class="upload-cv">
          <label for="resume" class="btn">Upload CV</label>
          <input type="file" name="resume" id="resume" class="form-control uploadDocument" value="Upload CV">
        </div>
      </label>

        <?php if($errors->has('resume')): ?>
          <div class="text-danger"><?php echo e($errors->first('resume')); ?></div>
        <?php endif; ?>
      </div>

      <div class="col-sm-12">
            <div class="col-form-label col-form-label-sm t-a-center" data-bs-toggle="tooltip" data-bs-placement="bottom" title=".jpeg, .jpg, .pdf">
                View Supported CV formats
            </div>
      </div>
     
    </div>

  
    <div class="form-group">
      <div class="col-sm-12">
            <span class="recaptcha-wrapper"><?php echo app('captcha')->display(); ?></span>
            <!-- <button type="button" class="btn btn-success refresh-cpatcha"><i class="fa fa-refresh"></i></button> -->
            <?php if($errors->has('g-recaptcha-response')): ?>
              <div class="text-danger"><?php echo e($errors->first('g-recaptcha-response')); ?></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-12 t-a-center" style="margin-bottom: 5px;">
        <button type="submit" class="btn btn-primary ideas-brand">Signup</button>   
        
      </div>
        <div class="form-group">        
          <div class="col-sm-12 t-a-center acc-signup">
            <span>Aleardy have an account</span>
            <span class="">
            <a href="<?php echo e(route('signin.show')); ?>">Signin</a>
          </span>
        </div>
      </div>
    </div>
   
  </form>
</div>

</div>



<script>
   const fileInput = document.querySelector('input[type="file"]');
var isAdvancedUpload = function() {
  var div = document.createElement('div');
  return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
}();
$form = $(".form-horizontal label.file-wrapper");
var droppedFiles = false;
if (isAdvancedUpload) {
  $form.addClass('has-advanced-upload');

  $form.on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
    e.preventDefault();
    e.stopPropagation();
  })
  .on('dragover dragenter', function() {
    $form.addClass('is-dragover');
  })
  .on('dragleave dragend drop', function() {
    $form.removeClass('is-dragover');
  })
  .on('drop', function(e) {
    droppedFiles = e.originalEvent.dataTransfer.files;
    $(".dropped_file_name").html("<h2><span class='fa fa-file'></span><span class='name'> "+droppedFiles[0].name+"</span></h2>");
    $(".box__dragndrop").addClass("disable");

    fileInput.files = droppedFiles;
  });
}
$("input[type=file]").change(function(e)
{
  droppedFiles = e.originalEvent.target.files;
  $(".dropped_file_name").html("<h2><span class='fa fa-file'></span><span class='name'> "+droppedFiles[0].name+"</span></h2>");
  $(".box__dragndrop").addClass("disable");
})
  // A $( document ).ready() block.
$( document ).ready(function() {
  ShowHideCodes();
});

  function ShowHideCodes(){
      let country = $('#country').val();
      
      if(country == 'PK'){
         $('#div-int-mobile').hide();
         $('#div-local-mobile').show();
      }else{
        $('#div-local-mobile').hide();
        $('#div-int-mobile').show();
      }
  }
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.auth-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/auth/signup.blade.php ENDPATH**/ ?>