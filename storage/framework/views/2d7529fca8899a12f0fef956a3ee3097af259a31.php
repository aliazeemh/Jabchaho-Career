
<?php $__env->startSection('title', 'Professional Experience'); ?>
<?php $__env->startSection('content'); ?>


<div class="card-title"><img src="<?php echo e(asset('assets/images/banners/professional.png')); ?>" ></div>


<?php if(!empty($professionalExperienceAllData)): ?>
        <div id="myCarousel" class="carousel slide profile" data-ride="carousel" data-interval="0">
           <!-- Wrapper for carousel items -->
			<div class="carousel-inner">
                <div class="item carousel-item active">
                    <div class="row">
                        <?php $counter=0;?>
                        <?php $__currentLoopData = $professionalExperienceAllData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       
                            <div class="col-sm mydivouter">
                            <a class="mybuttonoverlap" onclick="return confirm('Do you wish to remove Professional Experience?')" href="<?php echo e(route('professional.experience.delete',Arr::get($row, 'id'))); ?>"><span class="fa fa-remove"></span></a>
                                <a class="myref" href="<?php echo e(route('professional.experience.show')); ?>/<?php echo e(Arr::get($row, 'id')); ?>">
                                    <p class="card-text"><?php echo e(Arr::get($row, 'company_name')); ?></p>
                                    <p class="card-text"><?php echo e(Arr::get($row, 'job_title')); ?></p>
                                    <p class="card-text">
                                            <?php echo e(date("M Y", strtotime(Arr::get($row, 'from')))); ?>

                                            -
                                            <?php if(Arr::get($row, 'is_present')): ?>
                                            <?php echo e('Present'); ?>

                                            <?php else: ?>
                                            <?php echo e(date("M Y", strtotime(Arr::get($row, 'to')))); ?>

                                            <?php endif; ?>
                                    </p>
                                   
                                </a>
                                
                            </div>
                            
                            
                            <?php $counter++; ?>
                            <?php if($counter %3==0): ?>
                                <?php if($counter != count($professionalExperienceAllData)): ?>
                                    </div>
                                    </div>  
                                    <div class="item carousel-item">
                                    <div class="row">
                                <?php endif; ?>
                            <?php endif; ?>
                            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </div>
                </div>  
             </div>

        <?php if(count($professionalExperienceAllData)>3): ?>
            <!-- Carousel controls -->
        <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="carousel-control-next" href="#myCarousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>
        <?php endif; ?>
    </div>

<?php endif; ?>   


<form class="form-horizontal" method="POST" action="<?php echo e(route('professional.experience.perform')); ?>" autocomplete="off">
<?php if(!empty(Arr::get($professionalExperienceData, 'id'))): ?>
    <?php echo method_field('put'); ?>
