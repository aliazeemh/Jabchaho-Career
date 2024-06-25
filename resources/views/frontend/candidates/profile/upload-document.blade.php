@extends('frontend.layouts.app-profile')
@section('title', 'Upload Documents')
@section('content')

<div class="card-title"><img src="{{asset('assets/images/banners/uploaddoc.jpg')}}" ></div>

<h4 class="col-form-label-sm strong">Please provide documents of your work and credentials</h4>
<div class="col-form-label-sm">(Supported file formats are: jpeg, jpg, png, gif, bmp, psd, doc, docx, xls, xlsx, ppt, pptx, pdf, zip, rar, mp3)</div>

<form id="uploadDocumentForm" enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('upload.documents.perform') }}" autocomplete="off">
<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<input type="hidden" id="selected" name="selected" value="" />
<h4><hr class="bg-danger border-2 border-top border-danger">Resume</h4>


<div class="row mb-3 text-left">
    <label for="Resume" class="col-sm-5 col-form-label col-form-label-sm"> <img src=" @if(!empty(Arr::get($defaultDocumentArray,'resume'))){{asset('assets/images/icons/buttons/d1.png')}} @else {{asset('assets/images/icons/buttons/U1.png')}}  @endif" id="img_upload_resume" > Resume</label>
        
    <div class="col-sm-7" id="div_resume">
        @if(!empty(Arr::get($defaultDocumentArray,'resume')))
            @if(Helper::isFileExtensionForIcon(Arr::get($defaultDocumentArray['resume'],'file')))
                <img class="center" src="{{asset(config('constants.files.filetypes'))}}/{{Helper::isFileExtensionForIcon(Arr::get($defaultDocumentArray['resume'],'file'))}}" >
            @else
                <img class="center" src="{{asset(config('constants.files.douments'))}}/thumbnail/{{Arr::get($defaultDocumentArray['resume'],'file')}}" >
            @endif
                <a class="" onclick="return confirm('Do you wish to remove?')" href="{{ route('document.delete',Arr::get($defaultDocumentArray['resume'], 'id'))}}"><span class="fa fa-remove"></span></a>
                <a class="downloadFile" data-filepath="{{asset(config('constants.files.douments'))}}/{{Arr::get($defaultDocumentArray['resume'],'file')}}">Download</a>
        @else
            <input type="file" name="resume" id="resume"  class="form-control uploadDocument">
        @endif
    </div>
</div>
<div id="resume_error" class="row mb-3 alert alert-danger small"  style="display:none"></div>



<h4><hr class="bg-danger border-2 border-top border-danger">Personal Documents</h4>

<div class="row mb-3 text-left" >
    <label for="Bank Statement" class="col-sm-5 col-form-label col-form-label-sm"> <img src="@if(!empty(Arr::get($defaultDocumentArray,'bank_statement'))){{asset('assets/images/icons/buttons/d1.png')}} @else {{asset('assets/images/icons/buttons/U1.png')}}  @endif" > Bank Statement</label>
    <div class="col-sm-7" id="div_bank_statement">
        @if(!empty(Arr::get($defaultDocumentArray,'bank_statement')))
            @if(Helper::isFileExtensionForIcon(Arr::get($defaultDocumentArray['bank_statement'],'file')))
                <img class="center" src="{{asset(config('constants.files.filetypes'))}}/{{Helper::isFileExtensionForIcon(Arr::get($defaultDocumentArray['bank_statement'],'file'))}}" >
            @else
                <img class="center" src="{{asset(config('constants.files.douments'))}}/thumbnail/{{Arr::get($defaultDocumentArray['bank_statement'],'file')}}" >
            @endif
                <a class="" onclick="return confirm('Do you wish to remove?')" href="{{ route('document.delete',Arr::get($defaultDocumentArray['bank_statement'], 'id'))}}"><span class="fa fa-remove"></span></a>
                <a class="downloadFile" data-filepath="{{asset(config('constants.files.douments'))}}/{{Arr::get($defaultDocumentArray['bank_statement'],'file')}}">Download</a>
        @else
            <input type="file" name="bank_statement" id="bank_statement"  class="form-control uploadDocument">
        @endif
    </div>
</div>
<div id="bank_statement_error" class="alert alert-danger small"  style="display:none"></div>

