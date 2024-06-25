<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<meta name="generator" content="">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title><?php echo $__env->yieldContent('title'); ?></title>

<style>

body {
    background: #e9eaee !important;
    font: normal 12px 'LucidaGrande' !important;
}
body header.bg-dark.header-blade{
    position: relative !important;
    width: 100vw !important;
}
#container{
    margin: auto;
    text-align: center;
}

/*
.custom-nav {
    display: flex;
    flex-wrap: wrap;
    padding-left: 340px;
    margin-top: 65px;
    list-style: none;
    display: flex;
    flex-wrap: wrap;
    padding-left: 660px;
    list-style: none;
}*/
.custom-nav {
    margin: 60px 0 0 0;
    display: inline-flex;
    position: relative;
    float: right;
    list-style: none;
}

.dropdownImage{
	margin-left: auto;
    margin-right: auto;
    width: 32px;
	height: 32px;
}  
.sidenav {
  position: absolute;
  left: 300px;
  background: #eee;
  overflow-x: hidden;
  padding: 8px 0;
}

.sidenav li a {
    display: block;
    color: black;
    text-decoration: none;
}

.sidenav ul li.active, .sidenav ul li:hover {
    background-color: #e9ecef;
}


.main {
    font-size: 14px;
    display: inline-flex;
    flex-wrap: wrap;
    justify-content: center;
    margin: auto;
}
.main .sider-bar{
    max-width: 200px;
}
.card.sidenav{
    width: 100%;
    left: 0;
}
@media  screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 14px;}
}

.carousel {
	padding: 0 70px;
}
.carousel .item {
	color: #747d89;
	/* text-align: center; */
	overflow: hidden;
}

.carousel-control-prev, .carousel-control-next {
	height: 44px;
	width: 40px;
	background: #7ac400;
	opacity: 0.8;
}
.carousel-control-prev:hover, .carousel-control-next:hover {
	background: #78bf00;
	opacity: 1;
}
.carousel-control-prev i, .carousel-control-next i {
	position: absolute;
	left: 0;
	right: 0;
	
}

/* delete button  */
.mydivouter{
	position:relative;
    margin: 0 auto;
    margin: 2px;
}
.mydivoverlap{
    position: relative;
    z-index: 1;
}
.mybuttonoverlap{
    float:right;	
}
.mydivouter:hover .mybuttonoverlap{ 
	display:block;
}

.btn-primary, .btn-primary:hover, .btn-primary:active, .btn-primary:visited {
    background-color: #89b61b !important;
}

.form-check-input {
    background-color: #89b61b !important;
}

.fa-remove{
	color: red !important;
}

.item .row {
    --bs-gutter-x: 0rem  !important;
}

.carousel {
    padding: 0px 40px !important;
}    


.mydivouter  .card-text {
  display: block;
  width: 160px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
@media(min-width: 1025px){
    .mybuttonoverlap{
        display: none;	
    }
}
</style>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo url('assets/css/app.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('assets/bootstrap/css/font-awesome.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('assets/css/extended.css'); ?>?v=<?php echo e(config('constants.css_version')); ?>" rel="stylesheet">
    <script src="<?php echo url('assets/js/jquery.min.js'); ?>"></script>
</head>
<body>
<div class="loader"></div>

<div id="container" class="ff-gothambook">

    <?php echo $__env->make('frontend.layouts.top-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.includes.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="main">
        <nav class="navbar navbar-expand-lg navbar-dark bg-light profile-nav">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="side-bar collapse navbar-collapse" id="navbarSupportedContent2">
                <?php echo $__env->make('frontend.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </nav>
        <div class="card" >
             <div class="card-body text-left">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div> 
        
    </div>  
        
    <?php echo $__env->make('frontend.includes.modals.change-password', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

   
</div>
<div class="mt-5 footerDiv" >
    <?php echo $__env->make('frontend.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>  

    <script src="<?php echo url('assets/js/custom.js'); ?>"></script>
    <script src="<?php echo url('assets/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>

</body>
</html> 
<?php /**PATH C:\wamp\www\career\resources\views/frontend/layouts/app-profile.blade.php ENDPATH**/ ?>