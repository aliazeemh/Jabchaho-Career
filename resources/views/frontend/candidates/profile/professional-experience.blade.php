@extends('frontend.layouts.app-profile')
@section('title', 'Professional Experience')
@section('content')


<div class="card-title"><img src="{{asset('assets/images/banners/professional.png')}}" ></div>


@if(!empty($professionalExperienceAllData))
        <div id="myCarousel" class="carousel slide profile" data-ride="carousel" data-interval="0">
           <!-- Wrapper for carousel items -->
			<div class="carousel-inner">
                <div class="item carousel-item active">
                    <div class="row">
                        @php $counter=0;@endphp
                        @foreach($professionalExperienceAllData as $row)
                       
                            <div class="col-sm mydivouter">
                            <a class="mybuttonoverlap" onclick="return confirm('Do you wish to remove Professional Experience?')" href="{{ route('professional.experience.delete',Arr::get($row, 'id'))}}"><span class="fa fa-remove"></span></a>
                                <a class="myref" href="{{ route('professional.experience.show')}}/{{Arr::get($row, 'id')}}">
                                    <p class="card-text">{{Arr::get($row, 'company_name')}}</p>
                                    <p class="card-text">{{Arr::get($row, 'job_title')}}</p>
                                    <p class="card-text">
                                            {{ date("M Y", strtotime(Arr::get($row, 'from'))) }}
                                            -
                                            @if(Arr::get($row, 'is_present'))
                                            {{'Present'}}
                                            @else
                                            {{ date("M Y", strtotime(Arr::get($row, 'to'))) }}
                                            @endif
                                    </p>
                                   
                                </a>
                                
                            </div>
                            
                            
                            @php $counter++; @endphp
                            @if($counter %3==0)
                                @if($counter != count($professionalExperienceAllData))
                                    </div>
                                    </div>  
                                    <div class="item carousel-item">
                                    <div class="row">
                                @endif
                            @endif
                            
                        @endforeach
                     </div>
                </div>  
             </div>

        @if(count($professionalExperienceAllData)>3)
            <!-- Carousel controls -->
        <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="carousel-control-next" href="#myCarousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>
        @endif
    </div>

@endif   


<form class="form-horizontal" method="POST" action="{{ route('professional.experience.perform') }}" autocomplete="off">
@if(!empty(Arr::get($professionalExperienceData, 'id')))
    @method('put')
