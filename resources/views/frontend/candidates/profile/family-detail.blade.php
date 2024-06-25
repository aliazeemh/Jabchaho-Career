@extends('frontend.layouts.app-profile')
@section('title', 'Family Details')
@section('content')

<div class="card-title"><img src="{{asset('assets/images/banners/Family-Banner.jpg')}}" ></div>
@if(!empty($familyDetailAllData))
        <div id="myCarousel" class="carousel slide profile" data-ride="carousel" data-interval="0">
           <!-- Wrapper for carousel items -->
			<div class="carousel-inner">
                <div class="item carousel-item active">
                    <div class="row">
                        @php $counter=0;@endphp
                        @foreach($familyDetailAllData as $row)
                       
                            <div class="col-sm mydivouter">
                            <a class="mybuttonoverlap " onclick="return confirm('Do you wish to remove Family Detail?')" href="{{ route('family.details.delete',Arr::get($row, 'id'))}}"><span class="fa fa-remove"></span></a>
                                <a class="myref" href="{{ route('family.details.show')}}/{{Arr::get($row, 'id')}}">
                                    <p class="card-text">{{config('constants.relation_options')[Arr::get($row, 'relation_id')]}}</p>
                                    <p class="card-text">
                                        @if(!empty(Arr::get($row, 'picture')))
                                            <img src="{{asset(config('constants.files.familydetail'))}}/thumbnail/{{ Arr::get($row, 'picture') }}" > 
                                        @else
                                            <img src="{{asset('assets/images/default/profile.jpg')}}"  class="center" >
                                        @endif
                                        {{Arr::get($row, 'name')}}</p>
                                    <p class="card-text">
                                            {{ date("M d, Y", strtotime(Arr::get($row, 'date_of_birth'))) }}
                                    </p>
                                   
                                </a>
                            </div>
                            
                            
                            @php $counter++; @endphp
                            @if($counter %3==0)
                                @if($counter != count($familyDetailAllData))
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

        @if(count($familyDetailAllData)>3)
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
<h4><hr class="bg-danger border-2 border-top border-danger">Family Details</h4>
<form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('family.details.perform') }}" autocomplete="off">


@if(!empty(Arr::get($familyDetailData, 'id')))
    @method('put')
@endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="id" value="{{ Arr::get($familyDetailData, 'id','') }}" />
    @if($errors->has('id'))
        <div class="text-danger">{{ $errors->first('id') }}</div>
    @endif


    <div class="row mb-3">
        <label for="relationOptions" class="col-sm-3 col-form-label col-form-label-sm">Relation<span style="color: red"> * </span></label>
        <div class="col-sm-9 text-left">
            <select class="form-control form-control-sm" id="relationOptions"  name="relation_id" >
                <option value=''>Select</option>
                @if(!empty($relationOptions) )
                    @foreach($relationOptions as $key =>$value)
                        @if(old('relation_id') == $key)
                            <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                        @elseif(old('_token') == null && !empty(Arr::get($familyDetailData, 'relation_id')) && Arr::get($familyDetailData, 'relation_id')== $key  )
                            <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                        @else
                            <option  value="{{trim($key)}}" >{{trim($value)}}</option>
                        @endif
                    @endforeach
                @endif
            </select>
            @if($errors->has('relation_id'))
                <div class="text-danger">{{ $errors->first('relation_id') }}</div>
            @endif
        </div>
    </div>

    <div class="row mb-3">
        <label for="Name" class="col-sm-3 col-form-label col-form-label-sm">Name<span style="color: red"> * </span></label>
        <div class="col-sm-9 text-left">
            <input type="text" class="form-control form-control-sm" maxlength="100" id="name" name="name" value="@if(old('name')){{old('name')}}@elseif(empty(old('name')) && old('_token')) {{''}}@else{{Arr::get($familyDetailData,'name')}}@endif">
            @if($errors->has('name'))
                <div class="text-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>
    </div>
    
    <div class="row mb-3">
        <label for="EmergencyContact" class="col-sm-3 col-form-label col-form-label-sm">
            Is This Your Emergency Contact<span style="color: red"> * </span>
        </label>
        <div class="col-sm-9 text-left">
            @if(!empty($booleanOptions))
                @foreach($booleanOptions as $key=>$value)
                    <input class="form-check-input EmergencyContact" type="radio" name="emergency_contact" id="emergency_contact-{{$key}}" value="{{$key}}" 
                            
                    @if((old('_token') && old('emergency_contact') == $key)) 
                        {{'checked'}}
                    @elseif(old('_token') == null && array_key_exists(Arr::get($familyDetailData, 'emergency_contact'), config('constants.boolean_options')) )  
                        {{ Arr::get($familyDetailData, 'emergency_contact') == $key ? 'checked' : '' }} 
                    @else 
                        @if(old('_token') == null && $key==0)
                            {{'checked'}}
                        @endif
                    @endif
                    
                    >
                    <label class="form-check-label" for="emergency_contact-{{$key}}">{{$value}}</label>
                @endforeach
            @endif
        </div>
        @if($errors->has('emergency_contact'))
            <div class="text-danger">{{ $errors->first('emergency_contact') }}</div>
        @endif
    </div>

    <div class="row mb-3 EmergencyContactNumber" style="display:none;">
        <label for="ContactNo" class="col-sm-3 col-form-label col-form-label-sm">Contact No<span style="color: red"> * </span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm" maxlength="11" id="ContactNo" name="contact_no" onkeydown="return isNumberKey(this);" value="@if(old('contact_no')){{old('contact_no')}}@elseif(empty(old('contact_no')) && old('_token')) {{''}}@else{{Arr::get($familyDetailData,'contact_no')}}@endif">
            @if($errors->has('contact_no'))
                <div class="text-danger">{{ $errors->first('contact_no') }}</div>
            @endif
        </div>
    </div>
    
    
    <div class="row mb-3">
        <label for="InstituteName" class="col-sm-3 col-form-label col-form-label-sm">Date of Birth<span style="color: red"> * </span></label>
        <div class="col-sm-9 text-left">
            <div class="row">

                <div class="col-sm-4"> 
                    <select class="form-control form-control-sm" id="month"  name="month" >
                        <option value=''>Month</option>
                        @if(!empty($months) )
                            @foreach($months as $key =>$value)
                                @if(old('month') == $key)
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                                @elseif(old('_token') == null && !empty(Arr::get($familyDetailData, 'date_of_birth')) &&  date("m", strtotime(Arr::get($familyDetailData, 'date_of_birth')))== $key  )
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

                <div class="col-sm-4"> 
                    <select id="day" name="day" class="form-control form-control-sm">
                        <option value=''>Day</option>
                        @for ($i = 1; $i<=31; $i++)
                            @if(old('day') == $i)

                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @elseif(old('_token') == null && !empty(Arr::get($familyDetailData, 'date_of_birth')) &&  date("d", strtotime(Arr::get($familyDetailData, 'date_of_birth')))==  $i   )
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

                <div class="col-sm-4">  
                    <select id="year" name="year" class="form-control form-control-sm">
                        <option value=''>Year</option>
                        @php $last= date('Y')-120 @endphp
                        @php $now = date('Y') @endphp

                        @for ($i = $now; $i >= $last; $i--)
                            @if(old('year') == $i)

                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @elseif(old('_token') == null && !empty(Arr::get($familyDetailData, 'date_of_birth')) &&  date("Y", strtotime(Arr::get($familyDetailData, 'date_of_birth')))==  $i   )
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
        <label for="statusId" class="col-sm-3 col-form-label col-form-label-sm">Status</label>
        <div class="col-sm-9 text-left">
            <select class="form-control form-control-sm" id="statusId"  name="status_id" >
                <option value=''>Select</option>
                @if(!empty($maritalStatuses) )
                    @foreach($maritalStatuses as $key =>$value)
                        @if(old('status_id') == $key)
                            <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                        @elseif(old('_token') == null && !empty(Arr::get($familyDetailData, 'status_id')) && (Arr::get($familyDetailData, 'status_id')== $key)  )
                            <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                        @else
                            <option  value="{{trim($key)}}" >{{trim($value)}}</option>
                        @endif
                    @endforeach
                @endif
            </select>
            @if($errors->has('status_id'))
                <div class="text-danger">{{ $errors->first('status_id') }}</div>
            @endif
        </div>
    </div>

    <div class="row mb-3">
        <label for="Qualification" class="col-sm-3 col-form-label col-form-label-sm">Qualification</label>
        <div class="col-sm-9 text-left">
            <input type="text" class="form-control form-control-sm" maxlength="100" id="qualification" name="qualification" value="@if(old('qualification')){{old('qualification')}}@elseif(empty(old('qualification')) && old('_token')) {{''}}@else{{Arr::get($familyDetailData,'qualification')}}@endif">
            @if($errors->has('qualification'))
                <div class="text-danger">{{ $errors->first('qualification') }}</div>
            @endif
        </div>
    </div>

    <div class="row mb-3">
        <label for="occupationId" class="col-sm-3 col-form-label col-form-label-sm">Occupation</label>
        <div class="col-sm-9 text-left">
            <select class="form-control form-control-sm" id="occupationId"  name="occupation_id" >
                <option value='0'>Select</option>
                @if(!empty($occupationOptions) )
                    @foreach($occupationOptions as $key =>$value)
                        @if(old('occupation_id') == $key)
                            <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                        @elseif(old('_token') == null && !empty(Arr::get($familyDetailData, 'occupation_id')) && (Arr::get($familyDetailData, 'occupation_id')== $key)  )
                            <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                        @else
                            <option  value="{{trim($key)}}" >{{trim($value)}}</option>
                        @endif
                    @endforeach
                @endif
            </select>
            @if($errors->has('occupation_id'))
                <div class="text-danger">{{ $errors->first('occupation_id') }}</div>
            @endif
        </div>
    </div>

    <span id="occupationBasedHide">
    <div class="row mb-3">
        <label for="Designation" class="col-sm-3 col-form-label col-form-label-sm">Designation</label>
        <div class="col-sm-9 text-left">
            <input type="text" class="form-control form-control-sm" maxlength="100" id="designation" name="designation" value="@if(old('designation')){{old('designation')}}@elseif(empty(old('designation')) && old('_token')) {{''}}@else{{Arr::get($familyDetailData,'designation')}}@endif">
            @if($errors->has('designation'))
                <div class="text-danger">{{ $errors->first('designation') }}</div>
            @endif
        </div>
    </div>

    
    <div class="row mb-3">
        <label for="companyOrInstitute" class="col-sm-3 col-form-label col-form-label-sm">Company/Institute</label>
        <div class="col-sm-9 text-left">
            <input type="text" class="form-control form-control-sm" maxlength="100" id="companyOrInstitute" name="company_or_institute" value="@if(old('company_or_institute')){{old('company_or_institute')}}@elseif(empty(old('company_or_institute')) && old('_token')) {{''}}@else{{Arr::get($familyDetailData,'company_or_institute')}}@endif">
            @if($errors->has('company_or_institute'))
                <div class="text-danger">{{ $errors->first('company_or_institute') }}</div>
            @endif
        </div>
    </div>
