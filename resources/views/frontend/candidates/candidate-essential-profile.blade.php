
@extends('frontend.layouts.auth-master')
@section('title', 'Complete Essential Profile')
@section('content')
<style>
.document-boxes {
    position: relative;
    cursor: pointer;
}
.document-boxes .action-btns {
    display: flex;
    justify-content: end;
    gap: 5px;
    align-self: end;
    margin-top: -20px;
    margin-right: -10px;
    position: absolute;
    top: 0;
    z-index: 1;
    right: 0;
}
</style>
<div class="container-auth">
    <div class="container signin signup">
        <h2 class="header">Complete Essential Profile</h2>
        <div class="desc"><small>To continue, kindly fill out your profile.</small></div>
        @include('frontend.includes.partials.messages')

        <form id="uploadResumeForm" class="form-horizontal" action="{{ route('candidate.essential.profile.perform') }}" method="Post" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
           
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" autocomplete="off" class="form-control" id="full-name" placeholder="Candidate Full Name" name="candidate_full_name" @if(!empty($fullName)) readonly @endif maxlength="50" value="@if(old('candidate_full_name')){{old('candidate_full_name')}}@elseif(empty(old('candidate_full_name')) && old('_token')) {{''}}@else{{$fullName}}@endif" onpaste="return false;" onkeydown="return isAlphabatKey(this);">
                    @if($errors->has('candidate_full_name'))
                        <div class="text-danger">{{ $errors->first('candidate_full_name') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" autocomplete="off" class="form-control" id="email" placeholder="Candidate Email" name="email" maxlength="50" @if(!empty($email)) readonly @endif  value="@if(old('email')){{old('email')}}@elseif(empty(old('email')) && old('_token')) {{''}}@else{{$email}}@endif">
                    @if($errors->has('email'))
                        <div class="text-danger">{{ $errors->first('email') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" autocomplete="off" class="form-control" id="mobile" placeholder="Mobile Number" name="mobile" maxlength="11" value="@if(old('mobile')){{old('mobile')}}@elseif(empty(old('mobile')) && old('_token')) {{''}}@else{{$mobile}}@endif" onpaste="return false;" onkeydown="return isNumberKey(this);">
                    @if($errors->has('mobile'))
                        <div class="text-danger">{{ $errors->first('mobile') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <select class="form-control c-select" id="country"  name="country_code" rel="{{old('country_code')}}">
                        @if(!empty($countries) )
                            @foreach($countries as $key =>$value)
                                @if(old('country_code') == $key)
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                @elseif($value == config('constants.countries.PK') && empty(old('country_code')) && empty($countryCode) )
                                <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                @elseif($countryCode== $key)
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
                            
                                    @if (old('area_of_interest_option_id') == $object['id'] )
                                        <option value="{{ trim($object['id']) }}" selected>{{trim($object['name'])}} </option>  
                                    @elseif($areaOfInterestOptionId== $object['id'])    
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

            <div class="form-group upload-resume">

            @if(Arr::get($resume, 'file'))
            <div class="col-sm-12 text-center">
                    @if(Helper::isFileExtensionForIcon(Arr::get($resume,'file')))
                        <img  src="{{asset(config('constants.files.filetypes'))}}/{{Helper::isFileExtensionForIcon(Arr::get($resume,'file'))}}"  />
                    @endif
                    <a class="downloadFile" data-filepath="{{asset(config('constants.files.douments'))}}/{{Arr::get($resume,'file')}}">Download</a>
                </div>
      
            @else
                
                <div class="col-sm-12">
                    <label class="file-wrapper">
                        <span class="dropped_file_name"></span>
                        <div class="upload-cv">
                            <label for="resume" class="btn">Upload CV</label>
                            <input type="file" name="resume" id="resume" class="form-control uploadDocument" value="Upload CV">
                        </div>
                    </label>

                        @if($errors->has('resume'))
                        <div class="text-danger">{{ $errors->first('resume') }}</div>
                        @endif
                </div>

                <div class="col-sm-12">
                        <div class="col-form-label col-form-label-sm t-a-center" data-bs-toggle="tooltip" data-bs-placement="bottom" title=".jpeg, .jpg, .pdf">
                            View Supported CV formats
                        </div>
                </div>
                    
               
            @endif
            </div>
            <div class="form-group">        
                <div class="col-sm-12 t-a-center" style="margin-bottom: 5px;">
                    <input  type="submit" class="btn btn-primary" value="Submit" name="submit" />
                </div>
            </div>

        </form>
    </div>

</div>

<script>
    
$(document).on('click', '.downloadFile', function (e) {
        e.preventDefault();  //stop the browser from following

        var filepath = $(this).attr('data-filepath');
        window.open(filepath , '_blank');
    });
</script>


@endsection