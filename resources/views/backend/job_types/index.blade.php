@extends('backend.layouts.app-master')

@section('content')
    
    <div class="bg-light p-4 rounded">
        <h2>Job Types</h2>
        <div class="lead">
            Manage your Job Types here.
            
            @if(Auth::user()->can('job_types.create'))
            <a href="{{ route('job_types.create') }}" class="btn btn-primary btn-sm float-right">Add Job Type</a>
            @endif
                
           
            
        </div>
        
        <table class="table table-bordered">
          <tr>
             <th>Name</th>
             <th>Enabled</th>
             <th>Default Checked</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
          @if(!empty($jobTypes))  
            @foreach ($jobTypes as $key => $jobType)
                <tr>
                    <td>{{ $jobType->name }}</td>
                    <td>{{ Arr::get($booleanOptions, $jobType->is_enabled)}}</td>
                    <td>{{ Arr::get($booleanOptions, $jobType->is_checked)}}</td>
                    
                    @if(Auth::user()->can('job_types.show'))
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('job_types.show', $jobType->id) }}">Show</a>
                    </td>
                    @endif
                    @if(Auth::user()->can('job_types.edit'))
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('job_types.edit', $jobType->id) }}">Edit</a>
                    </td>
                    @endif
                    @if(Auth::user()->can('job_types.destroy'))
                    <td>
                        {!! Form::open(['method' => 'DELETE','route' => ['job_types.destroy', $jobType->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    </td>
                    @endif
                </tr>
                @endforeach
            @endif    
        </table>

        <div class="d-flex">
            {!! $jobTypes->links() !!}
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
