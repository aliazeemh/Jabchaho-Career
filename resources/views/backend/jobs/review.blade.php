@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Review Job</h2>
        <div class="lead">
            Review Job & update Status.
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
                    <label for="Benefits" class="form-label">Benefits</label>
                   
                        @if(!empty($jobBenefits))
                            <div style=" overflow-y:scroll; height:150px">
                            @foreach($jobBenefits as $key =>$value)
                                <div>
                                    <input class="form-check-input"  type="checkbox" id="job_benefit_id-{{Arr::get($value, 'id')}}" name="job_benefit_id[]" value="{{Arr::get($value, 'id')}}" 
                                
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

                <div class="row mb-3">
                    <label for="job_status_id" class="form-label">Status</label>
                   
                        <select class="form-control form-control-sm" id="job_status_id"  name="job_status_id" >
                            <option value=''>Select Status</option>
                            @if(!empty($jobStatuses) )
                                @foreach($jobStatuses as $jobStatus)
                                    @if(old('job_status_id') == Arr::get($jobStatus, 'id'))
                                        <option value="{{ trim(Arr::get($jobStatus, 'id')) }}" selected>{{trim(Arr::get($jobStatus, 'name'))}}</option> 
                                    @elseif(old('_token') == null && !empty(Arr::get($job, 'job_status_id')) &&  (Arr::get($job, 'job_status_id')== Arr::get($jobStatus, 'id'))  )
                                        <option value="{{ trim(Arr::get($jobStatus, 'id')) }}" selected>{{trim(Arr::get($jobStatus, 'name'))}}</option> 
                                    @else
                                        <option  value="{{trim(Arr::get($jobStatus, 'id'))}}" >{{trim(Arr::get($jobStatus, 'name'))}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                </div>

                <div class="row mb-3">
                    <label for="comment" class="form-label">Comments</label>
                    <div class="col">
                            <textarea class="form-control" name="comment" rows="3" cols="50" placeholder="Enter your Comments here..." ></textarea>
                    </div>
                </div>

                

                <button type="submit" class="btn btn-primary">Save changes</button>
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

});

</script>   
@endsection