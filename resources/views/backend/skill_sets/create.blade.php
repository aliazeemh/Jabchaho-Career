@extends('backend.layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Add Skill Set</h2>
        <div class="lead">
            Add Skill Set
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('skill_sets.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <div class="col-sm-9">  
                        <input value="{{ old('name') }}" 
                            type="text" 
                            class="form-control" 
                            name="name" 
                            placeholder="Name" 
                            maxlength="200"
                            >
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <div class="col-sm-9">  
                        <textarea class="form-control" 
                            id="description"
                            name="description"  >{{ old('description') }}</textarea>
                    </div>    
                </div>

                <div class="mb-3">
                    <label for="Email" class="form-label">View on search</label>
                    <div class="col-sm-9">   
                        @if(!empty($booleanOptions))
                            @foreach($booleanOptions as $key=>$value)
                                <input class="form-check-input" type="radio" name="is_viewable" id="is_viewable-{{$key}}" value="{{$key}}" 
                                        
                                @if((old('_token') && old('is_viewable') == $key)) 
                                    {{'checked'}}
                                @else 
                                    @if(old('_token') == null && $key==0)
                                        {{'checked'}}
                                    @endif
                                @endif
                                
                                >
                                <label class="form-check-label" for="position-{{$key}}">{{$value}}</label>
                            @endforeach
                        @endif
                    </div>     
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('skill_sets.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>

@endsection