@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Update Tips & Guides</h2>
        <div class="lead">
            Edit Tips & Guides.
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('tips_and_guides.update', $tipAndGuide->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input value="@if(old('title')){{old('title')}}@elseif(empty(old('title')) && old('_token')) {{''}}@else{{Arr::get($tipAndGuide,'title')}}@endif" 
                        type="text" 
                        class="form-control" 
                        name="title"
                        maxlength="200" 
                        placeholder="Title" >

                </div>

                <div class="mb-3">
                    <label for="summary" class="form-label">Summary</label>
                
                    <textarea
                        type="text" 
                        class="form-control content" 
                        name="summary" 
                        placeholder="Summary" >@if(old('summary')){{old('summary')}}@elseif(empty(old('summary')) && old('_token')) {{''}}@else{{Arr::get($tipAndGuide,'summary')}}@endif</textarea>    

                    
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea
                        type="text" 
                        class="form-control content" 
                        name="content" 
                        placeholder="Content" >@if(old('content')){{old('content')}}@elseif(empty(old('content')) && old('_token')) {{''}}@else{{Arr::get($tipAndGuide,'content')}}@endif</textarea>

                    
                </div>

                <div class="mb-3">
                    <label for="Publish" class="form-label">Publish</label>
                    <input class="form-check-input" type="checkbox" id="publish" name="publish" value="1" 
                    @if((old('_token') && old('publish') != null) || (old('_token') == null && $tipAndGuide->publish_date))    
                        {{'checked'}}
                    @else
                        {{''}}
                    @endif  
                    >

                    
                </div>
                

                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('tips_and_guides.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>

<link href="{!! url('assets/bootstrap/css/bootstrap_3.4.1.min.css') !!}" rel="stylesheet">
<link href="{!! url('assets/css/summernote.min.css') !!}" rel="stylesheet">
<script src="{!! url('assets/js/summernote.min.js') !!}"></script>
<script>
$( document ).ready(function() {
    
    $('.content').summernote({

    height:300,

    });

});

</script>   
@endsection