
<?php $__env->startSection('title', 'Referral'); ?>
<?php $__env->startSection('content'); ?>

<div class="card-title"><img src="<?php echo e(asset('assets/images/banners/referral.jpg')); ?>" ></div>

<form class="form-horizontal" id="ReferralForm" method="post" action="<?php echo e(route('referral.perform')); ?>" autocomplete="off">
<?php if(!empty(Arr::get($referralData, 'id'))): ?>
    <?php echo method_field('put'); ?>
<?php endif; ?>
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
    <input type="hidden" name="id" value="<?php echo e(Arr::get($referralData, 'id','')); ?>" />
    <?php if($errors->has('id')): ?>
        <div class="text-danger"><?php echo e($errors->first('id')); ?></div>
    <?php endif; ?>

    <p class="text-start"><small>Please tell us, where did you hear about jobs at Ideas</small></p>

    <div class="row mb-3 text-left">
        <label for="InstituteName" class="col-sm-3 col-form-label col-form-label-sm">Select a Medium</label>
        <div class="col-sm-9">
            <?php if(!empty($referralOptions)): ?>
                <?php $__currentLoopData = $referralOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <input class="form-check-input referralOptions" type="radio" name="referral_id" id="referralOptions-<?php echo e($key); ?>"  value="<?php echo e($key); ?>" 
                        <?php if((old('_token') && old('referral_id') == $key)): ?> 
                            <?php echo e('checked'); ?>

                        <?php elseif(old('_token') == null && Arr::get($referralData, 'referral_id')): ?>  
                            <?php echo e(Arr::get($referralData, 'referral_id') == $key ? 'checked' : ''); ?> 
                        <?php else: ?> 
                        <?php if(old('_token') == null && $key==0): ?>
                                <?php echo e('checked'); ?>

                                <?php endif; ?>
                        <?php endif; ?>    
                
                    >
                    <label class="form-check-label col-form-label-sm" for="referralOptions-<?php echo e($key); ?>"><?php echo e($value); ?></label>
                </div>        
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if($errors->has('referral_id')): ?>
                <div class="text-danger"><?php echo e($errors->first('referral_id')); ?></div>
            <?php endif; ?>
        </div>
    </div>


    <div id="div-reference-details" style="display:none;">
        <div><hr class="bg-danger border-2 border-top border-danger">Enter Reference Details</div>

        <div class="row mb-3 IknowSomeone " style="display:none;">
            <label for="PersonName" class="col-sm-3 col-form-label col-form-label-sm">Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="100" id="PersonName" name="person_name" value="<?php if(old('person_name')): ?><?php echo e(old('person_name')); ?><?php elseif(empty(old('person_name')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($referralData,'person_name')); ?><?php endif; ?>">
                <?php if($errors->has('person_name')): ?>
                    <div class="text-danger"><?php echo e($errors->first('person_name')); ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-3 IknowSomeone" style="display:none;">
            <label for="ContactNo" class="col-sm-3 col-form-label col-form-label-sm">Contact No</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="20" id="ContactNo" name="contact_no" value="<?php if(old('contact_no')): ?><?php echo e(old('contact_no')); ?><?php elseif(empty(old('contact_no')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($referralData,'contact_no')); ?><?php endif; ?>">
                <?php if($errors->has('contact_no')): ?>
                    <div class="text-danger"><?php echo e($errors->first('contact_no')); ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-3 IknowSomeone" style="display:none;">
            <label for="EmplyedId" class="col-sm-3 col-form-label col-form-label-sm">Emplyed Id</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="100" id="EmplyedId" name="emplyed_id" value="<?php if(old('emplyed_id')): ?><?php echo e(old('emplyed_id')); ?><?php elseif(empty(old('emplyed_id')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($referralData,'emplyed_id')); ?><?php endif; ?>">
                <?php if($errors->has('emplyed_id')): ?>
                    <div class="text-danger"><?php echo e($errors->first('emplyed_id')); ?></div>
                <?php endif; ?>
            </div>
        </div>


        <div class="row mb-3 ReferredMe" style="display:none;">
            <label for="ReferenceCode" class="col-sm-3 col-form-label col-form-label-sm">Reference Code</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="20" id="ReferenceCode" name="reference_code" onkeydown="return isNumberKey(this);" value="<?php if(old('reference_code')): ?><?php echo e(old('reference_code')); ?><?php elseif(empty(old('reference_code')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($referralData,'reference_code')); ?><?php endif; ?>">
                <?php if($errors->has('reference_code')): ?>
                    <div class="text-danger"><?php echo e($errors->first('reference_code')); ?></div>
                <?php endif; ?>
            </div>
        </div>

    </div>    

    <div id="div-other-medium" style="display:none;">
        <div><hr class="bg-danger border-2 border-top border-danger">Enter Other Medium Details</div>

        <div class="row mb-3">
            <label for="OtherVendor" class="col-sm-3 col-form-label col-form-label-sm">Vendor</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="100" id="OtherVendor" name="other_vendor" value="<?php if(old('other_vendor')): ?><?php echo e(old('other_vendor')); ?><?php elseif(empty(old('other_vendor')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($referralData,'other_vendor')); ?><?php endif; ?>">
                <?php if($errors->has('other_vendor')): ?>
                    <div class="text-danger"><?php echo e($errors->first('other_vendor')); ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row mb-3">
            <label for="OtherName" class="col-sm-3 col-form-label col-form-label-sm">Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="100" id="OtherName" name="other_name" value="<?php if(old('other_name')): ?><?php echo e(old('other_name')); ?><?php elseif(empty(old('other_name')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($referralData,'other_name')); ?><?php endif; ?>">
                <?php if($errors->has('other_name')): ?>
                    <div class="text-danger"><?php echo e($errors->first('other_name')); ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row mb-3">
            <label for="otherContactNo" class="col-sm-3 col-form-label col-form-label-sm">Contact No</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="20" id="otherContactNo" name="other_contact_no" value="<?php if(old('other_contact_no')): ?><?php echo e(old('other_contact_no')); ?><?php elseif(empty(old('other_contact_no')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($referralData,'other_contact_no')); ?><?php endif; ?>">
                <?php if($errors->has('other_contact_no')): ?>
                    <div class="text-danger"><?php echo e($errors->first('other_contact_no')); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
        
    <hr class="bg-danger border-2 border-top border-danger">
    <div class="row mb-3">
        <div class="col-sm-10 offset-sm-2">
            <div class="text-end">
                <button type="submit" id="submitReferral" class="btn btn-primary" value="Save & Continue">Save & Continue</button>  
            </div>
        </div>
    </div>

