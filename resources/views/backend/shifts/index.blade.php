@extends('backend.layouts.app-master')

@section('content')
    
    <div class="bg-light p-4 rounded">
        <h2>Shifts</h2>
        <div class="lead">
            Manage your Shifts here.
            
            @if(Auth::user()->can('shifts.create'))
            <a href="{{ route('shifts.create') }}" class="btn btn-primary btn-sm float-right">Add Shifts</a>
            @endif
                
           
            
        </div>
        
        <table class="table table-bordered">
          <tr>
             <th>Name</th>
             <th>From</th>
             <th>To</th>
             <th>Enabled</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
          @if(!empty($shifts))  
            @foreach ($shifts as $key => $shift)
                <tr>
                    <td>{{ $shift->name }}</td>
                    <td>{{ date('g:i A',strtotime(Arr::get($shift, 'from'))) }}</td>
                    <td>{{ date('g:i A',strtotime(Arr::get($shift, 'to'))) }}</td>
                    <td>{{ Arr::get($booleanOptions, $shift->is_enabled)}}</td>
                    @if(Auth::user()->can('shifts.show'))
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('shifts.show', $shift->id) }}">Show</a>
                    </td>
                    @endif
                    @if(Auth::user()->can('shifts.edit'))
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('shifts.edit', $shift->id) }}">Edit</a>
                    </td>
                    @endif
                    @if(Auth::user()->can('shifts.destroy'))
                    <td>
                        {!! Form::open(['method' => 'DELETE','route' => ['shifts.destroy', $shift->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    </td>
                    @endif
                </tr>
                @endforeach
            @endif    
        </table>

        <div class="d-flex">
            {!! $shifts->links() !!}
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
