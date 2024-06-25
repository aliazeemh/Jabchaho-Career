@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded mb-4">
        <h2>Job Detail</h2>
        <div class="lead">
            
        </div>
        
        <div class="container mt-4">
            <div>
                <strong>Status:</strong> {{ Arr::get($jobStatusName, 'name') }}
            </div>
            <div>
                <strong>Title:</strong> {{ Arr::get($job, 'title') }}
            </div>
            <div>
                <strong>City:</strong> {{ $jobcityName }}
            </div>
            <div>
                <strong>Responsibilities:</strong> {!! Arr::get($job, 'responsibility') !!}
            </div>
            <div>
                <strong>Requirements:</strong> {!! Arr::get($job, 'requirement') !!}
            </div>
            <div>
                <strong>Start Date:</strong> {{ date('M d, Y',strtotime(Arr::get($job, 'start_date'))) }}
            </div>
            <div>
                <strong>End Date:</strong> {{ date('M d, Y',strtotime(Arr::get($job, 'end_date'))) }}
            </div>
            <div>
                <strong>Benefits:</strong>
                   
                    @if(!empty($jobPostedBenefits))
                        <ul>
                        @foreach($jobPostedBenefits as $jobPostedBenefit)
                            <li> {{ Arr::get($jobPostedBenefit->jobBenefit, 'name') }}</li> 
                        @endforeach
                        </ul>
                    @endif
            </div>
           
        </div>

    </div>





<div class="card">
  <div class="card-header">
    Comment History
  </div>
  <div class="card-body">
        
    @if(Auth::user()->can('jobs.comment'))
        <div class="col mt-4">
            <form class="py-2 px-4" action="{{ route('jobs.comment', $job->id) }}" style="box-shadow: 0 0 10px 0 #ddd;" method="POST" autocomplete="off">
                @csrf
                <input type="hidden" name="job_id" value="{{ Arr::get($job,'id')}}">
                
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
                
                <div class="form-group row mt-4">
                    <label for="job_status_id" class="form-label">Comment</label>
                    <textarea class="form-control" name="comment" rows="3" cols="50" placeholder="Enter your comment here..." >@if(old('comment')){{old('comment')}}@elseif(empty(old('comment')) && old('_token')) {{''}} @endif</textarea>
                </div>
                <div class="mt-3 text-end">
                    <button class="btn btn-sm py-2 px-3 btn-info">Submit</button>
                </div>
            </form>
        </div>

    @endif


        @if(!empty($jobComments))
    
            @foreach($jobComments as $jobComment)
                <div class="container">
                    <div class="row">
                        <div class="col mt-4">
                            <div class="py-2 px-2" style="box-shadow: 0 0 10px 0 #ddd;">
                                <div class="row">
                                    <div class="col-sm-12"><strong>{{ ucwords(Arr::get($jobComment->user,'name'))}}</strong> <small>| @if(!empty(Arr::get($jobComment, 'created_at'))){{ date("M d, Y", strtotime(Arr::get($jobComment, 'created_at'))) }}@endif | {{ Arr::get($jobComment->jobStatus,'name') }} </small></div>
                                </div>
                                <p class="font-weight-bold ">{{ Arr::get($jobComment,'comment')}}</p>
                                @if(Auth::user()->hasRole('admin'))
                        
                                {!! Form::open(['method' => 'DELETE','route' => ['jobs.commentDestroy', $jobComment->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                                {!! Form::submit('Remove', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                                
                                @endIf
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    
  </div><!--//card body-->
</div> <!--//card-->




<div class="mt-4">
    
    @if(Auth::user()->can('jobs.edit'))    
        <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-primary btn-sm">Edit</a>
    @endif
    
    <a href="{{ route('jobs.index') }}" class="btn btn-info btn-sm">Back</a>
</div>

<script>
function ConfirmDelete()
{
    var x = confirm("Are you sure you want to delete?");
    if (x) {
        return true;
    }
    else {

        event.preventDefault();
        return false;
    }
}  
</script>

@endsection
