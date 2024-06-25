@extends('backend.layouts.app-master')

@section('content')
    
    <div class="bg-light p-4 rounded">
        <h2>Area of Intrest Options</h2>
        <div class="lead">
            Manage your Area of Intrest Options here.
            
            @if(Auth::user()->can('area_of_interest_options.create'))
            <a href="{{ route('area_of_interest_options.create') }}" class="btn btn-primary btn-sm float-right">Add Option</a>
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
            @foreach ($areaOfInterestOptions as $key => $areaOfInterestOption)
            <tr>
                <td>{{ $areaOfInterestOption->id }}</td>
                <td>{{ $areaOfInterestOption->group_name }}</td>
                <td>{{ $areaOfInterestOption->name }}</td>
                <td>{{ Arr::get($booleanOptions, $areaOfInterestOption->is_enabled)}}</td>
                @if(Auth::user()->can('area_of_interest_options.edit'))
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('area_of_interest_options.edit', $areaOfInterestOption->id) }}">Edit</a>
                </td>
                @endif
                @if(Auth::user()->can('area_of_interest_options.destroy'))
                <td>
                    {!! Form::open(['method' => 'DELETE','route' => ['area_of_interest_options.destroy', $areaOfInterestOption->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm',]) !!}
                    {!! Form::close() !!}
                </td>
                @endif
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $areaOfInterestOptions->links() !!}
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
