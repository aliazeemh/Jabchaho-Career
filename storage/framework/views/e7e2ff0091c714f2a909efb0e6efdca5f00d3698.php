

<?php $__env->startSection('content'); ?>
    <div class="bg-light p-4 rounded">
        <h2>Update Tips & Guides</h2>
        <div class="lead">
            Edit Tips & Guides.
        </div>

        <div class="container mt-4">

            <form method="POST" action="<?php echo e(route('tips_and_guides.update', $tipAndGuide->id)); ?>">
                <?php echo method_field('patch'); ?>
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input value="<?php echo e($tipAndGuide->title); ?>" 
                        type="text" 
                        class="form-control" 
                        name="title" 
                        placeholder="Title" >

                </div>

                <div class="mb-3">
                    <label for="summary" class="form-label">Summary</label>
                
                    <textarea
                        type="text" 
                        class="form-control content" 
                        name="summary" 
                        placeholder="Summary" ><?php echo e($tipAndGuide->summary); ?></textarea>    

                    
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea
                        type="text" 
                        class="form-control content" 
                        name="content" 
                        placeholder="Content" ><?php echo e($tipAndGuide->content); ?></textarea>

                    
                </div>

                <div class="mb-3">
                    <label for="Publish" class="form-label">Publish</label>
                    <input class="form-check-input" type="checkbox" id="publish" name="publish" value="1" 
                    <?php if((old('_token') && old('publish') != null) || (old('_token') == null && $tipAndGuide->publish_date)): ?>    
                        <?php echo e('checked'); ?>

                    <?php else: ?>
                        <?php echo e(''); ?>

                    <?php endif; ?>  
                    >

                    
                </div>
                

                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="<?php echo e(route('tips_and_guides.index')); ?>" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>

<link href="<?php echo url('assets/bootstrap/css/bootstrap_3.4.1.min.css'); ?>" rel="stylesheet">
<link href="<?php echo url('assets/css/summernote.min.css'); ?>" rel="stylesheet">
<script src="<?php echo url('assets/js/summernote.min.js'); ?>"></script>
<script>
$( document ).ready(function() {
    
    $('.content').summernote({

    height:300,

    });

});

</script>   
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/backend/tips_and_guides/edit.blade.php ENDPATH**/ ?>