@endif

    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="id" value="{{ Arr::get($professionalExperienceData, 'id','') }}" />
    @if($errors->has('id'))
        <div class="text-danger">{{ $errors->first('id') }}</div>
    @endif

    <div @if(!empty($professionalExperienceAllData)) style="display:none"; @endif  >
        <p class="text-start"><small>Please provide us details of your professional experiences</small></p>
        <p class="text-start">
            <small>Do you have professional experience?</small>
            @if(!empty($booleanOptions))
                @foreach($booleanOptions as $key=>$value)
                    <input class="form-check-input experienceRadio" type="radio" name="is_experience_saved" id="experience-{{$key}}" value="{{$key}}" 
                    @if((old('_token') && old('is_experience_saved') == $key)) 
                        {{'checked'}}
                    @elseif(old('_token') == null && Arr::get(Auth::guard('candidate')->user(), 'is_experience_saved'))  
                        {{ Arr::get(Auth::guard('candidate')->user(), 'is_experience_saved') == $key ? 'checked' : '' }} 
                    @else 
                       @if(old('_token') == null && $key==0)
                            {{'checked'}}
                        @endif
                    @endif    
                   
                    >
                    <label class="form-check-label" for="experience-{{$key}}" value="{{$key}}">{{$value}}</label>
                @endforeach
            @endif

            @if($errors->has('is_experience_saved'))
                <div class="text-danger">{{ $errors->first('is_experience_saved') }}</div>
            @endif
              
        </p>
   
    </div>
    <div id="div-experience-form" style="display:block;">
        <h4><hr class="bg-danger border-2 border-top border-danger">Company Details</h4>

       
            <!-- Select2 for companies -->
            {!! Helper::select2Fields($professionalExperienceData,$errors,$companyName) !!}


            <div class="row mb-3">
                <label for="CompanyWebsite" class="col-sm-3 col-form-label col-form-label-sm">Company Website</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" maxlength="100" id="CompanyWebsite" name="company_website" value="@if(old('company_website')){{old('company_website')}}@elseif(empty(old('company_website')) && old('_token')) {{''}}@else{{Arr::get($professionalExperienceData, 'company_website')}}@endif">
                    @if($errors->has('company_website'))
                        <div class="text-danger">{{ $errors->first('company_website') }}</div>
                    @endif
                </div>
            </div>
            <h4><hr class="bg-danger border-2 border-top border-danger">Job Details</h4>
            
            <!-- Select2 for job title -->
            {!! Helper::select2Fields($professionalExperienceData,$errors,$jobTitle) !!}
            

            <!-- Job City Drop Down -->
            <div class="row mb-3">
                <label for="JobCityCountry" class="col-sm-3 col-form-label col-form-label-sm">Job City<span style="color: red"> * </span></label>
                <div class="col-sm-9 col-form-label-sm text-left">
                    <select class="form-control" id="JobCityCountry" name="job_city_country">
                        <option value="">Select City</option>
                        @foreach (config('constants.cities') as $key => $value)
                            @if(old('job_city_country')==$key)
                                <option value="{{ trim($key) }}" selected>{{ trim($value) }}</option>
                            @elseif(!empty($professionalExperienceData->job_city_country) && $professionalExperienceData->job_city_country==$key)
                                <option value="{{ trim($key) }}" selected>{{ trim($value) }}</option>
                            @else
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endif
                        @endforeach
                    </select>
                    @if($errors->has('job_city_country'))
                        <div class="text-danger">{{ $errors->first('job_city_country') }}</div>
                    @endif
                </div>
            </div>
            
            <div class="row mb-3">
                <label for="jobTypeDiv" class="col-sm-3 col-form-label col-form-label-sm">Job Type<span style="color: red"> * </span></label>
                <div class="col-sm-9">
                    <div class="text-end" id="jobTypeDiv">
                        @if(!empty($jobTypes))
                            @foreach($jobTypes as $jobType)
                                <input class="form-check-input" type="radio" name="job_type_id" id="job_type_{{Arr::get($jobType, 'id')}}"  value="{{Arr::get($jobType, 'id')}}"  
                                    @if(!empty(old('job_type_id'))) 
                                        {{ old('job_type_id') == Arr::get($jobType, 'id') ? 'checked' : '' }} 
                                    @elseif(Arr::get($professionalExperienceData, 'job_type_id'))  
                                        {{ Arr::get($professionalExperienceData, 'job_type_id') == Arr::get($jobType, 'id') ? 'checked' : '' }} 
                                    @else 
                                        @if(!empty(Arr::get($jobType, 'is_checked'))) checked 
                                        @endif 
                                    @endif
                                >
                                <label class="form-check-label" for="job_type_{{Arr::get($jobType, 'id')}}">
                                {{Arr::get($jobType, 'name')}}
                                </label>
                            @endforeach
                        @endif
                        @if($errors->has('job_type_id'))
                            <div class="text-danger">{{ $errors->first('job_type_id') }}</div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <label for="Responsibilities" class="col-sm-3 col-form-label col-form-label-sm">Responsibilities</label>
                <div class="col-sm-9">
                <textarea name="responsibilities" rows="2" cols="20" id="Responsibilities" class="form-control form-control-sm">@if(old('responsibilities')){{old('responsibilities')}} 
 @elseif(empty(old('responsibilities')) && old('_token')) {{''}}@else{{Arr::get($professionalExperienceData, 'responsibilities')}}@endif</textarea>
                    @if($errors->has('responsibilities'))
                        <div class="text-danger">{{ $errors->first('responsibilities') }}</div>
                    @endif
                </div>
            </div> 
            <div class="row mb-3">
                <label for="ResonForLeaving" class="col-sm-3 col-form-label col-form-label-sm">Reson For Leaving</label>
                <div class="col-sm-9">
                    <textarea name="reason_for_leaving" rows="2" cols="20" id="ResonForLeaving" class="form-control form-control-sm">@if(old('reason_for_leaving')){{old('reason_for_leaving')}}@elseif(empty(old('reason_for_leaving')) && old('_token')) {{''}}@else{{Arr::get($professionalExperienceData, 'reason_for_leaving')}}@endif</textarea>
                    @if($errors->has('reason_for_leaving'))
                        <div class="text-danger">{{ $errors->first('reason_for_leaving') }}</div>
                    @endif
                </div>
            </div> 

            <div class="row mb-3 duration">
                <label for="Duration" class="col-sm-3 col-form-label col-form-label-sm">Duration<span style="color: red"> * </span></label>
                <div class="col-sm-9 text-left">  
                    <div class="row">               
                        <label> 
                            <span class="w50px">From:</span>   
                            <span id="fromDiv" style="display: contents;">
                                <div class="col-sm-4">
                                
                                    <select class="form-control form-control-sm" id="from_months"  name="from_months" >
                                        <option value=''>Month</option>
                                        @if(!empty($months) )
                                            @foreach($months as $key =>$value)
                                                @if(old('from_months') == $key)
                                                    <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                                                @elseif(old('_token') == null && !empty(Arr::get($professionalExperienceData, 'from')) &&  date("m", strtotime(Arr::get($professionalExperienceData, 'from')))== $key  )
                                                    <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                                                @else
                                                    <option  value="{{trim($key)}}" >{{trim($value)}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->has('from_months'))
                                        <div class="text-danger">{{ $errors->first('from_months') }}</div>
                                    @endif
                                </div>    
                                <div class="col-sm-4">
                                    <select id="from_year" name="from_year" class="form-control form-control-sm">
                                    <option value=''>Year</option>
                                    @php $last= date('Y')-120 @endphp
                                    @php $now = date('Y') @endphp

                                        @for ($i = $now; $i >= $last; $i--)
                                            @if(old('from_year') == $i)

                                                <option value="{{ $i }}" selected>{{ $i }}</option>
                                            @elseif(old('_token') == null && !empty(Arr::get($professionalExperienceData, 'from')) &&  date("Y", strtotime(Arr::get($professionalExperienceData, 'from')))==  $i   )
                                                <option value="{{ $i }}" selected>{{ $i }}</option>
                                            @else
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endif    
                                        @endfor
                                    </select>
                                    @if($errors->has('from_year'))
                                        <div class="text-danger">{{ $errors->first('from_year') }}</div>
                                    @endif
                                </div>    
                            </span>
                        </label>
                        <br/>
                        <label>
                            <span class="w50px">To:</span>
                            <span id="toDiv" style="display: contents;">
                                <div class="col-sm-4">                                
                                    <select class="form-control form-control-sm" id="to_months"  name="to_months" >
                                        <option value=''>Month</option>
                                        @if(!empty($months) )
                                            @foreach($months as $key =>$value)
                                                @if(old('to_months') == $key)
                                                    <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                                                @elseif(old('_token') == null && !empty(Arr::get($professionalExperienceData, 'to')) &&  date("m", strtotime(Arr::get($professionalExperienceData, 'to')))== $key  )
                                                    <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                                                @else
                                                    <option  value="{{trim($key)}}" >{{trim($value)}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->has('to_months'))
                                        <div class="text-danger">{{ $errors->first('to_months') }}</div>
                                    @endif
                                </div>    
                                <div class="col-sm-4">
                                    <select id="to_year" name="to_year" class="form-control form-control-sm">
                                    <option value=''>Year</option>
                                    @php $last= date('Y')-120 @endphp
                                    @php $now = date('Y') @endphp

                                        @for ($i = $now; $i >= $last; $i--)
                                            @if(old('to_year') == $i)
                                                <option value="{{ $i }}" selected>{{ $i }}</option>
                                            @elseif(old('_token') == null && !empty(Arr::get($professionalExperienceData, 'to')) &&  date("Y", strtotime(Arr::get($professionalExperienceData, 'to')))==  $i   )
                                                <option value="{{ $i }}" selected>{{ $i }}</option>
                                            @else
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endif   
                                        @endfor
                                    </select>
                                    @if($errors->has('to_year'))
                                        <div class="text-danger">{{ $errors->first('to_year') }}</div>
                                    @endif
                                </div>   
                            </span> 
                        </label>
                    </div>
                    <span class="col-sm-3" id="presentSpanId" style=" display:none"><small>Present</small></span>
                </div> 

            </div>
            
            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <div class="text-end">
                        <input class="form-check-input"  type="checkbox" id="isPresent" name="is_present" value="1" 
                   
                        @if((old('_token') && old('is_present') != null) || (old('_token') == null && Arr::get($professionalExperienceData, 'is_present')))    
                        {{'checked'}}
                        @else
                            {{''}}
                        @endif   
                        >
                        <label class="form-check-label" for="isPresent">
                        Currently working here
                        </label>
                    </div>
                    @if($errors->has('is_present'))
                        <div class="text-danger">{{ $errors->first('is_present') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="CurrentSalary" class="col-sm-3 col-form-label col-form-label-sm">Current Salary<span style="color: red"> * </span></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" maxlength="7" id="CurrentSalary" name="current_salary" value="@if(old('current_salary')){{old('current_salary')}}@elseif(empty(old('current_salary')) && old('_token')) {{''}}@else{{Arr::get($professionalExperienceData, 'current_salary')}}@endif" onkeydown="return isNumberKey(this);">
                    @if($errors->has('current_salary'))
                        <div class="text-danger">{{ $errors->first('current_salary') }}</div>
                    @endif
                </div>
            </div>
            <div class="row mb-3" >
                <label for="Initial Salary" class="col-sm-3 col-form-label col-form-label-sm">Initial Salary<span style="color: red"> * </span></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" maxlength="7" id="InitialSalary" name="initial_salary" value="@if(old('initial_salary')){{old('initial_salary')}}@elseif(empty(old('initial_salary')) && old('_token')) {{''}}@else{{Arr::get($professionalExperienceData, 'initial_salary')}}@endif" onkeydown="return isNumberKey(this);">
                    @if($errors->has('initial_salary'))
                        <div class="text-danger">{{ $errors->first('initial_salary') }}</div>
                    @endif
                </div>
            </div>

            @if(!empty($facilityGroupWithOptions) )
                @php $groupName = ''; $counter=0;@endphp
                @foreach($facilityGroupWithOptions as $object)
                    
                        
                        @if ($groupName != $object['group_name'])

                        @if ($counter != 0)
                        </div>
                        </div>
                        @endif

                        <div class="row mb-3" >
                        <label for="" class="col-sm-3 col-form-label col-form-label-sm">{{Arr::get($object, 'group_name')}}</label>
                        <div class="col-sm-9 text-left">  
                               
                        @php $groupName = $object['group_name']; @endphp
                        @php $counter++; @endphp
                        @endif
                    
                        
                            <input class="form-check-input" type="checkbox" id="{{Arr::get($object, 'name')}}-{{Arr::get($object, 'id')}}" name="facilityGroup[]" value="{{Arr::get($object, 'id')}}"  
                            @if(is_array(old('facilityGroup')) && !empty(old('facilityGroup')))
                                {{ (is_array(old('facilityGroup')) && in_array(Arr::get($object, 'id'), old('facilityGroup'))) ? ' checked' : '' }} 
                            
                            @elseif(empty(old('facilityGroup')) && old('_token'))
                            {{''}}
                            @else

                                @if(!empty($professionalExperienceData->candidateExperienceFacilities))
                                    @foreach($professionalExperienceData->candidateExperienceFacilities as $candidateExperienceFacility)
                                        @if(Arr::get($candidateExperienceFacility, 'facility_option_id'))  
                                            {{ Arr::get($candidateExperienceFacility, 'facility_option_id') == Arr::get($object, 'id') ? 'checked' : '' }} 
                                        @endif
                                    @endforeach
                                @endif
                            
                            @endif
                            > 
                            <label class="form-check-label" for="{{Arr::get($object, 'name')}}-{{Arr::get($object, 'id')}}">{{Arr::get($object, 'name')}}</label>
                        
                       
                    
                @endforeach

                @if ($counter != 0)
                        </div>
                        </div>
                @endif
            @endif

            @if($errors->has('facilityGroup'))
                <div class="text-danger">{{ $errors->first('facilityGroup') }}</div>
            @endif

            <hr class="bg-danger border-2 border-top border-danger">

            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <div class="text-end">
                        <input type="submit" value="Save & Add more" name="form_submit" />
                    </div>
                </div>
            </div>

       
    </div>

    <hr class="bg-danger border-2 border-top border-danger">
    <div class="row mb-3">
        <div class="col-sm-10 offset-sm-2">
            <div class="text-end">
                <input  type="submit" class="btn btn-primary" value="Save & Continue" name="form_submit" />
            </div>
        </div>
    </div>
    
    
    
</form>

   


    
<script>

    // A $( document ).ready() block.
    $( document ).ready(function() {
        showHideExperienceForm();

        showHideDurationTo();
        
        //Company Search
        select2Fields('company_name', 'Enter Your Company', "{{route('company.search')}}");

        //Job Title Search
        select2Fields('job_title', 'Enter Your Job Title', "{{route('job.search')}}");
    });


    $(".experienceRadio").change(function(){
        showHideExperienceForm();
    });

    function showHideExperienceForm(){
      
     // if there is data mean value = 1 
    let isExperienceSaved = $('input[name="is_experience_saved"]:checked').val();
     
      if(isExperienceSaved==1){
        $('#div-experience-form').show();
      }else{
        $('#div-experience-form').hide();      }
        
    }

    $('#isPresent').click(function() {
            showHideDurationTo();
    });

    function showHideDurationTo(){
        if($('#isPresent').is(":checked")){
                $('#toDiv').hide();
                $('#presentSpanId').show();

            }else{
                $('#toDiv').show();
                $('#presentSpanId').hide();
            }
    }
</script>
    
   


@endsection