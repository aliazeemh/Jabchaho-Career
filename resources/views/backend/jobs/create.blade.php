@extends('backend.layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Add Job</h2>
        <div class="lead">
            Add Job
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('jobs.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input value="{{ old('title') }}" 
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
                                @else
                                    <option  value="{{trim(Arr::get($jobType, 'id'))}}" >{{trim(Arr::get($jobType, 'name'))}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label for="responsibility" class="form-label">Responsibilities</label>
                
                    <textarea class="form-control content" 
                        id="responsibility"
                        name="responsibility" 
                        placeholder="responsibility" >{{ old('responsibility') }}</textarea>

              
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label">Requirements</label>
                    <textarea class="form-control content" 
                        id="requirement"
                        name="requirement" 
                        placeholder="requirement" >{{ old('requirement') }}</textarea>

             
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input value="{{ old('start_date') }}" 
                        type="date" 
                        class="form-control" 
                        name="start_date"
                        placeholder="Start Date" >

             
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label">End Date</label>
                    <input value="{{ old('end_date') }}" 
                        type="date" 
                        class="form-control" 
                        name="end_date"
                        placeholder="End Date" >

             
                </div>

                <div class="mb-3">
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
                

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('jobs.index') }}" class="btn btn-default">Back</a>
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