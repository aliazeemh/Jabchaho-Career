@extends('backend.layouts.app-master')

@section('content')
    
    <div class="bg-light p-4 rounded">
        <h2>Jobs</h2>
        <div class="lead mb-3">
            Manage your Jobs here.
            
            @if(Auth::user()->can('jobs.create'))
            <a href="{{ route('jobs.create') }}" class="btn btn-primary btn-sm float-right">Add Job</a>
            @endif
                 
        </div>

        <form class="form-inline" method="GET">
       
       <div class="row mb-3" >
           <div class="col-sm-3">
           <input type="hidden" id="dashboardFilter" placeholder="dashboardFilter" name="dashboard_filter" maxlength="50" value="{{ $dashboardFilter}}">         
           <input type="text" autocomplete="off" class="form-control form-control-sm" id="title" placeholder="Enter Title" name="title" maxlength="50" value="{{ $title}}">
           </div>
           <div class="col-sm-3">
                <select class="form-control form-control-sm" id="city"  name="city_id" >
                    <option value="">Select City</option>
                    @if(!empty($cities) )
                        @foreach($cities as $key =>$value)
                            @if($cityId == $key)
                                <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                            @else
                                <option  value="{{trim($key)}}" > {{trim($value)}} </option>
                            @endif
                        @endforeach
                    @endif
                </select>
           </div> 
           <div class="col-sm-3">
                <select class="form-control form-control-sm" id="job_status_id"  name="job_status_id" >
                    <option value=''>Select Status</option>
                    @if(!empty($jobStatuses) )
                        @foreach($jobStatuses as $jobStatus)
                            @if($jobStatusId == Arr::get($jobStatus, 'id'))
                                <option value="{{ trim(Arr::get($jobStatus, 'id')) }}" selected>{{trim(Arr::get($jobStatus, 'name'))}}</option> 
                            @else
                                <option  value="{{trim(Arr::get($jobStatus, 'id'))}}" >{{trim(Arr::get($jobStatus, 'name'))}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
           </div>
       
           <div class="col-sm-1">
               <button type="submit" class="btn btn-primary btn-sm ">Search</button>
           </div>
           <div class="col-sm-1"> 
           <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-sm">Reset</a>
           </div>
       </div>  
       
   </form>
        
        <table class="table table-bordered">
          <tr>
             <th>Title</th>
             <th>Total Applied</th>
             <th>City</th>
             <th>Status</th>
             <th width="3%" colspan="2">Action</th>
          </tr>
          @if(!empty($jobs))  
            @foreach ($jobs as $key => $job)
                <tr>
                    <td>{{ Arr::get($job, 'title')}}</td>
                    <td>
                        @if(Auth::user()->can('applicants.index'))
                            <a class="btn btn-info btn-sm" href="{{ route('applicants.index') }}?job_id={{Arr::get($job, 'id')}}">{{ Arr::get($job, 'applicant_count', 0)}}</a>
                        @else
                            {{ Arr::get($job, 'applicant_count', 0)}}                       
                        @endif
                    </td>
                    <td>{{ config('constants.cities.'.Arr::get($job, 'city_id') )}}</td>
                    <td>{{ Arr::get($job->jobStatus, 'name')}}</td>
                    
                    @if(Auth::user()->can('jobs.show'))
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('jobs.show', $job->id) }}">Review</a>
                    </td>
                    @endif
                    
                    @if(Auth::user()->can('jobs.edit') ) 
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('jobs.edit', $job->id) }}">Edit</a>
                    </td>
                   
                    @endif
         
                </tr>
                @endforeach
            @endif    
        </table>

        <div class="d-flex">
            {!! $jobs->appends(Request::except('page'))->render() !!}
        </div>

    </div>

<script type="text/javascript">
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