</form>

<script>

    $("#submitReferral").on("click", function(e) {
        e.preventDefault();
        
        let referralId = $('input[name="referral_id"]:checked').val();
        if(referralId!=5)
        {
            $('#PersonName').val('');
            $('#ContactNo').val('');
            $('#EmplyedId').val('');
        }
        if(referralId!=6){
            $('#ReferenceCode').val('');
        }    
          
        if(referralId!=7){
            $('#OtherVendor').val('');
            $('#OtherName').val('');
            $('#otherContactNo').val('');
        }


        //ReferralForm
        $("#ReferralForm").submit();
        
    });
    
    $( document ).ready(function() {
        showHideReferralForm();
    });

    $(".referralOptions").change(function(){
        showHideReferralForm();
    });  

    function showHideReferralForm(){
      let referralId = $('input[name="referral_id"]:checked').val();
        $('.ReferredMe').hide(); 
        $('.IknowSomeone').hide();
        $('#div-other-medium').hide();  
        $('#div-reference-details').hide();
       
        if(referralId==5)
        {
            $('#div-reference-details').show();
            $('.IknowSomeone').show();

            $('.ReferredMe').hide(); 
            $('#div-other-medium').hide();   
        }
        else if(referralId==6)
        {
            $('#div-reference-details').show();
            $('.ReferredMe').show(); 
            
            $('.IknowSomeone').hide();
            $('#div-other-medium').hide();  
        }
        else if(referralId==7)
        {
            $('#div-other-medium').show(); 

            $('#div-reference-details').hide();
            $('.IknowSomeone').hide();

            $('.ReferredMe').hide(); 
        }   
        
    }
</script>    

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/candidates/profile/referral.blade.php ENDPATH**/ ?>