<?php endif; ?>

    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
    <input type="hidden" name="id" value="<?php echo e(Arr::get($professionalExperienceData, 'id','')); ?>" />
    <?php if($errors->has('id')): ?>
        <div class="text-danger"><?php echo e($errors->first('id')); ?></div>
    <?php endif; ?>

    <div <?php if(!empty($professionalExperienceAllData)): ?> style="display:none"; <?php endif; ?>  >
        <p class="text-start"><small>Please provide us details of your professional experiences</small></p>
        <p class="text-start">
            <small>Do you have professional experience?</small>
            <?php if(!empty($booleanOptions)): ?>
                <?php $__currentLoopData = $booleanOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input class="form-check-input experienceRadio" type="radio" name="is_experience_saved" id="experience-<?php echo e($key); ?>" value="<?php echo e($key); ?>" 
                    <?php if((old('_token') && old('is_experience_saved') == $key)): ?> 
                        <?php echo e('checked'); ?>

                    <?php elseif(old('_token') == null && Arr::get(Auth::guard('candidate')->user(), 'is_experience_saved')): ?>  
                        <?php echo e(Arr::get(Auth::guard('candidate')->user(), 'is_experience_saved') == $key ? 'checked' : ''); ?> 
                    <?php else: ?> 
                       <?php if(old('_token') == null && $key==0): ?>
                            <?php echo e('checked'); ?>

                        <?php endif; ?>
                    <?php endif; ?>    
                   
                    >
                    <label class="form-check-label" for="experience-<?php echo e($key); ?>" value="<?php echo e($key); ?>"><?php echo e($value); ?></label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if($errors->has('is_experience_saved')): ?>
                <div class="text-danger"><?php echo e($errors->first('is_experience_saved')); ?></div>
            <?php endif; ?>
              
        </p>
   
    </div>
    <div id="div-experience-form" style="display:block;">
        <h4><hr class="bg-danger border-2 border-top border-danger">Company Details</h4>

       
            <div class="row mb-3">
                <label for="CompanyName" class="col-sm-3 col-form-label col-form-label-sm">Company Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" maxlength="100" id="CompanyName" name="company_name" value="<?php if(old('company_name')): ?><?php echo e(old('company_name')); ?><?php elseif(empty(old('company_name')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($professionalExperienceData,'company_name')); ?><?php endif; ?>">
                    <?php if($errors->has('company_name')): ?>
                        <div class="text-danger"><?php echo e($errors->first('company_name')); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row mb-3">
                <label for="CompanyWebsite" class="col-sm-3 col-form-label col-form-label-sm">Company Website</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" maxlength="100" id="CompanyWebsite" name="company_website" value="<?php if(old('company_website')): ?><?php echo e(old('company_website')); ?><?php elseif(empty(old('company_website')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($professionalExperienceData, 'company_website')); ?><?php endif; ?>">
                    <?php if($errors->has('company_website')): ?>
                        <div class="text-danger"><?php echo e($errors->first('company_website')); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <h4><hr class="bg-danger border-2 border-top border-danger">Job Details</h4>
            <div class="row mb-3">
                <label for="JobTitle" class="col-sm-3 col-form-label col-form-label-sm">Job Title</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" maxlength="100" id="JobTitle"  name="job_title" value="<?php if(old('job_title')): ?><?php echo e(old('job_title')); ?> <?php elseif(empty(old('job_title')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($professionalExperienceData, 'job_title')); ?><?php endif; ?>">
                    <?php if($errors->has('job_title')): ?>
                        <div class="text-danger"><?php echo e($errors->first('job_title')); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row mb-3">
                <label for="JobCityCountry" class="col-sm-3 col-form-label col-form-label-sm">Job City/Country</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" maxlength="200" id="JobCityCountry"  name="job_city_country" value="<?php if(old('job_city_country')): ?><?php echo e(old('job_city_country')); ?> <?php elseif(empty(old('job_city_country')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($professionalExperienceData, 'job_city_country')); ?><?php endif; ?>">
                    <?php if($errors->has('job_city_country')): ?>
                        <div class="text-danger"><?php echo e($errors->first('job_city_country')); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="text-end">
                <?php if(!empty($jobTypes)): ?>
                    <?php $__currentLoopData = $jobTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input class="form-check-input" type="radio" name="job_type_id" id="job_type_<?php echo e(Arr::get($jobType, 'id')); ?>"  value="<?php echo e(Arr::get($jobType, 'id')); ?>"  
                            <?php if(!empty(old('job_type_id'))): ?> 
                                <?php echo e(old('job_type_id') == Arr::get($jobType, 'id') ? 'checked' : ''); ?> 
                            <?php elseif(Arr::get($professionalExperienceData, 'job_type_id')): ?>  
                                <?php echo e(Arr::get($professionalExperienceData, 'job_type_id') == Arr::get($jobType, 'id') ? 'checked' : ''); ?> 
                            <?php else: ?> 
                                <?php if(!empty(Arr::get($jobType, 'is_checked'))): ?> checked 
                                <?php endif; ?> 
                            <?php endif; ?>
                        >
                        <label class="form-check-label" for="job_type_<?php echo e(Arr::get($jobType, 'id')); ?>">
                        <?php echo e(Arr::get($jobType, 'name')); ?>

                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <?php if($errors->has('job_type_id')): ?>
                    <div class="text-danger"><?php echo e($errors->first('job_type_id')); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="row mb-3">
                <label for="Responsibilities" class="col-sm-3 col-form-label col-form-label-sm">Responsibilities</label>
                <div class="col-sm-9">
                <textarea name="responsibilities" rows="2" cols="20" id="Responsibilities" class="form-control form-control-sm"><?php if(old('responsibilities')): ?><?php echo e(old('responsibilities')); ?> 
 <?php elseif(empty(old('responsibilities')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($professionalExperienceData, 'responsibilities')); ?><?php endif; ?></textarea>
                    <?php if($errors->has('responsibilities')): ?>
                        <div class="text-danger"><?php echo e($errors->first('responsibilities')); ?></div>
                    <?php endif; ?>
                </div>
            </div> 
            <div class="row mb-3">
                <label for="ResonForLeaving" class="col-sm-3 col-form-label col-form-label-sm">Reson For Leaving</label>
                <div class="col-sm-9">
                    <textarea name="reason_for_leaving" rows="2" cols="20" id="ResonForLeaving" class="form-control form-control-sm"><?php if(old('reason_for_leaving')): ?><?php echo e(old('reason_for_leaving')); ?><?php elseif(empty(old('reason_for_leaving')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($professionalExperienceData, 'reason_for_leaving')); ?><?php endif; ?></textarea>
                    <?php if($errors->has('reason_for_leaving')): ?>
                        <div class="text-danger"><?php echo e($errors->first('reason_for_leaving')); ?></div>
                    <?php endif; ?>
                </div>
            </div> 

            <div class="row mb-3 duration">
                <label for="Duration" class="col-sm-3 col-form-label col-form-label-sm">Duration</label>
                <div class="col-sm-9 text-left">  
                    <div class="row">               
                        <label> 
                            <span class="w50px">From:</span>   
                            <span id="fromDiv" style="display: contents;">
                                <div class="col-sm-4">
                                
                                    <select class="form-control form-control-sm" id="from_months"  name="from_months" >
                                        <option value=''>Month</option>
                                        <?php if(!empty($months) ): ?>
                                            <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(old('from_months') == $key): ?>
                                                    <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                                <?php elseif(old('_token') == null && !empty(Arr::get($professionalExperienceData, 'from')) &&  date("m", strtotime(Arr::get($professionalExperienceData, 'from')))== $key  ): ?>
                                                    <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                                <?php else: ?>
                                                    <option  value="<?php echo e(trim($key)); ?>" ><?php echo e(trim($value)); ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                    <?php if($errors->has('from_months')): ?>
                                        <div class="text-danger"><?php echo e($errors->first('from_months')); ?></div>
                                    <?php endif; ?>
                                </div>    
                                <div class="col-sm-4">
                                    <select id="from_year" name="from_year" class="form-control form-control-sm">
                                    <option value=''>Year</option>
                                    <?php $last= date('Y')-120 ?>
                                    <?php $now = date('Y') ?>

                                        <?php for($i = $now; $i >= $last; $i--): ?>
                                            <?php if(old('from_year') == $i): ?>

                                                <option value="<?php echo e($i); ?>" selected><?php echo e($i); ?></option>
                                            <?php elseif(old('_token') == null && !empty(Arr::get($professionalExperienceData, 'from')) &&  date("Y", strtotime(Arr::get($professionalExperienceData, 'from')))==  $i   ): ?>
                                                <option value="<?php echo e($i); ?>" selected><?php echo e($i); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                            <?php endif; ?>    
                                        <?php endfor; ?>
                                    </select>
                                    <?php if($errors->has('from_year')): ?>
                                        <div class="text-danger"><?php echo e($errors->first('from_year')); ?></div>
                                    <?php endif; ?>
                                </div>    
                            </span>
                        </label>
                        <br/>
                        <label>
                            <span class="w50px">To:</span>
                            <span id="toDiv" style="display: contents;">
                                <div class="col-sm-4">                                
                                    <select class="form-control form-control-sm" id="to_months"  name="to_months" >
                                        <option value=''>Month</option>
                                        <?php if(!empty($months) ): ?>
                                            <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(old('to_months') == $key): ?>
                                                    <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                                <?php elseif(old('_token') == null && !empty(Arr::get($professionalExperienceData, 'to')) &&  date("m", strtotime(Arr::get($professionalExperienceData, 'to')))== $key  ): ?>
                                                    <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                                <?php else: ?>
                                                    <option  value="<?php echo e(trim($key)); ?>" ><?php echo e(trim($value)); ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                    <?php if($errors->has('to_months')): ?>
                                        <div class="text-danger"><?php echo e($errors->first('to_months')); ?></div>
                                    <?php endif; ?>
                                </div>    
                                <div class="col-sm-4">
                                    <select id="to_year" name="to_year" class="form-control form-control-sm">
                                    <option value=''>Year</option>
                                    <?php $last= date('Y')-120 ?>
                                    <?php $now = date('Y') ?>

                                        <?php for($i = $now; $i >= $last; $i--): ?>
                                            <?php if(old('to_year') == $i): ?>
                                                <option value="<?php echo e($i); ?>" selected><?php echo e($i); ?></option>
                                            <?php elseif(old('_token') == null && !empty(Arr::get($professionalExperienceData, 'to')) &&  date("Y", strtotime(Arr::get($professionalExperienceData, 'to')))==  $i   ): ?>
                                                <option value="<?php echo e($i); ?>" selected><?php echo e($i); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                            <?php endif; ?>   
                                        <?php endfor; ?>
                                    </select>
                                    <?php if($errors->has('to_year')): ?>
                                        <div class="text-danger"><?php echo e($errors->first('to_year')); ?></div>
                                    <?php endif; ?>
                                </div>   
                            </span> 
                        </label>
                    </div>
                    <span class="col-sm-3" id="presentSpanId" style=" display:none"><small>Present</small></span>
                </div> 

            </div>
            
            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <div class="text-end">
                        <input class="form-check-input"  type="checkbox" id="isPresent" name="is_present" value="1" 
                   
                        <?php if((old('_token') && old('is_present') != null) || (old('_token') == null && Arr::get($professionalExperienceData, 'is_present'))): ?>    
                        <?php echo e('checked'); ?>

                        <?php else: ?>
                            <?php echo e(''); ?>

                        <?php endif; ?>   
                        >
                        <label class="form-check-label" for="isPresent">
                        Currently working here
                        </label>
                    </div>
                    <?php if($errors->has('is_present')): ?>
                        <div class="text-danger"><?php echo e($errors->first('is_present')); ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="CurrentSalary" class="col-sm-3 col-form-label col-form-label-sm">Current Salary</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" maxlength="7" id="CurrentSalary" name="current_salary" value="<?php if(old('current_salary')): ?><?php echo e(old('current_salary')); ?><?php elseif(empty(old('current_salary')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($professionalExperienceData, 'current_salary')); ?><?php endif; ?>" onkeydown="return isNumberKey(this);">
                    <?php if($errors->has('current_salary')): ?>
                        <div class="text-danger"><?php echo e($errors->first('current_salary')); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row mb-3" >
                <label for="Initial Salary" class="col-sm-3 col-form-label col-form-label-sm">Initial Salary</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" maxlength="7" id="InitialSalary" name="initial_salary" value="<?php if(old('initial_salary')): ?><?php echo e(old('initial_salary')); ?><?php elseif(empty(old('initial_salary')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($professionalExperienceData, 'initial_salary')); ?><?php endif; ?>" onkeydown="return isNumberKey(this);">
                    <?php if($errors->has('initial_salary')): ?>
                        <div class="text-danger"><?php echo e($errors->first('initial_salary')); ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if(!empty($facilityGroupWithOptions) ): ?>
                <?php $groupName = ''; $counter=0;?>
                <?php $__currentLoopData = $facilityGroupWithOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $object): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                        
                        <?php if($groupName != $object['group_name']): ?>

                        <?php if($counter != 0): ?>
                        </div>
                        </div>
                        <?php endif; ?>

                        <div class="row mb-3" >
                        <label for="" class="col-sm-3 col-form-label col-form-label-sm"><?php echo e(Arr::get($object, 'group_name')); ?></label>
                        <div class="col-sm-9 text-left">  
                               
                        <?php $groupName = $object['group_name']; ?>
                        <?php $counter++; ?>
                        <?php endif; ?>
                    
                        
                            <input class="form-check-input" type="checkbox" id="<?php echo e(Arr::get($object, 'name')); ?>-<?php echo e(Arr::get($object, 'id')); ?>" name="facilityGroup[]" value="<?php echo e(Arr::get($object, 'id')); ?>"  
                            <?php if(is_array(old('facilityGroup')) && !empty(old('facilityGroup'))): ?>
                                <?php echo e((is_array(old('facilityGroup')) && in_array(Arr::get($object, 'id'), old('facilityGroup'))) ? ' checked' : ''); ?> 
                            
                            <?php elseif(empty(old('facilityGroup')) && old('_token')): ?>
                            <?php echo e(''); ?>

                            <?php else: ?>

                                <?php if(!empty($professionalExperienceData->candidateExperienceFacilities)): ?>
                                    <?php $__currentLoopData = $professionalExperienceData->candidateExperienceFacilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidateExperienceFacility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(Arr::get($candidateExperienceFacility, 'facility_option_id')): ?>  
                                            <?php echo e(Arr::get($candidateExperienceFacility, 'facility_option_id') == Arr::get($object, 'id') ? 'checked' : ''); ?> 
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            
                            <?php endif; ?>
                            > 
                            <label class="form-check-label" for="<?php echo e(Arr::get($object, 'name')); ?>-<?php echo e(Arr::get($object, 'id')); ?>"><?php echo e(Arr::get($object, 'name')); ?></label>
                        
                       
                    
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if($counter != 0): ?>
                        </div>
                        </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if($errors->has('facilityGroup')): ?>
                <div class="text-danger"><?php echo e($errors->first('facilityGroup')); ?></div>
            <?php endif; ?>

            <hr class="bg-danger border-2 border-top border-danger">

            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <div class="text-end">
                        <input type="submit" value="Save & Add more" name="form_submit" />
                    </div>
                </div>
            </div>

       
    </div>

    <hr class="bg-danger border-2 border-top border-danger">
    <div class="row mb-3">
        <div class="col-sm-10 offset-sm-2">
            <div class="text-end">
                <input  type="submit" class="btn btn-primary" value="Save & Continue" name="form_submit" />
            </div>
        </div>
    </div>
    
    
    
</form>

   


    
<script>

    // A $( document ).ready() block.
    $( document ).ready(function() {
        showHideExperienceForm();

        showHideDurationTo();

    });


    $(".experienceRadio").change(function(){
        showHideExperienceForm();
    });

    function showHideExperienceForm(){
      
     // if there is data mean value = 1 
    let isExperienceSaved = $('input[name="is_experience_saved"]:checked').val();
     
      if(isExperienceSaved==1){
        $('#div-experience-form').show();
      }else{
        $('#div-experience-form').hide();      }
        
    }

    $('#isPresent').click(function() {
            showHideDurationTo();
    });

    function showHideDurationTo(){
        if($('#isPresent').is(":checked")){
                $('#toDiv').hide();
                $('#presentSpanId').show();

            }else{
                $('#toDiv').show();
                $('#presentSpanId').hide();
            }
    }
</script>
    
   


<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/candidates/profile/professional-experience.blade.php ENDPATH**/ ?>