@extends('backend.layouts.app-master')

@section('content')
    
    <div class="bg-light p-4 rounded">
        <h2>Job Benefits</h2>
        <div class="lead">
            Manage your Job Benefits here.
            
            @if(Auth::user()->can('job_benefits.create'))
            <a href="{{ route('job_benefits.create') }}" class="btn btn-primary btn-sm float-right">Add Job Benefit</a>
            @endif
                
           
            
        </div>
        
        <table class="table table-bordered">
          <tr>
             <th>Name</th>
             <th>Enabled</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
          @if(!empty($jobBenefits))  
            @foreach ($jobBenefits as $key => $jobBenefit)
                <tr>
                    <td>{{ $jobBenefit->name }}</td>
                    <td>{{ Arr::get($booleanOptions, $jobBenefit->is_enabled)}}</td>
                    
                    @if(Auth::user()->can('job_benefits.show'))
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('job_benefits.show', $jobBenefit->id) }}">Show</a>
                    </td>
                    @endif
                    @if(Auth::user()->can('job_benefits.edit'))
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('job_benefits.edit', $jobBenefit->id) }}">Edit</a>
                    </td>
                    @endif
                    @if(Auth::user()->can('job_benefits.destroy'))
                    <td>
                        {!! Form::open(['method' => 'DELETE','route' => ['job_benefits.destroy', $jobBenefit->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    </td>
                    @endif
                </tr>
                @endforeach
            @endif    
        </table>

        <div class="d-flex">
            {!! $jobBenefits->links() !!}
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
