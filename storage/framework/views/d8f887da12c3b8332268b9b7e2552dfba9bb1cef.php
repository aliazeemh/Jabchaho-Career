
<?php $__env->startSection('title', 'Family Details'); ?>
<?php $__env->startSection('content'); ?>

<div class="card-title"><img src="<?php echo e(asset('assets/images/banners/Family-Banner.jpg')); ?>" ></div>
<?php if(!empty($familyDetailAllData)): ?>
        <div id="myCarousel" class="carousel slide profile" data-ride="carousel" data-interval="0">
           <!-- Wrapper for carousel items -->
			<div class="carousel-inner">
                <div class="item carousel-item active">
                    <div class="row">
                        <?php $counter=0;?>
                        <?php $__currentLoopData = $familyDetailAllData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       
                            <div class="col-sm mydivouter">
                            <a class="mybuttonoverlap " onclick="return confirm('Do you wish to remove Family Detail?')" href="<?php echo e(route('family.details.delete',Arr::get($row, 'id'))); ?>"><span class="fa fa-remove"></span></a>
                                <a class="myref" href="<?php echo e(route('family.details.show')); ?>/<?php echo e(Arr::get($row, 'id')); ?>">
                                    <p class="card-text"><?php echo e(config('constants.relation_options')[Arr::get($row, 'relation_id')]); ?></p>
                                    <p class="card-text">
                                        <?php if(!empty(Arr::get($row, 'picture'))): ?>
                                            <img src="<?php echo e(asset(config('constants.files.familydetail'))); ?>/thumbnail/<?php echo e(Arr::get($row, 'picture')); ?>" > 
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('assets/images/default/profile.jpg')); ?>"  class="center" >
                                        <?php endif; ?>
                                        <?php echo e(Arr::get($row, 'name')); ?></p>
                                    <p class="card-text">
                                            <?php echo e(date("M d, Y", strtotime(Arr::get($row, 'date_of_birth')))); ?>

                                    </p>
                                   
                                </a>
                            </div>
                            
                            
                            <?php $counter++; ?>
                            <?php if($counter %3==0): ?>
                                <?php if($counter != count($familyDetailAllData)): ?>
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

        <?php if(count($familyDetailAllData)>3): ?>
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
<h4><hr class="bg-danger border-2 border-top border-danger">Family Details</h4>
<form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo e(route('family.details.perform')); ?>" autocomplete="off">


<?php if(!empty(Arr::get($familyDetailData, 'id'))): ?>
    <?php echo method_field('put'); ?>
