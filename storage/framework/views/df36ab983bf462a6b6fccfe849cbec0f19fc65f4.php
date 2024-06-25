<footer class="p-3 bg-dark text-white ff-gothambook footer">
    <div class="container ">

        <div class="footer-container">
            <div class="footer-col t-a-center">
                <h3 class="tc-green"><img class="logo" src="<?php echo e(asset('assets/images/ideas-logo.png')); ?>" /></h3>
                <div class="social-wrapper">
                    <span><img class="social-icn" src="<?php echo e(asset('assets/images/icons/social/fb_icn.png')); ?>" /></span>
                    <span><img class="social-icn" src="<?php echo e(asset('assets/images/icons/social/insta_icn.png')); ?>" /></span>
                    <span><img class="social-icn" src="<?php echo e(asset('assets/images/icons/social/in_icn.png')); ?>" /></span>
                </div>
            </div>
            <div class="footer-col t-a-center">
                <h3 class="tc-green">CONTACT US</h3>
                <div class="social-wrapper">
                    <div>UAN Number: 021-111-143-327</div>
                </div>
            </div>
            <div class="footer-col t-a-center">
                <h3 class="tc-green">ADDRESS</h3>
                <div class="social-wrapper">
                    Plot # 65, Grand Industry, 1, Sector 30 <br />Korangi Industrial Area <br />Karachi City, Sindh, Pakistan
                </div>
            </div>
        </div>
        <div class="text-muted"><p class="copyright">Copyright © <?php echo e(date('Y')); ?> Ideas Group. All Rights Reserved.</p></div>
        <div class="ff-gothambook t-a-center">
            <?php if(!empty($cmsPages)): ?>
                <?php $counter=1; ?>
                <?php $__currentLoopData = $cmsPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cmsPage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <a class="px-2 text-white" href="<?php echo e(route('cms.pages',Arr::get($cmsPage,'url'))); ?>" target="_blank"/><?php echo e(Arr::get($cmsPage,'page')); ?></a>  

                    <?php if(count($cmsPages) != $counter): ?>
                        |
                    <?php endif; ?>
                    <?php $counter++; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</footer>
<?php /**PATH C:\wamp\www\career\resources\views/frontend/layouts/footer.blade.php ENDPATH**/ ?>