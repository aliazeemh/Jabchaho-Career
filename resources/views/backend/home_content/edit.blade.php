@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Update Home Content</h2>
        <div class="lead">
            Edit Home Content.
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('home_content.update', $homeContent->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Status</label>
                    <select name="candidate_status_id" class="form-control"  >
                        <option value=''>-Select-</option>
                        @if(!empty($candidateStatuses))
                            @foreach($candidateStatuses as $candidateStatus)
                                    @if(old('candidate_status_id') == Arr::get($candidateStatus, 'id'))
                                        <option value="{{ Arr::get($candidateStatus, 'id') }}" selected>{{Arr::get($candidateStatus, 'name')}}</option> 
                                    @elseif(old('_token') == null && Arr::get($homeContent, 'candidate_status_id')== Arr::get($candidateStatus, 'id')  )
                                        <option value="{{ Arr::get($candidateStatus, 'id') }}" selected>{{Arr::get($candidateStatus, 'name')}}</option> 
                                    @else
                                        <option  value="{{ Arr::get($candidateStatus, 'id') }}" >{{Arr::get($candidateStatus, 'name')}}</option>
                                    @endif
                            @endforeach
                        @endif
                    </select>
                </div>    
                
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input value="@if(old('title')){{old('title')}}@elseif(empty(old('title')) && old('_token')) {{''}}@else{{Arr::get($homeContent,'title')}}@endif" 
                        type="text" 
                        class="form-control" 
                        name="title" 
                        maxlength="200"
                        placeholder="Title">
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label">Content</label>
                    <textarea class="form-control content" 
                        id="content"
                        name="content" 
                        placeholder="Content" >@if(old('content')){{old('content')}}@elseif(empty(old('content')) && old('_token')) {{''}}@else{{Arr::get($homeContent,'content')}}@endif</textarea>
                </div>
 
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('home_content.index') }}" class="btn btn-default">Back</a>
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