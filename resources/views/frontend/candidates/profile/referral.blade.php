@extends('frontend.layouts.app-profile')
@section('title', 'Referral')
@section('content')

<div class="card-title"><img src="{{asset('assets/images/banners/referral.jpg')}}" ></div>

<form class="form-horizontal" id="ReferralForm" method="post" action="{{ route('referral.perform') }}" autocomplete="off">
@if(!empty(Arr::get($referralData, 'id')))
    @method('put')
@endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="id" value="{{ Arr::get($referralData, 'id','') }}" />
    @if($errors->has('id'))
        <div class="text-danger">{{ $errors->first('id') }}</div>
    @endif

    <p class="text-start"><small>Please tell us, where did you hear about jobs at Ideas</small></p>

    <div class="row mb-3 text-left">
        <label for="InstituteName" class="col-sm-3 col-form-label col-form-label-sm">Select a Medium<span style="color: red"> * </span></label>
        <div class="col-sm-9">
            @if(!empty($referralOptions))
                @foreach($referralOptions as $key=>$value)
                <div>
                    <input class="form-check-input referralOptions" type="radio" name="referral_id" id="referralOptions-{{$key}}"  value="{{$key}}" 
                        @if((old('_token') && old('referral_id') == $key)) 
                            {{'checked'}}
                        @elseif(old('_token') == null && Arr::get($referralData, 'referral_id'))  
                            {{ Arr::get($referralData, 'referral_id') == $key ? 'checked' : '' }} 
                        @else 
                        @if(old('_token') == null && $key==0)
                                {{'checked'}}
                                @endif
                        @endif    
                
                    >
                    <label class="form-check-label col-form-label-sm" for="referralOptions-{{$key}}">{{$value}}</label>
                </div>        
                @endforeach
            @endif

            @if($errors->has('referral_id'))
                <div class="text-danger">{{ $errors->first('referral_id') }}</div>
            @endif
        </div>
    </div>


    <div id="div-reference-details" style="display:none;">
        <div><hr class="bg-danger border-2 border-top border-danger">Enter Reference Details</div>

        <div class="row mb-3 IknowSomeone " style="display:none;">
            <label for="PersonName" class="col-sm-3 col-form-label col-form-label-sm">Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="100" id="PersonName" name="person_name" value="@if(old('person_name')){{old('person_name')}}@elseif(empty(old('person_name')) && old('_token')) {{''}}@else{{Arr::get($referralData,'person_name')}}@endif">
                @if($errors->has('person_name'))
                    <div class="text-danger">{{ $errors->first('person_name') }}</div>
                @endif
            </div>
        </div>

        <div class="row mb-3 IknowSomeone" style="display:none;">
            <label for="ContactNo" class="col-sm-3 col-form-label col-form-label-sm">Contact No</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="20" id="ContactNo" name="contact_no" onkeydown="return isNumberKey(this);" value="@if(old('contact_no')){{old('contact_no')}}@elseif(empty(old('contact_no')) && old('_token')) {{''}}@else{{Arr::get($referralData,'contact_no')}}@endif">
                @if($errors->has('contact_no'))
                    <div class="text-danger">{{ $errors->first('contact_no') }}</div>
                @endif
            </div>
        </div>

        <div class="row mb-3 IknowSomeone" style="display:none;">
            <label for="EmployeeId" class="col-sm-3 col-form-label col-form-label-sm">Employee Id</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="100" id="EmployeeId" name="employee_id" value="@if(old('employee_id')){{old('employee_id')}}@elseif(empty(old('employee_id')) && old('_token')) {{''}}@else{{Arr::get($referralData,'employee_id')}}@endif">
                @if($errors->has('employee_id'))
                    <div class="text-danger">{{ $errors->first('employee_id') }}</div>
                @endif
            </div>
        </div>


        <div class="row mb-3 ReferredMe" style="display:none;">
            <label for="ReferenceCode" class="col-sm-3 col-form-label col-form-label-sm">Reference Code</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="20" id="ReferenceCode" name="reference_code" onkeydown="return isNumberKey(this);" value="@if(old('reference_code')){{old('reference_code')}}@elseif(empty(old('reference_code')) && old('_token')) {{''}}@else{{Arr::get($referralData,'reference_code')}}@endif">
                @if($errors->has('reference_code'))
                    <div class="text-danger">{{ $errors->first('reference_code') }}</div>
                @endif
            </div>
        </div>

    </div>    

    <div id="div-other-medium" style="display:none;">
        <div><hr class="bg-danger border-2 border-top border-danger">Enter Other Medium Details</div>

        <div class="row mb-3">
            <label for="OtherMedium" class="col-sm-3 col-form-label col-form-label-sm">Medium</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="200" id="OtherMedium" name="other_medium" value="@if(old('other_medium')){{old('other_medium')}}@elseif(empty(old('other_medium')) && old('_token')) {{''}}@else{{Arr::get($referralData,'other_medium')}}@endif">
                @if($errors->has('other_medium'))
                    <div class="text-danger">{{ $errors->first('other_medium') }}</div>
                @endif
            </div>
        </div>
        <div class="row mb-3">
            <label for="OtherName" class="col-sm-3 col-form-label col-form-label-sm">Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="100" id="OtherName" name="other_name" value="@if(old('other_name')){{old('other_name')}}@elseif(empty(old('other_name')) && old('_token')) {{''}}@else{{Arr::get($referralData,'other_name')}}@endif">
                @if($errors->has('other_name'))
                    <div class="text-danger">{{ $errors->first('other_name') }}</div>
                @endif
            </div>
        </div>
        <div class="row mb-3">
            <label for="otherContactNo" class="col-sm-3 col-form-label col-form-label-sm">Contact No</label>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" maxlength="20" id="otherContactNo" name="other_contact_no" onkeydown="return isNumberKey(this);" value="@if(old('other_contact_no')){{old('other_contact_no')}}@elseif(empty(old('other_contact_no')) && old('_token')) {{''}}@else{{Arr::get($referralData,'other_contact_no')}}@endif">
                @if($errors->has('other_contact_no'))
                    <div class="text-danger">{{ $errors->first('other_contact_no') }}</div>
                @endif
            </div>
        </div>
    </div>
        
    <hr class="bg-danger border-2 border-top border-danger">
    <div class="row mb-3">
        <div class="col-sm-10 offset-sm-2">
            <div class="text-end">
                <button type="submit" id="submitReferral" class="btn btn-primary" value="Save & Continue">Save & Continue</button>  
            </div>
        </div>
    </div>

