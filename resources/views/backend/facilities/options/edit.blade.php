@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Update Facility Option</h2>
        <div class="lead">
            Edit Group.
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('facility_options.update', $facilityOption->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Group Name</label>
                    <select name="facility_group_id" class="form-control"  >
                    <option value=''>-Select-</option>
                        @if(!empty($facilityGroups))
                            @foreach($facilityGroups as $facilityGroup)
                                    @if(old('facility_group_id') == Arr::get($facilityGroup, 'id'))
                                        <option value="{{ Arr::get($facilityGroup, 'id') }}" selected>{{Arr::get($facilityGroup, 'name')}}</option> 
                                    @elseif(old('_token') == null && Arr::get($facilityOption, 'facility_group_id')== Arr::get($facilityGroup, 'id')  )
                                    <option value="{{ Arr::get($facilityGroup, 'id') }}" selected>{{Arr::get($facilityGroup, 'name')}}</option> 
                                    @else
                                        <option  value="{{ Arr::get($facilityGroup, 'id') }}" >{{Arr::get($facilityGroup, 'name')}}</option>
                                    @endif
                            @endforeach
                        @endif
                    </select>
                </div>    
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="@if(old('name')){{old('name')}}@elseif(empty(old('name')) && old('_token')) {{''}}@else{{Arr::get($facilityOption,'name')}}@endif" 
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
                                @elseif(old('_token') == null && Arr::get($facilityOption, 'is_enabled'))  
                                    {{ Arr::get($facilityOption, 'is_enabled') == $key ? 'checked' : '' }}   
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
                <a href="{{ route('facility_options.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection