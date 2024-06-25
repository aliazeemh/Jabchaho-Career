@extends('frontend.layouts.app-profile')
@section('title', 'Personal Details')
@section('content')

<div class="card-title"><img src="{{asset('assets/images/banners/personaldetails.jpg')}}" ></div>

<h4><hr class="bg-danger border-2 border-top border-danger">Personal Details</h4>
<form class="form-horizontal" method="post" action="{{ route('personal.details.perform') }}" autocomplete="off">
@if(!empty(Arr::get($personalDetailData, 'id')))
    @method('put')
@endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="id" value="{{ Arr::get($personalDetailData, 'id','') }}" />
    @if($errors->has('id'))
        <div class="text-danger">{{ $errors->first('id') }}</div>
    @endif

    <div class="row mb-3">
        <label for="fullName" class="col-sm-3 col-form-label col-form-label-sm">Your Name <span style="color: red"> * </span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm" maxlength="50" id="fullName" name="full_name" value="@if(old('full_name')){{old('full_name')}}@elseif(empty(old('full_name')) && old('_token')) {{''}}@else{{Arr::get(Auth::guard('candidate')->user(), 'full_name')}}@endif">
            @if($errors->has('full_name'))
                <div class="text-danger">{{ $errors->first('full_name') }}</div>
            @endif
        </div>
    </div>

    <div class="row mb-3">
            <label for="" class="col-sm-3 col-form-label col-form-label-sm">Gender <span style="color: red"> * </span></label>
        <div class="col-sm-9 col-form-label-sm text-left" >
            @if(!empty($genderOptions))
                @foreach($genderOptions as $key=>$value)
                    <input class="form-check-input" type="radio" name="gender" id="gender-{{$key}}" value="{{$key}}"
                    @if((old('_token') && old('gender') == $key)) 
                        {{'checked'}}
                    @elseif( old('_token') == null && array_key_exists(Arr::get($personalDetailData, 'gender'), config('constants.gender_options')) )
                        {{ Arr::get($personalDetailData, 'gender') == $key ? 'checked' : '' }} 
                    @else 
                    @if(old('_token') == null && $key==1)
                            {{'checked'}}
                        @endif
                    @endif    
                
                    >
                    <label class="form-check-label" for="gender-{{$key}}">{{$value}}</label>
                @endforeach
            @endif
        </div>
        @if($errors->has('gender'))
            <div class="text-danger">{{ $errors->first('gender') }}</div>
        @endif
    </div>


    <div class="row mb-3">
        <label for="InstituteName" class="col-sm-3 col-form-label">Date of Birth <span style="color: red"> * </span></label>
        <div class="col-sm-9 text-left">
            <div class="row">

                <div class="col-sm-2"> 
                    <select class="form-control form-control-sm" id="month"  name="month" >
                        <option value=''>Month</option>
                        @if(!empty($months) )
                            @foreach($months as $key =>$value)
                                @if(old('month') == $key)
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                                @elseif(old('_token') == null && !empty(Arr::get($personalDetailData, 'date_of_birth')) &&  date("m", strtotime(Arr::get($personalDetailData, 'date_of_birth')))== $key  )
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                                @else
                                    <option  value="{{trim($key)}}" >{{trim($value)}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if($errors->has('month'))
                        <div class="text-danger">{{ $errors->first('month') }}</div>
                    @endif
                </div>

                <div class="col-sm-2"> 
                    <select id="day" name="day" class="form-control form-control-sm">
                        <option value=''>Day</option>
                        @for ($i = 1; $i<=31; $i++)
                            @if(old('day') == $i)

                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @elseif(old('_token') == null && !empty(Arr::get($personalDetailData, 'date_of_birth')) &&  date("d", strtotime(Arr::get($personalDetailData, 'date_of_birth')))==  $i   )
                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif    
                        @endfor
                    </select>
                    @if($errors->has('day'))
                        <div class="text-danger">{{ $errors->first('day') }}</div>
                    @endif
                </div>

                <div class="col-sm-2">  
                    <select id="year" name="year" class="form-control form-control-sm">
                        <option value=''>Year</option>
                        @php $last= date('Y')-120 @endphp
                        @php $now = date('Y')-16 @endphp

                        @for ($i = $now; $i >= $last; $i--)
                            @if(old('year') == $i)

                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @elseif(old('_token') == null && !empty(Arr::get($personalDetailData, 'date_of_birth')) &&  date("Y", strtotime(Arr::get($personalDetailData, 'date_of_birth')))==  $i   )
                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif    
                        @endfor
                    </select>
                    @if($errors->has('year'))
                        <div class="text-danger">{{ $errors->first('year') }}</div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="row mb-3">
            <label for="DiplomaTitle" class="col-sm-3 col-form-label col-form-label-sm">Marital Status<span style="color: red"> * </span></label>
            <div class="col-sm-9 text-left">
                <select class="form-control form-control-sm" id="marital_status"  name="marital_status" >
                    <option value=''>Select Marital Status</option>
                    @if(!empty($maritalStatuses) )
                        @foreach($maritalStatuses as $key =>$value)
                            @if(old('marital_status') == $key)
                                <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                            @elseif(old('_token') == null && !empty(Arr::get($personalDetailData, 'marital_status')) && (Arr::get($personalDetailData, 'marital_status')== $key)  )
                                <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                            @else
                                <option  value="{{trim($key)}}" >{{trim($value)}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
                @if($errors->has('marital_status'))
                    <div class="text-danger">{{ $errors->first('marital_status') }}</div>
                @endif
            </div>
        </div>

        <div class="row mb-3">
            <label for="DiplomaTitle" class="col-sm-3 col-form-label col-form-label-sm">Nationality<span style="color: red"> * </span></label>
            <div class="col-sm-9  text-left">
                @if(!empty($nationality))
                    @foreach($nationality as $key=>$value)
                        <input class="form-check-input nationality" type="radio" name="nationality" id="nationality-{{$key}}" value="{{$key}}"
                        @if((old('_token') && old('nationality') == $key)) 
                            {{'checked'}}
                        @elseif(old('_token') == null)  
                            {{ Arr::get($personalDetailData, 'nationality') == $key ? 'checked' : '' }} 
                        @else 
                        @if(old('_token') == null && $key==1)
                                {{'checked'}}
                            @endif
                        @endif    
                    
                        >
                        <label class="form-check-label" for="nationality-{{$key}}">{{$value}}</label>
                    @endforeach
                @endif
            </div>
            @if($errors->has('nationality'))
                <div class="text-danger">{{ $errors->first('nationality') }}</div>
            @endif
        </div>
        
        <div class="row mb-3" id="cnicDiv">
            <label for="cnic" class="col-sm-3 col-form-label col-form-label-sm">CNIC <small>(Without dashes)<span style="color: red"> * </span></small></label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="13" id="cnic" name="cnic" value="@if(old('cnic')){{old('cnic')}}@elseif(empty(old('cnic')) && old('_token')) {{''}}@else{{Arr::get($personalDetailData,'cnic')}}@endif" onkeydown="return isNumberKey(this);">
                @if($errors->has('cnic'))
                    <div class="text-danger">{{ $errors->first('cnic') }}</div>
                @endif
            </div>
        </div>

        <div class="row mb-3" id="passportDiv" style="display:none">
            <label for="passport" class="col-sm-3 col-form-label col-form-label-sm">Passport<span style="color: red"> * </span></label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="20" id="passport" name="passport" value="@if(old('passport')){{old('passport')}}@elseif(empty(old('passport')) && old('_token')) {{''}}@else{{Arr::get($personalDetailData,'passport')}}@endif">
                @if($errors->has('passport'))
                    <div class="text-danger">{{ $errors->first('passport') }}</div>
                @endif
            </div>
        </div>

        <div class="row mb-3">
            <label for="Religion" class="col-sm-3 col-form-label col-form-label-sm">Religion<span style="color: red"> * </span></label>
            <div class="col-sm-9">
                <select class="form-control form-control-sm" id="religion"  name="religion" >
                    <option value=''>Select Religion</option>
                    @if(!empty($religions) )
                        @foreach($religions as $key =>$value)
                            @if(old('religion') == $key)
                                <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                            @elseif(old('_token') == null && !empty(Arr::get($personalDetailData, 'religion')) &&  (Arr::get($personalDetailData, 'religion')== $key)  )
                                <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                            @else
                                <option  value="{{trim($key)}}" >{{trim($value)}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
                @if($errors->has('religion'))
                    <div class="text-danger">{{ $errors->first('religion') }}</div>
                @endif
            </div>
        </div>
        <div class="row mb-3" id="LinkedinProfileDiv" >
            <label for="linkedin_profile" class="col-sm-3 col-form-label col-form-label-sm">Linkedin Profile<span style="color: red"> * </span> </label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="500" id="linkedin_profile" name="linkedin_profile" value="@if(old('linkedin_profile')){{old('linkedin_profile')}}@elseif(empty(old('linkedin_profile')) && old('_token')) {{''}}@else{{Arr::get($personalDetailData,'linkedin_profile')}}@endif">
                @if($errors->has('linkedin_profile'))
                    <div class="text-danger">{{ $errors->first('linkedin_profile') }}</div>
                @endif
            </div>
        </div>
        <div class="row mb-3">
            <label for="InstituteName" class="col-sm-3 col-form-label col-form-label-sm">Shift Availability<span style="color: red"> * </span></label>
            <div class="col-sm-9 text-left">
                @if(!empty($shifts))
                    
                    @foreach($shifts as $key =>$value)
                        <div>
                            <input class="form-check-input"  type="checkbox" id="shift_id-{{Arr::get($value, 'id')}}" name="shift_id[]" value="{{Arr::get($value, 'id')}}" 
                        
                            @if(is_array(old('shift_id')) && !empty(old('shift_id')))
                                {{ (is_array(old('shift_id')) && in_array(Arr::get($value, 'id'), old('shift_id'))) ? ' checked' : '' }} 
                            @elseif(empty(old('shift_id')) && old('_token'))
                                {{''}}
                            @else
                                    @if(!empty($candidateShifts))
                                        @foreach($candidateShifts as $row)
                                            @if(Arr::get($row, 'shift_id'))  
                                                {{ Arr::get($row, 'shift_id') == Arr::get($value, 'id') ? 'checked' : '' }} 
                                            @endif
                                        @endforeach
                                    @endif  
                            @endif   
                            >
                            
                            <label class="form-check-label col-form-label-sm" for="shift_id-{{Arr::get($value, 'id')}}">
                                {{Arr::get($value, 'name')}} ({{ date('g:i A',strtotime(Arr::get($value, 'from')))}} to {{ date('g:i A',strtotime(Arr::get($value, 'to')))}})
                            </label>
                        </div>
                    @endforeach
                @endif
                @if($errors->has('shift_id'))
                    <div class="text-danger">{{ $errors->first('shift_id') }}</div>
                @endif
            </div>
        </div>
        <div class="row mb-3">
            <label for="Height" class="col-sm-3 col-form-label col-form-label-sm">Height</label>
            <div class="col-sm-9  text-left">
                <div class="row">
                    
                    @php $exploded        = explode('.',Arr::get($personalDetailData,'height'));  @endphp
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" maxlength="2" id="HeightFeet" name="height_feet" value="@if(old('height_feet')){{old('height_feet')}}@elseif(empty(old('height_feet')) && old('_token')) {{''}}@else{{Arr::get($exploded,'0')?Arr::get($exploded,'0'):0}}@endif" onkeydown="return isNumberKey(this);"><label class="col-form-label-sm">feet</label>
                        @if($errors->has('height_feet'))
                            <div class="text-danger">{{ $errors->first('height_feet') }}</div>
                        @endif
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" maxlength="2" id="heightInches" name="height_inches" value="@if(old('height_inches')){{old('height_inches')}}@elseif(empty(old('height_inches')) && old('_token')) {{''}}@else{{Arr::get($exploded,'1')?Arr::get($exploded,'1'):0}}@endif" onkeydown="return isNumberKey(this);"><label class="col-form-label-sm">inches</label>
                        @if($errors->has('height_inches'))
                            <div class="text-danger">{{ $errors->first('height_inches') }}</div>
                        @endif
                    </div>
                    <label class="col-form-label-sm">(e.g. 5 feet 7 inches)</label>
                </div>
            
            </div>
        </div> 

        <div class="row mb-3">
            <label for="Weight" class="col-sm-3 col-form-label col-form-label-sm">Weight</label>
            <div class="col-sm-9  text-left">
                <div class="row">
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" maxlength="3" id="weight" name="weight" value="@if(old('weight')){{old('weight')}}@elseif(empty(old('weight')) && old('_token')) {{''}}@else{{Arr::get($personalDetailData,'weight')?Arr::get($personalDetailData,'weight'):0}}@endif" onkeydown="return isNumberKey(this);">
                        @if($errors->has('weight'))
                            <div class="text-danger">{{ $errors->first('weight') }}</div>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label-sm">kg (e.g. 54 kg)</label>
                    </div>    
                </div>
            </div>    
        </div>

        <div class="row mb-3">
            <label for="ExpectedSalary" class="col-sm-3 col-form-label col-form-label-sm">Total Experience <small>(in years)<span style="color: red"> * </span></small></label>
            <div class="col-sm-9  text-left">
                <div class="row">
                    <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" maxlength="3" id="total_experience" name="total_experience" value="@if(old('total_experience')){{old('total_experience')}}@elseif(empty(old('total_experience')) && old('_token')) {{''}}@else{{Arr::get(Auth::guard('candidate')->user(),'total_experience')}}@endif" onkeydown="return isNumberKey(this);">
                        @if($errors->has('total_experience'))
                            <div class="text-danger">{{ $errors->first('total_experience') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
       
        <div class="row mb-3">
            <label for="ExpectedSalary" class="col-sm-3 col-form-label col-form-label-sm">Expected Salary</label>
            <div class="col-sm-9  text-left">
                <div class="row">
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" maxlength="7" id="ExpectedSalary" name="expected_salary" value="@if(old('expected_salary')){{old('expected_salary')}}@elseif(empty(old('expected_salary')) && old('_token')) {{''}}@else{{Arr::get($personalDetailData,'expected_salary')?Arr::get($personalDetailData,'expected_salary'):0}}@endif" onkeydown="return isNumberKey(this);">
                        @if($errors->has('expected_salary'))
                            <div class="text-danger">{{ $errors->first('expected_salary') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="" class="col-sm-3 col-form-label col-form-label-sm">Own Convenience<span style="color: red"> * </span></label>
            <div class="col-sm-9  text-left" >
              
                @if(!empty($ownConvenience))
                    @foreach($ownConvenience as $key=>$value)
                        <input class="form-check-input" type="checkbox" name="own_convenience[]" id="own_convenience-{{$key}}" value="{{$key}}"
                        @if(is_array(old('own_convenience')) && !empty(old('own_convenience')))
                                {{ (is_array(old('own_convenience')) && in_array($key, old('own_convenience'))) ? ' checked' : '' }} 
                            @elseif(empty(old('own_convenience')) && old('_token'))
                                {{''}}
                            @else
                                    @if(!empty(Arr::get($personalDetailData,'own_convenience')))
                                   
                                     

                                    {{ in_array($key,explode(',', Arr::get($personalDetailData,'own_convenience')) )  ? 'checked' : '' }}  
                                    @endif  
                            @endif   
                            >
                        <label class="form-check-label" for="own_convenience-{{$key}}">{{$value}}</label>
                    @endforeach
                @endif
                @if($errors->has('own_convenience'))
                    <div class="text-danger">{{ $errors->first('own_convenience') }}</div>
                @endif
            </div>
        </div>
        
        <h4><hr class="bg-danger border-2 border-top border-danger">Enter Contact Details</h4>

        <div class="row mb-3">
            <label for="MobileNumber" class="col-sm-3 col-form-label col-form-label-sm">Mobile Number</label>
            <div class="col-sm-9  text-left">
            <label class="col-form-label-sm">{{Arr::get(Auth::guard('candidate')->user(), 'mobile_number')}}</label>
            </div>
        </div>

        <div class="row mb-3">
            <label for="" class="col-sm-3 col-form-label col-form-label-sm"></label>
            <div class="col-sm-9  text-left">
               
                    @if(   !empty(old('mobile_code')) || !empty(old('mobile_number')))

                        @php $counter=1; @endphp
                        @foreach(old('mobile_code') as $outerKey => $outerValue)

                            @if(!empty(old('mobile_code')[$outerKey]) || !empty(old('mobile_number')[$outerKey]))
                                <div class="row multi-field">
                                    <div class="col-sm-5" >
                                        <select class="form-control c-select mobile_code" id="mobileCode"  name="mobile_code[]"  >
                                            @if(!empty($mobileCodes) )
                                                @foreach($mobileCodes as $key =>$value)
                                                    @if ( $outerValue==$value)
                                                        <option value="{{ trim($value) }}" selected>{{trim($value)}}</option>   
                                                    @else
                                                        <option  value="{{trim($value)}}">{{trim($value)}}</option>
                                                    @endif                               
                                                @endforeach
                                            @endif
                                        </select>

                                        @if($errors->has('mobile_code.*'))
                                            <div class="text-danger">{{ $errors->first('mobile_code.*') }}</div>
                                        @endif
                                  
                                    </div>
                                    <div class="col-sm-6" >
                                        <input type="text" autocomplete="off" class="form-control" id="mobile" maxlength="11" placeholder="Enter Mobile" name="mobile_number[]" value="{{old('mobile_number')[$outerKey]}}" onkeydown="return isNumberKey(this);">
                                        @if($errors->has('mobile_number.*'))
                                            <div class="text-danger">{{ $errors->first('mobile_number.*') }}</div>
                                        @endif
                                    </div>    
                                    <div class="col-sm-1 plusDiv" id="plusDiv"  @if($counter == count(old('mobile_code')) &&  count(old('mobile_code'))!=3) style="display:block" @else style="display:none" @endif>
                                        <button class="btn btn-small btn-secondary add-field" type="button"  style="padding: 1px 6px;">
                                            <img src="{{asset('assets/images/icons/buttons/plus.png')}}" >
                                        </button>
                                    </div>
                                    <div class="col-sm-1 minusDiv" @if($counter == count(old('mobile_code'))) style="display:none" @else style="display:block" @endif id="minusDiv">
                                        <button class="btn btn-small btn-secondary remove-field" type="button"  style="padding: 1px 6px;">
                                            <img src="{{asset('assets/images/icons/buttons/minus.jpg')}}" >
                                        </button>
                                    </div>  
                                    
                                </div>
                            @php $counter++; @endphp
                            @endif
                        @endforeach

                   
                
                    @elseif(!empty($candidateMobileNumbers)) 
                        @php $counter=1; @endphp
                        @foreach($candidateMobileNumbers as $row)    
                            <div class="row multi-field">
                                <div class="col-sm-5" >
                                    <select class="form-control c-select mobile_code" id="mobileCode"  name="mobile_code[]"  >
                                        @if(!empty($mobileCodes) )
                                            @foreach($mobileCodes as $key =>$value)
                                                @if ( Arr::get($row,'mobile_code')==$value)
                                                    <option value="{{ trim($value) }}" selected>{{trim($value)}}</option>   
                                                @else
                                                    <option  value="{{trim($value)}}">{{trim($value)}}</option>
                                                @endif                               
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->has('mobile_code.*'))
                                        <div class="text-danger">{{ $errors->first('mobile_code.*') }}</div>
                                    @endif
                                </div>
                                <div class="col-sm-6" >
                                    <input type="text" autocomplete="off" class="form-control" id="mobile" maxlength="11" placeholder="Enter Mobile" name="mobile_number[]" value="{{Arr::get($row,'mobile_number')}}" onkeydown="return isNumberKey(this);">
                                    @if($errors->has('mobile_number.*'))
                                        <div class="text-danger">{{ $errors->first('mobile_number.*') }}</div>
                                    @endif
                                </div>    
                                <div class="col-sm-1 plusDiv" id="plusDiv"  @if($counter == count($candidateMobileNumbers) &&  count($candidateMobileNumbers)!=3) style="display:block" @else style="display:none" @endif>
                                    <button class="btn btn-small btn-secondary add-field" type="button"  style="padding: 1px 6px;">
                                        <img src="{{asset('assets/images/icons/buttons/plus.png')}}" >
                                    </button>
                                </div>
                                <div class="col-sm-1 minusDiv" @if($counter == count($candidateMobileNumbers)) style="display:none" @else style="display:block" @endif id="minusDiv">
                                    <button class="btn btn-small btn-secondary remove-field" type="button"  style="padding: 1px 6px;">
                                        <img src="{{asset('assets/images/icons/buttons/minus.jpg')}}" >
                                    </button>
                                </div>  
                                
                            </div>
                            @php $counter++; @endphp
                        @endforeach
                   @else
                  
                <div class="row multi-field">
                    <div class="col-sm-5" >
                        <select class="form-control c-select mobile_code" id="mobileCode"  name="mobile_code[]"  >
                            @if(!empty($mobileCodes) )
                                @foreach($mobileCodes as $key =>$value)
                                        <option  value="{{trim($value)}}">{{trim($value)}}</option>                                   
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('mobile_code.*'))
                            <div class="text-danger">{{ $errors->first('mobile_code.*') }}</div>
                        @endif
                    </div>
                    <div class="col-sm-6" >
                        <input type="text" autocomplete="off" class="form-control" id="mobile" maxlength="7" placeholder="Enter Mobile" name="mobile_number[]" value="{{old('mobile_number')}}" onkeydown="return isNumberKey(this);">
                        @if($errors->has('mobile_number.*'))
                            <div class="text-danger">{{ $errors->first('mobile_number.*') }}</div>
                        @endif
                    </div>
                    <div class="col-sm-1 plusDiv" id="plusDiv">
                        <button class="btn btn-small btn-secondary add-field" type="button"  style="padding: 1px 6px;">
                            <img src="{{asset('assets/images/icons/buttons/plus.png')}}" >
                        </button>
                    </div>    
                    <div class="col-sm-1 minusDiv" style="display:none" id="minusDiv">
                        <button class="btn btn-small btn-secondary remove-field" type="button"  style="padding: 1px 6px;">
                            <img src="{{asset('assets/images/icons/buttons/minus.jpg')}}" >
                        </button>
                    </div>  
                    
                </div>
                @endif
        </div>
    </div>    

        <div class="row mb-3">
            <label for="LandlineNumber" class="col-sm-3 col-form-label col-form-label-sm">Landline Number</label>
            <div class="col-sm-9  text-left">
                <div class="row">    
                    @php $exploded        = explode('-',Arr::get($personalDetailData,'landline_number'));  @endphp
                    <div class="col-sm-4">
                        <input type="text" placeholder="Area Code" class="form-control" maxlength="5" id="AreaCode" name="area_code" value="@if(old('area_code')){{old('area_code')}}@elseif(empty(old('area_code')) && old('_token')) {{''}}@else{{Arr::get($exploded,'0')}}@endif" onkeydown="return isNumberKey(this);">
                        @if($errors->has('area_code'))
                            <div class="text-danger">{{ $errors->first('area_code') }}</div>
                        @endif
                    </div>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Number" class="form-control" maxlength="11" id="Number" name="landline_number" value="@if(old('landline_number')){{old('landline_number')}}@elseif(empty(old('landline_number')) && old('_token')) {{''}}@else{{Arr::get($exploded,'1')}}@endif" onkeydown="return isNumberKey(this);">
                        @if($errors->has('landline_number'))
                            <div class="text-danger">{{ $errors->first('landline_number') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="EmailAddress" class="col-sm-3 col-form-label col-form-label-sm">Email Address</label>
            <div class="col-sm-9  text-left">
            <label class="col-form-label-sm">{{Arr::get(Auth::guard('candidate')->user(), 'email')}}</label>
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="Address" class="col-sm-3 col-form-label col-form-label-sm">Address<span style="color: red"> * </span></label>
            <div class="col-sm-9  text-left">
                <div class="row">   
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="House No" maxlength="50" id="HouseNo" name="house_no" value="@if(old('house_no')){{old('house_no')}}@elseif(empty(old('house_no')) && old('_token')) {{''}}@else{{Arr::get($personalDetailData,'house_no')}}@endif">
                        @if($errors->has('house_no'))
                            <div class="text-danger">{{ $errors->first('house_no') }}</div>
                        @endif
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" placeholder="Block/Street" maxlength="50" id="street" name="street" value="@if(old('street')){{old('street')}}@elseif(empty(old('street')) && old('_token')) {{''}}@else{{Arr::get($personalDetailData,'street')}}@endif">
                        @if($errors->has('street'))
                            <div class="text-danger">{{ $errors->first('street') }}</div>
                        @endif
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Area" maxlength="200" id="area" name="area" value="@if(old('area')){{old('area')}}@elseif(empty(old('area')) && old('_token')) {{''}}@else{{Arr::get($personalDetailData,'area')}}@endif">
                        @if($errors->has('area'))
                            <div class="text-danger">{{ $errors->first('area') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="row mb-3">
            <label for="" class="col-sm-3 col-form-label col-form-label-sm"></label>
            <div class="col-sm-9 text-left">
                <div class="row">
                    <div class="col-sm-4" id="CityDiv">
                        <input type="text" class="form-control form-control-sm" maxlength="200" placeholder="City" id="city" name="city" value="@if(old('city')){{old('city')}}@elseif(empty(old('city')) && old('_token')) {{''}}@elseif(config('constants.default_country_code')!=Arr::get(Auth::guard('candidate')->user(), 'country_code')) {{Arr::get($personalDetailData,'city')}}@endif">
                        @if($errors->has('city'))
                            <div class="text-danger">{{ $errors->first('city') }}</div>
                        @endif
                    </div>
                    <div class="col-sm-4" id="PakCityDiv">
                        <select class="form-control c-select" id="PakCity"  name="pak_city" rel="{{old('pak_city')}}" >
                        <option value="">Select City</option>
                            @if(!empty($cities) )
                                @foreach($cities as $key =>$value)
                                    @if(old('pak_city') == $key)
                                        <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                    @elseif($key==(Arr::get($personalDetailData,'city')) && empty(old('pak_city')) && config('constants.default_country_code')==Arr::get(Auth::guard('candidate')->user(), 'country_code') )
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                    @else
                                        <option  value="{{trim($key)}}" > {{trim($value)}} </option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('pak_city'))
                            <div class="text-danger">{{ $errors->first('pak_city') }}</div>
                        @endif
                    </div>
                    <div class="col-sm-5">
                    <select class="form-control c-select" id="country"  name="country_code" rel="{{old('country_code')}}"  onchange="ShowHideCityDiv();">
                    <option value="">Select Country</option>
                        @if(!empty($countries) )
                            @foreach($countries as $key =>$value)
                                @if(old('country_code') == $key)
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                @elseif($key==(Arr::get(Auth::guard('candidate')->user(), 'country_code')) && empty(old('country_code')) )
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
            </div>
        </div>
        <hr class="bg-danger border-2 border-top border-danger">
        <div class="row mb-3">
        <div class="col-sm-10 offset-sm-2">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary" value="Save & Continue">Save & Continue</button>  
                </div>
            </div>
        </div>
</form>


<script>

    $( document ).ready(function() {
        showHideNationalityBasedFields();
        ShowHideCityDiv();
        //showHideButtons();

        $(".form-horizontal").submit(function(event) {
            // Prevent the default form submission
            event.preventDefault();
            
            // Disable the submit button
            $(".btn-primary").prop("disabled", true);
            $('.btn-primary').text("Saving.....");
            $(this).off('submit').submit();
            // Optionally, perform other actions here
        });
    });
    
    $(".nationality").change(function(){
        showHideNationalityBasedFields();
    });   
    
    function ShowHideCityDiv(){
      let country = $('#country').val();
      
      if(country == 'PK'){
         $('#CityDiv').hide();
         $('#PakCityDiv').show();
         $('#CityDiv').val('');
      }else{
        $('#PakCityDiv').hide();
        $('#CityDiv').show();
        $('#PakCityDiv').val('');
      }
  }


    function showHideNationalityBasedFields()
    {
        let nationality = $('input[name="nationality"]:checked').val();
      
        if(nationality==1)
        {
            $('#cnicDiv').show();
            $('#passportDiv').hide();  
        }
        else
        {
            $('#passportDiv').show();
            $('#cnicDiv').hide();      
        }
    }    


    $(document).on('click', '.add-field', function () {
        var html = $(".multi-field").first().clone();
        $(html).find('input').val('').focus();
        $(html).find('.mobile_code').val('0300').focus();
        $(html).find(".plusDiv").remove();
        $(html).find(".minusDiv").show();

        $(".multi-field").first().before(html);

       
        showHideButtons();
     
    });


    $(document).on('click', '.remove-field', function () {
            $(this).closest('.multi-field').remove();
            showHideButtons();
    });


    function showHideButtons(){
        var numOfFields = $('.multi-field').length;
        // remove Plus sign after count 3
        if(numOfFields>=3) 
        {
            $('.plusDiv').hide();
        }else{
            var displayBlockedCount = $('.multi-field > .plusDiv').filter(function() {
                return $(this).css('display') === 'block';
            }).length;

            //console.log("count:"+displayBlockedCount)
            
            if(displayBlockedCount ==0)
                $('.multi-field div.plusDiv:last').show();
        }
    }

</script>  

@endsection