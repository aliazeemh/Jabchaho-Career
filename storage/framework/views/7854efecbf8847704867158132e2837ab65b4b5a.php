<?php if(Session::get('success', false)): ?>
    <div class="alert alert-success" role="alert">
        <i class="fa fa-check"></i>
        <?php echo e(Session::get('success')); ?>

    </div>
<?php endif; ?>

<?php $__errorArgs = ['error'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="alert alert-danger"><?php echo e($message); ?></div>  
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/includes/partials/messages.blade.php ENDPATH**/ ?>