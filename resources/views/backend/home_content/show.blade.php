@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Show Home Content</h2>
        <div class="lead">
            
        </div>
        
        <div class="container mt-4">
            <div>
                Status: {{  Arr::get($homeContent->candidateStatus, 'name') }}
            </div>
            <div>
                Title: {{ Arr::get($homeContent, 'title') }}
            </div>
            <div>
                Content: {!! Arr::get($homeContent, 'content') !!}
            </div>
            
        </div>

    </div>
    <div class="mt-4">
        <a href="{{ route('home_content.edit', $homeContent->id) }}" class="btn btn-info">Edit</a>
        <a href="{{ route('home_content.index') }}" class="btn btn-default">Back</a>
    </div>
@endsection
