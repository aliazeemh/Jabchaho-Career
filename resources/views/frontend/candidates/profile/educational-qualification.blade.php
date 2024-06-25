@extends('frontend.layouts.app-profile')
@section('title', 'Educational Qualification')
@section('content')
<div class="card-title"><img src="{{asset('assets/images/banners/education.jpg')}}" ></div>


@if(!empty($educationalQualificationAllData))
        <div id="myCarousel" class="carousel slide profile" data-ride="carousel" data-interval="0">
           <!-- Wrapper for carousel items -->
			<div class="carousel-inner">
                <div class="item carousel-item active">
                    <div class="row">
                        @php $counter=0;@endphp
                        @foreach($educationalQualificationAllData as $row)
                       
                            <div class="col-sm mydivouter">
                            <a class="mybuttonoverlap" onclick="return confirm('Do you wish to remove Educational Qualification?')" href="{{ route('educational.qualification.delete',Arr::get($row, 'id'))}}"><span class="fa fa-remove"></span></a>
                                <a class="myref" href="{{ route('educational.qualification.show')}}/{{Arr::get($row, 'id')}}">
                                    <p class="card-text">{{Arr::get($row, 'institute_name')}}</p>
                                    <p class="card-text">{{Arr::get($row, 'field_of_study')}}</p>
                                    <p class="card-text">
                                            {{ date("M Y", strtotime(Arr::get($row, 'from'))) }}
                                            -
                                            @if(Arr::get($row, 'is_in_progress'))
                                            {{'Now'}}
                                            @else
                                            {{ date("M Y", strtotime(Arr::get($row, 'to'))) }}
                                            @endif
                                    </p>
                                   
                                </a>
                                
                            </div>
                            
                            
                            @php $counter++; @endphp
                            @if($counter %3==0)
                                @if($counter != count($educationalQualificationAllData))
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

        @if(count($educationalQualificationAllData)>3)
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

<form class="form-horizontal" method="post" action="{{ route('educational.qualification.perform') }}" autocomplete="off">
@if(!empty(Arr::get($educationalQualificationData, 'id')))
    @method('put')
