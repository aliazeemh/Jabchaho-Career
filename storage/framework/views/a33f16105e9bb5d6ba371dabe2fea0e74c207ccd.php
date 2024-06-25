
<?php $__env->startSection('title', 'Skill Set'); ?>
<?php $__env->startSection('content'); ?>

<link href="<?php echo url('assets/css/select2.min.css'); ?>" rel="stylesheet">

<div class="card-title"><img src="<?php echo e(asset('assets/images/banners/skillset.jpg')); ?>" ></div>

<form class="form-horizontal" method="post" action="<?php echo e(route('skillset.perform')); ?>" autocomplete="off">
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />

    <div><hr class="bg-danger border-2 border-top border-danger">Add your Skills or Expertise</div>

    <div class="row mb-3">
        <div class="col-sm-12">
                <select class="form-control form-control tokenizationSelect2" multiple="true" name="name[]">
                <?php if(!empty($skillSets) ): ?>
                        <?php $__currentLoopData = $skillSets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e(Arr::get($row->skillSet, 'name')); ?>" selected="selected"><?php echo e(Arr::get($row->skillSet, 'name')); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>                    
                </select>
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

<script src="<?php echo url('assets/js/select2.min.js'); ?>"></script>
<script>
$(document).ready(function(){
//   $(".tokenizationSelect2").select2({
// 		tags: true,
// 		tokenSeparators: ['/',',',';'," "],
// 	});

$('.tokenizationSelect2').select2({
        //placeholder: 'Select Skill Set',
        tags: true,
 		//tokenSeparators: ['/',',',';'," "],
         tokenSeparators: [','],
         minimumInputLength: 2, // only start searching when the user has input 3 or more characters
         maximumInputLength:200,
        ajax: {
            url: "<?php echo e(route('skillset.search')); ?>",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.name //save name b/c user can also add some tage
                        }
                    })
                };
            },
            cache: true
        }
    });

})
</script>        

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/candidates/profile/skill-set.blade.php ENDPATH**/ ?>