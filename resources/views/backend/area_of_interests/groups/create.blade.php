@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Add new Area of Intrest Group</h2>
        <div class="lead">
            Add new Group.
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('area_of_interest_groups.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ old('name') }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="Name">
                </div>

                <div class="mb-3">
                    <label for="Email" class="form-label">Enable</label>
                    <div class="col-sm-9">   
                        @if(!empty($booleanOptions))
                            @foreach($booleanOptions as $key=>$value)
                                <input class="form-check-input" type="radio" name="is_enabled" id="is_enabled-{{$key}}" value="{{$key}}" 
                                        
                                @if((old('_token') && old('is_enabled') == $key)) 
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
                <a href="{{ route('area_of_interest_groups.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection