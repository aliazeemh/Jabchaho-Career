
<?php $__env->startSection('title', 'Personal Details'); ?>
<?php $__env->startSection('content'); ?>

<div class="card-title"><img src="<?php echo e(asset('assets/images/banners/personaldetails.jpg')); ?>" ></div>

<h4><hr class="bg-danger border-2 border-top border-danger">Personal Details</h4>
<form class="form-horizontal" method="post" action="<?php echo e(route('personal.details.perform')); ?>" autocomplete="off">
<?php if(!empty(Arr::get($personalDetailData, 'id'))): ?>
    <?php echo method_field('put'); ?>
<?php endif; ?>
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
    <input type="hidden" name="id" value="<?php echo e(Arr::get($personalDetailData, 'id','')); ?>" />
    <?php if($errors->has('id')): ?>
        <div class="text-danger"><?php echo e($errors->first('id')); ?></div>
    <?php endif; ?>

    <div class="row mb-3">
        <label for="fullName" class="col-sm-3 col-form-label col-form-label-sm">Your Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm" maxlength="50" id="fullName" name="full_name" value="<?php if(old('full_name')): ?><?php echo e(old('full_name')); ?><?php elseif(empty(old('full_name')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get(Auth::guard('candidate')->user(), 'full_name')); ?><?php endif; ?>">
            <?php if($errors->has('full_name')): ?>
                <div class="text-danger"><?php echo e($errors->first('full_name')); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mb-3">
            <label for="" class="col-sm-3 col-form-label col-form-label-sm">Gender</label>
        <div class="col-sm-9 col-form-label-sm text-left" >
            <?php if(!empty($genderOptions)): ?>
                <?php $__currentLoopData = $genderOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input class="form-check-input" type="radio" name="gender" id="gender-<?php echo e($key); ?>" value="<?php echo e($key); ?>"
                    <?php if((old('_token') && old('gender') == $key)): ?> 
                        <?php echo e('checked'); ?>

                    <?php elseif( old('_token') == null && array_key_exists(Arr::get($personalDetailData, 'gender'), config('constants.gender_options')) ): ?>
                        <?php echo e(Arr::get($personalDetailData, 'gender') == $key ? 'checked' : ''); ?> 
                    <?php else: ?> 
                    <?php if(old('_token') == null && $key==1): ?>
                            <?php echo e('checked'); ?>

                        <?php endif; ?>
                    <?php endif; ?>    
                
                    >
                    <label class="form-check-label" for="gender-<?php echo e($key); ?>"><?php echo e($value); ?></label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
        <?php if($errors->has('gender')): ?>
            <div class="text-danger"><?php echo e($errors->first('gender')); ?></div>
        <?php endif; ?>
    </div>


    <div class="row mb-3">
        <label for="InstituteName" class="col-sm-3 col-form-label">Date of Birth</label>
        <div class="col-sm-9 text-left">
            <div class="row">

                <div class="col-sm-2"> 
                    <select class="form-control form-control-sm" id="month"  name="month" >
                        <option value=''>Month</option>
                        <?php if(!empty($months) ): ?>
                            <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(old('month') == $key): ?>
                                    <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                <?php elseif(old('_token') == null && !empty(Arr::get($personalDetailData, 'date_of_birth')) &&  date("m", strtotime(Arr::get($personalDetailData, 'date_of_birth')))== $key  ): ?>
                                    <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                <?php else: ?>
                                    <option  value="<?php echo e(trim($key)); ?>" ><?php echo e(trim($value)); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>
                    <?php if($errors->has('month')): ?>
                        <div class="text-danger"><?php echo e($errors->first('month')); ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-sm-2"> 
                    <select id="day" name="day" class="form-control form-control-sm">
                        <option value=''>Day</option>
                        <?php for($i = 1; $i<=31; $i++): ?>
                            <?php if(old('day') == $i): ?>

                                <option value="<?php echo e($i); ?>" selected><?php echo e($i); ?></option>
                            <?php elseif(old('_token') == null && !empty(Arr::get($personalDetailData, 'date_of_birth')) &&  date("d", strtotime(Arr::get($personalDetailData, 'date_of_birth')))==  $i   ): ?>
                                <option value="<?php echo e($i); ?>" selected><?php echo e($i); ?></option>
                            <?php else: ?>
                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                            <?php endif; ?>    
                        <?php endfor; ?>
                    </select>
                    <?php if($errors->has('day')): ?>
                        <div class="text-danger"><?php echo e($errors->first('day')); ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-sm-2">  
                    <select id="year" name="year" class="form-control form-control-sm">
                        <option value=''>Year</option>
                        <?php $last= date('Y')-120 ?>
                        <?php $now = date('Y')-16 ?>

                        <?php for($i = $now; $i >= $last; $i--): ?>
                            <?php if(old('year') == $i): ?>

                                <option value="<?php echo e($i); ?>" selected><?php echo e($i); ?></option>
                            <?php elseif(old('_token') == null && !empty(Arr::get($personalDetailData, 'date_of_birth')) &&  date("Y", strtotime(Arr::get($personalDetailData, 'date_of_birth')))==  $i   ): ?>
                                <option value="<?php echo e($i); ?>" selected><?php echo e($i); ?></option>
                            <?php else: ?>
                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                            <?php endif; ?>    
                        <?php endfor; ?>
                    </select>
                    <?php if($errors->has('year')): ?>
                        <div class="text-danger"><?php echo e($errors->first('year')); ?></div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <div class="row mb-3">
            <label for="DiplomaTitle" class="col-sm-3 col-form-label col-form-label-sm">Marital Status</label>
            <div class="col-sm-9 text-left">
                <select class="form-control form-control-sm" id="marital_status"  name="marital_status" >
                    <option value=''>Select Marital Status</option>
                    <?php if(!empty($maritalStatuses) ): ?>
                        <?php $__currentLoopData = $maritalStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(old('marital_status') == $key): ?>
                                <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                            <?php elseif(old('_token') == null && !empty(Arr::get($personalDetailData, 'marital_status')) && (Arr::get($personalDetailData, 'marital_status')== $key)  ): ?>
                                <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                            <?php else: ?>
                                <option  value="<?php echo e(trim($key)); ?>" ><?php echo e(trim($value)); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
                <?php if($errors->has('marital_status')): ?>
                    <div class="text-danger"><?php echo e($errors->first('marital_status')); ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-3">
            <label for="DiplomaTitle" class="col-sm-3 col-form-label col-form-label-sm">Nationality</label>
            <div class="col-sm-9  text-left">
                <?php if(!empty($nationality)): ?>
                    <?php $__currentLoopData = $nationality; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input class="form-check-input nationality" type="radio" name="nationality" id="nationality-<?php echo e($key); ?>" value="<?php echo e($key); ?>"
                        <?php if((old('_token') && old('nationality') == $key)): ?> 
                            <?php echo e('checked'); ?>

                        <?php elseif(old('_token') == null): ?>  
                            <?php echo e(Arr::get($personalDetailData, 'nationality') == $key ? 'checked' : ''); ?> 
                        <?php else: ?> 
                        <?php if(old('_token') == null && $key==1): ?>
                                <?php echo e('checked'); ?>

                            <?php endif; ?>
                        <?php endif; ?>    
                    
                        >
                        <label class="form-check-label" for="nationality-<?php echo e($key); ?>"><?php echo e($value); ?></label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
            <?php if($errors->has('nationality')): ?>
                <div class="text-danger"><?php echo e($errors->first('nationality')); ?></div>
            <?php endif; ?>
        </div>
        
        <div class="row mb-3" id="cnicDiv">
            <label for="cnic" class="col-sm-3 col-form-label col-form-label-sm">CNIC</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="13" id="cnic" name="cnic" value="<?php if(old('cnic')): ?><?php echo e(old('cnic')); ?><?php elseif(empty(old('cnic')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($personalDetailData,'cnic')); ?><?php endif; ?>">
            </div>
            <?php if($errors->has('cnic')): ?>
                <div class="text-danger"><?php echo e($errors->first('cnic')); ?></div>
            <?php endif; ?>
        </div>

        <div class="row mb-3" id="passportDiv" style="display:none">
            <label for="passport" class="col-sm-3 col-form-label col-form-label-sm">Passport</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="20" id="passport" name="passport" value="<?php if(old('passport')): ?><?php echo e(old('passport')); ?><?php elseif(empty(old('passport')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($personalDetailData,'passport')); ?><?php endif; ?>">
            </div>
            <?php if($errors->has('passport')): ?>
                <div class="text-danger"><?php echo e($errors->first('passport')); ?></div>
            <?php endif; ?>
        </div>

        <div class="row mb-3">
            <label for="Religion" class="col-sm-3 col-form-label col-form-label-sm">Religion</label>
            <div class="col-sm-9">
                <select class="form-control form-control-sm" id="religion"  name="religion" >
                    <option value=''>Select Religion</option>
                    <?php if(!empty($religions) ): ?>
                        <?php $__currentLoopData = $religions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(old('religion') == $key): ?>
                                <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                            <?php elseif(old('_token') == null && !empty(Arr::get($personalDetailData, 'religion')) &&  (Arr::get($personalDetailData, 'religion')== $key)  ): ?>
                                <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                            <?php else: ?>
                                <option  value="<?php echo e(trim($key)); ?>" ><?php echo e(trim($value)); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
                <?php if($errors->has('religion')): ?>
                    <div class="text-danger"><?php echo e($errors->first('religion')); ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row mb-3" id="LinkedinProfileDiv" >
            <label for="linkedin_profile" class="col-sm-3 col-form-label col-form-label-sm">Linkedin Profile </label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="500" id="linkedin_profile" name="linkedin_profile" value="<?php if(old('linkedin_profile')): ?><?php echo e(old('linkedin_profile')); ?><?php elseif(empty(old('linkedin_profile')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($personalDetailData,'linkedin_profile')); ?><?php endif; ?>">
            </div>
            <?php if($errors->has('linkedin_profile')): ?>
                <div class="text-danger"><?php echo e($errors->first('linkedin_profile')); ?></div>
            <?php endif; ?>
        </div>
        <div class="row mb-3">
            <label for="InstituteName" class="col-sm-3 col-form-label col-form-label-sm">Shift Availability</label>
            <div class="col-sm-9 text-left">
                <?php if(!empty($shifts)): ?>
                    
                    <?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <input class="form-check-input"  type="checkbox" id="shift_id-<?php echo e(Arr::get($value, 'id')); ?>" name="shift_id[]" value="<?php echo e(Arr::get($value, 'id')); ?>" 
                        
                            <?php if(is_array(old('shift_id')) && !empty(old('shift_id'))): ?>
                                <?php echo e((is_array(old('shift_id')) && in_array(Arr::get($value, 'id'), old('shift_id'))) ? ' checked' : ''); ?> 
                            <?php elseif(empty(old('shift_id')) && old('_token')): ?>
                                <?php echo e(''); ?>

                            <?php else: ?>
                                    <?php if(!empty($candidateShifts)): ?>
                                        <?php $__currentLoopData = $candidateShifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(Arr::get($row, 'shift_id')): ?>  
                                                <?php echo e(Arr::get($row, 'shift_id') == Arr::get($value, 'id') ? 'checked' : ''); ?> 
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>  
                            <?php endif; ?>   
                            >
                            
                            <label class="form-check-label col-form-label-sm" for="shift_id-<?php echo e(Arr::get($value, 'id')); ?>">
                                <?php echo e(Arr::get($value, 'name')); ?> (<?php echo e(date('g:i A',strtotime(Arr::get($value, 'from')))); ?> to <?php echo e(date('g:i A',strtotime(Arr::get($value, 'to')))); ?>)
                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
            <?php if($errors->has('shift_id')): ?>
                <div class="text-danger"><?php echo e($errors->first('shift_id')); ?></div>
            <?php endif; ?>
        </div>
        <div class="row mb-3">
            <label for="Height" class="col-sm-3 col-form-label col-form-label-sm">Height</label>
            <div class="col-sm-9  text-left">
                <div class="row">
                    
                    <?php $exploded        = explode('.',Arr::get($personalDetailData,'height'));  ?>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" maxlength="2" id="HeightFeet" name="height_feet" value="<?php if(old('height_feet')): ?><?php echo e(old('height_feet')); ?><?php elseif(empty(old('height_feet')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($exploded,'0')?Arr::get($exploded,'0'):0); ?><?php endif; ?>" onkeydown="return isNumberKey(this);"><label class="col-form-label-sm">feet</label>
                        <?php if($errors->has('height_feet')): ?>
                            <div class="text-danger"><?php echo e($errors->first('height_feet')); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" maxlength="2" id="heightInches" name="height_inches" value="<?php if(old('height_inches')): ?><?php echo e(old('height_inches')); ?><?php elseif(empty(old('height_inches')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($exploded,'1')?Arr::get($exploded,'1'):0); ?><?php endif; ?>" onkeydown="return isNumberKey(this);"><label class="col-form-label-sm">inches</label>
                        <?php if($errors->has('height_inches')): ?>
                            <div class="text-danger"><?php echo e($errors->first('height_inches')); ?></div>
                        <?php endif; ?>
                    </div>
                    <label class="col-form-label-sm">(e.g. 5 feet 7 inches)</label>
                </div>
            
            </div>
        </div> 

        <div class="row mb-3">
            <label for="Weight" class="col-sm-3 col-form-label col-form-label-sm">Weight</label>
            <div class="col-sm-9  text-left">
                <div class="row">
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" maxlength="3" id="weight" name="weight" value="<?php if(old('weight')): ?><?php echo e(old('weight')); ?><?php elseif(empty(old('weight')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($personalDetailData,'weight')?Arr::get($personalDetailData,'weight'):0); ?><?php endif; ?>" onkeydown="return isNumberKey(this);">
                        <?php if($errors->has('weight')): ?>
                            <div class="text-danger"><?php echo e($errors->first('weight')); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label-sm">kg (e.g. 54 kg)</label>
                    </div>    
                </div>
            </div>    
        </div>

       
        <div class="row mb-3">
            <label for="ExpectedSalary" class="col-sm-3 col-form-label col-form-label-sm">Expected Salary</label>
            <div class="col-sm-9  text-left">
                <div class="row">
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" maxlength="7" id="ExpectedSalary" name="expected_salary" value="<?php if(old('expected_salary')): ?><?php echo e(old('expected_salary')); ?><?php elseif(empty(old('expected_salary')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($personalDetailData,'expected_salary')?Arr::get($personalDetailData,'expected_salary'):0); ?><?php endif; ?>" onkeydown="return isNumberKey(this);">
                        <?php if($errors->has('expected_salary')): ?>
                            <div class="text-danger"><?php echo e($errors->first('expected_salary')); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="" class="col-sm-3 col-form-label col-form-label-sm">Own Convenience</label>
            <div class="col-sm-9  text-left" >
              
                <?php if(!empty($ownConvenience)): ?>
                    <?php $__currentLoopData = $ownConvenience; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input class="form-check-input" type="checkbox" name="own_convenience[]" id="own_convenience-<?php echo e($key); ?>" value="<?php echo e($key); ?>"
                        <?php if(is_array(old('own_convenience')) && !empty(old('own_convenience'))): ?>
                                <?php echo e((is_array(old('own_convenience')) && in_array($key, old('own_convenience'))) ? ' checked' : ''); ?> 
                            <?php elseif(empty(old('own_convenience')) && old('_token')): ?>
                                <?php echo e(''); ?>

                            <?php else: ?>
                                    <?php if(!empty(Arr::get($personalDetailData,'own_convenience'))): ?>
                                   
                                     

                                    <?php echo e(in_array($key,explode(',', Arr::get($personalDetailData,'own_convenience')) )  ? 'checked' : ''); ?>  
                                    <?php endif; ?>  
                            <?php endif; ?>   
                            >
                        <label class="form-check-label" for="own_convenience-<?php echo e($key); ?>"><?php echo e($value); ?></label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
            <?php if($errors->has('own_convenience')): ?>
                <div class="text-danger"><?php echo e($errors->first('own_convenience')); ?></div>
            <?php endif; ?>
        </div>
        
        <h4><hr class="bg-danger border-2 border-top border-danger">Enter Contact Details</h4>

        <div class="row mb-3">
            <label for="MobileNumber" class="col-sm-3 col-form-label col-form-label-sm">Mobile Number</label>
            <div class="col-sm-9  text-left">
            <label class="col-form-label-sm"><?php echo e(Arr::get(Auth::guard('candidate')->user(), 'mobile_number')); ?></label>
            </div>
        </div>

        <div class="row mb-3">
            <label for="" class="col-sm-3 col-form-label col-form-label-sm"></label>
            <div class="col-sm-9  text-left">
               
                    <?php if(   !empty(old('mobile_code')) || !empty(old('mobile_number'))): ?>

                        <?php $counter=1; ?>
                        <?php $__currentLoopData = old('mobile_code'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outerKey => $outerValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php if(!empty(old('mobile_code')[$outerKey]) || !empty(old('mobile_number')[$outerKey])): ?>
                                <div class="row multi-field">
                                    <div class="col-sm-5" >
                                        <select class="form-control c-select mobile_code" id="mobileCode"  name="mobile_code[]"  >
                                            <?php if(!empty($mobileCodes) ): ?>
                                                <?php $__currentLoopData = $mobileCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if( $outerValue==$value): ?>
                                                        <option value="<?php echo e(trim($value)); ?>" selected><?php echo e(trim($value)); ?></option>   
                                                    <?php else: ?>
                                                        <option  value="<?php echo e(trim($value)); ?>"><?php echo e(trim($value)); ?></option>
                                                    <?php endif; ?>                               
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>

                                        <?php if($errors->has('mobile_code.*')): ?>
                                            <div class="text-danger"><?php echo e($errors->first('mobile_code.*')); ?></div>
                                        <?php endif; ?>
                                  
                                    </div>
                                    <div class="col-sm-6" >
                                        <input type="text" autocomplete="off" class="form-control" id="mobile" maxlength="11" placeholder="Enter Mobile" name="mobile_number[]" value="<?php echo e(old('mobile_number')[$outerKey]); ?>" onkeydown="return isNumberKey(this);">
                                        <?php if($errors->has('mobile_number.*')): ?>
                                            <div class="text-danger"><?php echo e($errors->first('mobile_number.*')); ?></div>
                                        <?php endif; ?>
                                    </div>    
                                    <div class="col-sm-1 plusDiv" id="plusDiv"  <?php if($counter == count(old('mobile_code')) &&  count(old('mobile_code'))!=3): ?> style="display:block" <?php else: ?> style="display:none" <?php endif; ?>>
                                        <button class="btn btn-small btn-secondary add-field" type="button"  style="padding: 1px 6px;">
                                            <img src="<?php echo e(asset('assets/images/icons/buttons/plus.png')); ?>" >
                                        </button>
                                    </div>
                                    <div class="col-sm-1 minusDiv" <?php if($counter == count(old('mobile_code'))): ?> style="display:none" <?php else: ?> style="display:block" <?php endif; ?> id="minusDiv">
                                        <button class="btn btn-small btn-secondary remove-field" type="button"  style="padding: 1px 6px;">
                                            <img src="<?php echo e(asset('assets/images/icons/buttons/minus.jpg')); ?>" >
                                        </button>
                                    </div>  
                                    
                                </div>
                            <?php $counter++; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                   
                
                    <?php elseif(!empty($candidateMobileNumbers)): ?> 
                        <?php $counter=1; ?>
                        <?php $__currentLoopData = $candidateMobileNumbers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
                            <div class="row multi-field">
                                <div class="col-sm-5" >
                                    <select class="form-control c-select mobile_code" id="mobileCode"  name="mobile_code[]"  >
                                        <?php if(!empty($mobileCodes) ): ?>
                                            <?php $__currentLoopData = $mobileCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if( Arr::get($row,'mobile_code')==$value): ?>
                                                    <option value="<?php echo e(trim($value)); ?>" selected><?php echo e(trim($value)); ?></option>   
                                                <?php else: ?>
                                                    <option  value="<?php echo e(trim($value)); ?>"><?php echo e(trim($value)); ?></option>
                                                <?php endif; ?>                               
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                    <?php if($errors->has('mobile_code.*')): ?>
                                        <div class="text-danger"><?php echo e($errors->first('mobile_code.*')); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-6" >
                                    <input type="text" autocomplete="off" class="form-control" id="mobile" maxlength="11" placeholder="Enter Mobile" name="mobile_number[]" value="<?php echo e(Arr::get($row,'mobile_number')); ?>" onkeydown="return isNumberKey(this);">
                                    <?php if($errors->has('mobile_number.*')): ?>
                                        <div class="text-danger"><?php echo e($errors->first('mobile_number.*')); ?></div>
                                    <?php endif; ?>
                                </div>    
                                <div class="col-sm-1 plusDiv" id="plusDiv"  <?php if($counter == count($candidateMobileNumbers) &&  count($candidateMobileNumbers)!=3): ?> style="display:block" <?php else: ?> style="display:none" <?php endif; ?>>
                                    <button class="btn btn-small btn-secondary add-field" type="button"  style="padding: 1px 6px;">
                                        <img src="<?php echo e(asset('assets/images/icons/buttons/plus.png')); ?>" >
                                    </button>
                                </div>
                                <div class="col-sm-1 minusDiv" <?php if($counter == count($candidateMobileNumbers)): ?> style="display:none" <?php else: ?> style="display:block" <?php endif; ?> id="minusDiv">
                                    <button class="btn btn-small btn-secondary remove-field" type="button"  style="padding: 1px 6px;">
                                        <img src="<?php echo e(asset('assets/images/icons/buttons/minus.jpg')); ?>" >
                                    </button>
                                </div>  
                                
                            </div>
                            <?php $counter++; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   <?php else: ?>
                  
                <div class="row multi-field">
                    <div class="col-sm-5" >
                        <select class="form-control c-select mobile_code" id="mobileCode"  name="mobile_code[]"  >
                            <?php if(!empty($mobileCodes) ): ?>
                                <?php $__currentLoopData = $mobileCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option  value="<?php echo e(trim($value)); ?>"><?php echo e(trim($value)); ?></option>                                   
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                        <?php if($errors->has('mobile_code.*')): ?>
                            <div class="text-danger"><?php echo e($errors->first('mobile_code.*')); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-6" >
                        <input type="text" autocomplete="off" class="form-control" id="mobile" maxlength="11" placeholder="Enter Mobile" name="mobile_number[]" value="<?php echo e(old('mobile_number')); ?>" onkeydown="return isNumberKey(this);">
                        <?php if($errors->has('mobile_number.*')): ?>
                            <div class="text-danger"><?php echo e($errors->first('mobile_number.*')); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-1 plusDiv" id="plusDiv">
                        <button class="btn btn-small btn-secondary add-field" type="button"  style="padding: 1px 6px;">
                            <img src="<?php echo e(asset('assets/images/icons/buttons/plus.png')); ?>" >
                        </button>
                    </div>    
                    <div class="col-sm-1 minusDiv" style="display:none" id="minusDiv">
                        <button class="btn btn-small btn-secondary remove-field" type="button"  style="padding: 1px 6px;">
                            <img src="<?php echo e(asset('assets/images/icons/buttons/minus.jpg')); ?>" >
                        </button>
                    </div>  
                    
                </div>
                <?php endif; ?>
        </div>
    </div>    

        <div class="row mb-3">
            <label for="LandlineNumber" class="col-sm-3 col-form-label col-form-label-sm">Landline Number</label>
            <div class="col-sm-9  text-left">
                <div class="row">    
                    <?php $exploded        = explode('-',Arr::get($personalDetailData,'landline_number'));  ?>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Area Code" class="form-control" maxlength="5" id="AreaCode" name="area_code" value="<?php if(old('area_code')): ?><?php echo e(old('area_code')); ?><?php elseif(empty(old('area_code')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($exploded,'0')); ?><?php endif; ?>">
                        <?php if($errors->has('area_code')): ?>
                            <div class="text-danger"><?php echo e($errors->first('area_code')); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Number" class="form-control" maxlength="11" id="Number" name="landline_number" value="<?php if(old('landline_number')): ?><?php echo e(old('landline_number')); ?><?php elseif(empty(old('landline_number')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($exploded,'1')); ?><?php endif; ?>">
                        <?php if($errors->has('landline_number')): ?>
                            <div class="text-danger"><?php echo e($errors->first('landline_number')); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="EmailAddress" class="col-sm-3 col-form-label col-form-label-sm">Email Address</label>
            <div class="col-sm-9  text-left">
            <label class="col-form-label-sm"><?php echo e(Arr::get(Auth::guard('candidate')->user(), 'email')); ?></label>
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="Address" class="col-sm-3 col-form-label col-form-label-sm">Address</label>
            <div class="col-sm-9  text-left">
                <div class="row">   
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="House No" maxlength="50" id="HouseNo" name="house_no" value="<?php if(old('house_no')): ?><?php echo e(old('house_no')); ?><?php elseif(empty(old('house_no')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($personalDetailData,'house_no')); ?><?php endif; ?>">
                        <?php if($errors->has('house_no')): ?>
                            <div class="text-danger"><?php echo e($errors->first('house_no')); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" placeholder="Block/Street" maxlength="50" id="street" name="street" value="<?php if(old('street')): ?><?php echo e(old('street')); ?><?php elseif(empty(old('street')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($personalDetailData,'street')); ?><?php endif; ?>">
                        <?php if($errors->has('street')): ?>
                            <div class="text-danger"><?php echo e($errors->first('street')); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Area" maxlength="200" id="area" name="area" value="<?php if(old('area')): ?><?php echo e(old('area')); ?><?php elseif(empty(old('area')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($personalDetailData,'area')); ?><?php endif; ?>">
                        <?php if($errors->has('area')): ?>
                            <div class="text-danger"><?php echo e($errors->first('area')); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mb-3">
            <label for="" class="col-sm-3 col-form-label col-form-label-sm"></label>
            <div class="col-sm-9 text-left">
                <div class="row">
                    <div class="col-sm-4" id="CityDiv">
                        <input type="text" class="form-control form-control-sm" maxlength="200" placeholder="City" id="city" name="city" value="<?php if(old('city')): ?><?php echo e(old('city')); ?><?php elseif(empty(old('city')) && old('_token')): ?> <?php echo e(''); ?><?php elseif(config('constants.default_country_code')!=Arr::get(Auth::guard('candidate')->user(), 'country_code')): ?> <?php echo e(Arr::get($personalDetailData,'city')); ?><?php endif; ?>">
                        <?php if($errors->has('city')): ?>
                            <div class="text-danger"><?php echo e($errors->first('city')); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-4" id="PakCityDiv">
                        <select class="form-control c-select" id="PakCity"  name="pak_city" rel="<?php echo e(old('pak_city')); ?>" >
                        <option value="">Select City</option>
                            <?php if(!empty($cities) ): ?>
                                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(old('pak_city') == $key): ?>
                                        <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?> </option> 
                                    <?php elseif($key==(Arr::get($personalDetailData,'city')) && empty(old('pak_city')) && config('constants.default_country_code')==Arr::get(Auth::guard('candidate')->user(), 'country_code') ): ?>
                                    <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?> </option> 
                                    <?php else: ?>
                                        <option  value="<?php echo e(trim($key)); ?>" > <?php echo e(trim($value)); ?> </option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                        <?php if($errors->has('pak_city')): ?>
                            <div class="text-danger"><?php echo e($errors->first('pak_city')); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-5">
                    <select class="form-control c-select" id="country"  name="country_code" rel="<?php echo e(old('country_code')); ?>"  onchange="ShowHideCityDiv();">
                    <option value="">Select Country</option>
                        <?php if(!empty($countries) ): ?>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(old('country_code') == $key): ?>
                                    <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?> </option> 
                                <?php elseif($key==(Arr::get(Auth::guard('candidate')->user(), 'country_code')) && empty(old('country_code')) ): ?>
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
            </div>
        </div>
        <hr class="bg-danger border-2 border-top border-danger">
        <div class="row mb-3">
        <div class="col-sm-10 offset-sm-2">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary" value="Save & Continue">Save & Continue</button>  
                </div>
            </div>
        </div>
</form>


<script>

    $( document ).ready(function() {
        showHideNationalityBasedFields();
        ShowHideCityDiv();
        //showHideButtons();
    });

    $(".nationality").change(function(){
        showHideNationalityBasedFields();
    });   
    
    function ShowHideCityDiv(){
      let country = $('#country').val();
      
      if(country == 'PK'){
         $('#CityDiv').hide();
         $('#PakCityDiv').show();
         $('#CityDiv').val('');
      }else{
        $('#PakCityDiv').hide();
        $('#CityDiv').show();
        $('#PakCityDiv').val('');
      }
  }


    function showHideNationalityBasedFields()
    {
        let nationality = $('input[name="nationality"]:checked').val();
      
        if(nationality==1)
        {
            $('#cnicDiv').show();
            $('#passportDiv').hide();  
        }
        else
        {
            $('#passportDiv').show();
            $('#cnicDiv').hide();      
        }
    }    


    $(document).on('click', '.add-field', function () {
        var html = $(".multi-field").first().clone();
        $(html).find('input').val('').focus();
        $(html).find('.mobile_code').val('0300').focus();
        $(html).find(".plusDiv").remove();
        $(html).find(".minusDiv").show();

        $(".multi-field").first().before(html);

       
        showHideButtons();
     
    });


    $(document).on('click', '.remove-field', function () {
            $(this).closest('.multi-field').remove();
            showHideButtons();
    });


    function showHideButtons(){
        var numOfFields = $('.multi-field').length;
        // remove Plus sign after count 3
        if(numOfFields>=3) 
        {
            $('.plusDiv').hide();
        }else{
            var displayBlockedCount = $('.multi-field > .plusDiv').filter(function() {
                return $(this).css('display') === 'block';
            }).length;

            //console.log("count:"+displayBlockedCount)
            
            if(displayBlockedCount ==0)
                $('.multi-field div.plusDiv:last').show();
        }
    }

</script>  

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/candidates/profile/personal-detail.blade.php ENDPATH**/ ?>