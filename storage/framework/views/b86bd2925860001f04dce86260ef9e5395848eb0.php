

<?php $__env->startSection('content'); ?>
    <div class="bg-light p-4 rounded">
        <h2>Update CMS Page</h2>
        <div class="lead">
            Edit CMS Page.
        </div>

        <div class="container mt-4">

            <form method="POST" action="<?php echo e(route('cms.update', $cmsPage->id)); ?>">
                <?php echo method_field('patch'); ?>
                <?php echo csrf_field(); ?>
         
                
                <div class="mb-3">
                    <label for="page" class="form-label">Page</label>
                    <input value="<?php if(old('page')): ?><?php echo e(old('page')); ?><?php elseif(empty(old('page')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($cmsPage,'page')); ?><?php endif; ?>" 
                        type="text" 
                        class="form-control" 
                        name="page" 
                        maxlength="100"
                        placeholder="Page">
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input value="<?php if(old('title')): ?><?php echo e(old('title')); ?><?php elseif(empty(old('title')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($cmsPage,'title')); ?><?php endif; ?>" 
                        type="text" 
                        class="form-control" 
                        name="title" 
                        maxlength="200"
                        placeholder="Title">
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label">Content</label>
                    <textarea class="form-control content" 
                        id="content"
                        name="content" 
                        placeholder="Content" ><?php if(old('content')): ?><?php echo e(old('content')); ?><?php elseif(empty(old('content')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($cmsPage,'content')); ?><?php endif; ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="meta_keywords" class="form-label">Meta keywords</label>
                    <textarea class="form-control" 
                        id="meta_keywords"
                        name="meta_keywords"  ><?php if(old('meta_keywords')): ?><?php echo e(old('meta_keywords')); ?><?php elseif(empty(old('meta_keywords')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($cmsPage,'meta_keywords')); ?><?php endif; ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label">Meta description</label>
                    <textarea class="form-control" 
                        id="meta_description"
                        name="meta_description" ><?php if(old('meta_description')): ?><?php echo e(old('meta_description')); ?><?php elseif(empty(old('meta_description')) && old('_token')): ?> <?php echo e(''); ?><?php else: ?><?php echo e(Arr::get($cmsPage,'meta_description')); ?><?php endif; ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="Email" class="form-label">Enable</label>
                        <?php if(!empty($booleanOptions)): ?>
                            <?php $__currentLoopData = $booleanOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input class="form-check-input" type="radio" name="is_enabled" id="is_enabled-<?php echo e($key); ?>" value="<?php echo e($key); ?>" 
                                        
                                <?php if((old('_token') && old('is_enabled') == $key)): ?> 
                                    <?php echo e('checked'); ?>

                                <?php elseif(old('_token') == null && Arr::get($cmsPage, 'is_enabled')): ?>  
                                    <?php echo e(Arr::get($cmsPage, 'is_enabled') == $key ? 'checked' : ''); ?>     
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
 
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?php echo e(route('cms.index')); ?>" class="btn btn-default">Back</a>
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
<?php echo $__env->make('backend.layouts.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/backend/cms/edit.blade.php ENDPATH**/ ?>