@extends('backend.layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Add Shifts</h2>
        <div class="lead">
            Add Shifts
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('shifts.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <div class="col-sm-9">  
                        <input value="{{ old('name') }}" 
                            type="text" 
                            class="form-control" 
                            name="name" 
                            placeholder="Name" 
                            maxlength="100"  onpaste="return false;" onkeydown="return isAlphabatKey(this);"
                            >
                    </div>
                </div>

                <div class="mb-3">
                    <label for="Email" class="form-label">From</label>
                    <div class="col-sm-9">   
                    <select class="form-control form-control-sm" id="from"  name="from" >
                            <option value=''>Select</option>
                            @if(!empty($timeSlots) )
                                @foreach($timeSlots as $key =>$value)
                                    @if(old('from') == $key)
                                        <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                                    @else
                                        <option  value="{{trim($key)}}" >{{trim($value)}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>     
                </div>


                <div class="mb-3">
                    <label for="Email" class="form-label">To</label>
                    <div class="col-sm-9">   
                    <select class="form-control form-control-sm" id="to"  name="to" >
                            <option value=''>Select</option>
                            @if(!empty($timeSlots) )
                                @foreach($timeSlots as $key =>$value)
                                    @if(old('to') == $key)
                                        <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                                    @else
                                        <option  value="{{trim($key)}}" >{{trim($value)}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
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
                <a href="{{ route('shifts.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>

@endsection