<div class="row mb-3 text-left" >
    <label for="NIC" class="col-sm-5 col-form-label col-form-label-sm"> <img src="@if(!empty(Arr::get($defaultDocumentArray,'nic'))){{asset('assets/images/icons/buttons/d1.png')}} @else {{asset('assets/images/icons/buttons/U1.png')}}  @endif" > NIC</label>
    <div class="col-sm-7" id="div_nic">
        @if(!empty(Arr::get($defaultDocumentArray,'nic')))
            @if(Helper::isFileExtensionForIcon(Arr::get($defaultDocumentArray['nic'],'file')))
                <img class="center" src="{{asset(config('constants.files.filetypes'))}}/{{Helper::isFileExtensionForIcon(Arr::get($defaultDocumentArray['nic'],'file'))}}" >
            @else
                <img class="center" src="{{asset(config('constants.files.douments'))}}/thumbnail/{{Arr::get($defaultDocumentArray['nic'],'file')}}" >
            @endif
                <a class="" onclick="return confirm('Do you wish to remove?')" href="{{ route('document.delete',Arr::get($defaultDocumentArray['nic'], 'id'))}}"><span class="fa fa-remove"></span></a>
                <a class="downloadFile" data-filepath="{{asset(config('constants.files.douments'))}}/{{Arr::get($defaultDocumentArray['nic'],'file')}}">Download</a>
        @else
        <input type="file" name="nic" id="nic" class="form-control uploadDocument">
        @endif    
    </div>
</div>
<div id="nic_error" class="alert alert-danger small"  style="display:none"></div>


@if(!empty($candidateExperienceRequiredDocments))
    <h4><hr class="bg-danger border-2 border-top border-danger">Experience Documents</h4>
    @foreach($candidateExperienceRequiredDocments as $key=>$value)
    <div class="row mb-3 text-left" >
            @php $candidateExperiences = false;  @endphp
            @if(!empty(Arr::get($dynamicDocumentsArray,'candidate_experiences')))
            @if(!empty(Arr::get($dynamicDocumentsArray['candidate_experiences'],$key)))
                @php $candidateExperiences = Arr::get($dynamicDocumentsArray['candidate_experiences'],$key); @endphp
                @endif   
            @endif 
    
            <label for="{{$value}}" class="col-sm-5 col-form-label col-form-label-sm"> <img src="@if(!empty($candidateExperiences)){{asset('assets/images/icons/buttons/d1.png')}} @else {{asset('assets/images/icons/buttons/U1.png')}}  @endif">{{$value}}</label>
            <div class="col-sm-7" id="div_{{$key}}">
               

                @if(!empty($candidateExperiences))

					@if(Helper::isFileExtensionForIcon(Arr::get($candidateExperiences,'file')))
                        <img class="center" src="{{asset(config('constants.files.filetypes'))}}/{{Helper::isFileExtensionForIcon(Arr::get($candidateExperiences,'file'))}}" >
                    @else
                        <img class="center" src="{{asset(config('constants.files.douments'))}}/thumbnail/{{Arr::get($candidateExperiences,'file')}}" >
                    @endif
                        <a class="" onclick="return confirm('Do you wish to remove?')" href="{{ route('document.delete',Arr::get($candidateExperiences, 'id'))}}"><span class="fa fa-remove"></span></a>
                        <a class="downloadFile" data-filepath="{{asset(config('constants.files.douments'))}}/{{Arr::get($candidateExperiences,'file')}}">Download</a>
                @else
                    <input type="file" name="{{$key}}" id="{{$key}}" class="form-control uploadDocument" >
                @endif      
            </div>
        </div>
        <div id="{{$key}}_error" class="alert alert-danger small"  style="display:none"></div>    
    @endforeach
@endif


