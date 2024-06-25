@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Show Tips and Guides</h2>
        <div class="lead">
            
        </div>
        
        <div class="container mt-4">
            <div>
                Title: {{ $tipAndGuide->title }}
            </div>
            <div>
                Summary: {!! $tipAndGuide->summary  !!}
            </div>
            <div>
                Content: {!! $tipAndGuide->content  !!}
            </div>
            <div>
                Published: {{ $tipAndGuide->publish_date }}
            </div>
        </div>

    </div>
    <div class="mt-4">
        @if(Auth::user()->can('tips_and_guides.edit'))
            <a href="{{ route('tips_and_guides.edit', $tipAndGuide->id) }}" class="btn btn-info">Edit</a>
        @endif
        <a href="{{ route('tips_and_guides.index') }}" class="btn btn-default">Back</a>
    </div>
@endsection
