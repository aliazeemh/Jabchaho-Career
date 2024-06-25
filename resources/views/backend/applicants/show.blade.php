@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded mb-4">
        <h2>Applicant Detail</h2>
        <div class="lead">
            
        </div>
        
        <div class="container mt-4">
            
            <div>
                <strong>Job Title:</strong> {{ Arr::get($job, 'title') }}
            </div>
            <div>
                <strong>Name:</strong> {{ Arr::get($applicant, 'full_name') }}
            </div>
            <div>
                <strong>Email:</strong> {{ Arr::get($applicant, 'email') }}
            </div>
            <div>
                <strong>Phone:</strong> {{ Arr::get($applicant, 'phone') }}
            </div>
            <div>
            <strong>Date of Application:</strong> {{ date("d-m-Y", strtotime(Arr::get($applicant, 'created_at'))) }}
            </div>
            <div>
                <strong>Resume:</strong>
            </div>
            <div>
                @if(Arr::get($resume, 'file'))
                    @if(Helper::isFileExtensionForIcon(Arr::get($resume,'file')))
                        <img  src="{{asset(config('constants.files.filetypes'))}}/{{Helper::isFileExtensionForIcon(Arr::get($resume,'file'))}}"  />
                    @endif
                    <a class="downloadFile" data-filepath="{{asset(config('constants.files.douments'))}}/{{Arr::get($resume,'file')}}">Download</a>
                @endif
            </div>
           
        </div>

    </div>


<div class="card">
  <div class="card-header">Comment History</div>
  <div class="card-body">    
        @if(Auth::user()->can('applicants.comment'))
            <div class="col mt-4">
                <form class="py-2 px-4" action="{{ route('applicants.comment', $applicant->id) }}" style="box-shadow: 0 0 10px 0 #ddd;" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" name="applicant_id" value="{{ Arr::get($applicant,'id')}}">
                    
                    <div class="row mb-3">
                        <label for="applicant_status_id" class="form-label">Status</label>
                    
                        <select class="form-control form-control-sm" id="applicant_status_id"  name="applicant_status_id" >
                            <option value=''>Select Status</option>
                            @if(!empty($applicantsStatuses) )
                                @foreach($applicantsStatuses as $applicantsStatus)
                                    @if(old('applicant_status_id') == Arr::get($applicantsStatus, 'id'))
                                        <option value="{{ trim(Arr::get($applicantsStatus, 'id')) }}" selected>{{trim(Arr::get($applicantsStatus, 'name'))}}</option> 
                                    @elseif(old('_token') == null && !empty(Arr::get($applicant, 'applicant_status_id')) &&  (Arr::get($applicant, 'applicant_status_id')== Arr::get($applicantsStatus, 'id'))  )
                                        <option value="{{ trim(Arr::get($applicantsStatus, 'id')) }}" selected>{{trim(Arr::get($applicantsStatus, 'name'))}}</option> 
                                    @else
                                        <option  value="{{trim(Arr::get($applicantsStatus, 'id'))}}" >{{trim(Arr::get($applicantsStatus, 'name'))}}</option>
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

        @if(!empty($applicantComments))
    
            @foreach($applicantComments as $applicantComment)
                <div class="container">
                    <div class="row">
                        <div class="col mt-4">
                            <div class="py-2 px-2" style="box-shadow: 0 0 10px 0 #ddd;">
                                <div class="row">
                                    <div class="col-sm-12"><strong>{{ ucwords(Arr::get($applicantComment->user,'name'))}}</strong> <small>| @if(!empty(Arr::get($applicantComment, 'created_at'))){{ date("M d, Y H:i:s", strtotime(Arr::get($applicantComment, 'created_at'))) }}@endif | {{ Arr::get($applicantComment->applicantStatus,'name') }} </small></div>
                                </div>
                                <p class="font-weight-bold ">{{ Arr::get($applicantComment,'comment')}}</p>
                                @if(Auth::user()->hasRole('admin'))
                        
                                {!! Form::open(['method' => 'DELETE','route' => ['applicants.commentDestroy', $applicantComment->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
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
    <a href="{{ route('applicants.index') }}" class="btn btn-info btn-sm">Back</a>
</div>



<script>
$(document).ready(function() {

    $(document).on('click', '.downloadFile', function (e) {
            e.preventDefault();  //stop the browser from following
    
            var filepath = $(this).attr('data-filepath');
            window.open(filepath , '_blank');
    });
});


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
