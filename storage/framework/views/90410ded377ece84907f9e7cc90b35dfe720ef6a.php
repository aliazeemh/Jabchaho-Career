
<?php $__env->startSection('title', 'Upload Documents'); ?>
<?php $__env->startSection('content'); ?>

<div class="card-title"><img src="<?php echo e(asset('assets/images/banners/uploaddoc.jpg')); ?>" ></div>

<h4 class="col-form-label-sm strong">Please provide documents of your work and credentials</h4>
<div class="col-form-label-sm">(Supported file formats are: jpeg, jpg, png, gif, bmp, psd, doc, docx, xls, xlsx, ppt, pptx, pdf, zip, rar, mp3)</div>

<form id="uploadDocumentForm" enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo e(route('upload.documents.perform')); ?>" autocomplete="off">
<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
<input type="hidden" id="selected" name="selected" value="" />
<h4><hr class="bg-danger border-2 border-top border-danger">Resume</h4>


<div class="row mb-3 text-left">
    <label for="Resume" class="col-sm-5 col-form-label col-form-label-sm"> <img src=" <?php if(!empty(Arr::get($defaultDocumentArray,'resume'))): ?><?php echo e(asset('assets/images/icons/buttons/d1.png')); ?> <?php else: ?> <?php echo e(asset('assets/images/icons/buttons/U1.png')); ?>  <?php endif; ?>" id="img_upload_resume" > Resume</label>
        
    <div class="col-sm-7" id="div_resume">
        <?php if(!empty(Arr::get($defaultDocumentArray,'resume'))): ?>
            <?php if(Helper::isFileExtensionForIcon(Arr::get($defaultDocumentArray['resume'],'file'))): ?>
                <img class="center" src="<?php echo e(asset(config('constants.files.filetypes'))); ?>/<?php echo e(Helper::isFileExtensionForIcon(Arr::get($defaultDocumentArray['resume'],'file'))); ?>" >
            <?php else: ?>
                <img class="center" src="<?php echo e(asset(config('constants.files.douments'))); ?>/thumbnail/<?php echo e(Arr::get($defaultDocumentArray['resume'],'file')); ?>" >
            <?php endif; ?>
                <a class="" onclick="return confirm('Do you wish to remove?')" href="<?php echo e(route('document.delete',Arr::get($defaultDocumentArray['resume'], 'id'))); ?>"><span class="fa fa-remove"></span></a>
                <a class="downloadFile" data-filepath="<?php echo e(asset(config('constants.files.douments'))); ?>/<?php echo e(Arr::get($defaultDocumentArray['resume'],'file')); ?>">Download</a>
        <?php else: ?>
            <input type="file" name="resume" id="resume"  class="form-control uploadDocument">
        <?php endif; ?>
    </div>
</div>
<div id="resume_error" class="row mb-3 alert alert-danger small"  style="display:none"></div>



<h4><hr class="bg-danger border-2 border-top border-danger">Personal Documents</h4>

<div class="row mb-3 text-left" >
    <label for="Bank Statement" class="col-sm-5 col-form-label col-form-label-sm"> <img src="<?php if(!empty(Arr::get($defaultDocumentArray,'bank_statement'))): ?><?php echo e(asset('assets/images/icons/buttons/d1.png')); ?> <?php else: ?> <?php echo e(asset('assets/images/icons/buttons/U1.png')); ?>  <?php endif; ?>" > Bank Statement</label>
    <div class="col-sm-7" id="div_bank_statement">
        <?php if(!empty(Arr::get($defaultDocumentArray,'bank_statement'))): ?>
            <?php if(Helper::isFileExtensionForIcon(Arr::get($defaultDocumentArray['bank_statement'],'file'))): ?>
                <img class="center" src="<?php echo e(asset(config('constants.files.filetypes'))); ?>/<?php echo e(Helper::isFileExtensionForIcon(Arr::get($defaultDocumentArray['bank_statement'],'file'))); ?>" >
            <?php else: ?>
                <img class="center" src="<?php echo e(asset(config('constants.files.douments'))); ?>/thumbnail/<?php echo e(Arr::get($defaultDocumentArray['bank_statement'],'file')); ?>" >
            <?php endif; ?>
                <a class="" onclick="return confirm('Do you wish to remove?')" href="<?php echo e(route('document.delete',Arr::get($defaultDocumentArray['bank_statement'], 'id'))); ?>"><span class="fa fa-remove"></span></a>
                <a class="downloadFile" data-filepath="<?php echo e(asset(config('constants.files.douments'))); ?>/<?php echo e(Arr::get($defaultDocumentArray['bank_statement'],'file')); ?>">Download</a>
        <?php else: ?>
            <input type="file" name="bank_statement" id="bank_statement"  class="form-control uploadDocument">
        <?php endif; ?>
    </div>
</div>
<div id="bank_statement_error" class="alert alert-danger small"  style="display:none"></div>

