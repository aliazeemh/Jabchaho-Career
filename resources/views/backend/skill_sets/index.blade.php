@extends('backend.layouts.app-master')

@section('content')
    
    <div class="bg-light p-4 rounded">
        <h2>Skill Sets</h2>
        <div class="lead mb-3">
            Manage your Skill Set here.
            
            @if(Auth::user()->can('skill_sets.create'))
            <a href="{{ route('skill_sets.create') }}" class="btn btn-primary btn-sm float-right">Add Skill Set</a>
            @endif
                
        </div>

        <form class="form-inline" method="GET">
       
       <div class="row mb-3" >
           <div class="col-sm-3">
               <input type="text" autocomplete="off" class="form-control" id="name" placeholder="Enter Name" name="name" maxlength="200" value="{{ $name}}">
           </div>
           <div class="col-sm-3">
                <select class="form-control c-select" id="is_viewable"  name="is_viewable" rel="{{$isViewable}}">
                        <option value=''>View on search</option>
                        @if(!empty($booleanOptions) )
                            
                            @foreach($booleanOptions as $key=>$value)
                                
                                @if (isset($isViewable) && $isViewable == $key)
                                    <option value="{{ $key }}" selected>{{trim($value)}}</option>    
                                @else
                                    <option value="{{ $key }}">{{trim($value)}} </option>    
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>    

           <div class="col-sm-1">
               <button type="submit" class="btn btn-primary btn-sm ">Search</button>
           </div>
           <div class="col-sm-1"> 
           <a href="{{ route('skill_sets.index') }}" class="btn btn-primary btn-sm">Reset</a>
           </div>
       </div>  
       
   </form>
        
        <table class="table table-bordered">
          <tr>
            <th width="1%">No</th> 
            <th>Name</th>
            <th>View on Search</th>
             <th width="3%" colspan="2">Action</th>
          </tr>

          @if(!empty($skillSets))  
            @foreach ($skillSets as $key => $skillSet)
                <tr>
                    <td>{{  Arr::get($skillSet,'id')}}</td>
                    <td>{{ Arr::get($skillSet,'name')}}</td>
                    <td>{{ Arr::get($booleanOptions, $skillSet->is_viewable)}}</td>
                    @if(Auth::user()->can('skill_sets.edit'))
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('skill_sets.edit', $skillSet->id) }}">Edit</a>
                    </td>
                    @endif
                    @if(Auth::user()->can('skill_sets.destroy'))
                    <td>
                        {!! Form::open(['method' => 'DELETE','route' => ['skill_sets.destroy', $skillSet->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    </td>
                    @endif
                </tr>
                @endforeach
            @endif    
        </table>

        <div class="d-flex">
            {!! $skillSets->appends(Request::except('page'))->render() !!}
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
