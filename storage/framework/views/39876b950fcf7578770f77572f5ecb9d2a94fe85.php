

<?php $__env->startSection('content'); ?>
    
    <div class="bg-light p-4 rounded">
        <h2>Tips & Guides</h2>
        <div class="lead">
            Manage your Tips & Guides here.
            
            <?php if(Auth::user()->can('tips_and_guides.create')): ?>
            <a href="<?php echo e(route('tips_and_guides.create')); ?>" class="btn btn-primary btn-sm float-right">Add Tips & Guides</a>
            <?php endif; ?>
                
           
            
        </div>
        
        <table class="table table-bordered">
          <tr>
             <th width="1%">No</th>
             <th>Name</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
            <?php $__currentLoopData = $tipsAndGuides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tipAndGuide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($tipAndGuide->id); ?></td>
                <td><?php echo e($tipAndGuide->title); ?></td>
                <?php if(Auth::user()->can('tips_and_guides.show')): ?>
                <td>
                    <a class="btn btn-info btn-sm" href="<?php echo e(route('tips_and_guides.show', $tipAndGuide->id)); ?>">Show</a>
                </td>
                <?php endif; ?>
                <?php if(Auth::user()->can('tips_and_guides.edit')): ?>
                <td>
                    <a class="btn btn-primary btn-sm" href="<?php echo e(route('tips_and_guides.edit', $tipAndGuide->id)); ?>">Edit</a>
                </td>
                <?php endif; ?>
                <?php if(Auth::user()->can('tips_and_guides.destroy')): ?>
                <td>
                    <?php echo Form::open(['method' => 'DELETE','route' => ['tips_and_guides.destroy', $tipAndGuide->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']); ?>

                    <?php echo Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']); ?>

                    <?php echo Form::close(); ?>

                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>

        <div class="d-flex">
            <?php echo $tipsAndGuides->links(); ?>

        </div>

    </div>
<script type="text/javascript">
    function ConfirmDelete()
    {
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            return true;
        }
        else {

            event.preventDefault();
            return false;
        }
    }  
</script>    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/backend/tips_and_guides/index.blade.php ENDPATH**/ ?>