

<?php $__env->startSection('content'); ?>
    
    <div class="bg-light p-4 rounded">
        <h2>Shifts</h2>
        <div class="lead">
            Manage your Shifts here.
            
            <?php if(Auth::user()->can('shifts.create')): ?>
            <a href="<?php echo e(route('shifts.create')); ?>" class="btn btn-primary btn-sm float-right">Add Shifts</a>
            <?php endif; ?>
                
           
            
        </div>
        
        <table class="table table-bordered">
          <tr>
             <th>Name</th>
             <th>From</th>
             <th>To</th>
             <th>Enabled</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
          <?php if(!empty($shifts)): ?>  
            <?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($shift->name); ?></td>
                    <td><?php echo e(date('g:i A',strtotime(Arr::get($shift, 'from')))); ?></td>
                    <td><?php echo e(date('g:i A',strtotime(Arr::get($shift, 'to')))); ?></td>
                    <td><?php echo e(Arr::get($booleanOptions, $shift->is_enabled)); ?></td>
                    <?php if(Auth::user()->can('shifts.show')): ?>
                    <td>
                        <a class="btn btn-info btn-sm" href="<?php echo e(route('shifts.show', $shift->id)); ?>">Show</a>
                    </td>
                    <?php endif; ?>
                    <?php if(Auth::user()->can('shifts.edit')): ?>
                    <td>
                        <a class="btn btn-primary btn-sm" href="<?php echo e(route('shifts.edit', $shift->id)); ?>">Edit</a>
                    </td>
                    <?php endif; ?>
                    <?php if(Auth::user()->can('shifts.destroy')): ?>
                    <td>
                        <?php echo Form::open(['method' => 'DELETE','route' => ['shifts.destroy', $shift->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']); ?>

                        <?php echo Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']); ?>

                        <?php echo Form::close(); ?>

                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>    
        </table>

        <div class="d-flex">
            <?php echo $shifts->links(); ?>

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

<?php echo $__env->make('backend.layouts.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/backend/shifts/index.blade.php ENDPATH**/ ?>