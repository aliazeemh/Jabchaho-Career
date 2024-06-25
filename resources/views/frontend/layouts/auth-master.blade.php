<!doctype html>
<html lang="en">
    <head>
    <link type="image/x-icon" href="{{asset('assets/images/job-page-logo.png')}}" rel="icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{!! url('assets/css/app.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/bootstrap/css/font-awesome.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/css/extended.css') !!}?v={{config('constants.css_version')}}" rel="stylesheet">
    <script src="{!! url('assets/js/jquery.min.js') !!}"></script>


<style>
html, body {
  margin: 0;
  height: 100%;
  min-height: 100%;
}
body {
    background: #e9eaee;
    font: normal 11px 'LucidaGrande';
}
body {
  display: flex;
  flex-direction: column;
}

header,
footer {
  flex: none;
}

main 
{
  -webkit-overflow-scrolling: touch;
  flex: auto;
}

.btn-primary, .btn-primary:hover, .btn-primary:active, .btn-primary:visited {
    background-color: #89b61b !important;
}

.form-check-input {
    background-color: #89b61b !important;
}

.social-btn .btn i {
    float: left;
    margin: 2px 10px 0 3px;
    min-width: 15px;
}

.social-btn .btn-primary {
    background-color: #3B5998 !important;
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

.carousel {
    padding: 0px 40px !important;
}    

.row{
  --bs-gutter-x: 3.5rem !important;
}

</style>
</head>
<body class="{{Request::segment(1)}}">
<div class="loader"></div>
    
    @include('frontend.layouts.navbar')
    
    <main class="container mt-5">
        @yield('content')
    </main>

    <script src="{!! url('assets/js/custom.js') !!}"></script>
    <script src="{!! url('assets/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
    <script src="{!! url('assets/bootstrap/js/bootstrap.min.js') !!}"></script>
    


    @show
    @include('frontend.layouts.footer')
  </body>
</html>
