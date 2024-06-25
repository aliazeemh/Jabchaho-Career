

<?php $__env->startSection('content'); ?>
    
    <div class="bg-light p-4 rounded">
        <h2>CMS Pages</h2>
        <div class="lead">
            Manage your CMS pages here.
            
            <?php if(Auth::user()->can('cms.create')): ?>
                <a href="<?php echo e(route('cms.create')); ?>" class="btn btn-primary btn-sm float-right">Add CMS Page</a>
            <?php endif; ?>
                
           
            
        </div>
        
        <table class="table table-bordered">
          <tr>
             <th width="1%">No</th>
             <th>Page</th>
             <th>Url</th>
             <th>Title</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
            <?php $__currentLoopData = $cmsPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cmsPage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e(Arr::get($cmsPage, 'id')); ?></td>
                <td><?php echo e(Arr::get($cmsPage, 'page')); ?></td>
                <td><?php echo e(Arr::get($cmsPage, 'url')); ?></td>
                <td><?php echo e(Arr::get($cmsPage, 'title')); ?></td>

                <?php if(Auth::user()->can('cms.show')): ?>
                <td>
                    <a class="btn btn-info btn-sm" href="<?php echo e(route('cms.show', $cmsPage->id)); ?>">Show</a>
                </td>
                <?php endif; ?>
                <?php if(Auth::user()->can('cms.edit')): ?>
                <td>
                    <a class="btn btn-primary btn-sm" href="<?php echo e(route('cms.edit', $cmsPage->id)); ?>">Edit</a>
                </td>
                <?php endif; ?>
                <?php if(Auth::user()->can('cms.destroy')): ?>
                <td>
                    <?php echo Form::open(['method' => 'DELETE','route' => ['cms.destroy', $cmsPage->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']); ?>

                    <?php echo Form::submit('Delete', ['class' => 'btn btn-danger btn-sm',]); ?>

                    <?php echo Form::close(); ?>

                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>

        <div class="d-flex">
            <?php echo $cmsPages->links(); ?>

        </div>

    </div>

    <script type="text/javascript">
        function ConfirmDelete(){
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

<?php echo $__env->make('backend.layouts.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/backend/cms/index.blade.php ENDPATH**/ ?>