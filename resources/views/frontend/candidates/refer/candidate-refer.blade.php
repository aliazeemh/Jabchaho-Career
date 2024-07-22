@extends('frontend.layouts.auth-master')
@section('title', 'Refer a Candidate')
@section('content')

<div class="container-auth">
    <div class="container signin signup">
        <h2 class="header">Refer a Candidate</h2>
        
        @include('frontend.includes.partials.messages')

        <form class="form-horizontal" action="{{ route('candidate.perform') }}" method="Post" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" autocomplete="off" class="form-control" id="full-name" placeholder="Candidate Full Name" name="candidate_full_name" maxlength="50" value="{{old('candidate_full_name')}}" onpaste="return false;" onkeydown="return isAlphabatKey(this);">
                    @if($errors->has('candidate_full_name'))
                        <div class="text-danger">{{ $errors->first('candidate_full_name') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <select class="form-control c-select" id="job_type_id"  name="job_type_id" >
                        <option value=''>Select Job Category</option>
                        @if(!empty($jobTypes))
                            @foreach($jobTypes as $jobType)
                                @if (old('job_type_id') ==  Arr::get($jobType, 'id'))
                                    <option value="{{Arr::get($jobType, 'id')}}" selected>{{Arr::get($jobType, 'name')}} </option>   
                                @else
                                    <option  value="{{Arr::get($jobType, 'id')}}" > {{Arr::get($jobType, 'name')}} </option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if($errors->has('job_type_id'))
                        <div class="text-danger">{{ $errors->first('job_type_id') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group d-elem">
                <div class="row">
                    <div class="col-sm-12">          
                    <select class="form-control c-select" id="area_of_interest_option_id"  name="area_of_interest_option_id"  >
                            <option value=''>Select Area Of Interest</option>
                            @if(!empty($areaOfInterests) )
                                
                            @php $groupName = ''; @endphp
                            @foreach($areaOfInterests as $object)
                                    
                                    @if ($groupName != $object['group_name'])
                                            <optgroup label="{{$object['group_name']}}">
                                            @php $groupName = $object['group_name']; @endphp
                                    @endif
                            
                                    @if (old('area_of_interest_option_id') == $object['id'])
                                        <option value="{{ trim($object['id']) }}" selected>{{trim($object['name'])}} </option>   
                                    @else
                                        <option  value="{{ trim($object['id']) }}" > {{trim($object['name'])}} </option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('area_of_interest_option_id'))
                        <div class="text-danger">{{ $errors->first('area_of_interest_option_id') }}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" autocomplete="off" class="form-control" id="mobile" placeholder="Mobile Number" name="mobile" maxlength="12" value="{{old('mobile')}}" onpaste="return false;" onkeydown="return isNumberKey(this);">
                    @if($errors->has('mobile'))
                        <div class="text-danger">{{ $errors->first('mobile') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" autocomplete="off" class="form-control" id="city-region" placeholder="City/Region" name="city_region" maxlength="50" value="{{old('city_region')}}" >
                    @if($errors->has('city_region'))
                        <div class="text-danger">{{ $errors->first('city_region') }}</div>
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <select class="form-control form-control-sm" id="levelOfEducation"  name="level_of_education" >
                    <option  value="">Select Education Level</option>
                        @if(!empty($levelOfEducations) )
                            @foreach($levelOfEducations as $key =>$value)
                                @if(old('level_of_education')==$key)
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                @else
                                    <option  value="{{trim($key)}}" >{{trim($value)}} </option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if($errors->has('level_of_education'))
                        <div class="text-danger">{{ $errors->first('level_of_education') }}</div>
                    @endif
                </div>
            </div>
        
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" autocomplete="off" class="form-control" id="email" placeholder="Candidate Email" name="email" maxlength="50" value="{{old('email')}}">
                    @if($errors->has('email'))
                        <div class="text-danger">{{ $errors->first('email') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <select class="form-control c-select" id="country"  name="country_code" rel="{{old('country_code')}}" >
                        @if(!empty($countries) )
                            @foreach($countries as $key =>$value)
                                @if(old('country_code') == $key)
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                @elseif($value == config('constants.countries.PK') && empty(old('country_code')))
                                <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                @else
                                    <option  value="{{trim($key)}}" > {{trim($value)}} </option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if($errors->has('country_code'))
                        <div class="text-danger">{{ $errors->first('country_code') }}</div>
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <select class="form-control form-control-sm" id="previousExperience"  name="previous_experience" >
                    <option  value="">Select Previous Experience</option>
                        @if(!empty($previousExperience) )
                            @foreach($previousExperience as $key =>$value)
                                @if(old('previous_experience')==$key)
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                @else
                                    <option  value="{{trim($key)}}" >{{trim($value)}} </option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if($errors->has('previous_experience'))
                        <div class="text-danger">{{ $errors->first('previous_experience') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" autocomplete="off" class="form-control" id="AX-Code" placeholder="AX Code" name="ax_code" maxlength="50" value="{{old('ax_code')}}" >
                    @if($errors->has('ax_code'))
                        <div class="text-danger">{{ $errors->first('ax_code') }}</div>
                    @endif
                </div>
            </div>
            <div class="col-sm-12">
                <div class="col-form-label  t-a-center" >
                    In case, if you are a Jab Chaho employee and wish to refer someone
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <span class="recaptcha-wrapper">{!! app('captcha')->display() !!}</span>
                    <!-- <button type="button" class="btn btn-success refresh-cpatcha"><i class="fa fa-refresh"></i></button> -->
                    @if($errors->has('g-recaptcha-response'))
                    <div class="text-danger">{{ $errors->first('g-recaptcha-response') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">        
                <div class="col-sm-12 t-a-center" style="margin-bottom: 5px;">
                    <input  type="submit" class="btn btn-primary" value="Submit" name="submit" />
                </div>
            </div>

        </form>
    </div>

</div>

@endsection