</span>
    <div class="row mb-3">
        <label for="Picture" class="col-sm-3 col-form-label col-form-label-sm">Picture</label>
        <div class="col-sm-9 text-left">
            <input type="file" name="picture" id="picture" value="{{ old('picture')}}" class="form-control"  original-title="Picture">
            @if(Arr::get($familyDetailData, 'picture'))
            <img src="{{asset(config('constants.files.familydetail'))}}/{{ Arr::get($familyDetailData, 'picture') }}" class="center" width="200" height="200" >
            <a class="btn btn-danger " onclick="return confirm('Do you wish to remove Picture?')" href="{{ route('family.details.picture.remove',Arr::get($familyDetailData, 'id'))}}"><span class="fa fa-remove"></span></a>
            @endif
            
            @if($errors->has('picture'))
                <div class="text-danger">{{ $errors->first('picture') }}</div>
             @endif
        </div>
       
    </div>

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
    $( document ).ready(function() {
        showHideFormFields();
        showHideEmergencyContactNumber();
    });

    $("#occupationId").change(function(){
        showHideFormFields();
    });  

    function showHideFormFields()
    {
        let occupationId = $('#occupationId').val();
        //if occupationId is not empty
        if(occupationId== 2 || occupationId== 3 || occupationId== 5 || occupationId== 6)
        {
            $('#occupationBasedHide').hide();
            $('#designation').val('');
            $('#companyOrInstitute').val('');
        }else
        {
            $('#occupationBasedHide').show();
        }
    }


    $(".EmergencyContact").click(function(){
        showHideEmergencyContactNumber();
    }); 

    function showHideEmergencyContactNumber()
    {
        let emergencyContact = $('input[name="emergency_contact"]:checked').val();
        
        if(emergencyContact==1)
        {
            $(".EmergencyContactNumber").show();
        }
        else
        {
            $(".EmergencyContactNumber").hide();
            $("#ContactNo").val('');
        }
       
    }
</script>
@endsection
