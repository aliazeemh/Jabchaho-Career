@extends('frontend.layouts.app-profile')
@section('title', 'Portfolio')
@section('content')

<div class="card-title"><img src="{{asset('assets/images/banners/portfolio.jpg')}}" ></div>
<form id="portfolioForm" enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('portfolio.perform') }}" autocomplete="off">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <div @if(!empty( Arr::get(Auth::guard('candidate')->user(), 'is_portfolio_saved') )) style="display:none"; @endif  >
        <p class="text-start"><small>Please provide us details of your portfolio</small></p>
        <p class="text-start">
                <small>Do you have a portfolio?</small>

                @if(!empty($booleanOptions))
                    @foreach($booleanOptions as $key=>$value)
                        <input class="form-check-input portfolioRadio" type="radio" name="is_portfolio_saved" id="portfolio-{{$key}}" value="{{$key}}" 
                        @if((old('_token') && old('is_portfolio_saved') == $key)) 
                            {{'checked'}}
                        @elseif(old('_token') == null && Arr::get(Auth::guard('candidate')->user(), 'is_portfolio_saved'))  
                            {{ Arr::get(Auth::guard('candidate')->user(), 'is_portfolio_saved') == $key ? 'checked' : '' }} 
                        @else 
                        @if(old('_token') == null && $key==0)
                                {{'checked'}}
                            @endif
                        @endif    
                    
                        >
                        <label class="form-check-label" for="portfolio-{{$key}}">{{$value}}</label>
                    @endforeach
                @endif   
                
                @if($errors->has('is_portfolio_saved'))
                    <div class="text-danger">{{ $errors->first('is_portfolio_saved') }}</div>
                @endif
        </p>
    </div>   

    <div id="div-portfolio-form" style="display:block;">
        <h4><hr class="bg-danger border-2 border-top border-danger">Portfolio</h4>
            <div class="alert alert-danger small"  id="img-error"   style="display:none"></div>
            <div class="alert alert-success small" id="img-success" style="display:none"></div>  
            
            <div class="savedFiles">
                @if($candidateAttachments)
                    @foreach($candidateAttachments as $candidateAttachment)
                   
                        @if(Helper::isFileExtensionForIcon(Arr::get($candidateAttachment,'file')))
                        <img class="center" src="{{asset(config('constants.files.filetypes'))}}/{{Helper::isFileExtensionForIcon(Arr::get($candidateAttachment,'file'))}}" >
                        @else
                            <img class="center" src="{{asset(config('constants.files.portfolio'))}}/thumbnail/{{Arr::get($candidateAttachment,'file')}}" >
                        @endif
                        <a class="" onclick="return confirm('Do you wish to remove?')" href="{{ route('attachment.delete',Arr::get($candidateAttachment, 'id'))}}"><span class="fa fa-remove"></span></a>
                        <a class="downloadFile" data-filepath="{{asset(config('constants.files.portfolio'))}}/{{Arr::get($candidateAttachment,'file')}}">Download</a>
                    @endforeach
                @endif
            </div>  
            
            <div class="row mb-3 text-left">
                <label for="" class="col-sm-3 col-form-label col-form-label-sm">Attach Files</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" name="attachment[]" type="file" id="formFileMultiple" multiple />
                </div>
            </div>

        <div class="row mb-3 text-left">
            <label for="" class="col-sm-3"></label>
            <div class="col-sm-9 col-form-label col-form-label-sm" data-bs-toggle="tooltip" data-bs-placement="bottom" title=".jpeg, .jpg, .png, .gif, .bmp, .psd, .doc, .docx, .xls, .xlsx, .zip, .rar, .ppt, .pptx, .pdf, .mp3">
                View Supported file formats
            </div>
            
        </div>

        <h4><hr class="bg-danger border-2 border-top border-danger"> Add Urls</h4>

        <div class="row mb-3 parentDiv">
            <div class="col-sm-12" >
                 
                @if(!empty(old('title')) || !empty(old('url'))) 
                    
                    @foreach(old('title') as $key=>$value)
                        @if(!empty(old('title')[$key]) || !empty(old('url')[$key]))
                            <div class="row multi-field">
                                <div class="col-sm-5" >
                                    <input type="text" class="form-control form-control-sm" placeholder="Title" maxlength="200" id="" name="title[]" value="{{old('title')[$key]}}">
                                    @if($errors->has('title.*'))
                                        <div class="text-danger">{{ $errors->first('title.*') }}</div>
                                    @endif
                                </div>
                                <div class="col-sm-6" >
                                    <input type="text" class="form-control form-control-sm" placeholder="URL" maxlength="500" id="" name="url[]" value="{{old('url')[$key]}}">
                                    @if($errors->has('url.*'))
                                        <div class="text-danger">{{ $errors->first('url.*') }}</div>
                                    @endif
                                </div>
                                <div class="col-sm-1 minusDiv" style="display:block" id="minusDiv">
                                    <button class="btn btn-small btn-secondary remove-field" type="button"  style="padding: 1px 6px;">
                                        <img src="{{asset('assets/images/icons/buttons/minus.jpg')}}" >
                                    </button>
                                </div>  
                                
                            </div>
                        @endif
                    @endforeach

                @elseif(!empty($candidatePortfolioDetail))     
                    @foreach($candidatePortfolioDetail as $row)
                        <div class="row multi-field">
                            <div class="col-sm-5" >
                                <input type="text" class="form-control form-control-sm" placeholder="Title" maxlength="200" id="" name="title[]" value="{{Arr::get($row, 'title')}}">
                                @if($errors->has('title.*'))
                                    <div class="text-danger">{{ $errors->first('title.*') }}</div>
                                @endif
                            </div>
                            <div class="col-sm-6" >
                                <input type="text" class="form-control form-control-sm" placeholder="URL" maxlength="500" id="" name="url[]" value="{{Arr::get($row, 'url')}}">
                                @if($errors->has('url.*'))
                                    <div class="text-danger">{{ $errors->first('url.*') }}</div>
                                @endif
                            </div>
                            <div class="col-sm-1 minusDiv" style="display:block" id="minusDiv">
                                <button class="btn btn-small btn-secondary remove-field" type="button"  style="padding: 1px 6px;">
                                    <img src="{{asset('assets/images/icons/buttons/minus.jpg')}}" >
                                </button>
                            </div>  
                            
                        </div>
                    @endforeach
                @endif

                <div class="row multi-field">
                    <div class="col-sm-5" >
                        <input type="text" class="form-control form-control-sm" placeholder="Title" maxlength="200" id="" name="title[]" value="">
                    </div>
                    <div class="col-sm-6" >
                        <input type="text" class="form-control form-control-sm" placeholder="URL" maxlength="500" id="" name="url[]" value="">
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
            </div>
            
        </div>
       
    
    </div>

    <hr class="bg-danger border-2 border-top border-danger">
    <div class="row mb-3 text-left">
        <div class="col-sm-10 offset-sm-2">
            <div class="text-end">
                <button type="submit" id="submitPortFolio" class="btn btn-primary" value="submit">Save</button>  
            </div>
        </div>
    </div>


    