<div class="row mb-3 text-left" >
    <label for="NIC" class="col-sm-5 col-form-label col-form-label-sm"> <img src="<?php if(!empty(Arr::get($defaultDocumentArray,'nic'))): ?><?php echo e(asset('assets/images/icons/buttons/d1.png')); ?> <?php else: ?> <?php echo e(asset('assets/images/icons/buttons/U1.png')); ?>  <?php endif; ?>" > NIC</label>
    <div class="col-sm-7" id="div_nic">
        <?php if(!empty(Arr::get($defaultDocumentArray,'nic'))): ?>
            <?php if(Helper::isFileExtensionForIcon(Arr::get($defaultDocumentArray['nic'],'file'))): ?>
                <img class="center" src="<?php echo e(asset(config('constants.files.filetypes'))); ?>/<?php echo e(Helper::isFileExtensionForIcon(Arr::get($defaultDocumentArray['nic'],'file'))); ?>" >
            <?php else: ?>
                <img class="center" src="<?php echo e(asset(config('constants.files.douments'))); ?>/thumbnail/<?php echo e(Arr::get($defaultDocumentArray['nic'],'file')); ?>" >
            <?php endif; ?>
                <a class="" onclick="return confirm('Do you wish to remove?')" href="<?php echo e(route('document.delete',Arr::get($defaultDocumentArray['nic'], 'id'))); ?>"><span class="fa fa-remove"></span></a>
                <a class="downloadFile" data-filepath="<?php echo e(asset(config('constants.files.douments'))); ?>/<?php echo e(Arr::get($defaultDocumentArray['nic'],'file')); ?>">Download</a>
        <?php else: ?>
        <input type="file" name="nic" id="nic" class="form-control uploadDocument">
        <?php endif; ?>    
    </div>
</div>
<div id="nic_error" class="alert alert-danger small"  style="display:none"></div>


<?php if(!empty($candidateExperienceRequiredDocments)): ?>
    <h4><hr class="bg-danger border-2 border-top border-danger">Experience Documents</h4>
    <?php $__currentLoopData = $candidateExperienceRequiredDocments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="row mb-3 text-left" >
            <?php $candidateExperiences = false;  ?>
            <?php if(!empty(Arr::get($dynamicDocumentsArray,'candidate_experiences'))): ?>
            <?php if(!empty(Arr::get($dynamicDocumentsArray['candidate_experiences'],$key))): ?>
                <?php $candidateExperiences = Arr::get($dynamicDocumentsArray['candidate_experiences'],$key); ?>
                <?php endif; ?>   
            <?php endif; ?> 
    
            <label for="<?php echo e($value); ?>" class="col-sm-5 col-form-label col-form-label-sm"> <img src="<?php if(!empty($candidateExperiences)): ?><?php echo e(asset('assets/images/icons/buttons/d1.png')); ?> <?php else: ?> <?php echo e(asset('assets/images/icons/buttons/U1.png')); ?>  <?php endif; ?>"><?php echo e($value); ?></label>
            <div class="col-sm-7" id="div_<?php echo e($key); ?>">
               

                <?php if(!empty($candidateExperiences)): ?>

					<?php if(Helper::isFileExtensionForIcon(Arr::get($candidateExperiences,'file'))): ?>
                        <img class="center" src="<?php echo e(asset(config('constants.files.filetypes'))); ?>/<?php echo e(Helper::isFileExtensionForIcon(Arr::get($candidateExperiences,'file'))); ?>" >
                    <?php else: ?>
                        <img class="center" src="<?php echo e(asset(config('constants.files.douments'))); ?>/thumbnail/<?php echo e(Arr::get($candidateExperiences,'file')); ?>" >
                    <?php endif; ?>
                        <a class="" onclick="return confirm('Do you wish to remove?')" href="<?php echo e(route('document.delete',Arr::get($candidateExperiences, 'id'))); ?>"><span class="fa fa-remove"></span></a>
                        <a class="downloadFile" data-filepath="<?php echo e(asset(config('constants.files.douments'))); ?>/<?php echo e(Arr::get($candidateExperiences,'file')); ?>">Download</a>
                <?php else: ?>
                    <input type="file" name="<?php echo e($key); ?>" id="<?php echo e($key); ?>" class="form-control uploadDocument" >
                <?php endif; ?>      
            </div>
        </div>
        <div id="<?php echo e($key); ?>_error" class="alert alert-danger small"  style="display:none"></div>    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<?php if(!empty($candidateEducationalQualificationDocments)): ?>
    <h4><hr class="bg-danger border-2 border-top border-danger">Educational Documents</h4>
    <?php $__currentLoopData = $candidateEducationalQualificationDocments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="row mb-3 text-left" >
            <?php $candidateEducations = false;  ?>
            <?php if(!empty(Arr::get($dynamicDocumentsArray,'candidate_educations'))): ?>
            <?php if(!empty(Arr::get($dynamicDocumentsArray['candidate_educations'],$key))): ?>
                <?php $candidateEducations = Arr::get($dynamicDocumentsArray['candidate_educations'],$key); ?>
                <?php endif; ?>   
            <?php endif; ?> 
    
            <label for="<?php echo e($value); ?>" class="col-sm-5 col-form-label col-form-label-sm"> <img src="<?php if(!empty($candidateEducations)): ?><?php echo e(asset('assets/images/icons/buttons/d1.png')); ?> <?php else: ?> <?php echo e(asset('assets/images/icons/buttons/U1.png')); ?>  <?php endif; ?>"><?php echo e($value); ?></label>
            <div class="col-sm-7" id="div_<?php echo e($key); ?>">
               

                <?php if(!empty($candidateEducations)): ?>

					<?php if(Helper::isFileExtensionForIcon(Arr::get($candidateEducations,'file'))): ?>
                        <img class="center" src="<?php echo e(asset(config('constants.files.filetypes'))); ?>/<?php echo e(Helper::isFileExtensionForIcon(Arr::get($candidateEducations,'file'))); ?>" >
                    <?php else: ?>
                        <img class="center" src="<?php echo e(asset(config('constants.files.douments'))); ?>/thumbnail/<?php echo e(Arr::get($candidateEducations,'file')); ?>" >
                    <?php endif; ?>
                        <a class="" onclick="return confirm('Do you wish to remove?')" href="<?php echo e(route('document.delete',Arr::get($candidateEducations, 'id'))); ?>"><span class="fa fa-remove"></span></a>
                        <a class="downloadFile" data-filepath="<?php echo e(asset(config('constants.files.douments'))); ?>/<?php echo e(Arr::get($candidateEducations,'file')); ?>">Download</a>
                <?php else: ?>
                    <input type="file" name="<?php echo e($key); ?>" id="<?php echo e($key); ?>" class="form-control uploadDocument" >
                <?php endif; ?>      
            </div>
        </div>
        <div id="<?php echo e($key); ?>_error" class="alert alert-danger small"  style="display:none"></div>    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>




