@extends('frontend.layouts.app-profile')
@section('title', 'Diploma')
@section('content')

<div class="card-title"><img src="{{asset('assets/images/banners/diploma.jpg')}}" ></div>
@if(!empty($diplomaAllData))
        <div id="myCarousel" class="carousel slide profile jabchaho ideas" data-ride="carousel" data-interval="0">
           <!-- Wrapper for carousel items -->
			<div class="carousel-inner">
                <div class="item carousel-item active">
                    <div class="row">
                        @php $counter=0;@endphp
                        @foreach($diplomaAllData as $row)
                       
                            <div class="col-sm mydivouter">
                            <a class="mybuttonoverlap " onclick="return confirm('Do you wish to remove Diploma?')" href="{{ route('diploma.delete',Arr::get($row, 'id'))}}"><span class="fa fa-remove"></span></a>
                                <a class="myref" href="{{ route('diploma.show')}}/{{Arr::get($row, 'id')}}">
                                    <p class="card-text">{{Arr::get($row, 'institute_name')}}</p>
                                    <p class="card-text">{{Arr::get($row, 'diploma_title')}}</p>
                                    <p class="card-text">
                                            {{ date("M Y", strtotime(Arr::get($row, 'from'))) }}
                                            -
                                            @if(Arr::get($row, 'is_in_progress'))
                                            {{'Present'}}
                                            @else
                                            {{ date("M Y", strtotime(Arr::get($row, 'to'))) }}
                                            @endif
                                    </p>
                                   
                                </a>
                            </div>
                            
                            
                            @php $counter++; @endphp
                            @if($counter %3==0)
                                @if($counter != count($diplomaAllData))
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

        @if(count($diplomaAllData)>3)
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
<form class="form-horizontal" method="post" action="{{ route('diploma.perform') }}" autocomplete="off">

@if(!empty(Arr::get($diplomaData, 'id')))
    @method('put')
@endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="id" value="{{ Arr::get($diplomaData, 'id','') }}" />
    @if($errors->has('id'))
        <div class="text-danger">{{ $errors->first('id') }}</div>
    @endif

    <div @if(!empty($diplomaAllData)) style="display:none"; @endif  >
        <p class="text-start"><small>Please provide us details of your diplomas</small></p>
        <p class="text-start">
                <small>Do you have any diplomas?</small>
                
                @if(!empty($booleanOptions))
                    @foreach($booleanOptions as $key=>$value)
                        <input class="form-check-input diplomaRadio" type="radio" name="is_diplomas_saved" id="diploma-{{$key}}"  value="{{$key}}" 
                        @if((old('_token') && old('is_diplomas_saved') == $key)) 
                            {{'checked'}}
                        @elseif(old('_token') == null && Arr::get(Auth::guard('candidate')->user(), 'is_diplomas_saved'))  
                            {{ Arr::get(Auth::guard('candidate')->user(), 'is_diplomas_saved') == $key ? 'checked' : '' }} 
                        @else 
                        @if(old('_token') == null && $key==0)
                                {{'checked'}}
                            @endif
                        @endif    
                    
                        >
                        <label class="form-check-label" for="diploma-{{$key}}">{{$value}}</label>
                    @endforeach
                @endif

                @if($errors->has('is_diplomas_saved'))
                    <div class="text-danger">{{ $errors->first('is_diplomas_saved') }}</div>
                @endif
        </p>
    </div>    
    <div id="div-diploma-form" style="display:block;">
        <h4><hr class="bg-danger border-2 border-top border-danger">Diploma Details</h4>


        <!-- Select2 for institutes -->
        {!! Helper::select2Fields($diplomaData,$errors,$instituteParam) !!}

        <div class="row mb-3">
            <label for="DiplomaTitle" class="col-sm-3 col-form-label col-form-label-sm">Diploma Title<span style="color: red"> * </span></label>
            <div class="col-sm-9 text-left">
                <input type="text" class="form-control form-control-sm" maxlength="100" id="DiplomaTitle" name="diploma_title" value="@if(old('diploma_title')){{old('diploma_title')}}@elseif(empty(old('diploma_title')) && old('_token')) {{''}}@else{{Arr::get($diplomaData,'diploma_title')}}@endif">
                @if($errors->has('diploma_title'))
                    <div class="text-danger">{{ $errors->first('diploma_title') }}</div>
                @endif
            </div>
        </div>


        <!-- Field of study using select2 -->
        {!! Helper::select2Fields($diplomaData,$errors,$fieldOfStudyParam) !!}

        <div class="row mb-3 duration">
            <label for="Duration" class="col-sm-3 col-form-label col-form-label-sm">Duration<span style="color: red"> * </span></label>
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
                                            @elseif(old('_token') == null && !empty(Arr::get($diplomaData, 'from')) &&  date("m", strtotime(Arr::get($diplomaData, 'from')))== $key  )
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
                                        @elseif(old('_token') == null && !empty(Arr::get($diplomaData, 'from')) &&  date("Y", strtotime(Arr::get($diplomaData, 'from')))==  $i   )
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
                    <label> <span class="w50px">To:</span>     
                        <span id="toDiv" style="display: contents;">
                            <div class="col-sm-4">
                                    
                                <select class="form-control form-control-sm" id="to_months"  name="to_months" >
                                    <option value=''>Month</option>
                                    @if(!empty($months) )
                                        @foreach($months as $key =>$value)
                                            @if(old('to_months') == $key)
                                                <option value="{{ trim($key) }}" selected>{{trim($value)}}</option> 
                                            @elseif(old('_token') == null && !empty(Arr::get($diplomaData, 'to')) &&  date("m", strtotime(Arr::get($diplomaData, 'to')))== $key  )
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
                                            @elseif(old('_token') == null && !empty(Arr::get($diplomaData, 'to')) &&  date("Y", strtotime(Arr::get($diplomaData, 'to')))==  $i   )
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
        <div class="row mb-3">
            <div class="col-sm-10 offset-sm-2">
                <div class="text-end">
                    <input class="form-check-input" type="checkbox" id="isInProgress" name="is_in_progress" value="1" 
                    @if((old('_token') && old('is_in_progress') != null) || (old('_token') == null && Arr::get($diplomaData, 'is_in_progress')))    
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
    showHideDiplomaeForm();

    enabledAndDisabledDurationTo();

    //Insitute Names Search
    select2Fields('institute_name', 'Enter Your Institute', "{{route('institute.search')}}");

    //Field Of Study Search
    select2Fields('field_of_study', 'Enter Your Field Of Study', "{{route('field.search')}}");
});


$(".diplomaRadio").change(function(){
    showHideDiplomaeForm();
});    


function showHideDiplomaeForm(){
      let isDiplomasSaved = $('input[name="is_diplomas_saved"]:checked').val();
      
      if(isDiplomasSaved==1){
        $('#div-diploma-form').show();
      }else{
        $('#div-diploma-form').hide();      }
        
    }


    $('#isInProgress').click(function() {
        enabledAndDisabledDurationTo();
    });
    function enabledAndDisabledDurationTo()
    {
        if($('#isInProgress').is(":checked")){
  
            $("#to_months").prop("disabled", true);
            $("#to_year").prop("disabled", true);
  
        }else{
       
            $("#to_months").prop("disabled", false);  
            $("#to_year").prop("disabled", false);  
           
  
        }
    }
</script>
    
   


@endsection