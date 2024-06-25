@extends('backend.layouts.app-master')

@section('content')
    
    <div class="bg-light p-4 rounded">
        <h2>CMS Pages</h2>
        <div class="lead">
            Manage your CMS pages here.
            
            @if(Auth::user()->can('cms.create'))
                <a href="{{ route('cms.create') }}" class="btn btn-primary btn-sm float-right">Add CMS Page</a>
            @endif
                
           
            
        </div>
        
        <table class="table table-bordered">
          <tr>
             <th width="1%">No</th>
             <th>Page</th>
             <th>Url</th>
             <th>Title</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
            @foreach ($cmsPages as $key => $cmsPage)
            <tr>
                <td>{{ Arr::get($cmsPage, 'id')}}</td>
                <td>{{ Arr::get($cmsPage, 'page')}}</td>
                <td>{{ Arr::get($cmsPage, 'url')}}</td>
                <td>{{ Arr::get($cmsPage, 'title')}}</td>

                @if(Auth::user()->can('cms.show'))
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('cms.show', $cmsPage->id) }}">Show</a>
                </td>
                @endif
                @if(Auth::user()->can('cms.edit'))
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('cms.edit', $cmsPage->id) }}">Edit</a>
                </td>
                @endif
                @if(Auth::user()->can('cms.destroy'))
                <td>
                    {!! Form::open(['method' => 'DELETE','route' => ['cms.destroy', $cmsPage->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm',]) !!}
                    {!! Form::close() !!}
                </td>
                @endif
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $cmsPages->links() !!}
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