<hr class="bg-danger border-2 border-top border-danger">
<div class="row mb-3 text-left">
<div class="col-sm-10 offset-sm-2">
        <div class="text-end">
            <button type="submit" class="btn btn-primary" value="Save & Continue">Save & Continue</button>  
        </div>
    </div>
</div>
</form>
<script>

$(document).ready(function() {
    $('#uploadDocumentForm').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(); //this
        var selectedFile = $('#selected').val();
        
        if(selectedFile!='')
        {
            $.each($("#"+selectedFile).prop('files'), function (key, file){
            
                formData.append('attachment', file);
            });  
            
            formData.append('_token', "<?php echo e(csrf_token()); ?>");
            formData.append('selected', selectedFile);
            
            $('#'+selectedFile+'_error').hide();
            $('#'+selectedFile+'_error').html('');
            
            $.ajax({
                type:'POST',
                url: $(this).attr('action'),
                data:formData,
                cache:false,
                    contentType: false,
                processData: false,
                success:function(data){
                    if(data.errors){
                        jQuery.each(data.errors, function(key, value){
                        $('#'+selectedFile+'_error').show();
                        $('#'+selectedFile+'_error').append('<li>'+value+'</li>');
                    
                    });
                    }else{
                        if(data)
                        {
                            $("#div_"+selectedFile).html('<img class="center" src="'+data.diaplay_image_path+'" > <a onclick="return confirm(\'Do you wish to remove?\')" href="'+data.url+'"><span class="fa fa-remove"></span></a>&nbsp;<a class="downloadFile" data-filepath="'+data.file_path+'">Download</a>');
                            $("#img_upload_"+selectedFile).attr('src',"<?php echo e(asset('assets/images/icons/buttons/')); ?>/d1.png")
                        }
                    }
                    
                },
                error: function(data){
                    $('#'+selectedFile+'_error').show();
                    $('#'+selectedFile+'_error').html('Unable to process request. Please refresh the page and try again!!');
                    
                }
            });
        }else
        {
            window.location.href = "<?php echo e(route('upload.documents.mark.saved')); ?>";
        }    

        $('.uploadDocument').val('');
        $('#selected').val('');
        $('#selected_table').val('');     
    }));


    //On change file

    $(".uploadDocument").on("change", function() {
        $('#selected').val(''); 

        var selected        = $(this).attr('name');
    
        $('#selected').val(selected);     
        $("#uploadDocumentForm").submit();
        
    });


    $(document).on('click', '.downloadFile', function (e) {
            e.preventDefault();  //stop the browser from following
    
            var filepath = $(this).attr('data-filepath');
            window.open(filepath , '_blank');
        });


});



</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/candidates/profile/upload-document.blade.php ENDPATH**/ ?>