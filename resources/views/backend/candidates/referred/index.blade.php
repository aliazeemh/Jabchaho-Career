@extends('backend.layouts.app-master')

@section('content')
    
    <div class="bg-light p-4 rounded">
        <h2>Referred Candidates</h2>
        <div class="lead  mb-3">
            Manage your Referred Candidates here.    
        </div>

        <form class="form-inline" method="GET">
       
            <div class="row mb-3" >
                <div class="col-sm-3">
                    <input type="text" autocomplete="off" class="form-control" id="name" placeholder="Candidate Name" name="name" maxlength="50" value="{{ $name}}">
                </div>
                <div class="col-sm-3">
                    <input type="text" autocomplete="off" class="form-control" id="mobile" placeholder="Mobile Number" name="mobile" maxlength="50" value="{{ $mobile}}">
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
                <a href="{{ route('candidates.referred.index') }}" class="btn btn-primary btn-sm">Reset</a>
                </div>
            </div>  
            
        </form>
        
        <table class="table table-bordered">
          <tr>
             <th width="1%">No</th>
             <th>Name</th>
             <th>Mobile</th>
             <th>Area of Interest</th>
             <th>Education Level</th>
             <th>Previous Experience</th>
             <th width="3%" colspan="2">Action</th>
          </tr>
            @foreach ($referCandidates as $key => $referCandidate)
            <tr>
                <td>{{ $referCandidate->id }}</td>
                <td>{{ $referCandidate->candidate_full_name }}</td>
                <td>{{ $referCandidate->mobile }}</td>
                <td>@if(!empty($referCandidate->areaOfInterestOption->name)) {{ $referCandidate->areaOfInterestOption->name }} @endif </td>
                <td>@if(!empty($levelOfEducations[$referCandidate->level_of_education])) {{ $levelOfEducations[$referCandidate->level_of_education] }} @endif</td>
                <td>@if(!empty($previousExperience[$referCandidate->previous_experience])) {{ $previousExperience[$referCandidate->previous_experience] }} @endif</td>
                <td>
                @if(Auth::user()->can('candidates.referred.show'))
                
                    <a class="btn btn-info btn-sm" href="{{ route('candidates.referred.show', $referCandidate->id) }}">Show</a>
                
                @endif
                </td>
                <td></td>
                
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $referCandidates->appends(Request::except('page'))->render() !!}
        </div>

    </div>

@endsection
