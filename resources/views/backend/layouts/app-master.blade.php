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
    <title>Career</title>

       <script src="{!! url('assets/js/jquery.min.js') !!}"></script>
    <!-- Bootstrap core CSS -->
    <link href="{!! url('assets/bootstrap/css/font-awesome.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet" media='all'>
    <link rel="stylesheet" href="{!! url('assets/bootstrap/css/bootstrap-print.min.css') !!}" media="print">
    <link href="{!! url('assets/css/admin-custom.css') !!}?v={{config('constants.css_version')}}" rel="stylesheet">
    
</head>
<body>
    
    @include('backend.layouts.includes.navbar')
    
    <main class="container mt-1">
       <div class="mt-2">
            @include('backend.layouts.partials.messages')
        </div>
        @yield('content')
    </main>

    <script src="{!! url('assets/bootstrap/js/bootstrap.min.js') !!}"></script>
    <script src="{!! url('assets/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>

    
    @section("scripts")

    @show
  </body>
</html>