@if(!empty($candidateEducationalQualificationDocments))
    <h4><hr class="bg-danger border-2 border-top border-danger">Educational Documents</h4>
    @foreach($candidateEducationalQualificationDocments as $key=>$value)
    <div class="row mb-3 text-left" >
            @php $candidateEducations = false;  @endphp
            @if(!empty(Arr::get($dynamicDocumentsArray,'candidate_educations')))
            @if(!empty(Arr::get($dynamicDocumentsArray['candidate_educations'],$key)))
                @php $candidateEducations = Arr::get($dynamicDocumentsArray['candidate_educations'],$key); @endphp
                @endif   
            @endif 
    
            <label for="{{$value}}" class="col-sm-5 col-form-label col-form-label-sm"> <img src="@if(!empty($candidateEducations)){{asset('assets/images/icons/buttons/d1.png')}} @else {{asset('assets/images/icons/buttons/U1.png')}}  @endif">{{$value}}</label>
            <div class="col-sm-7" id="div_{{$key}}">
               

                @if(!empty($candidateEducations))

					@if(Helper::isFileExtensionForIcon(Arr::get($candidateEducations,'file')))
                        <img class="center" src="{{asset(config('constants.files.filetypes'))}}/{{Helper::isFileExtensionForIcon(Arr::get($candidateEducations,'file'))}}" >
                    @else
                        <img class="center" src="{{asset(config('constants.files.douments'))}}/thumbnail/{{Arr::get($candidateEducations,'file')}}" >
                    @endif
                        <a class="" onclick="return confirm('Do you wish to remove?')" href="{{ route('document.delete',Arr::get($candidateEducations, 'id'))}}"><span class="fa fa-remove"></span></a>
                        <a class="downloadFile" data-filepath="{{asset(config('constants.files.douments'))}}/{{Arr::get($candidateEducations,'file')}}">Download</a>
                @else
                    <input type="file" name="{{$key}}" id="{{$key}}" class="form-control uploadDocument" >
                @endif      
            </div>
        </div>
        <div id="{{$key}}_error" class="alert alert-danger small"  style="display:none"></div>    
    @endforeach
@endif




<hr class="bg-danger border-2 border-top border-danger">
<div class="row mb-3 text-left">
<div class="col-sm-10 offset-sm-2">
        <div class="text-end">
            <button type="submit" class="btn btn-primary" value="Save & Continue">Save & Continue</button>  
        </div>
    </div>
</div>
</form>
<script>

$(document).ready(function() {
    $('#uploadDocumentForm').on('submit',(function(e) {
        e.preventDefault();
        $(".loader").addClass("show");
        var formData = new FormData(); //this
        var selectedFile = $('#selected').val();
        
        if(selectedFile!='')
        {
            $.each($("#"+selectedFile).prop('files'), function (key, file){
            
                formData.append('attachment', file);
            });  
            
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('selected', selectedFile);
            
            $('#'+selectedFile+'_error').hide();
            $('#'+selectedFile+'_error').html('');
            
            $.ajax({
                type:'POST',
                url: $(this).attr('action'),
                data:formData,
                cache:false,
                    contentType: false,
                processData: false,
                success:function(data){
                    $(".loader").removeClass("show");
                    if(data.errors){
                        jQuery.each(data.errors, function(key, value){
                        $('#'+selectedFile+'_error').show();
                        $('#'+selectedFile+'_error').append('<li>'+value+'</li>');
                    
                    });
                    }else{
                        if(data)
                        {
                            $("#div_"+selectedFile).html('<img class="center" src="'+data.diaplay_image_path+'" > <a onclick="return confirm(\'Do you wish to remove?\')" href="'+data.url+'"><span class="fa fa-remove"></span></a>&nbsp;<a class="downloadFile" data-filepath="'+data.file_path+'">Download</a>');
                            $("#img_upload_"+selectedFile).attr('src',"{{asset('assets/images/icons/buttons/')}}/d1.png")
                        }
                    }
                    
                },
                error: function(data){
                    $(".loader").removeClass("show");
                    $('#'+selectedFile+'_error').show();
                    $('#'+selectedFile+'_error').html('Unable to process request. Please refresh the page and try again!!');
                    
                }
            });
        }else
        {
            window.location.href = "{{ route('upload.documents.mark.saved') }}";
        }    

        $('.uploadDocument').val('');
        $('#selected').val('');
        $('#selected_table').val('');     
    }));


    //On change file

    $(".uploadDocument").on("change", function() {
        $('#selected').val(''); 

        var selected        = $(this).attr('name');
    
        $('#selected').val(selected);     
        $("#uploadDocumentForm").submit();
        
    });


    $(document).on('click', '.downloadFile', function (e) {
            e.preventDefault();  //stop the browser from following
    
            var filepath = $(this).attr('data-filepath');
            window.open(filepath , '_blank');
        });


});



</script>


@endsection