<?php endif; ?>
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
    <input type="hidden" name="id" value="<?php echo e(Arr::get($familyDetailData, 'id','')); ?>" />
    <?php if($errors->has('id')): ?>
        <div class="text-danger"><?php echo e($errors->first('id')); ?></div>
    <?php endif; ?>


    <div class="row mb-3">
        <label for="relationOptions" class="col-sm-3 col-form-label col-form-label-sm">Relation</label>
        <div class="col-sm-9 text-left">
            <select class="form-control form-control-sm" id="relationOptions"  name="relation_id" >
                <option value=''>Select</option>
                <?php if(!empty($relationOptions) ): ?>
                    <?php $__currentLoopData = $relationOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(old('relation_id') == $key): ?>
                            <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                        <?php elseif(old('_token') == null && !empty(Arr::get($familyDetailData, 'relation_id')) && Arr::get($familyDetailData, 'relation_id')== $key  ): ?>
                            <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                        <?php else: ?>
                            <option  value="<?php echo e(trim($key)); ?>" ><?php echo e(trim($value)); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
            <?php if($errors->has('relation_id')): ?>
                <div class="text-danger"><?php echo e($errors->first('relation_id')); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mb-3">
        <label for="Name" class="col-sm-3 col-form-label col-form-label-sm">Name</label>
        <div class="col-sm-9 text-left">
            <input type="text" class="form-control form-control-sm" maxlength="100" id="name" name="name" value="<?php if(old('name')): ?><?php echo e(old('name')); ?><?php elseif(empty(old('name')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($familyDetailData,'name')); ?><?php endif; ?>">
            <?php if($errors->has('name')): ?>
                <div class="text-danger"><?php echo e($errors->first('name')); ?></div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="row mb-3">
        <label for="EmergencyContact" class="col-sm-3 col-form-label col-form-label-sm">
            Is This Your Emergency Contact
        </label>
        <div class="col-sm-9 text-left">
            <?php if(!empty($booleanOptions)): ?>
                <?php $__currentLoopData = $booleanOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input class="form-check-input EmergencyContact" type="radio" name="emergency_contact" id="emergency_contact-<?php echo e($key); ?>" value="<?php echo e($key); ?>" 
                            
                    <?php if((old('_token') && old('emergency_contact') == $key)): ?> 
                        <?php echo e('checked'); ?>

                    <?php elseif(old('_token') == null && array_key_exists(Arr::get($familyDetailData, 'emergency_contact'), config('constants.boolean_options')) ): ?>  
                        <?php echo e(Arr::get($familyDetailData, 'emergency_contact') == $key ? 'checked' : ''); ?> 
                    <?php else: ?> 
                        <?php if(old('_token') == null && $key==0): ?>
                            <?php echo e('checked'); ?>

                        <?php endif; ?>
                    <?php endif; ?>
                    
                    >
                    <label class="form-check-label" for="emergency_contact-<?php echo e($key); ?>"><?php echo e($value); ?></label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
        <?php if($errors->has('emergency_contact')): ?>
            <div class="text-danger"><?php echo e($errors->first('emergency_contact')); ?></div>
        <?php endif; ?>
    </div>

    <div class="row mb-3 EmergencyContactNumber" style="display:none;">
        <label for="ContactNo" class="col-sm-3 col-form-label col-form-label-sm">Contact No</label>
        <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm" maxlength="20" id="ContactNo" name="contact_no" onkeydown="return isNumberKey(this);" value="<?php if(old('contact_no')): ?><?php echo e(old('contact_no')); ?><?php elseif(empty(old('contact_no')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($familyDetailData,'contact_no')); ?><?php endif; ?>">
            <?php if($errors->has('contact_no')): ?>
                <div class="text-danger"><?php echo e($errors->first('contact_no')); ?></div>
            <?php endif; ?>
        </div>
    </div>
    
    
    <div class="row mb-3">
        <label for="InstituteName" class="col-sm-3 col-form-label col-form-label-sm">Date of Birth</label>
        <div class="col-sm-9 text-left">
            <div class="row">

                <div class="col-sm-4"> 
                    <select class="form-control form-control-sm" id="month"  name="month" >
                        <option value=''>Month</option>
                        <?php if(!empty($months) ): ?>
                            <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(old('month') == $key): ?>
                                    <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                <?php elseif(old('_token') == null && !empty(Arr::get($familyDetailData, 'date_of_birth')) &&  date("m", strtotime(Arr::get($familyDetailData, 'date_of_birth')))== $key  ): ?>
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

                <div class="col-sm-4"> 
                    <select id="day" name="day" class="form-control form-control-sm">
                        <option value=''>Day</option>
                        <?php for($i = 1; $i<=31; $i++): ?>
                            <?php if(old('day') == $i): ?>

                                <option value="<?php echo e($i); ?>" selected><?php echo e($i); ?></option>
                            <?php elseif(old('_token') == null && !empty(Arr::get($familyDetailData, 'date_of_birth')) &&  date("d", strtotime(Arr::get($familyDetailData, 'date_of_birth')))==  $i   ): ?>
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

                <div class="col-sm-4">  
                    <select id="year" name="year" class="form-control form-control-sm">
                        <option value=''>Year</option>
                        <?php $last= date('Y')-120 ?>
                        <?php $now = date('Y') ?>

                        <?php for($i = $now; $i >= $last; $i--): ?>
                            <?php if(old('year') == $i): ?>

                                <option value="<?php echo e($i); ?>" selected><?php echo e($i); ?></option>
                            <?php elseif(old('_token') == null && !empty(Arr::get($familyDetailData, 'date_of_birth')) &&  date("Y", strtotime(Arr::get($familyDetailData, 'date_of_birth')))==  $i   ): ?>
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
        <label for="statusId" class="col-sm-3 col-form-label col-form-label-sm">Status</label>
        <div class="col-sm-9 text-left">
            <select class="form-control form-control-sm" id="statusId"  name="status_id" >
                <option value=''>Select</option>
                <?php if(!empty($maritalStatuses) ): ?>
                    <?php $__currentLoopData = $maritalStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(old('status_id') == $key): ?>
                            <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                        <?php elseif(old('_token') == null && !empty(Arr::get($familyDetailData, 'status_id')) && (Arr::get($familyDetailData, 'status_id')== $key)  ): ?>
                            <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                        <?php else: ?>
                            <option  value="<?php echo e(trim($key)); ?>" ><?php echo e(trim($value)); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
            <?php if($errors->has('status_id')): ?>
                <div class="text-danger"><?php echo e($errors->first('status_id')); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mb-3">
        <label for="Qualification" class="col-sm-3 col-form-label col-form-label-sm">Qualification</label>
        <div class="col-sm-9 text-left">
            <input type="text" class="form-control form-control-sm" maxlength="100" id="qualification" name="qualification" value="<?php if(old('qualification')): ?><?php echo e(old('qualification')); ?><?php elseif(empty(old('qualification')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($familyDetailData,'qualification')); ?><?php endif; ?>">
            <?php if($errors->has('qualification')): ?>
                <div class="text-danger"><?php echo e($errors->first('qualification')); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mb-3">
        <label for="occupationId" class="col-sm-3 col-form-label col-form-label-sm">Occupation</label>
        <div class="col-sm-9 text-left">
            <select class="form-control form-control-sm" id="occupationId"  name="occupation_id" >
                <option value='0'>Select</option>
                <?php if(!empty($occupationOptions) ): ?>
                    <?php $__currentLoopData = $occupationOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(old('occupation_id') == $key): ?>
                            <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                        <?php elseif(old('_token') == null && !empty(Arr::get($familyDetailData, 'occupation_id')) && (Arr::get($familyDetailData, 'occupation_id')== $key)  ): ?>
                            <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                        <?php else: ?>
                            <option  value="<?php echo e(trim($key)); ?>" ><?php echo e(trim($value)); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
            <?php if($errors->has('occupation_id')): ?>
                <div class="text-danger"><?php echo e($errors->first('occupation_id')); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <span id="occupationBasedHide">
    <div class="row mb-3">
        <label for="Designation" class="col-sm-3 col-form-label col-form-label-sm">Designation</label>
        <div class="col-sm-9 text-left">
            <input type="text" class="form-control form-control-sm" maxlength="100" id="designation" name="designation" value="<?php if(old('designation')): ?><?php echo e(old('designation')); ?><?php elseif(empty(old('designation')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($familyDetailData,'designation')); ?><?php endif; ?>">
            <?php if($errors->has('designation')): ?>
                <div class="text-danger"><?php echo e($errors->first('designation')); ?></div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="row mb-3">
        <label for="companyOrInstitute" class="col-sm-3 col-form-label col-form-label-sm">Company/Institute</label>
        <div class="col-sm-9 text-left">
            <input type="text" class="form-control form-control-sm" maxlength="100" id="companyOrInstitute" name="company_or_institute" value="<?php if(old('company_or_institute')): ?><?php echo e(old('company_or_institute')); ?><?php elseif(empty(old('company_or_institute')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($familyDetailData,'company_or_institute')); ?><?php endif; ?>">
            <?php if($errors->has('company_or_institute')): ?>
                <div class="text-danger"><?php echo e($errors->first('company_or_institute')); ?></div>
            <?php endif; ?>
        </div>
    </div>
</span>
    <div class="row mb-3">
        <label for="Picture" class="col-sm-3 col-form-label col-form-label-sm">Picture</label>
        <div class="col-sm-9 text-left">
            <input type="file" name="picture" id="picture" value="<?php echo e(old('picture')); ?>" class="form-control"  original-title="Picture">
            <?php if(Arr::get($familyDetailData, 'picture')): ?>
            <img src="<?php echo e(asset(config('constants.files.familydetail'))); ?>/<?php echo e(Arr::get($familyDetailData, 'picture')); ?>" class="center" width="200" height="200" >
            <a class="btn btn-danger " onclick="return confirm('Do you wish to remove Picture?')" href="<?php echo e(route('family.details.picture.remove',Arr::get($familyDetailData, 'id'))); ?>"><span class="fa fa-remove"></span></a>
            <?php endif; ?>
            
            <?php if($errors->has('picture')): ?>
                <div class="text-danger"><?php echo e($errors->first('picture')); ?></div>
             <?php endif; ?>
        </div>
       
    </div>

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
    $( document ).ready(function() {
        showHideFormFields();
        showHideEmergencyContactNumber();
    });

    $("#occupationId").change(function(){
        showHideFormFields();
    });  

    function showHideFormFields()
    {
        let occupationId = $('#occupationId').val();
        //if occupationId is not empty
        if(occupationId== 2 || occupationId== 3 || occupationId== 5 || occupationId== 6)
        {
            $('#occupationBasedHide').hide();
            $('#designation').val('');
            $('#companyOrInstitute').val('');
        }else
        {
            $('#occupationBasedHide').show();
        }
    }


    $(".EmergencyContact").click(function(){
        showHideEmergencyContactNumber();
    }); 

    function showHideEmergencyContactNumber()
    {
        let emergencyContact = $('input[name="emergency_contact"]:checked').val();
        
        if(emergencyContact==1)
        {
            $(".EmergencyContactNumber").show();
        }
        else
        {
            $(".EmergencyContactNumber").hide();
            $("#ContactNo").val('');
        }
       
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/candidates/profile/family-detail.blade.php ENDPATH**/ ?>