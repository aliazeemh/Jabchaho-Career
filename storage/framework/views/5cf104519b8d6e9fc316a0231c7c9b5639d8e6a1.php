
<?php $__env->startSection('title', 'Educational Qualification'); ?>
<?php $__env->startSection('content'); ?>
<link href="<?php echo url('assets/css/select2.min.css'); ?>" rel="stylesheet">
<div class="card-title"><img src="<?php echo e(asset('assets/images/banners/education.jpg')); ?>" ></div>


<?php if(!empty($educationalQualificationAllData)): ?>
        <div id="myCarousel" class="carousel slide profile" data-ride="carousel" data-interval="0">
           <!-- Wrapper for carousel items -->
			<div class="carousel-inner">
                <div class="item carousel-item active">
                    <div class="row">
                        <?php $counter=0;?>
                        <?php $__currentLoopData = $educationalQualificationAllData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       
                            <div class="col-sm mydivouter">
                            <a class="mybuttonoverlap" onclick="return confirm('Do you wish to remove Educational Qualification?')" href="<?php echo e(route('educational.qualification.delete',Arr::get($row, 'id'))); ?>"><span class="fa fa-remove"></span></a>
                                <a class="myref" href="<?php echo e(route('educational.qualification.show')); ?>/<?php echo e(Arr::get($row, 'id')); ?>">
                                    <p class="card-text"><?php echo e(Arr::get($row, 'institute_name')); ?></p>
                                    <p class="card-text"><?php echo e(Arr::get($row, 'field_of_study')); ?></p>
                                    <p class="card-text">
                                            <?php echo e(date("M Y", strtotime(Arr::get($row, 'from')))); ?>

                                            -
                                            <?php if(Arr::get($row, 'is_in_progress')): ?>
                                            <?php echo e('Now'); ?>

                                            <?php else: ?>
                                            <?php echo e(date("M Y", strtotime(Arr::get($row, 'to')))); ?>

                                            <?php endif; ?>
                                    </p>
                                   
                                </a>
                                
                            </div>
                            
                            
                            <?php $counter++; ?>
                            <?php if($counter %3==0): ?>
                                <?php if($counter != count($educationalQualificationAllData)): ?>
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

        <?php if(count($educationalQualificationAllData)>3): ?>
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

<form class="form-horizontal" method="post" action="<?php echo e(route('educational.qualification.perform')); ?>" autocomplete="off">
<?php if(!empty(Arr::get($educationalQualificationData, 'id'))): ?>
    <?php echo method_field('put'); ?>
