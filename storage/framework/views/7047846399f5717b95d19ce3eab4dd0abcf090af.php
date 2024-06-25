
<?php $__env->startSection('title', 'Diploma'); ?>
<?php $__env->startSection('content'); ?>

<div class="card-title"><img src="<?php echo e(asset('assets/images/banners/diploma.jpg')); ?>" ></div>
<?php if(!empty($diplomaAllData)): ?>
        <div id="myCarousel" class="carousel slide profile ideas" data-ride="carousel" data-interval="0">
           <!-- Wrapper for carousel items -->
			<div class="carousel-inner">
                <div class="item carousel-item active">
                    <div class="row">
                        <?php $counter=0;?>
                        <?php $__currentLoopData = $diplomaAllData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       
                            <div class="col-sm mydivouter">
                            <a class="mybuttonoverlap " onclick="return confirm('Do you wish to remove Diploma?')" href="<?php echo e(route('diploma.delete',Arr::get($row, 'id'))); ?>"><span class="fa fa-remove"></span></a>
                                <a class="myref" href="<?php echo e(route('diploma.show')); ?>/<?php echo e(Arr::get($row, 'id')); ?>">
                                    <p class="card-text"><?php echo e(Arr::get($row, 'institute_name')); ?></p>
                                    <p class="card-text"><?php echo e(Arr::get($row, 'diploma_title')); ?></p>
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
                                <?php if($counter != count($diplomaAllData)): ?>
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

        <?php if(count($diplomaAllData)>3): ?>
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
<form class="form-horizontal" method="post" action="<?php echo e(route('diploma.perform')); ?>" autocomplete="off">

<?php if(!empty(Arr::get($diplomaData, 'id'))): ?>
    <?php echo method_field('put'); ?>
