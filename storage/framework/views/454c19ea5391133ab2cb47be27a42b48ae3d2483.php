
<?php $__env->startSection('title', 'Certification'); ?>
<?php $__env->startSection('content'); ?>

<div class="card-title"><img src="<?php echo e(asset('assets/images/banners/certification.jpg')); ?>" ></div>
<?php if(!empty($certificateAllData)): ?>
        <div id="myCarousel" class="carousel slide profile" data-ride="carousel" data-interval="0">
           <!-- Wrapper for carousel items -->
			<div class="carousel-inner">
                <div class="item carousel-item active">
                    <div class="row">
                        <?php $counter=0;?>
                        <?php $__currentLoopData = $certificateAllData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       
                            <div class="col-sm mydivouter">
                            <a class="mybuttonoverlap " onclick="return confirm('Do you wish to remove Certification detail?')" href="<?php echo e(route('certification.delete',Arr::get($row, 'id'))); ?>"><span class="fa fa-remove"></span></a>
                                <a class="myref" href="<?php echo e(route('certification.show')); ?>/<?php echo e(Arr::get($row, 'id')); ?>">
                                    <p class="card-text"><?php echo e(Arr::get($row, 'institute_name')); ?></p>
                                    <p class="card-text"><?php echo e(Arr::get($row, 'certification_title')); ?></p>
                                    <p class="card-text">
                                            <?php echo e(date("M Y", strtotime(Arr::get($row, 'from')))); ?>

                                            -
                                            <?php if(Arr::get($row, 'is_in_progress')): ?>
                                            <?php echo e('Present'); ?>

                                            <?php else: ?>
                                            <?php echo e(date("M Y", strtotime(Arr::get($row, 'to')))); ?>

                                            <?php endif; ?>
                                    </p>
                                   
                                </a>
                            </div>
                            
                            
                            <?php $counter++; ?>
                            <?php if($counter %3==0): ?>
                                <?php if($counter != count($certificateAllData)): ?>
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

        <?php if(count($certificateAllData)>3): ?>
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

<form class="form-horizontal" method="post" action="<?php echo e(route('certification.perform')); ?>" autocomplete="off">
<?php if(!empty(Arr::get($certificateData, 'id'))): ?>
    <?php echo method_field('put'); ?>
