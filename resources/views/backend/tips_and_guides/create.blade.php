@extends('backend.layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Add Tips & Guides</h2>
        <div class="lead">
            Add Tips & Guides
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('tips_and_guides.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input value="{{ old('title') }}" 
                        type="text" 
                        class="form-control" 
                        name="title" 
                        maxlength="200"
                        placeholder="Title" >

                </div>

                <div class="mb-3">
                    <label for="summary" class="form-label">Summary</label>
                
                    <textarea class="form-control content" 
                        id="summary"
                        name="summary" 
                        placeholder="Summary" >{{ old('summary') }}</textarea>

              
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label">Content</label>
                    <textarea class="form-control content" 
                        id="content"
                        name="content" 
                        placeholder="Content" >{{ old('content') }}</textarea>

             
                </div>

                <div class="mb-3">
                    <label for="Publish" class="form-label">Publish</label>
                    <input class="form-check-input" type="checkbox" id="publish" name="publish" value="1" 
                    @if((old('_token') && old('publish') != null))    
                        {{'checked'}}
                    @else
                        {{''}}
                    @endif  
                    >

                
                </div>
                

                <button type="submit" class="btn btn-primary">Save</button>
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