<!doctype html>
<html lang="en">
    <head>
    <link type="image/x-icon" href="{{asset('assets/images/job-page-logo.png')}}" rel="icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    

        <script src="{!! url('assets/js/jquery.min.js') !!}"></script>
    <link href="{!! url('assets/css/extended.css') !!}?v={{config('constants.css_version')}}" rel="stylesheet">
        <link href="{!! url('assets/css/timeline.css') !!}" rel="stylesheet">
         <!-- Bootstrap core CSS -->
        <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/bootstrap/css/font-awesome.min.css') !!}" rel="stylesheet">
</head>
<body>
    <div class="loader"></div>

    <div id="container" class="ff-gothambook app-profile">
        @include('frontend.layouts.top-header')
    
       
        @include('frontend.layouts.header')
        
        @include('frontend.includes.partials.messages')
        @yield('content')
        
        @include('frontend.includes.modals.change-password')
        
    <div>
    <div class="mt-5">
    @include('frontend.layouts.footer')
</div> 
     <script src="{!! url('assets/js/custom.js') !!}"></script>
    <script src="{!! url('assets/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
    <script src="{!! url('assets/bootstrap/js/bootstrap.min.js') !!}"></script>
    <script src="{!! url('assets/js/jquery.wallform.js') !!}"></script>
    <script src="{!! url('assets/js/jquery-ui.min.js') !!}"></script>

    

  </body>
</html>
