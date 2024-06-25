@extends('backend.layouts.app-master')

@section('content')
    
    <div class="bg-light p-4 rounded">
        <h2>Facility Options</h2>
        <div class="lead">
            Manage your Facility Options here.
            
            @if(Auth::user()->can('facility_options.create'))
            <a href="{{ route('facility_options.create') }}" class="btn btn-primary btn-sm float-right">Add Option</a>
            @endif
        </div>
        
        <table class="table table-bordered">
          <tr>
             <th width="1%">No</th>
             <th>Group</th>
             <th>Name</th>
             <th>Enable</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
            @foreach ($facilityOptions as $key => $facilityOption)
            <tr>
                <td>{{ $facilityOption->id }}</td>
                <td>{{ $facilityOption->group_name }}</td>
                <td>{{ $facilityOption->name }}</td>
                <td>{{ Arr::get($booleanOptions, $facilityOption->is_enabled)}}</td>
                @if(Auth::user()->can('facility_options.edit'))
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('facility_options.edit', $facilityOption->id) }}">Edit</a>
                </td>
                @endif
                @if(Auth::user()->can('facility_options.destroy'))
                <td>
                    {!! Form::open(['method' => 'DELETE','route' => ['facility_options.destroy', $facilityOption->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm',]) !!}
                    {!! Form::close() !!}
                </td>
                @endif
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $facilityOptions->links() !!}
        </div>

    </div>

    <script type="text/javascript">
        function ConfirmDelete(){
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