<?php endif; ?>
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
    <input type="hidden" name="id" value="<?php echo e(Arr::get($diplomaData, 'id','')); ?>" />
    <?php if($errors->has('id')): ?>
        <div class="text-danger"><?php echo e($errors->first('id')); ?></div>
    <?php endif; ?>

    <div <?php if(!empty($diplomaAllData)): ?> style="display:none"; <?php endif; ?>  >
        <p class="text-start"><small>Please provide us details of your diplomas</small></p>
        <p class="text-start">
                <small>Do you have any diplomas?</small>
                
                <?php if(!empty($booleanOptions)): ?>
                    <?php $__currentLoopData = $booleanOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input class="form-check-input diplomaRadio" type="radio" name="is_diplomas_saved" id="diploma-<?php echo e($key); ?>"  value="<?php echo e($key); ?>" 
                        <?php if((old('_token') && old('is_diplomas_saved') == $key)): ?> 
                            <?php echo e('checked'); ?>

                        <?php elseif(old('_token') == null && Arr::get(Auth::guard('candidate')->user(), 'is_diplomas_saved')): ?>  
                            <?php echo e(Arr::get(Auth::guard('candidate')->user(), 'is_diplomas_saved') == $key ? 'checked' : ''); ?> 
                        <?php else: ?> 
                        <?php if(old('_token') == null && $key==0): ?>
                                <?php echo e('checked'); ?>

                            <?php endif; ?>
                        <?php endif; ?>    
                    
                        >
                        <label class="form-check-label" for="diploma-<?php echo e($key); ?>"><?php echo e($value); ?></label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                <?php if($errors->has('is_diplomas_saved')): ?>
                    <div class="text-danger"><?php echo e($errors->first('is_diplomas_saved')); ?></div>
                <?php endif; ?>
        </p>
    </div>    
    <div id="div-diploma-form" style="display:block;">
        <h4><hr class="bg-danger border-2 border-top border-danger">Diploma Details</h4>


        <div class="row mb-3">
            <label for="InstituteName" class="col-sm-3 col-form-label col-form-label-sm">Institute Name</label>
            <div class="col-sm-9 text-left">
                <input type="text" class="form-control form-control-sm" maxlength="100" id="InstituteName" name="institute_name" value="<?php if(old('institute_name')): ?><?php echo e(old('institute_name')); ?><?php elseif(empty(old('institute_name')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($diplomaData,'institute_name')); ?><?php endif; ?>">
                <?php if($errors->has('institute_name')): ?>
                    <div class="text-danger"><?php echo e($errors->first('institute_name')); ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-3">
            <label for="DiplomaTitle" class="col-sm-3 col-form-label col-form-label-sm">Diploma Title</label>
            <div class="col-sm-9 text-left">
                <input type="text" class="form-control form-control-sm" maxlength="100" id="DiplomaTitle" name="diploma_title" value="<?php if(old('diploma_title')): ?><?php echo e(old('diploma_title')); ?><?php elseif(empty(old('diploma_title')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($diplomaData,'diploma_title')); ?><?php endif; ?>">
                <?php if($errors->has('diploma_title')): ?>
                    <div class="text-danger"><?php echo e($errors->first('diploma_title')); ?></div>
                <?php endif; ?>
            </div>
        </div>


        <div class="row mb-3">
            <label for="FieldOfStudy" class="col-sm-3 col-form-label col-form-label-sm">Field of Study</label>
            <div class="col-sm-9 text-left">
                <input type="text" class="form-control form-control-sm" maxlength="100" id="FieldOfStudy" name="field_of_study" value="<?php if(old('field_of_study')): ?><?php echo e(old('field_of_study')); ?><?php elseif(empty(old('field_of_study')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($diplomaData,'field_of_study')); ?><?php endif; ?>">
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
                        <span id="fromDiv" style="display: contents;">    
                            <div class="col-sm-4">
                                
                                <select class="form-control form-control-sm" id="from_months"  name="from_months" >
                                    <option value=''>Month</option>
                                    <?php if(!empty($months) ): ?>
                                        <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(old('from_months') == $key): ?>
                                                <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                            <?php elseif(old('_token') == null && !empty(Arr::get($diplomaData, 'from')) &&  date("m", strtotime(Arr::get($diplomaData, 'from')))== $key  ): ?>
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
                                        <?php elseif(old('_token') == null && !empty(Arr::get($diplomaData, 'from')) &&  date("Y", strtotime(Arr::get($diplomaData, 'from')))==  $i   ): ?>
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
                    <label> <span class="w50px">To:</span>     
                        <span id="toDiv" style="display: contents;">
                            <div class="col-sm-4">
                                    
                                <select class="form-control form-control-sm" id="to_months"  name="to_months" >
                                    <option value=''>Month</option>
                                    <?php if(!empty($months) ): ?>
                                        <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(old('to_months') == $key): ?>
                                                <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                            <?php elseif(old('_token') == null && !empty(Arr::get($diplomaData, 'to')) &&  date("m", strtotime(Arr::get($diplomaData, 'to')))== $key  ): ?>
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
                                            <?php elseif(old('_token') == null && !empty(Arr::get($diplomaData, 'to')) &&  date("Y", strtotime(Arr::get($diplomaData, 'to')))==  $i   ): ?>
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
                    <?php if((old('_token') && old('is_in_progress') != null) || (old('_token') == null && Arr::get($diplomaData, 'is_in_progress'))): ?>    
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
    showHideDiplomaeForm();

    enabledAndDisabledDurationTo();

});


$(".diplomaRadio").change(function(){
    showHideDiplomaeForm();
});    


function showHideDiplomaeForm(){
      let isDiplomasSaved = $('input[name="is_diplomas_saved"]:checked').val();
      
      if(isDiplomasSaved==1){
        $('#div-diploma-form').show();
      }else{
        $('#div-diploma-form').hide();      }
        
    }


    $('#isInProgress').click(function() {
        enabledAndDisabledDurationTo();
    });
    function enabledAndDisabledDurationTo()
    {
        if($('#isInProgress').is(":checked")){
  
            $("#to_months").prop("disabled", true);
            $("#to_year").prop("disabled", true);
  
        }else{
       
            $("#to_months").prop("disabled", false);  
            $("#to_year").prop("disabled", false);  
           
  
        }
    }
</script>
    
   


<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/candidates/profile/diploma.blade.php ENDPATH**/ ?>