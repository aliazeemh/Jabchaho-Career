@extends('backend.layouts.app-master')

@section('content')
    
    <div class="bg-light p-4 rounded">
        <h2>Home Contents</h2>
        <div class="lead">
            Manage your Home Contents here.
            
            @if(Auth::user()->can('home_content.create'))
                <a href="{{ route('home_content.create') }}" class="btn btn-primary btn-sm float-right">Add Home Content</a>
            @endif
                
           
            
        </div>
        
        <table class="table table-bordered">
          <tr>
             <th width="1%">No</th>
             <th>Status</th>
             <th>Title</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
            @foreach ($homeContents as $key => $homeContent)
            <tr>
                <td>{{ Arr::get($homeContent, 'id')}}</td>
                <td>{{ Arr::get($homeContent->candidateStatus, 'name')}}</td>
                <td>{{ Arr::get($homeContent, 'title')}}</td>

                @if(Auth::user()->can('home_content.show'))
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('home_content.show', $homeContent->id) }}">Show</a>
                </td>
                @endif
                @if(Auth::user()->can('home_content.edit'))
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('home_content.edit', $homeContent->id) }}">Edit</a>
                </td>
                @endif
                @if(Auth::user()->can('home_content.destroy'))
                <td>
                    {!! Form::open(['method' => 'DELETE','route' => ['home_content.destroy', $homeContent->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm',]) !!}
                    {!! Form::close() !!}
                </td>
                @endif
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $homeContents->links() !!}
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