<?php endif; ?>
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
    <input type="hidden" name="id" value="<?php echo e(Arr::get($certificateData, 'id','')); ?>" />
    <?php if($errors->has('id')): ?>
        <div class="text-danger"><?php echo e($errors->first('id')); ?></div>
    <?php endif; ?>

    <div <?php if(!empty($certificateAllData)): ?> style="display:none"; <?php endif; ?>  >
        <p class="text-start"><small>Please provide us details of your certifications</small></p>
        <p class="text-start">
                <small>Do you have any certifications?</small>
                
                <?php if(!empty($booleanOptions)): ?>
                    <?php $__currentLoopData = $booleanOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input class="form-check-input certificationsRadio" type="radio" name="is_certifications_saved" id="certifications-<?php echo e($key); ?>" value="<?php echo e($key); ?>" 
                        <?php if((old('_token') && old('is_certifications_saved') == $key)): ?> 
                            <?php echo e('checked'); ?>

                        <?php elseif(old('_token') == null && Arr::get(Auth::guard('candidate')->user(), 'is_certifications_saved')): ?>  
                            <?php echo e(Arr::get(Auth::guard('candidate')->user(), 'is_certifications_saved') == $key ? 'checked' : ''); ?> 
                        <?php else: ?> 
                        <?php if(old('_token') == null && $key==0): ?>
                                <?php echo e('checked'); ?>

                            <?php endif; ?>
                        <?php endif; ?>    
                    
                        >
                        <label class="form-check-label" for="certifications-<?php echo e($key); ?>"><?php echo e($value); ?></label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                <?php if($errors->has('is_certifications_saved')): ?>
                    <div class="text-danger"><?php echo e($errors->first('is_certifications_saved')); ?></div>
                <?php endif; ?>
        </p>
    </div>    
    <div id="div-certificate-form" style="display:block;">
        <h4><hr class="bg-danger border-2 border-top border-danger">Certification Details</h4>


        <div class="row mb-3">
            <label for="InstituteName" class="col-sm-3 col-form-label col-form-label-sm">Institute Name</label>
            <div class="col-sm-9 text-left">
                <input type="text" class="form-control form-control-sm" maxlength="100" id="InstituteName" name="institute_name" value="<?php if(old('institute_name')): ?><?php echo e(old('institute_name')); ?><?php elseif(empty(old('institute_name')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($certificateData,'institute_name')); ?><?php endif; ?>">
                <?php if($errors->has('institute_name')): ?>
                    <div class="text-danger"><?php echo e($errors->first('institute_name')); ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-3">
            <label for="CertificationTitle" class="col-sm-3 col-form-label col-form-label-sm">Certification Title</label>
            <div class="col-sm-9 text-left">
                <input type="text" class="form-control form-control-sm" maxlength="100" id="CertificationTitle" name="certification_title" value="<?php if(old('certification_title')): ?><?php echo e(old('certification_title')); ?><?php elseif(empty(old('certification_title')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($certificateData,'certification_title')); ?><?php endif; ?>">
                <?php if($errors->has('certification_title')): ?>
                    <div class="text-danger"><?php echo e($errors->first('certification_title')); ?></div>
                <?php endif; ?>
            </div>
        </div>


        <div class="row mb-3">
            <label for="FieldOfStudy" class="col-sm-3 col-form-label col-form-label-sm">Field of Study</label>
            <div class="col-sm-9 text-left">
                <input type="text" class="form-control form-control-sm" maxlength="100" id="FieldOfStudy" name="field_of_study" value="<?php if(old('field_of_study')): ?><?php echo e(old('field_of_study')); ?><?php elseif(empty(old('field_of_study')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($certificateData,'field_of_study')); ?><?php endif; ?>">
                <?php if($errors->has('field_of_study')): ?>
                    <div class="text-danger"><?php echo e($errors->first('field_of_study')); ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-3 duration">
            <label for="Duration" class="col-sm-3 col-form-label col-form-label-sm">Duration</label>
            <div class="col-sm-9 text-left">
                
            <div class="row">
                    <label> <span class="w50px">From:</span>  
                        <div class="col-sm-4">
                            
                            <select class="form-control form-control-sm" id="from_months"  name="from_months" >
                                <option value=''>Month</option>
                                <?php if(!empty($months) ): ?>
                                    <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(old('from_months') == $key): ?>
                                            <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                        <?php elseif(old('_token') == null && !empty(Arr::get($certificateData, 'from')) &&  date("m", strtotime(Arr::get($certificateData, 'from')))== $key  ): ?>
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
                                        <?php elseif(old('_token') == null && !empty(Arr::get($certificateData, 'from')) &&  date("Y", strtotime(Arr::get($certificateData, 'from')))==  $i   ): ?>
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
                                            <?php elseif(old('_token') == null && !empty(Arr::get($certificateData, 'to')) &&  date("m", strtotime(Arr::get($certificateData, 'to')))== $key  ): ?>
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
                                            <?php elseif(old('_token') == null && !empty(Arr::get($certificateData, 'to')) &&  date("Y", strtotime(Arr::get($certificateData, 'to')))==  $i   ): ?>
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

            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-10 offset-sm-2">
                <div class="text-end">
                    <input class="form-check-input" type="checkbox" id="isInProgress" name="is_in_progress" value="1" 
                    <?php if((old('_token') && old('is_in_progress') != null) || (old('_token') == null && Arr::get($certificateData, 'is_in_progress'))): ?>    
                        <?php echo e('checked'); ?>

                    <?php else: ?>
                        <?php echo e(''); ?>

                    <?php endif; ?>  
                    >
                    <label class="form-check-label" for="isInProgress">
                        In progress
                    </label>
                    <?php if($errors->has('is_in_progress')): ?>
                        <div class="text-danger"><?php echo e($errors->first('is_in_progress')); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>


        
        <div class="row mb-3" id="CoursesPapersDiv" style="display:none">
            <label for="Duration" class="col-sm-3 col-form-label col-form-label-sm">Papers/Courses</label>
            <div class="col-sm-9 text-left duration">
                
                <div class="row">
                    <label>
                        <div class="w50px">Total</div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" maxlength="2" id="CoursesPapersTotal" name="courses_papers_total" value="<?php if(old('courses_papers_total')): ?><?php echo e(old('courses_papers_total')); ?><?php elseif(empty(old('courses_papers_total')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($certificateData,'courses_papers_total')); ?><?php endif; ?>" onkeydown="return isNumberKey(this);">
                            <?php if($errors->has('courses_papers_total')): ?>
                                <div class="text-danger"><?php echo e($errors->first('courses_papers_total')); ?></div>
                            <?php endif; ?>
                        </div> 
                    </label>
                    <label>
                        <div class="w50px">Cleared</div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" maxlength="2" id="CoursesPapersCleared" name="courses_papers_cleared" value="<?php if(old('courses_papers_cleared')): ?><?php echo e(old('courses_papers_cleared')); ?><?php elseif(empty(old('courses_papers_cleared')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($certificateData,'courses_papers_cleared')); ?><?php endif; ?>" onkeydown="return isNumberKey(this);">
                            <?php if($errors->has('courses_papers_cleared')): ?>
                                <div class="text-danger"><?php echo e($errors->first('courses_papers_cleared')); ?></div>
                            <?php endif; ?>
                        </div> 
                    </label>
                </div> 
            </div>
        </div>  

        <hr class="bg-danger border-2 border-top border-danger">

            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <div class="text-end">
                        <input type="submit" class="btn btn-light" value="Save & Add more" name="form_submit" />
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
    showHideCertificateForm();

    enabledAndDisabledDurationTo();

});


$(".certificationsRadio").change(function(){
    showHideCertificateForm();
});    


function showHideCertificateForm(){
      let isCertificationsSaved = $('input[name="is_certifications_saved"]:checked').val();
      
      if(isCertificationsSaved==1){
        $('#div-certificate-form').show();
      }else{
        $('#div-certificate-form').hide();      }
        
    }


    $('#isInProgress').click(function() {
        enabledAndDisabledDurationTo();
    });
    function enabledAndDisabledDurationTo()
    {
        if($('#isInProgress').is(":checked")){
  
            $("#to_months").prop("disabled", true);
            $("#to_year").prop("disabled", true);
            $('#CoursesPapersDiv').show();

        }else{
       
            $("#to_months").prop("disabled", false);  
            $("#to_year").prop("disabled", false);  
            $('#CoursesPapersDiv').hide();

        }
    }
</script>
    
   


<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/candidates/profile/certification.blade.php ENDPATH**/ ?>