@endif    
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="id" value="{{ Arr::get($educationalQualificationData, 'id','') }}" />
    @if($errors->has('id'))
        <div class="text-danger">{{ $errors->first('id') }}</div>
    @endif
    <h4><hr class="bg-danger border-2 border-top border-danger">Education Details</h4>

    <!-- Select2 for institutes -->
    {!! Helper::select2Fields($educationalQualificationData,$errors,$instituteParam) !!}

    <div class="row mb-3">
        <label for="levelOfEducation" class="col-sm-3 col-form-label col-form-label-sm text-left">Level of Education<span style="color: red"> * </span></label>
        <div class="col-sm-9 text-left">
            <select class="form-control form-control-sm" id="levelOfEducation"  name="level_of_education" onchange="showAndHideFields()" >
            <option  value="">Select Education Level</option>
                @if(!empty($levelOfEducations) )
                    @foreach($levelOfEducations as $key =>$value)
                        @if(old('level_of_education')==$key)
                            <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                        @elseif(old('_token') == null && Arr::get($educationalQualificationData, 'level_of_education') == $key  )
                            <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
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

    <div class="row mb-3" id="BoardNameDiv"  style="display:none;">
        <label for="BoardName" class="col-sm-3 col-form-label col-form-label-sm text-left">Board Name<span style="color: red"> * </span></label>
        <div class="col-sm-9 text-left">
            <select class="form-control form-control-sm" id="BoardName"  name="board" >
            <option  value="">Select Board</option>
                @if(!empty($boards) )
                    @foreach($boards as $key =>$value)
                        @if(old('board')==$key)
                            <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                        @elseif(old('_token') == null && Arr::get($educationalQualificationData, 'board') == $key  )
                            <option value="{{ trim($key) }}" selected>{{trim($value)}}</option>     
                        @else
                            <option  value="{{trim($key)}}" >{{trim($value)}} </option>
                        @endif
                    @endforeach
                @endif
            </select>
            @if($errors->has('board'))
                <div class="text-danger">{{ $errors->first('board') }}</div>
            @endif
        </div>
    </div>

    <!-- Field of study using select2 -->
    {!! Helper::select2Fields($educationalQualificationData,$errors,$fieldOfStudyParam) !!}

    <div class="row mb-3">
        <label for="majors" class="col-sm-3 col-form-label col-form-label-sm text-left">Majors<span style="color: red"> * </span></label>
        <div class="col-sm-9 text-left">
            
            @php  $majors = '';  @endphp


            @if(old('majors'))
                @php  $majors = old('majors');  @endphp
                
            @elseif( Arr::get($educationalQualificationData,'majors') && empty(old('_token')))
                   
                 @php $majors = explode(',',Arr::get($educationalQualificationData,'majors')); @endphp
                   
            @endif

            <select class="form-control form-control tokenizationSelect2" multiple="true" name="majors[]">
                @if(!empty($majors) )

                        @foreach($majors as $row)
                                <option value="{{$row}}" selected="selected">{{$row}}</option>
                        @endforeach
                @else   
                    <option value=""></option>
                @endif                    
            </select>
            @if($errors->has('majors'))
                <div class="text-danger">{{ $errors->first('majors') }}</div>
            @endif
        </div>
    </div>

    
    <div class="row mb-3 duration">
        <label for="Duration" class="col-sm-3 col-form-label col-form-label-sm text-left">Duration<span style="color: red"> * </span></label>
        <div class="col-sm-9 text-left">
            
            <div class="row">
                    <label> <span class="w50px">From:</span>   
                        <span id="fromDiv" style="display: contents;">
                            <div class="col-sm-4">
                                <select class="form-control form-control-sm" id="from_months"  name="from_months" >
                                    <option value=''>Month</option>
                                    @if(!empty($months) )
                                        @foreach($months as $key =>$value)
                                            @if(old('from_months') == $key)
                                                <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                                            @elseif(old('_token') == null && !empty(Arr::get($educationalQualificationData, 'from')) &&  date("m", strtotime(Arr::get($educationalQualificationData, 'from')))== $key  )
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
                                        @elseif(old('_token') == null && !empty(Arr::get($educationalQualificationData, 'from')) &&  date("Y", strtotime(Arr::get($educationalQualificationData, 'from')))==  $i   )
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
                                            @elseif(old('_token') == null && !empty(Arr::get($educationalQualificationData, 'to')) &&  date("m", strtotime(Arr::get($educationalQualificationData, 'to')))== $key  )
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
                                        @elseif(old('_token') == null && !empty(Arr::get($educationalQualificationData, 'to')) &&  date("Y", strtotime(Arr::get($educationalQualificationData, 'to')))==  $i   )
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

        </div>
    </div>
    <div class="row mb-3 awaiting-detail">
        <div class="col-sm-3 hide-on-mobile"></div>
        <div class="col-sm-8">
            <div class="row text-left">

                <div class="col-sm-12">
                    <input class="form-check-input" type="checkbox" id="finalResult" name="final_result" value="1" 
                    @if((old('_token') && old('final_result') != null) || (old('_token') == null && Arr::get($educationalQualificationData, 'final_result')))    
                        {{'checked'}}
                    @else
                        {{''}}
                    @endif  
                    >
                    <label class="form-check-label" for="finalResult">
                        Final Result / Transcript Awaited
                    </label>
                    @if($errors->has('final_result'))
                        <div class="text-danger">{{ $errors->first('final_result') }}</div>
                    @endif
                </div>

                <div class="col-sm-12">
                    <input class="form-check-input" type="checkbox" id="dropOut " name="drop_out" value="1" 
                    @if((old('_token') && old('drop_out') != null) || (old('_token') == null && Arr::get($educationalQualificationData, 'drop_out')))    
                        {{'checked'}}
                    @else
                        {{''}}
                    @endif  
                    >
                    <label class="form-check-label" for="dropOut">
                        Drop Out
                    </label>
                    @if($errors->has('drop_out'))
                        <div class="text-danger">{{ $errors->first('drop_out') }}</div>
                    @endif
                </div>

                <div class="col-sm-12">
                    <input class="form-check-input" type="checkbox" id="isInProgress" name="is_in_progress" value="1" 
                    @if((old('_token') && old('is_in_progress') != null) || (old('_token') == null && Arr::get($educationalQualificationData, 'is_in_progress')))    
                        {{'checked'}}
                    @else
                        {{''}}
                    @endif  
                    >
                    <label class="form-check-label" for="isInProgress">
                        In progress
                    </label>
                    @if($errors->has('is_in_progress'))
                        <div class="text-danger">{{ $errors->first('is_in_progress') }}</div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-10 offset-sm-2">
          
        </div>
    </div>

    <div class="row mb-3" id="MarksScored">
        <label for="Duration" class="col-sm-3 col-form-label col-form-label-sm text-left">Marks Scored<span style="color: red"> * </span></label>
        <div class="col-sm-9 text-left" >
            
            <div class="row" >
                <span class="d-content">Percentage</span>
                <div class="col-sm-3">
                    <input type="text" class="form-control form-control-sm" maxlength="5" id="percentage" name="percentage" value="@if(old('percentage')){{old('percentage')}}@elseif(empty(old('percentage')) && old('_token')) {{''}}@else{{Arr::get($educationalQualificationData,'percentage')}}@endif" onkeydown="return isNumberKey(this);">
                    @if($errors->has('percentage'))
                        @if($errors->first('percentage')!=config('constants.cgpa_percentage_error'))
                            <div class="text-danger">{{ $errors->first('percentage') }}</div>
                        @endif
                    @endif
                </div> 
                <span style="display:contents;" id="GPAField">
                <span class="d-content">CGPA</span>
                    <div class="col-sm-3" >
                        <input type="text" class="form-control form-control-sm" maxlength="4" id="gpa" name="gpa" value="@if(old('gpa')){{old('gpa')}}@elseif(empty(old('gpa')) && old('_token')) {{''}}@else{{Arr::get($educationalQualificationData,'gpa')}}@endif" onkeydown="return isNumberKey(this);">
                        @if($errors->has('gpa'))
                            @if($errors->first('gpa')!=config('constants.cgpa_percentage_error'))
                                <div class="text-danger">{{ $errors->first('gpa') }}</div>
                            @endif
                        @endif    
                    </div>
                </span>
                    <span class="d-content">
                        Grade
                    </span>
                    <div class="col-sm-3" >
                        <select class="form-control form-control-sm" id="grade"  name="grade" rel="{{old('grade')}}" >
                            <option  value="">Select</option>
                            @if(!empty($grades) )
                                @foreach($grades as $value)
                                    @if(old('grade') == $value)
                                        <option value="{{ trim($value) }}" selected>{{trim($value)}}</option> 
                                    @elseif(old('_token') == null && Arr::get($educationalQualificationData, 'grade') == $value  )
                                        <option value="{{ trim($value) }}" selected>{{trim($value)}}</option> 
                                    @else
                                        <option  value="{{trim($value)}}" >{{trim($value)}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('grade'))
                            <div class="text-danger">{{ $errors->first('grade') }}</div>
                        @endif
                    </div> 
                
            </div> 

            @if($errors->has('percentage') && $errors->has('gpa'))
                @if($errors->first('percentage')==config('constants.cgpa_percentage_error') && ($errors->first('gpa')==config('constants.cgpa_percentage_error')))
                    <div class="text-danger">{{ $errors->first('gpa') }}</div>
                @endif
            @endif
        </div>
    </div>    


    <div class="row mb-3" id="SelectGrades">
        <label for="Duration" class="col-sm-3 col-form-label col-form-label-sm text-left">Select Grades</label>
        <div class="col-sm-9 text-left" >
            
            <div class="row" >
                A
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" id="levelGradeA"  name="level_grade_a" rel="{{old('level_grade_a')}}" >
                        @if(!empty($OALevelGrades) )
                            @foreach($OALevelGrades as $value)
                                @if(old('level_grade_a') == $value)
                                    <option value="{{ trim($value) }}" selected>{{trim($value)}}</option> 
                                @elseif(old('_token') == null && Arr::get($educationalQualificationData, 'level_grade_a') == $value  )
                                    <option value="{{ trim($value) }}" selected>{{trim($value)}}</option> 
                                @else
                                    <option  value="{{trim($value)}}" >{{trim($value)}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if($errors->has('level_grade_a'))
                        <div class="text-danger">{{ $errors->first('level_grade_a') }}</div>
                    @endif
                </div> 
               
                B
                <div class="col-sm-2" >
                    <select class="form-control form-control-sm" id="levelGradeB"  name="level_grade_b" rel="{{old('level_grade_b')}}" >
                        @if(!empty($OALevelGrades) )
                            @foreach($OALevelGrades as $value)
                                @if(old('level_grade_b') == $value)
                                    <option value="{{ trim($value) }}" selected>{{trim($value)}}</option>
                                @elseif(old('_token') == null && Arr::get($educationalQualificationData, 'level_grade_b') == $value  )
                                    <option value="{{ trim($value) }}" selected>{{trim($value)}}</option> 
                                @else
                                    <option  value="{{trim($value)}}" >{{trim($value)}}</option>
                                @endif
                            @endforeach
                        @endif
                    
                    </select>
                    @if($errors->has('level_grade_b'))
                        <div class="text-danger">{{ $errors->first('level_grade_b') }}</div>
                    @endif
                </div>
                <div class="col-sm-2" >
                    <select class="form-control form-control-sm" id="levelGradeC"  name="level_grade_c" rel="{{old('level_grade_c')}}" >
                            @if(!empty($OALevelGrades) )
                                @foreach($OALevelGrades as $value)
                                    @if(old('level_grade_c') == $value)
                                        <option value="{{ trim($value) }}" selected>{{trim($value)}}</option>
                                    @elseif(old('_token') == null && Arr::get($educationalQualificationData, 'level_grade_c') == $value  )
                                        <option value="{{ trim($value) }}" selected>{{trim($value)}}</option>  
                                    @else
                                        <option  value="{{trim($value)}}" >{{trim($value)}}</option>
                                    @endif
                                @endforeach
                            @endif
                        
                    </select>
                    @if($errors->has('level_grade_c'))
                        <div class="text-danger">{{ $errors->first('level_grade_c') }}</div>
                    @endif
                </div> 
            </div> 
        </div>
    </div>   
    <div class="row mb-3">
        <label for="position" class="col-sm-3 col-form-label col-form-label-sm text-left">Position Achieved<span style="color: red"> * </span></label>
        <div class="col-sm-9 text-left">
            @if(!empty($booleanOptions))
                @foreach($booleanOptions as $key=>$value)
                    <input class="form-check-input" type="radio" name="position" id="position-{{$key}}" value="{{$key}}" 
                            
                    @if((old('_token') && old('position') == $key)) 
                        {{'checked'}}
                    @elseif(old('_token') == null && array_key_exists(Arr::get($educationalQualificationData, 'position'), config('constants.boolean_options')) )  
                        {{ Arr::get($educationalQualificationData, 'position') == $key ? 'checked' : '' }} 
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
        @if($errors->has('position'))
            <div class="text-danger">{{ $errors->first('position') }}</div>
        @endif
    </div>

    <div class="row mb-3">
        <label for="scholarships" class="col-sm-3 col-form-label col-form-label-sm text-left">Scholarships Received<span style="color: red"> * </span></label>
        <div class="col-sm-9 text-left">
            @if(!empty($booleanOptions))
                @foreach($booleanOptions as $key=>$value)
                    <input class="form-check-input" type="radio" name="scholarships" id="scholarships-{{$key}}" value="{{$key}}" 
                            
                    @if((old('_token') && old('scholarships') == $key)) 
                        {{'checked'}}
                    @elseif(old('_token') == null && array_key_exists(Arr::get($educationalQualificationData, 'scholarships'), config('constants.boolean_options')) )  
                        {{ Arr::get($educationalQualificationData, 'scholarships') == $key ? 'checked' : '' }} 
                    @else 
                        @if(old('_token') == null && $key==0)
                            {{'checked'}}
                        @endif
                    @endif
                    
                    >
                    <label class="form-check-label" for="scholarships-{{$key}}">{{$value}}</label>
                @endforeach
            @endif
        </div>
        @if($errors->has('scholarships'))
            <div class="text-danger">{{ $errors->first('scholarships') }}</div>
        @endif
    </div>

    <div class="row mb-3">
        <label for="extraCurricularActivities" class="col-sm-3 col-form-label col-form-label-sm text-left">Extra Curricular Activities</label>
        <div class="col-sm-9 text-left">
        <textarea name="extra_curricular_activities" rows="2" cols="20" id="extraCurricularActivities" class="form-control form-control-sm">@if(old('extra_curricular_activities')){{old('extra_curricular_activities')}} 
 @elseif(empty(old('extra_curricular_activities')) && old('_token')) {{''}}@else{{Arr::get($educationalQualificationData, 'extra_curricular_activities')}}@endif</textarea>
        @if($errors->has('extra_curricular_activities'))
            <div class="text-danger">{{ $errors->first('extra_curricular_activities') }}</div>
        @endif    
    </div>
    </div>
    <hr class="bg-danger border-2 border-top border-danger">

    <div class="row mb-3">
        <div class="col-sm-10 offset-sm-2">
            <div class="text-end">
                <input type="submit" class="btn btn-light" value="Save & Add more" name="form_submit" />
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
        showAndHideFields();

        enabledAndDisabledDurationTo();

        $(".tokenizationSelect2").select2({
            tags: true,
            //tokenSeparators: ['/',',',';'," "],
            tokenSeparators: [','],
        });
 
        //Insitute Names Search
        select2Fields('institute_name', 'Enter Your Institute', "{{route('institute.search')}}");

        //Field Of Study Search
        select2Fields('field_of_study', 'Enter Your Field Of Study', "{{route('field.search')}}");

    });

    $('#isInProgress').click(function() {
        enabledAndDisabledDurationTo();
    });
    function enabledAndDisabledDurationTo()
    {
        if($('#isInProgress').is(":checked")){
  

            $("#to_months").prop("disabled", true);
            $("#to_year").prop("disabled", true);
            $("#percentage").prop("disabled", true);
            $("#grade").prop("disabled", true);
            $("#gpa").prop("disabled", true);
  
      

        }else{
       
            $("#to_months").prop("disabled", false);  
            $("#to_year").prop("disabled", false);  
            $("#percentage").prop("disabled", false);  
            $("#grade").prop("disabled", false);  
            $("#gpa").prop("disabled", false);
        }
    }

    //
    function showAndHideFields(){
        
        let levelOfEducation  = $('#levelOfEducation').val();

        if(levelOfEducation){
            if(levelOfEducation==4 || levelOfEducation ==6 )
            { //|| levelOfEducation==''
                $('#GPAField').hide();
                $('#BoardNameDiv').show();
            }else{
                $('#GPAField').show();
            // $('#GPAField').css('display', 'contents');
                $('#BoardNameDiv').hide();
            }
        }else{
            $('#GPAField').hide();
        }
        


        if(levelOfEducation==1 || levelOfEducation ==8){
            $('#MarksScored').hide();
            $('#SelectGrades').show();
        }else{
            $('#MarksScored').show();
            $('#SelectGrades').hide();
        }

    }

</script>
    

@endsection