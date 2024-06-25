@extends('backend.layouts.app-master')

@section('content')
    
    <div class="bg-light p-4 rounded">
        <h2>Area of Intrest Groups</h2>
        <div class="lead">
            Manage your Area of Intrest Groups here.
            
            @if(Auth::user()->can('area_of_interest_groups.create'))
            <a href="{{ route('area_of_interest_groups.create') }}" class="btn btn-primary btn-sm float-right">Add Group</a>
            @endif
                
           
            
        </div>
        
        <table class="table table-bordered">
          <tr>
             <th width="1%">No</th>
             <th>Name</th>
             <th>Enable</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
            @foreach ($areaOfInterestGroups as $key => $areaOfInterestGroup)
            <tr>
                <td>{{ $areaOfInterestGroup->id }}</td>
                <td>{{ $areaOfInterestGroup->name }}</td>
                <td>{{ Arr::get($booleanOptions, $areaOfInterestGroup->is_enabled)}}</td>
                @if(Auth::user()->can('area_of_interest_groups.edit'))
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('area_of_interest_groups.edit', $areaOfInterestGroup->id) }}">Edit</a>
                </td>
                @endif
                @if(Auth::user()->can('area_of_interest_groups.destroy'))
                <td>
                    {!! Form::open(['method' => 'DELETE','route' => ['area_of_interest_groups.destroy', $areaOfInterestGroup->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm',]) !!}
                    {!! Form::close() !!}
                </td>
                @endif
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $areaOfInterestGroups->links() !!}
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
