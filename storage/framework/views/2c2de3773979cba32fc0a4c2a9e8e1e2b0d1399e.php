
<?php $__env->startSection('title', 'View Profile'); ?>
<?php $__env->startSection('content'); ?>



<div class="card first-child">
    
    <!--header -->
    <div class="card-header">
        <div class="row mb-3">
            <h4 class="col-sm-12">Profile</h4>
            <div class="col-sm-6 text-center m-auto">
                <small>Progress: <span id="ContentContainer_lblProgressPercentage"><?php echo e($profilePercentage); ?>%</span></small>
                <br/>
                <br/>
                <div class="progress">
                    <span class="progress-bar" role="progressbar" style="width: <?php echo e($profilePercentage); ?>%;" aria-valuenow="<?php echo e($profilePercentage); ?>" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>  
        </div>    
    </div>    
    <!--//header -->
    
    
    <!--body -->
    <div class="card-body">
        
    <!--Two Column-->
    <div class="container">
        <div class="row">
            <!--First column-->
                <div class="col-sm">
                    <!--card 1 --Experience-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            
                            <div class="row">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Experience</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="<?php echo e(route('professional.experience.show')); ?>" >Edit</a>
                                    </label>
                                </div>

                                <?php if(!empty($professionalExperienceAllData)): ?>
                                    <?php $experienceCounter=0;?>
                                    <?php $__currentLoopData = $professionalExperienceAllData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="experience-data mb-1 col-form-label-sm"  <?php if($experienceCounter>=2): ?> style="display:none" <?php endif; ?>>
                                        <div class="card-text"><?php echo e(Arr::get($row, 'company_name')); ?></div>
                                        <div class="card-text"><?php echo e(Arr::get($row, 'job_title')); ?></div>
                                        <div class="card-text">
                                                <?php echo e(date("M Y", strtotime(Arr::get($row, 'from')))); ?>

                                                -
                                                <?php if(Arr::get($row, 'is_present')): ?>
                                                <?php echo e('Present'); ?>

                                                <?php else: ?>
                                                <?php echo e(date("M Y", strtotime(Arr::get($row, 'to')))); ?>

                                                <?php endif; ?>
                                        </div>
                                       
                                    </div>
                                    <?php $experienceCounter++; ?>
                                   
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                   
                                    <?php if(count($professionalExperienceAllData) >2): ?>
                                        <a id="experience-anchor" style="display:block;" class="" data-original-title="" title=""><img src="<?php echo e(asset('assets/images/icons/buttons/bottom-arrow.png')); ?> " > See complete information</a>
                                    <?php endif; ?>
                                <?php else: ?> 
                                    <p class="col-sm-10 col-form-label col-form-label-sm"> No record Found.</p>
                                <?php endif; ?>
                               
                            </div>
                            
                           
                        </div>
                    </div>
                   
                    <!--//card 1-->


                    <!--card 2 --Education-- -->
                    <div class="card mb-3">
                        <div class="card-body">

                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Education</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="<?php echo e(route('educational.qualification.show')); ?>" >Edit</a>
                                    </label>
                                </div>
                                <?php if(!empty($educationalQualificationAllData)): ?>
                                    <?php $educationCounter=0;?>
                                    <?php $__currentLoopData = $educationalQualificationAllData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="education-data mb-1 col-form-label-sm" <?php if($educationCounter>=2): ?> style="display:none" <?php endif; ?>>
                                        <div class="card-text"><?php echo e(Arr::get($row, 'institute_name')); ?></div>
                                        <div class="card-text"><?php echo e(Arr::get($row, 'field_of_study')); ?></div>
                                        <div class="card-text">
                                                <?php echo e(date("M Y", strtotime(Arr::get($row, 'from')))); ?>

                                                -
                                                <?php if(Arr::get($row, 'is_present')): ?>
                                                <?php echo e('Present'); ?>

                                                <?php else: ?>
                                                <?php echo e(date("M Y", strtotime(Arr::get($row, 'to')))); ?>

                                                <?php endif; ?>
                                        </div>
                                       
                                    </div>
                               
                                    <?php $educationCounter++; ?>
                                   
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <?php if(count($educationalQualificationAllData) >2): ?>
                                        <a id="education-anchor" style="display:block;" class="" data-original-title="" title=""><img src="<?php echo e(asset('assets/images/icons/buttons/bottom-arrow.png')); ?> " > See complete information</a>
                                    <?php endif; ?>
                                <?php else: ?> 
                                    <p class="col-sm-10 col-form-label col-form-label-sm"> No record Found.</p>
                                <?php endif; ?>
                               
                            </div>    
                        
                        
                           
                        </div>
                    </div>
                    
                    <!--//card 2-->


                    <!--card 3 --Diplomas-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Diplomas</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="<?php echo e(route('diploma.show')); ?>" >Edit</a>
                                    </label>
                                </div>
                                <?php if(!empty($diplomaAllData)): ?>
                                    <?php $diplomaCounter=0;?>
                                    <?php $__currentLoopData = $diplomaAllData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="diploma-data mb-1 col-form-label-sm" <?php if($diplomaCounter>=2): ?> style="display:none" <?php endif; ?>>
                                        <div class="card-text"><?php echo e(Arr::get($row, 'institute_name')); ?></div>
                                        <div class="card-text"><?php echo e(Arr::get($row, 'diploma_title')); ?></div>
                                        <div class="card-text">
                                                <?php echo e(date("M Y", strtotime(Arr::get($row, 'from')))); ?>

                                                -
                                                <?php if(Arr::get($row, 'is_present')): ?>
                                                <?php echo e('Present'); ?>

                                                <?php else: ?>
                                                <?php echo e(date("M Y", strtotime(Arr::get($row, 'to')))); ?>

                                                <?php endif; ?>
                                        </div>
                                       
                                    </div>
                               
                                    <?php $diplomaCounter++; ?>
                                   
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                    <?php if(count($diplomaAllData) >2): ?>
                                        <a id="diploma-anchor" style="display:block;" class="" data-original-title="" title=""><img src="<?php echo e(asset('assets/images/icons/buttons/bottom-arrow.png')); ?> " > See complete information</a>
                                    <?php endif; ?>
                                <?php else: ?> 
                                    <p class="col-sm-10 col-form-label col-form-label-sm"> No record Found.</p>
                                <?php endif; ?>
                                
                            </div>    
                        </div>
                    </div>
                    <!--//card 3-->

                     <!--card 4 --Certifications-- --> 
                     <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Certifications</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="<?php echo e(route('certification.show')); ?>" >Edit</a>
                                    </label>
                                </div>
                                <?php if(!empty($certificateAllData)): ?>
                                    <?php $certificateCounter=0;?>
                                    <?php $__currentLoopData = $certificateAllData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="certification-data mb-1 col-form-label-sm" <?php if($certificateCounter>=2): ?> style="display:none" <?php endif; ?>>
                                        <div class="card-text"><?php echo e(Arr::get($row, 'institute_name')); ?></div>
                                        <div class="card-text"><?php echo e(Arr::get($row, 'certification_title')); ?></div>
                                        <div class="card-text">
                                                <?php echo e(date("M Y", strtotime(Arr::get($row, 'from')))); ?>

                                                -
                                                <?php if(Arr::get($row, 'is_present')): ?>
                                                <?php echo e('Present'); ?>

                                                <?php else: ?>
                                                <?php echo e(date("M Y", strtotime(Arr::get($row, 'to')))); ?>

                                                <?php endif; ?>
                                        </div>
                                        
                                    </div>
                               
                                    <?php $certificateCounter++; ?>
                                   
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 
                                    <?php if(count($certificateAllData) >2): ?>
                                        <a id="certification-anchor" style="display:block;" class="" data-original-title="" title=""><img src="<?php echo e(asset('assets/images/icons/buttons/bottom-arrow.png')); ?> " > See complete information</a>
                                    <?php endif; ?>
                                <?php else: ?> 
                                    <p class="col-sm-10 col-form-label col-form-label-sm"> No record Found.</p>
                                <?php endif; ?>
                                
                            </div>        
                        
                        </div>
                    </div>
                    <!--//card 4-->

                    <!--card 5 --Portfolio-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Portfolio</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="<?php echo e(route('portfolio.show')); ?>" >Edit</a>
                                    </label>
                                </div>
                                <?php if(!empty($candidatePortfolioDetail)): ?>
                                    <?php $portfolioDetailCounter=0;?>
                                    <?php $__currentLoopData = $candidatePortfolioDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="portfolio-detail-data" <?php if($portfolioDetailCounter>=2): ?> style="display:none" <?php endif; ?>>
                                        <div class="row mb-1 card-text">
                                            <label class="col-sm-3 col-form-label col-form-label-sm"><?php echo e(Arr::get($row, 'title')); ?></label>
                                            <div class="col-sm-9">
                                            <label class="col-form-label-sm"><?php echo e(Arr::get($row, 'url')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                               
                                    <?php $portfolioDetailCounter++; ?>
                                   
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                   
                                    <?php if(count($candidatePortfolioDetail) >2): ?>
                                        <a id="portfolio-detail-anchor" style="display:block;" class="" data-original-title="" title=""><img src="<?php echo e(asset('assets/images/icons/buttons/bottom-arrow.png')); ?> " > See complete information</a>
                                    <?php endif; ?>
                                <?php else: ?> 
                                    <p class="col-sm-10 col-form-label col-form-label-sm"> No record Found.</p>
                                <?php endif; ?>
                               
                            </div>         
                            
                        </div>
                    </div>
                  
                    <!--//card 5-->


                     <!--card 6 --Skill Set-- -->
                     <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Skill Set</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="<?php echo e(route('skillset.show')); ?>" >Edit</a>
                                    </label>
                                </div>
                                <?php if(!empty($skillSets) ): ?>
                                    <div class="card-text">
                                        <?php $__currentLoopData = $skillSets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <span class="badge bg-light text-dark"><?php echo e(Arr::get($row->skillSet, 'name')); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>    
                                <?php else: ?> 
                                    <p class="col-sm-10 col-form-label col-form-label-sm"> No record Found.</p>
                                <?php endif; ?>   
                               
                            </div>   
                        </div>
                    </div>
                    <!--//card 6-->


                </div>
            <!--//First column-->


            <!--Second column-->
            <div class="col-sm">
                 <!--card 1 --Personal Information-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Personal Information</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="<?php echo e(route('personal.details.show')); ?>" >Edit</a>
                                    </label>
                                </div>
                            </div>   
                            
                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Gender</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm">
                                <?php if(array_key_exists(Arr::get($personalDetailData, 'gender'), config('constants.gender_options'))): ?>   
                                        <?php echo e(config('constants.gender_options')[Arr::get($personalDetailData, 'gender')]); ?>

                                <?php endif; ?>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Birthday</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm"> <?php if(!empty(Arr::get($personalDetailData, 'date_of_birth'))): ?><?php echo e(date("M d, Y", strtotime(Arr::get($personalDetailData, 'date_of_birth')))); ?><?php endif; ?></label>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Marital Status</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm"> <?php if(array_key_exists(Arr::get($personalDetailData, 'marital_status'), config('constants.marital_statuses'))): ?>   
                                        <?php echo e(config('constants.marital_statuses')[Arr::get($personalDetailData, 'marital_status')]); ?>

                                <?php endif; ?></label>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Nationality</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm">
                                <?php if(array_key_exists(Arr::get($personalDetailData, 'nationality'), config('constants.nationality'))): ?>   
                                            <?php echo e(config('constants.nationality')[Arr::get($personalDetailData, 'nationality')]); ?>

                                    <?php endif; ?>
                                </label>
                                </div>
                            </div>
                            <?php if(Arr::get($personalDetailData, 'nationality')==1): ?>
                            <div class="row mb-1">
                                <label for="CNIC" class="col-sm-5 col-form-label col-form-label-sm">CNIC</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm"><?php echo e(Arr::get($personalDetailData, 'cnic')); ?></label>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="row mb-1">
                                <label for="Passport" class="col-sm-5 col-form-label col-form-label-sm">Passport</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm"><?php echo e(Arr::get($personalDetailData, 'passport')); ?></label>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Religion</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm">
                                    <?php if(array_key_exists(Arr::get($personalDetailData, 'religion'), config('constants.religion'))): ?>   
                                            <?php echo e(config('constants.religion')[Arr::get($personalDetailData, 'religion')]); ?>

                                    <?php endif; ?>
                                </label>
                                </div>
                            </div>

                        </div>
                    </div>
                
                    <!--//card 1-->


                    <!--card 2 --Contact Information-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Contact Information</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="<?php echo e(route('personal.details.show')); ?>" >Edit</a>
                                    </label>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Mobile Number</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm"><?php echo e(Arr::get(Auth::guard('candidate')->user(), 'mobile_number')); ?></label>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Landline Number</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm"><?php echo e(Arr::get($personalDetailData, 'landline_number')); ?></label>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Email Address</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm"><?php echo e(Arr::get(Auth::guard('candidate')->user(), 'email')); ?></label>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Address</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm"><?php echo e(Arr::get($personalDetailData, 'house_no')); ?> <?php echo e(Arr::get($personalDetailData, 'area')); ?> <?php echo e(Arr::get($personalDetailData, 'street')); ?> 
                                <?php if(array_key_exists(Arr::get($personalDetailData, 'city'), config('constants.cities'))): ?>   
                                        <?php echo e(config('constants.cities')[Arr::get($personalDetailData, 'city')]); ?>

                                <?php endif; ?>
                                </label>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!--//card 2-->


                    <!--card 3-->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Family Details</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="<?php echo e(route('family.details.show')); ?>" >Edit</a>
                                    </label>
                                </div>
                                <?php if(!empty($familyDetailAllData)): ?>
                                    <?php $familyDetailCounter=0;?>
                                    <?php $__currentLoopData = $familyDetailAllData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="family-detail-data mb-1 col-form-label-sm" <?php if($familyDetailCounter>=2): ?> style="display:none" <?php endif; ?>>
                                      <div class="card-text">
                                            <?php if(!empty(Arr::get($row, 'picture'))): ?>
                                                <img src="<?php echo e(asset(config('constants.files.familydetail'))); ?>/thumbnail/<?php echo e(Arr::get($row, 'picture')); ?>" > 
                                            <?php else: ?>
                                                <img src="<?php echo e(asset('assets/images/default/profile.jpg')); ?>" >
                                            <?php endif; ?>
                                      </div>   
                                    
                                      <div class="card-text">
                                            <?php if(array_key_exists(Arr::get($row, 'relation_id'), config('constants.relation_options'))): ?>   
                                                <?php echo e(config('constants.relation_options')[Arr::get($row, 'relation_id')]); ?>

                                            <?php endif; ?>    
                                       </div>
                                        <div class="card-text"><?php echo e(Arr::get($row, 'name')); ?></div>
                                        <div class="card-text">
                                                <?php echo e(date("M d, Y", strtotime(Arr::get($row, 'date_of_birth')))); ?>

                                        </div>
                                       
                                    </div>
                               
                                    <?php $familyDetailCounter++; ?>
                                   
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                    <?php if(count($familyDetailAllData) >2): ?>
                                        <a id="family-detail-anchor" style="display:block;" class="" data-original-title="" title=""><img src="<?php echo e(asset('assets/images/icons/buttons/bottom-arrow.png')); ?> " > See complete information</a>
                                    <?php endif; ?>
                                <?php else: ?> 
                                    <p class="col-sm-10 col-form-label col-form-label-sm"> No record Found.</p>
                                <?php endif; ?>
                                
                            </div>    
                  
                        </div>
                    </div>
                
                    <!--//card 3-->
            </div>
            <!--//Second column-->


        </div>
    </div>
    <!--//Two Column-->


    </div>
     <!--//body -->

</div>

<script>
   $(document).on('click', '#experience-anchor', function () {
        $('#experience-anchor').hide();
        $('.experience-data').show();

   });


   $(document).on('click', '#education-anchor', function () {
        $('#education-anchor').hide();
        $('.education-data').show();

   });


   $(document).on('click', '#diploma-anchor', function () {
        $('#diploma-anchor').hide();
        $('.diploma-data').show();

   });

   //certification

   $(document).on('click', '#certification-anchor', function () {
        $('#certification-anchor').hide();
        $('.certification-data').show();

   });

   //portfolio-detail
   $(document).on('click', '#portfolio-detail-anchor', function () {
        $('#portfolio-detail-anchor').hide();
        $('.portfolio-detail-data').show();

   });

   //family-detail
   $(document).on('click', '#family-detail-anchor', function () {
        $('#family-detail-anchor').hide();
        $('.family-detail-data').show();

   });
</script>    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/candidates/profile/view.blade.php ENDPATH**/ ?>