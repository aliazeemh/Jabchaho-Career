@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Update Job Type</h2>
        <div class="lead">
            Edit Job Type.
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('job_types.update', $jobType->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <div class="col-sm-9">  
                        <input value="@if(old('name')){{old('name')}}@elseif(empty(old('name')) && old('_token')) {{''}}@else{{Arr::get($jobType,'name')}}@endif" 
                            type="text" 
                            class="form-control" 
                            name="name" 
                            placeholder="Name" 
                            maxlength="100"  onpaste="return false;" onkeydown="return isAlphabatKey(this);"
                            >
                    </div>
                </div>

                <div class="mb-3">
                    <label for="Email" class="form-label">Enable</label>
                    <div class="col-sm-9">   
                        @if(!empty($booleanOptions))
                            @foreach($booleanOptions as $key=>$value)
                                <input class="form-check-input" type="radio" name="is_enabled" id="is_enabled-{{$key}}" value="{{$key}}" 
                                        
                                @if((old('_token') && old('is_enabled') == $key)) 
                                    {{'checked'}}
                                @elseif(old('_token') == null && Arr::get($jobType, 'is_enabled'))  
                                    {{ Arr::get($jobType, 'is_enabled') == $key ? 'checked' : '' }}     
                                @else 
                                    @if(old('_token') == null && $key==0)
                                        {{'checked'}}
                                    @endif
                                @endif
                                
                                >
                                <label class="form-check-label" for="is_enabled-{{$key}}">{{$value}}</label>
                            @endforeach
                        @endif
                    </div>     
                </div>


                <div class="mb-3">
                    <label for="Email" class="form-label">Default Checked</label>
                    <div class="col-sm-9">   
                        @if(!empty($booleanOptions))
                            @foreach($booleanOptions as $key=>$value)
                                <input class="form-check-input" type="radio" name="is_checked" id="is_checked-{{$key}}" value="{{$key}}" 
                                        
                                @if((old('_token') && old('is_checked') == $key)) 
                                    {{'checked'}}
                                @elseif(old('_token') == null && Arr::get($jobType, 'is_checked'))  
                                    {{ Arr::get($jobType, 'is_checked') == $key ? 'checked' : '' }}     
                                @else 
                                    @if(old('_token') == null && $key==0)
                                        {{'checked'}}
                                    @endif
                                @endif
                                
                                >
                                <label class="form-check-label" for="is_checked-{{$key}}">{{$value}}</label>
                            @endforeach
                        @endif
                    </div>     
                </div>
                

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('job_types.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection