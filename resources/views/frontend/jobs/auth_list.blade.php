@extends('frontend.layouts.app-master')
@section('title', 'Jobs')

@section('content')


<div class="container mb-3 first-child">
    @include('frontend.jobs.partials.list')
</div>

@endsection