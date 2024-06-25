@extends('backend.layouts.app-master')

@section('content')
    
    <div class="bg-light p-4 rounded">
        <h2>Candidates</h2>
        <div class="lead  mb-3">
            Manage your Candidates here.
            
            @if(Auth::user()->can('candidates.create'))
            <a href="{{ route('candidates.create') }}" class="btn btn-primary btn-sm float-right">Add Candidates</a>
            @endif
                
           
            
        </div>

        <form class="form-inline" method="GET">
       
            <div class="row mb-3" >
                <div class="col-sm-3">
                <input type="hidden" id="dashboardFilter" placeholder="dashboardFilter" name="dashboard_filter" maxlength="50" value="{{ $dashboardFilter}}">         
                    <input type="text" autocomplete="off" class="form-control" id="name" placeholder="Enter Name" name="name" maxlength="50" value="{{ $name}}">
                </div>
                <div class="col-sm-3">
                    <input type="text" autocomplete="off" class="form-control" id="email" placeholder="Enter Email" name="email" maxlength="50" value="{{ $email}}">
                </div> 
                <div class="col-sm-3">
                <select class="form-control c-select" id="area_of_interest_option_id"  name="area_of_interest_option_id" rel="{{ $areaOfInterestOptionId }}" >
                        <option value=''>Select Your Area Of Interest</option>
                        @if(!empty($areaOfInterests) )
                            
                            @php $groupName = ''; @endphp
                            @foreach($areaOfInterests as $object)
                                
                                @if ($groupName != $object['group_name'])
                                        <optgroup label="{{$object['group_name']}}">
                                        @php $groupName = $object['group_name']; @endphp
                                @endif
                            
                                @if (!empty($areaOfInterestOptionId) && $areaOfInterestOptionId== $object['id'])
                                    <option value="{{ trim($object['id']) }}" selected>{{trim($object['name'])}} </option>   
                                @else
                                    <option  value="{{ trim($object['id']) }}" > {{trim($object['name'])}} </option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>    
                <div class="col-sm-1">
                    <button type="submit" class="btn btn-primary btn-sm ">Search</button>
                </div>
                <div class="col-sm-1"> 
                <a href="{{ route('candidates.index') }}" class="btn btn-primary btn-sm">Reset</a>
                </div>
            </div>  
            
        </form>
        
        <table class="table table-bordered">
          <tr>
             <th width="1%">No</th>
             <th>Application Id</th>
             <th>Name</th>
             <th>Email</th>
             <th>Area of Interest</th>
             <th>CV</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
            @foreach ($candidates as $key => $candidate)
            <tr>
                <td>{{ $candidate->id }}</td>
                <td>{{ $candidate->application_id }}</td>
                <td>{{ $candidate->full_name }}</td>
                <td>{{ $candidate->email }}</td>
                <td>@if(!empty($candidate->areaOfInterestOption->name)) {{ $candidate->areaOfInterestOption->name }} @endif </td>
                <td>                      
                    @if(!empty($candidate->getCandidateResumeDocument->file)) 
                        @if(Helper::isFileExtensionForIcon(Arr::get($candidate->getCandidateResumeDocument,'file')))
                        <a class="downloadFile" data-filepath="{{asset(config('constants.files.douments'))}}/{{Arr::get($candidate->getCandidateResumeDocument,'file')}}">    
                            <img  width="30" src="{{asset(config('constants.files.filetypes'))}}/{{Helper::isFileExtensionForIcon(Arr::get($candidate->getCandidateResumeDocument,'file'))}}"  />
                        </a>
                        @else
                            <a class="downloadFile" data-filepath="{{asset(config('constants.files.douments'))}}/{{Arr::get($candidate->getCandidateResumeDocument,'file')}}"> 
                                <img class="center" width="30" src="{{asset(config('constants.files.douments'))}}/thumbnail/{{Arr::get($candidate->getCandidateResumeDocument,'file')}}" >
                            </a>
                        @endif
                    @endif 
                </td>
                @if(Auth::user()->can('candidates.show'))
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('candidates.show', $candidate->id) }}">Show</a>
                </td>
                @endif
                @if(Auth::user()->can('candidates.edit'))
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('candidates.edit', $candidate->id) }}">Edit</a>
                </td>
                @endif
                @if(Auth::user()->can('candidates.destroy'))
                <td>
                    {!! Form::open(['method' => 'DELETE','route' => ['candidates.destroy', $candidate->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    {!! Form::close() !!}
                </td>
                @endif
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $candidates->appends(Request::except('page'))->render() !!}
        </div>

    </div>

<script type="text/javascript">

$(document).ready(function() {

    $(document).on('click', '.downloadFile', function (e) {
            e.preventDefault();  //stop the browser from following

            var filepath = $(this).attr('data-filepath');
            window.open(filepath , '_blank');
    });
});

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
