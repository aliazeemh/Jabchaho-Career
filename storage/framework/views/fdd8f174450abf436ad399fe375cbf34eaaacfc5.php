
<?php $__env->startSection('title', 'Home'); ?>
<?php $__env->startSection('content'); ?>
<script>
    var positionConf = {};
    var imgConf = {};
    <?php $counter=0;?>
    <?php if(!empty($areaOfInterestGroups)): ?>
        <?php $__currentLoopData = $areaOfInterestGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(!empty($jobsCountViaAreaOfInterestGroups)): ?>               
                positionConf[<?php echo e(Arr::get($row, 'id')); ?>] = <?php echo e(Arr::get($jobsCountViaAreaOfInterestGroups, Arr::get($row, 'id'),0)); ?>;
                imgConf[<?php echo e(Arr::get($row, 'id')); ?>] = "<?php echo e(asset("assets/images/icons/home/0")); ?><?php echo $counter++; ?>.png";
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

</script>
<div class="container">
    
    <!--Search Section-->
    <?php echo $__env->make('frontend.jobs.partials.search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--//Search Section-->




    <!--Categories Section-->
    <?php if(!empty($areaOfInterestGroups)): ?>
        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
            <!-- Wrapper for carousel items -->
                <div class="carousel-inner">
                    
                </div>

            <?php if(count($areaOfInterestGroups)>6): ?>
                <!-- Carousel controls -->
            <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="carousel-control-next" href="#myCarousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
            <?php endif; ?>
        </div>
    <?php endif; ?> 
    <!--//Categories Section-->
    <div class="future-opportunities"><span class="tc-green">FOR FUTURE OPPORTUNITIES </span> <a class="sign-up" href="<?php echo e(route('signup.show')); ?>">SIGN UP</a></div>

</div>
<script type="text/javascript">
    var carouselConf = <?php echo $areaOfInterestGroups; ?>;
    carouselConf = carouselConf.map(conf => {
        conf.position = positionConf[conf.id];
        conf.img = imgConf[conf.id];
        return conf;
    });
    
    var carouselTemp = {
        row: '<div class="item carousel-item {isActive}"> \
                <div class="row"> \
                    {template} \
                </div>\
              </div>',
        item: '<div class="col-sm mydivouter"> \
                    <img class="card-img" src="{img}"/>\
                    <p class="card-text tc-green t-uppercase"><a href="<?php echo e(route("jobs.list")); ?>?title=&city=&category={id}&jobType=" class="tc-green t-uppercase job-link" >{name}</a></p> \
                    <p class="card-text">{position}</p>\
             </div>'
        }
    var renderedTemplate = "";
    var items = "";
    var isFirstCarousel = true;
    for (let index = 1; index <= carouselConf.length; index++) {
        let cConf = carouselConf[index-1];
        if(window.innerWidth>1024)
        {
            items += carouselTemp.item.replace("{img}",cConf.img).replace("{id}",cConf.id).replace("{name}",cConf.name).replace("{position}",cConf.position>1?"( "+cConf.position+" open positions )":"( "+cConf.position+" open position )")
            if((index>1 && index%6==0)||(index==carouselConf.length && index%6!=0))
            {
                renderedTemplate += carouselTemp.row.replace("{template}",items).replace("{isActive}", isFirstCarousel?"active":"");
                items = "";
                isFirstCarousel = false;
                console.log(index);
            }
        }
        else if(window.innerWidth>500)
        {
            items += carouselTemp.item.replace("{img}",cConf.img).replace("{id}",cConf.id).replace("{name}",cConf.name).replace("{position}",cConf.position>1?"( "+cConf.position+" open positions )":"( "+cConf.position+" open position )")
            if((index>1 && index%4==0)||(index==carouselConf.length && index%4!=0))
            {
                renderedTemplate += carouselTemp.row.replace("{template}",items).replace("{isActive}", isFirstCarousel?"active":"");
                items = "";
                isFirstCarousel = false;
            }
        }
        else
        {
            items += carouselTemp.item.replace("{img}",cConf.img).replace("{id}",cConf.id).replace("{name}",cConf.name).replace("{position}",cConf.position>1?"( "+cConf.position+" open positions )":"( "+cConf.position+" open position )")
            if((index>0 && index%2==0)||(index==carouselConf.length && index%2!=0))
            {
                renderedTemplate += carouselTemp.row.replace("{template}",items).replace("{isActive}", isFirstCarousel?"active":"");
                items = "";
                isFirstCarousel = false;
            }
        }
        
    }
    document.querySelector("#myCarousel .carousel-inner").innerHTML = renderedTemplate;
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.auth-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\career\resources\views/frontend/jobs/landing_page.blade.php ENDPATH**/ ?>