<?php endif; ?>    
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
    <input type="hidden" name="id" value="<?php echo e(Arr::get($educationalQualificationData, 'id','')); ?>" />
    <?php if($errors->has('id')): ?>
        <div class="text-danger"><?php echo e($errors->first('id')); ?></div>
    <?php endif; ?>
    <h4><hr class="bg-danger border-2 border-top border-danger">Education Details</h4>

    <div class="row mb-3">
        <label for="instituteName" class="col-sm-3 col-form-label col-form-label-sm  text-left">Institute Name</label>
        <div class="col-sm-9 text-left">
            <input type="text" class="form-control form-control-sm" maxlength="100" id="instituteName" name="institute_name" value="<?php if(old('institute_name')): ?><?php echo e(old('institute_name')); ?><?php elseif(empty(old('institute_name')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($educationalQualificationData,'institute_name')); ?><?php endif; ?>">
            <?php if($errors->has('institute_name')): ?>
                <div class="text-danger"><?php echo e($errors->first('institute_name')); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mb-3">
        <label for="levelOfEducation" class="col-sm-3 col-form-label col-form-label-sm text-left">Level of Education</label>
        <div class="col-sm-9 text-left">
            <select class="form-control form-control-sm" id="levelOfEducation"  name="level_of_education" onchange="showAndHideFields()" >
            <option  value="">Select Education Level</option>
                <?php if(!empty($levelOfEducations) ): ?>
                    <?php $__currentLoopData = $levelOfEducations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(old('level_of_education')==$key): ?>
                            <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?> </option> 
                        <?php elseif(old('_token') == null && Arr::get($educationalQualificationData, 'level_of_education') == $key  ): ?>
                            <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option> 
                        <?php else: ?>
                            <option  value="<?php echo e(trim($key)); ?>" ><?php echo e(trim($value)); ?> </option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
            <?php if($errors->has('level_of_education')): ?>
                <div class="text-danger"><?php echo e($errors->first('level_of_education')); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mb-3" id="BoardNameDiv"  style="display:none;">
        <label for="BoardName" class="col-sm-3 col-form-label col-form-label-sm text-left">Board Name</label>
        <div class="col-sm-9 text-left">
            <select class="form-control form-control-sm" id="BoardName"  name="board" >
            <option  value="">Select Board</option>
                <?php if(!empty($boards) ): ?>
                    <?php $__currentLoopData = $boards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(old('board')==$key): ?>
                            <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?> </option> 
                        <?php elseif(old('_token') == null && Arr::get($educationalQualificationData, 'board') == $key  ): ?>
                            <option value="<?php echo e(trim($key)); ?>" selected><?php echo e(trim($value)); ?></option>     
                        <?php else: ?>
                            <option  value="<?php echo e(trim($key)); ?>" ><?php echo e(trim($value)); ?> </option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
            <?php if($errors->has('board')): ?>
                <div class="text-danger"><?php echo e($errors->first('board')); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mb-3">
        <label for="fieldOfStudy" class="col-sm-3 col-form-label col-form-label-sm text-left">Field of Study</label>
        <div class="col-sm-9 text-left">
            <input type="text" class="form-control form-control-sm" maxlength="100" id="fieldOfStudy" name="field_of_study" value="<?php if(old('field_of_study')): ?><?php echo e(old('field_of_study')); ?><?php elseif(empty(old('field_of_study')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($educationalQualificationData,'field_of_study')); ?><?php endif; ?>">
            <?php if($errors->has('field_of_study')): ?>
                <div class="text-danger"><?php echo e($errors->first('field_of_study')); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mb-3">
        <label for="majors" class="col-sm-3 col-form-label col-form-label-sm text-left">Majors</label>
        <div class="col-sm-9 text-left">
            
            <?php  $majors = '';  ?>


            <?php if(old('majors')): ?>
                <?php  $majors = old('majors');  ?>
                
            <?php elseif( Arr::get($educationalQualificationData,'majors') && empty(old('_token'))): ?>
                   
                 <?php $majors = explode(',',Arr::get($educationalQualificationData,'majors')); ?>
                   
            <?php endif; ?>

            <select class="form-control form-control tokenizationSelect2" multiple="true" name="majors[]">
                <?php if(!empty($majors) ): ?>

                        <?php $__currentLoopData = $majors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($row); ?>" selected="selected"><?php echo e($row); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>   
                    <option value=""></option>
                <?php endif; ?>                    
            </select>
            <?php if($errors->has('majors')): ?>
                <div class="text-danger"><?php echo e($errors->first('majors')); ?></div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="row mb-3 duration">
        <label for="Duration" class="col-sm-3 col-form-label col-form-label-sm text-left">Duration</label>
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
                                            <?php elseif(old('_token') == null && !empty(Arr::get($educationalQualificationData, 'from')) &&  date("m", strtotime(Arr::get($educationalQualificationData, 'from')))== $key  ): ?>
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
                                        <?php elseif(old('_token') == null && !empty(Arr::get($educationalQualificationData, 'from')) &&  date("Y", strtotime(Arr::get($educationalQualificationData, 'from')))==  $i   ): ?>
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
                                            <?php elseif(old('_token') == null && !empty(Arr::get($educationalQualificationData, 'to')) &&  date("m", strtotime(Arr::get($educationalQualificationData, 'to')))== $key  ): ?>
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
                                        <?php elseif(old('_token') == null && !empty(Arr::get($educationalQualificationData, 'to')) &&  date("Y", strtotime(Arr::get($educationalQualificationData, 'to')))==  $i   ): ?>
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
    <div class="row mb-3 awaiting-detail">
        <div class="col-sm-3 hide-on-mobile"></div>
        <div class="col-sm-8">
            <div class="row text-left">

                <div class="col-sm-12">
                    <input class="form-check-input" type="checkbox" id="finalResult" name="final_result" value="1" 
                    <?php if((old('_token') && old('final_result') != null) || (old('_token') == null && Arr::get($educationalQualificationData, 'final_result'))): ?>    
                        <?php echo e('checked'); ?>

                    <?php else: ?>
                        <?php echo e(''); ?>

                    <?php endif; ?>  
                    >
                    <label class="form-check-label" for="finalResult">
                        Final Result / Transcript Awaited
                    </label>
                    <?php if($errors->has('final_result')): ?>
                        <div class="text-danger"><?php echo e($errors->first('final_result')); ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-sm-12">
                    <input class="form-check-input" type="checkbox" id="dropOut " name="drop_out" value="1" 
                    <?php if((old('_token') && old('drop_out') != null) || (old('_token') == null && Arr::get($educationalQualificationData, 'drop_out'))): ?>    
                        <?php echo e('checked'); ?>

                    <?php else: ?>
                        <?php echo e(''); ?>

                    <?php endif; ?>  
                    >
                    <label class="form-check-label" for="dropOut">
                        Drop Out
                    </label>
                    <?php if($errors->has('drop_out')): ?>
                        <div class="text-danger"><?php echo e($errors->first('drop_out')); ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-sm-12">
                    <input class="form-check-input" type="checkbox" id="isInProgress" name="is_in_progress" value="1" 
                    <?php if((old('_token') && old('is_in_progress') != null) || (old('_token') == null && Arr::get($educationalQualificationData, 'is_in_progress'))): ?>    
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
    </div>

    <div class="row mb-3">
        <div class="col-sm-10 offset-sm-2">
          
        </div>
    </div>

    <div class="row mb-3" id="MarksScored">
        <label for="Duration" class="col-sm-3 col-form-label col-form-label-sm text-left">Marks Scored</label>
        <div class="col-sm-9 text-left" >
            
            <div class="row" >
                <span class="d-content">Percentage</span>
                <div class="col-sm-3">
                    <input type="text" class="form-control form-control-sm" maxlength="5" id="percentage" name="percentage" value="<?php if(old('percentage')): ?><?php echo e(old('percentage')); ?><?php elseif(empty(old('percentage')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($educationalQualificationData,'percentage')); ?><?php endif; ?>" onkeydown="return isNumberKey(this);">
                    <?php if($errors->has('percentage')): ?>
                        <?php if($errors->first('percentage')!=config('constants.cgpa_percentage_error')): ?>
                            <div class="text-danger"><?php echo e($errors->first('percentage')); ?></div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div> 
                <span style="display:contents;" id="GPAField">
                <span class="d-content">CGPA</span>
                    <div class="col-sm-3" >
                        <input type="text" class="form-control form-control-sm" maxlength="4" id="gpa" name="gpa" value="<?php if(old('gpa')): ?><?php echo e(old('gpa')); ?><?php elseif(empty(old('gpa')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($educationalQualificationData,'gpa')); ?><?php endif; ?>" onkeydown="return isNumberKey(this);">
                        <?php if($errors->has('gpa')): ?>
                            <?php if($errors->first('gpa')!=config('constants.cgpa_percentage_error')): ?>
                                <div class="text-danger"><?php echo e($errors->first('gpa')); ?></div>
                            <?php endif; ?>
                        <?php endif; ?>    
                    </div>
                </span>
                    <span class="d-content">
                        Grade
                    </span>
                    <div class="col-sm-3" >
                        <select class="form-control form-control-sm" id="grade"  name="grade" rel="<?php echo e(old('grade')); ?>" >
                            <option  value="">Select</option>
                            <?php if(!empty($grades) ): ?>
                                <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(old('grade') == $value): ?>
                                        <option value="<?php echo e(trim($value)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                    <?php elseif(old('_token') == null && Arr::get($educationalQualificationData, 'grade') == $value  ): ?>
                                        <option value="<?php echo e(trim($value)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                    <?php else: ?>
                                        <option  value="<?php echo e(trim($value)); ?>" ><?php echo e(trim($value)); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                        <?php if($errors->has('grade')): ?>
                            <div class="text-danger"><?php echo e($errors->first('grade')); ?></div>
                        <?php endif; ?>
                    </div> 
                
            </div> 

            <?php if($errors->has('percentage') && $errors->has('gpa')): ?>
                <?php if($errors->first('percentage')==config('constants.cgpa_percentage_error') && ($errors->first('gpa')==config('constants.cgpa_percentage_error'))): ?>
                    <div class="text-danger"><?php echo e($errors->first('gpa')); ?></div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>    


    <div class="row mb-3" id="SelectGrades">
        <label for="Duration" class="col-sm-3 col-form-label col-form-label-sm text-left">Select Grades</label>
        <div class="col-sm-9 text-left" >
            
            <div class="row" >
                A
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" id="levelGradeA"  name="level_grade_a" rel="<?php echo e(old('level_grade_a')); ?>" >
                        <?php if(!empty($OALevelGrades) ): ?>
                            <?php $__currentLoopData = $OALevelGrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(old('level_grade_a') == $value): ?>
                                    <option value="<?php echo e(trim($value)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                <?php elseif(old('_token') == null && Arr::get($educationalQualificationData, 'level_grade_a') == $value  ): ?>
                                    <option value="<?php echo e(trim($value)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                <?php else: ?>
                                    <option  value="<?php echo e(trim($value)); ?>" ><?php echo e(trim($value)); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>
                    <?php if($errors->has('level_grade_a')): ?>
                        <div class="text-danger"><?php echo e($errors->first('level_grade_a')); ?></div>
                    <?php endif; ?>
                </div> 
               
                B
                <div class="col-sm-2" >
                    <select class="form-control form-control-sm" id="levelGradeB"  name="level_grade_b" rel="<?php echo e(old('level_grade_b')); ?>" >
                        <?php if(!empty($OALevelGrades) ): ?>
                            <?php $__currentLoopData = $OALevelGrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(old('level_grade_b') == $value): ?>
                                    <option value="<?php echo e(trim($value)); ?>" selected><?php echo e(trim($value)); ?></option>
                                <?php elseif(old('_token') == null && Arr::get($educationalQualificationData, 'level_grade_b') == $value  ): ?>
                                    <option value="<?php echo e(trim($value)); ?>" selected><?php echo e(trim($value)); ?></option> 
                                <?php else: ?>
                                    <option  value="<?php echo e(trim($value)); ?>" ><?php echo e(trim($value)); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    
                    </select>
                    <?php if($errors->has('level_grade_b')): ?>
                        <div class="text-danger"><?php echo e($errors->first('level_grade_b')); ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-sm-2" >
                    <select class="form-control form-control-sm" id="levelGradeC"  name="level_grade_c" rel="<?php echo e(old('level_grade_c')); ?>" >
                            <?php if(!empty($OALevelGrades) ): ?>
                                <?php $__currentLoopData = $OALevelGrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(old('level_grade_c') == $value): ?>
                                        <option value="<?php echo e(trim($value)); ?>" selected><?php echo e(trim($value)); ?></option>
                                    <?php elseif(old('_token') == null && Arr::get($educationalQualificationData, 'level_grade_c') == $value  ): ?>
                                        <option value="<?php echo e(trim($value)); ?>" selected><?php echo e(trim($value)); ?></option>  
                                    <?php else: ?>
                                        <option  value="<?php echo e(trim($value)); ?>" ><?php echo e(trim($value)); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        
                    </select>
                    <?php if($errors->has('level_grade_c')): ?>
                        <div class="text-danger"><?php echo e($errors->first('level_grade_c')); ?></div>
                    <?php endif; ?>
                </div> 
            </div> 
        </div>
    </div>   
    <div class="row mb-3">
        <label for="position" class="col-sm-3 col-form-label col-form-label-sm text-left">Position Achieved</label>
        <div class="col-sm-9 text-left">
            <?php if(!empty($booleanOptions)): ?>
                <?php $__currentLoopData = $booleanOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input class="form-check-input" type="radio" name="position" id="position-<?php echo e($key); ?>" value="<?php echo e($key); ?>" 
                            
                    <?php if((old('_token') && old('position') == $key)): ?> 
                        <?php echo e('checked'); ?>

                    <?php elseif(old('_token') == null && array_key_exists(Arr::get($educationalQualificationData, 'position'), config('constants.boolean_options')) ): ?>  
                        <?php echo e(Arr::get($educationalQualificationData, 'position') == $key ? 'checked' : ''); ?> 
                    <?php else: ?> 
                        <?php if(old('_token') == null && $key==0): ?>
                            <?php echo e('checked'); ?>

                        <?php endif; ?>
                    <?php endif; ?>
                    
                    >
                    <label class="form-check-label" for="position-<?php echo e($key); ?>"><?php echo e($value); ?></label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
        <?php if($errors->has('position')): ?>
            <div class="text-danger"><?php echo e($errors->first('position')); ?></div>
        <?php endif; ?>
    </div>

    <div class="row mb-3">
        <label for="scholarships" class="col-sm-3 col-form-label col-form-label-sm text-left">Scholarships Received</label>
        <div class="col-sm-9 text-left">
            <?php if(!empty($booleanOptions)): ?>
                <?php $__currentLoopData = $booleanOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input class="form-check-input" type="radio" name="scholarships" id="scholarships-<?php echo e($key); ?>" value="<?php echo e($key); ?>" 
                            
                    <?php if((old('_token') && old('scholarships') == $key)): ?> 
                        <?php echo e('checked'); ?>

                    <?php elseif(old('_token') == null && array_key_exists(Arr::get($educationalQualificationData, 'scholarships'), config('constants.boolean_options')) ): ?>  
                        <?php echo e(Arr::get($educationalQualificationData, 'scholarships') == $key ? 'checked' : ''); ?> 
                    <?php else: ?> 
                        <?php if(old('_token') == null && $key==0): ?>
                            <?php echo e('checked'); ?>

                        <?php endif; ?>
                    <?php endif; ?>
                    
                    >
                    <label class="form-check-label" for="scholarships-<?php echo e($key); ?>"><?php echo e($value); ?></label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
        <?php if($errors->has('scholarships')): ?>
            <div class="text-danger"><?php echo e($errors->first('scholarships')); ?></div>
        <?php endif; ?>
    </div>

    <div class="row mb-3">
        <label for="extraCurricularActivities" class="col-sm-3 col-form-label col-form-label-sm text-left">Extra Curricular Activities</label>
        <div class="col-sm-9 text-left">
        <textarea name="extra_curricular_activities" rows="2" cols="20" id="extraCurricularActivities" class="form-control form-control-sm"><?php if(old('extra_curricular_activities')): ?><?php echo e(old('extra_curricular_activities')); ?> 
 <?php elseif(empty(old('extra_curricular_activities')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($educationalQualificationData, 'extra_curricular_activities')); ?><?php endif; ?></textarea>
        <?php if($errors->has('extra_curricular_activities')): ?>
            <div class="text-danger"><?php echo e($errors->first('extra_curricular_activities')); ?></div>
        <?php endif; ?>    
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
        showAndHideFields();

        enabledAndDisabledDurationTo();

        $(".tokenizationSelect2").select2({
            tags: true,
            //tokenSeparators: ['/',',',';'," "],
            tokenSeparators: [','],
        });
 
 

    });
    
    $('#isInProgress').click(function() {
        enabledAndDisabledDurationTo();
    });
    function enabledAndDisabledDurationTo()
    {
        if($('#isInProgress').is(":checked")){
  

            $("#to_months").prop("disabled", true);
            $("#to_year").prop("disabled", true);
            $("#percentage").prop("disabled", true);
            $("#grade").prop("disabled", true);
            $("#gpa").prop("disabled", true);
  
      

        }else{
       
            $("#to_months").prop("disabled", false);  
            $("#to_year").prop("disabled", false);  
            $("#percentage").prop("disabled", false);  
            $("#grade").prop("disabled", false);  
            $("#gpa").prop("disabled", false);
        }
    }

    //
    function showAndHideFields(){
        
        let levelOfEducation  = $('#levelOfEducation').val();

        if(levelOfEducation){
            if(levelOfEducation==4 || levelOfEducation ==6 )
            { //|| levelOfEducation==''
                $('#GPAField').hide();
                $('#BoardNameDiv').show();
            }else{
                $('#GPAField').show();
            // $('#GPAField').css('display', 'contents');
                $('#BoardNameDiv').hide();
            }
        }else{
            $('#GPAField').hide();
        }
        


        if(levelOfEducation==1 || levelOfEducation ==8){
            $('#MarksScored').hide();
            $('#SelectGrades').show();
        }else{
            $('#MarksScored').show();
            $('#SelectGrades').hide();
        }

    }

</script>
<script src="<?php echo url('assets/js/select2.min.js'); ?>"></script>     

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/candidates/profile/educational-qualification.blade.php ENDPATH**/ ?>