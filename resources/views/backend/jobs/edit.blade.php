@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Update Job</h2>
        <div class="lead">
            Edit Job.
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('jobs.update', $job->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input value="@if(old('title')){{old('title')}}@elseif(empty(old('title')) && old('_token')) {{''}}@else{{Arr::get($job,'title')}}@endif" 
                        type="text" 
                        class="form-control" 
                        name="title"
                        maxlength="200" 
                        placeholder="Title" >

                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">City</label>
                    <select class="form-control" id="city"  name="city_id" rel="{{old('city_id')}}" >
                        <option value="">Select City</option>
                        @if(!empty($cities) )
                            @foreach($cities as $key =>$value)
                                @if(old('city_id') == $key)
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                @elseif($key==(Arr::get($job,'city_id')) && empty(old('pak_city')) )
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                @else
                                    <option  value="{{trim($key)}}" > {{trim($value)}} </option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="area_of_interest_option_id">Category:</label>        
                        <select class="form-control c-select" id="area_of_interest_option_id"  name="area_of_interest_option_id" rel="{{old('area_of_interest_option_id')}}" >
                            <option value=''>Select Category</option>
                            @if(!empty($areaOfInterests) )
                                
                                @php $groupName = ''; @endphp
                                @foreach($areaOfInterests as $object)
                                    
                                    @if ($groupName != $object['group_name'])
                                            <optgroup label="{{$object['group_name']}}">
                                            @php $groupName = $object['group_name']; @endphp
                                    @endif
                                
                                    @if (old('area_of_interest_option_id') == $object['id'])
                                        <option value="{{ trim($object['id']) }}" selected>{{trim($object['name'])}} </option>
                                    @elseif(Arr::get($job,'area_of_interest_option_id') == $object['id'] )
                                    <option value="{{ trim($object['id']) }}" selected>{{trim($object['name'])}} </option>
                                    @else
                                        <option  value="{{ trim($object['id']) }}" > {{trim($object['name'])}} </option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Job type</label>
                    <select class="form-control" id="job_type_id"  name="job_type_id" rel="{{old('job_type_id')}}" >
                        <option value="">Select Job type</option>
                        @if(!empty($jobTypes) )
                            @foreach($jobTypes as $jobType)
                                @if(old('job_type_id') == Arr::get($jobType, 'id'))
                                    <option value="{{ trim(Arr::get($jobType, 'id')) }}" selected>{{trim(Arr::get($jobType, 'name'))}}</option> 
                                @elseif(Arr::get($job,'job_type_id') == Arr::get($jobType, 'id') )
                                    <option value="{{ trim(Arr::get($jobType, 'id')) }}" selected>{{trim(Arr::get($jobType, 'name'))}}</option> 
                                @else
                                    <option  value="{{trim(Arr::get($jobType, 'id'))}}" >{{trim(Arr::get($jobType, 'name'))}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label for="responsibility" class="form-label">Responsibilities</label>
                
                    <textarea
                        type="text" 
                        class="form-control content" 
                        name="responsibility" 
                        placeholder="Responsibilities" >@if(old('responsibility')){{old('responsibility')}}@elseif(empty(old('responsibility')) && old('_token')) {{''}}@else{{Arr::get($job,'responsibility')}}@endif</textarea>    

                    
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Requirements</label>
                    <textarea
                        type="text" 
                        class="form-control content" 
                        name="requirement" 
                        placeholder="Requirements" >@if(old('requirement')){{old('requirement')}}@elseif(empty(old('requirement')) && old('_token')) {{''}}@else{{Arr::get($job,'requirement')}}@endif</textarea>

                    
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input value="@if(old('start_date')){{old('start_date')}}@elseif(empty(old('start_date')) && old('_token')) {{''}}@else{{Arr::get($job,'start_date')}}@endif" 
                        type="date" 
                        class="form-control" 
                        name="start_date"
                        placeholder="Start Date" >

             
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label">End Date</label>
                    <input value="@if(old('end_date')){{old('end_date')}}@elseif(empty(old('end_date')) && old('_token')) {{''}}@else{{Arr::get($job,'end_date')}}@endif" 
                        type="date" 
                        class="form-control" 
                        name="end_date"
                        placeholder="End Date" >

             
                </div>

                <div class="mb-5">
                <input type="checkbox" class="form-check-input" id="checkAll"><label for="Benefits" class="form-label">Benefits</label>
                   
                        @if(!empty($jobBenefits))
                            <div style=" overflow-y:scroll; height:150px">
                            @foreach($jobBenefits as $key =>$value)
                                <div>
                                    <input class="form-check-input checkboxClass"  type="checkbox" id="job_benefit_id-{{Arr::get($value, 'id')}}" name="job_benefit_id[]" value="{{Arr::get($value, 'id')}}" 
                                
                                    @if(is_array(old('job_benefit_id')) && !empty(old('job_benefit_id')))
                                        {{ (is_array(old('job_benefit_id')) && in_array(Arr::get($value, 'id'), old('job_benefit_id'))) ? ' checked' : '' }} 
                                    @elseif(empty(old('job_benefit_id')) && old('_token'))
                                        {{''}}
                                    @else
                                        @if(!empty($jobPostedBenefits))
                                            @foreach($jobPostedBenefits as $row)
                                                @if(Arr::get($row, 'job_benefit_id'))  
                                                    {{ Arr::get($row, 'job_benefit_id') == Arr::get($value, 'id') ? 'checked' : '' }} 
                                                @endif
                                            @endforeach
                                        @endif 
                                    @endif   
                                    >
                                    
                                    <label class="form-check-label col-form-label-sm" for="job_benefit_id-{{Arr::get($value, 'id')}}">
                                        {{Arr::get($value, 'name')}}
                                    </label>
                                </div>
                            @endforeach
                            </div>
                        @endif
                    
                </div>
                <div class="form-group row mt-4">
                    <label for="job_status_id" class="form-label">Comment</label>
                    <textarea class="form-control" name="comment" rows="3" cols="50" placeholder="Enter your comment here..." >@if(old('comment')){{old('comment')}}@elseif(empty(old('comment')) && old('_token')) {{''}} @endif</textarea>
                </div>
                <div class="mb-1">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <a href="{{ route('jobs.index') }}" class="btn btn-default">Back</a>
                </div>
            </form>
        </div>

    </div>

<link href="{!! url('assets/bootstrap/css/bootstrap_3.4.1.min.css') !!}" rel="stylesheet">
<link href="{!! url('assets/css/summernote.min.css') !!}" rel="stylesheet">
<script src="{!! url('assets/js/summernote.min.js') !!}"></script>
<script>
$( document ).ready(function() {
    
    $('.content').summernote({

    height:300,

    });

    //check "select all" if all checkbox items are checked
    if ($('.checkboxClass:checked').length == $('.checkboxClass').length ){
		$("#checkAll").prop('checked', true);
	}


    //select all checkboxes
    $("#checkAll").change(function(){  //"select all" change 
        $(".checkboxClass").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
    });

    //".checkbox" change 
    $('.checkboxClass').change(function(){ 
        //uncheck "select all", if one of the listed checkbox item is unchecked
        if(false == $(this).prop("checked")){ //if this item is unchecked
            $("#checkAll").prop('checked', false); //change "select all" checked status to false
        }
        //check "select all" if all checkbox items are checked
        if ($('.checkboxClass:checked').length == $('.checkboxClass').length ){
            $("#checkAll").prop('checked', true);
        }
    });



});

</script>   
@endsection