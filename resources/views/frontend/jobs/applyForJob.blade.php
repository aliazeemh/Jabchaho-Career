@extends('frontend.layouts.app-master')
@section('title', 'Apply For Job')
@section('content')

<div class="card">
  <div class="card-body">

        <h2>Easy Application For {{Arr::get($job, 'title')}} </h3> 

        <p>Please enter the correct contact details for faster processing.</p>

        <form id="uploadResumeForm" class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('applicant.apply') }}" autocomplete="off">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="job_id" value="{{ Arr::get($job, 'id','') }}" />
            
            @if($errors->has('job_id'))
                <div class="text-danger">{{ $errors->first('job_id') }}</div>
            @endif
            <div class="row mb-3">
                <label for="first_name" class="col-sm-3 col-form-label col-form-label-sm">Full Name<span style="color: red"> * </span></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" maxlength="50" id="full_name" name="full_name" value="@if(old('full_name')){{old('full_name')}}@elseif(empty(old('full_name')) && old('_token')) {{''}}@else{{Arr::get(Auth::guard('candidate')->user(),'full_name')}}@endif" onpaste="return false;" onkeydown="return isAlphabatKey(this);">
                    @if($errors->has('full_name'))
                        <div class="text-danger">{{ $errors->first('full_name') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="gender" class="col-sm-3 col-form-label col-form-label-sm">Gender<span style="color: red"> * </span></label>
                <div class="col-sm-9 col-form-label-sm text-left">
                   
                        @foreach(config('constants.gender_options') as $key => $value)
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="gender-{{$key}}">{{$value}}</label>
                                <input class="form-check-input" type="radio" name="gender" id="gender-{{$key}}" value="{{$key}}"
                                @if((old('gender')!==null && (old('gender') == $key)) || (empty(old('gender')) && (isset($personalDetailData->gender) && $personalDetailData->gender === $key)))
                                    {{'checked'}}
                                @endif>
                            </div>
                        @endforeach
                    
                    @if($errors->has('gender'))
                        <div class="text-danger">{{ $errors->first('gender') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label col-form-label-sm">Email Address<span style="color: red"> * </span></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" maxlength="50" id="email" name="email" value="@if(old('email')){{old('email')}}@elseif(empty(old('email')) && old('_token')) {{''}}@else{{Arr::get(Auth::guard('candidate')->user(),'email')}}@endif">
                    @if($errors->has('email'))
                        <div class="text-danger">{{ $errors->first('email') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="phone" class="col-sm-3 col-form-label col-form-label-sm">Phone Number<span style="color: red"> * </span></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" maxlength="11" id="phone" name="phone" value="@if(old('phone')){{old('phone')}}@elseif(empty(old('phone')) && old('_token')) {{''}}@else{{Arr::get(Auth::guard('candidate')->user(),'mobile_number')}}@endif" onkeydown="return isNumberKey(this);">
                    @if($errors->has('phone'))
                        <div class="text-danger">{{ $errors->first('phone') }}</div>
                    @endif
                </div>
            </div>


            <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label col-form-label-sm">Total Experience <small>(in years)</small><span style="color: red"> * </span></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" maxlength="2" id="total_experience" name="total_experience" value="@if(old('total_experience')){{old('total_experience')}}@elseif(empty(old('total_experience')) && old('_token')) {{''}}@else{{Arr::get(Auth::guard('candidate')->user(),'total_experience')}}@endif" onkeydown="return isNumberKey(this);">
                    @if($errors->has('total_experience'))
                        <div class="text-danger">{{ $errors->first('total_experience') }}</div>
                    @endif
                </div>
            </div>
            
            @if($educationCount == 0)
                <div class="row mb-3">
                    <label for="level_of_educations" class="col-sm-3 col-form-label col-form-label-sm">Select Level Of Education<span style="color: red"> * </span></label>
                    <div class="col-sm-9 col-form-label-sm text-left">
                        <select class="form-control" id="level_of_educations" name="level_of_educations">
                            <option value="">Select Level Of Education</option>
                            @foreach (config('constants.level_of_educations') as $key => $value)
                                @if(old('level_of_educations')==$key)
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                @else 
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @endforeach
                        </select>
                        @if($errors->has('level_of_educations'))
                            <div class="text-danger">{{ $errors->first('level_of_educations') }}</div>
                        @endif
                    </div>
                </div>

                <!-- Field of study using select2 -->
                {!! Helper::select2Fields($educationalQualificationData,$errors,$fieldOfStudyParam) !!}
                
            @endif

            <div class="row mb-3">
                <label for="city" class="col-sm-3 col-form-label col-form-label-sm">Select Your City<span style="color: red"> * </span></label>
                <div class="col-sm-9 col-form-label-sm text-left">
                    <select class="form-control" id="city" name="city">
                        <option value="">Select City</option>
                        @foreach (config('constants.cities') as $key => $value)
                            @if(old('city')==$key)
                                <option value="{{ trim($key) }}" selected>{{ trim($value) }}</option>
                            @elseif(!empty($personalDetailData->city) && $personalDetailData->city==$key)
                                <option value="{{ trim($key) }}" selected>{{ trim($value) }}</option>
                            @else
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endif
                        @endforeach
                    </select>
                    @if($errors->has('city'))
                        <div class="text-danger">{{ $errors->first('city') }}</div>
                    @endif
                </div>
            </div>            
            

            <div class="row mb-3">
                <label for="phone" class="col-sm-3 col-form-label col-form-label-sm">Attach your resume<span style="color: red"> * </span></label>
                <div class="col-sm-9"  id="div_resume">
                
                    @if(Arr::get($resume, 'file'))
                        @if(Helper::isFileExtensionForIcon(Arr::get($resume,'file')))
                            <img  src="{{asset(config('constants.files.filetypes'))}}/{{Helper::isFileExtensionForIcon(Arr::get($resume,'file'))}}"  />
                        @endif
                        <a class="" onclick="return confirm('Do you wish to remove?')" href="{{ route('document.delete',Arr::get($resume, 'id'))}}"><span class="fa fa-remove"></span></a>
                        <a class="downloadFile" data-filepath="{{asset(config('constants.files.douments'))}}/{{Arr::get($resume,'file')}}">Download</a>
                    @else
                            <input type="file" name="resume" id="resume" value="{{ old('resume')}}" class="form-control uploadDocument"  original-title="Resume">
                    @endif

                    @if($errors->has('resume'))
                        <div class="text-danger">{{ $errors->first('resume') }}</div>
                    @endif
                </div>
            </div>
            <div id="resume_error" class="row mb-3 alert alert-danger small"  style="display:none"></div>

            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary" value="Save & Continue">Submit</button>  
                    </div>
                </div>
            </div>

            

        </form>

    </div>
</div>        
<script>
$(document).ready(function() {
    var isFileUploadOnly = false;
    $('#uploadResumeForm').on('submit',(function(e) {
        if(isFileUploadOnly)
        {
            e.preventDefault();
            var formData = new FormData(); //this
            var selectedFile = 'resume';
            
            $.each($("#"+selectedFile).prop('files'), function (key, file){
            
                formData.append('attachment', file);
            });  
            
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('selected', selectedFile);
            
            $('#'+selectedFile+'_error').hide();
            $('#'+selectedFile+'_error').html('');
            
            $.ajax({
                type:'POST',
                url: "{{ route('upload.documents.perform') }}", //$(this).attr('action'),
                data:formData,
                cache:false,
                    contentType: false,
                processData: false,
                success:function(data){
                    if(data.errors){
                        jQuery.each(data.errors, function(key, value){
                        $('#'+selectedFile+'_error').show();
                        $('#'+selectedFile+'_error').append('<li>'+value+'</li>');
                    
                    });
                    }else{
                        if(data)
                        {
                            $("#div_"+selectedFile).html('<img src="'+data.diaplay_image_path+'" > <a onclick="return confirm(\'Do you wish to remove?\')" href="'+data.url+'"><span class="fa fa-remove"></span></a>&nbsp;<a class="downloadFile" data-filepath="'+data.file_path+'">Download</a>');
                            $("#img_upload_"+selectedFile).attr('src',"{{asset('assets/images/icons/buttons/')}}/d1.png")
                        }
                    }
                    
                },
                error: function(data){
                    $('#'+selectedFile+'_error').show();
                    $('#'+selectedFile+'_error').html('Unable to process request. Please refresh the page and try again!!');
                    
                }
            });

            $('.uploadDocument').val('');
        

        }else{
                return true;
        }    
    }));


    $(".uploadDocument").on("change", function() {
        isFileUploadOnly = true;
        $("#uploadResumeForm").submit();
        isFileUploadOnly = false;
    });

    $(document).on('click', '.downloadFile', function (e) {
            e.preventDefault();  //stop the browser from following
    
            var filepath = $(this).attr('data-filepath');
            window.open(filepath , '_blank');
        });



    select2Fields('field_of_study', 'Enter Your Field Of Study', "{{route('field.search')}}");
    



});

</script>

@endsection