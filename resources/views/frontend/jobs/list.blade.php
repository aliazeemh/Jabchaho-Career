@extends('frontend.layouts.auth-master')
@section('title', 'Jobs')

@section('content')


<div class="container mb-3">
        @include('frontend.jobs.partials.list')
</div>


@endsection