</form>


<script>


    $(document).on('click', '.add-field', function () {
        var html = $(".multi-field").first().clone();
        $(html).find('input').val('').focus();
        $(html).find(".plusDiv").remove();
        $(html).find(".minusDiv").show();

        $(".multi-field").last().before(html);
     
    });


    $(document).on('click', '.remove-field', function () {

        if($(this).closest('.multi-field').find(".plusDiv").length==0){

            $(this).closest('.multi-field').remove();
        }

        
    });


    //downloadFile
        $(document).on('click', '.downloadFile', function (e) {
            e.preventDefault();  //stop the browser from following
    
            var filepath = $(this).attr('data-filepath');
            window.open(filepath , '_blank');
        });

    $(document).ready(function (e) {

        showHidePortfolioForm();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
    
        var isFileUploadOnly = false;
        $("#formFileMultiple").on("change", function() {
            isFileUploadOnly = true;
            $("#portfolioForm").submit();
        });


        $("#submitPortFolio").on("click", function() {
            isFileUploadOnly = false;
        });
        
        //$('#portfolioFilesForm').submit(function(e) {
        $('#portfolioForm').on('submit',(function(e) {    

            

            if(isFileUploadOnly)
            {
                e.preventDefault();
                $(".loader").addClass("show");

                var formData = new FormData(this);
                let TotalFiles = $('#formFileMultiple')[0].files.length; //Total files
                let files = $('#formFileMultiple')[0];
                for (let i = 0; i < TotalFiles; i++) {
                    formData.append('files' + i, files.files[i]);
                }
                formData.append('TotalFiles', TotalFiles);

                $('#img-error').hide();
                $('#img-error').html('');

                $.ajax({
                    type:'POST',
                    url: "{{route('portfolio.attachments.upload')}}",//$(this).attr('action'),
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success:function(data){
                        $(".loader").removeClass("show");
                    if(data.errors){
                        jQuery.each(data.errors, function(key, value){
                        $('#img-error').show();
                        $('#img-error').append('<li>'+value+'</li>');
                    
                    });
                    }else{
                    
                        if(data)
                        {
                            $.each(data, function(i, obj){
                                $(".savedFiles").last().append('<img class="center" src="'+obj.diaplay_image_path+'" > <a onclick="return confirm(\'Do you wish to remove?\')" href="'+obj.url+'"><span class="fa fa-remove"></span></a>&nbsp;<a class="downloadFile" data-filepath="'+obj.file_path+'">Download</a>');
                            }); 
                        }
                    }
                    
                },
                error: function(data){
                    $(".loader").removeClass("show");
                    $('#img-error').show();
                    $('#img-error').html('Unable to process request. Please refresh the page and try again!!');
                    
                }
                });

                $('#formFileMultiple').val('');

            }else{
                return true;
            }
           
        
 
    }));

       

        $(".portfolioRadio").change(function(){
            showHidePortfolioForm();
        });
    });
   

    


    function showHidePortfolioForm(){
        let isPortfolioSaved = $('input[name="is_portfolio_saved"]:checked').val();
        
        if(isPortfolioSaved==1){
            $('#div-portfolio-form').show();
        }else{
            $('#div-portfolio-form').hide();      }
            
        }
</script>    
@endsection