</form>

<script>

    $("#submitReferral").on("click", function(e) {
        e.preventDefault();
        
        let referralId = $('input[name="referral_id"]:checked').val();
        if(referralId!=5)
        {
            $('#PersonName').val('');
            $('#ContactNo').val('');
            $('#EmplyedId').val('');
        }
        if(referralId!=6){
            $('#ReferenceCode').val('');
        }    
          
        if(referralId!=7){
            $('#OtherVendor').val('');
            $('#OtherName').val('');
            $('#otherContactNo').val('');
        }


        //ReferralForm
        $("#ReferralForm").submit();
        
    });
    
    $( document ).ready(function() {
        showHideReferralForm();
    });

    $(".referralOptions").change(function(){
        showHideReferralForm();
    });  

    function showHideReferralForm(){
      let referralId = $('input[name="referral_id"]:checked').val();
        $('.ReferredMe').hide(); 
        $('.IknowSomeone').hide();
        $('#div-other-medium').hide();  
        $('#div-reference-details').hide();
       
        if(referralId==5)
        {
            $('#div-reference-details').show();
            $('.IknowSomeone').show();

            $('.ReferredMe').hide(); 
            $('#div-other-medium').hide();   
        }
        else if(referralId==6)
        {
            $('#div-reference-details').show();
            $('.ReferredMe').show(); 
            
            $('.IknowSomeone').hide();
            $('#div-other-medium').hide();  
        }
        else if(referralId==7)
        {
            $('#div-other-medium').show(); 

            $('#div-reference-details').hide();
            $('.IknowSomeone').hide();

            $('.ReferredMe').hide(); 
        }   
        
    }
</script>    

@endsection