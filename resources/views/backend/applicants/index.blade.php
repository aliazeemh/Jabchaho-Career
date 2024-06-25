@extends('backend.layouts.app-master')

@section('content')
    <style>
    .col-sm-2 {
        width: 14% !important;
    }

    .ui-widget-header {
    border: 1px solid #0d6efd !important;
    background: #38c !important;
    color: #333333 !important;
}
   
    </style>
    <div class="bg-light p-4 rounded">
        <h2>Applicants</h2>


        <form class="form-inline" method="GET">
       
        <div class="row mb-3" >
           <div class="col-sm-2">
                <input type="hidden" id="id" placeholder="Id" name="job_id" maxlength="50" value="{{ $jobId}}">
                <input type="hidden" id="dashboardFilter" placeholder="dashboardFilter" name="dashboard_filter" maxlength="50" value="{{ $dashboardFilter}}">     
                <input type="text" autocomplete="off" class="form-control form-control-sm" id="title" placeholder="Title" name="title" maxlength="50" value="{{ $title}}">
            </div>
            <div class="col-sm-2">
               <input type="text" autocomplete="off" class="form-control form-control-sm" id="name" placeholder="Name" name="name" maxlength="50" value="{{ $name}}">
           </div>
            <div class="col-sm-1">
                <select class="form-control form-control-sm" id="city"  name="city" >
                        <option  value="">City</option>
                        @if(!empty($cities))
                            @foreach($cities as $key=>$value)
                                @if(isset($selectedCity) && $selectedCity==$key)
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                @else
                                    <option  value="{{trim($key)}}" >{{trim($value)}} </option>
                                @endif
                            @endforeach
                        @endif
                </select>
            </div>
            <div class="col-sm-1">
            <select class="form-control form-control-sm" id="gender"  name="gender" >
                    <option  value="">Gender</option>
                    @if(!empty($genderOptions))
                        @foreach($genderOptions as $key=>$value)
                            @if(isset($selectedGender) && $selectedGender==$key)
                                <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                            @else
                                <option  value="{{trim($key)}}" >{{trim($value)}} </option>
                            @endif
                        @endforeach
                    @endif
            </select>
            </div>
            <div class="col-sm-1">
                <!--<input type="text" autocomplete="off" class="form-control form-control-sm" id="total_experience" placeholder="Experience" name="total_experience" maxlength="3" value="{{ $totalExperience}}">-->
                <select class="form-control form-control-sm" id="total_experience"  name="total_experience" >
                    <option  value="">Experience</option>
                        @if(!empty($experience) )
                            @foreach($experience as $key =>$value)
                                @if($totalExperience==$key)
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                @else
                                    <option  value="{{trim($key)}}" >{{trim($value)}} </option>
                                @endif
                            @endforeach
                        @endif
                </select>
            </div>
            <div class="col-sm-2">
                <select class="form-control form-control-sm" id="levelOfEducation"  name="level_of_education" >
                    <option  value="">Education Level</option>
                        @if(!empty($levelOfEducations) )
                            @foreach($levelOfEducations as $key =>$value)
                                @if($selectedLevelOfEducation==$key)
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                @else
                                    <option  value="{{trim($key)}}" >{{trim($value)}} </option>
                                @endif
                            @endforeach
                        @endif
                </select>
            </div>
          
            <div class="col-sm-2">
                <select class="form-control form-control-sm" id="marital_status"  name="marital_status" >
                        <option  value="">Marital Status</option>
                        @if(!empty($maritalStatuses))
                            @foreach($maritalStatuses as $key=>$value)
                                @if(isset($selectedMaritalStatus) && $selectedMaritalStatus==$key)
                                    <option value="{{ trim($key) }}" selected>{{trim($value)}} </option> 
                                @else
                                    <option  value="{{trim($key)}}" >{{trim($value)}} </option>
                                @endif
                            @endforeach
                        @endif
                </select>
            </div>
           <div class="col-sm-2">
                <select class="form-control form-control-sm" id="applicant_status_id"  name="applicant_status_id" >
                    <option value=''>Status</option>
                    @if(!empty($applicantsStatuses) )
                        @foreach($applicantsStatuses as $applicantsStatus)
                            @if($applicantsStatusId == Arr::get($applicantsStatus, 'id'))
                                <option value="{{ trim(Arr::get($applicantsStatus, 'id')) }}" selected>{{trim(Arr::get($applicantsStatus, 'name'))}}</option> 
                            @else
                                <option  value="{{trim(Arr::get($applicantsStatus, 'id'))}}" >{{trim(Arr::get($applicantsStatus, 'name'))}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
           </div>
        </div>  

        <div class="row mb-3" >
           <div class="col-sm-6">

            <label for="current_salary">Current Salary:</label><input type="text" name="current_salary" id="current_salary" readonly style="border:0; color:#38c; font-weight:bold;"  value="{{ $currentSalary}}">
            <div id="current-salary-slider-range" class="mt-10"></div>
            
            </div>

            <div class="col-sm-6">

            <label for="expected_salary" class="text-center">Expected Salary:</label><input type="text" name="expected_salary" id="expected_salary" readonly style="border:0; color:#38c; font-weight:bold;"  value="{{ $expectedSalary}}">
            <div id="expected-salary-slider-range"  class="mt-10"></div>
            
            </div>
        </div>




        <div class="row mb-3" >
       
           <div class="col-sm-11">
               <button type="submit" class="btn btn-primary btn-sm float-right btn-fit">Search</button>
               
           </div>
           <div class="col-sm-1">
           <a href="{{ route('applicants.index') }}" class="btn btn-primary btn-sm float-left btn-fit">Reset</a>
           </div>
        </div>
       
   </form>
        
        <table class="table table-bordered">
          <tr>
             <th>Title</th>
             <th>Name</th>
             <th>Email</th>
             <th>Experience (Years)</th>
             <th>Status</th>
             <th>Date of Application</th>
             <th width="3%" colspan="2">Action</th>
          </tr>
          @if(!empty($applicants))  
            @foreach ($applicants as $key => $applicant)
                <tr>
                    <td>{{ Arr::get($applicant->job, 'title')}}</td>
                    <td>{{ Arr::get($applicant->candidate, 'full_name')}}</td>
                    <td><a href="{{route('candidates.index')}}?email={{ Arr::get($applicant->candidate, 'email')}}">{{ Arr::get($applicant->candidate, 'email')}}</a></td>
                    <td>{{ Arr::get($applicant->candidate, 'total_experience')}}</td>
                    <td>{{ Arr::get($applicant->applicantStatus, 'name')}}</td>
                    <td>{{ date("d-m-Y", strtotime(Arr::get($applicant, 'created_at')))}}</td>
                    @if(Auth::user()->can('applicants.show'))
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('applicants.show', $applicant->id) }}">Review</a>
                    </td>
                    @endif
         
                </tr>
                @endforeach
            @endif    
        </table>

        <div class="d-flex">
            {!! $applicants->appends(Request::except('page'))->render() !!}
        </div>

    </div>

<script>
$( function() {

    let postedCurrentSalary = '{{ $currentSalary}}';
    postedCurrentSalaryArray = [0,0];
    if(postedCurrentSalary)
    {
        postedCurrentSalaryArray = postedCurrentSalary.split("-");
    }
    
  $( "#current-salary-slider-range" ).slider({
    range: true,
    min: 0,
    max: 1000000,
    step: 1000,
    values: postedCurrentSalaryArray,
    slide: function( event, ui ) {
        let currentSalaryOnSelect =  ui.values[ 0 ] +"-"+ ui.values[ 1 ];
      $( "#current_salary" ).val(currentSalaryOnSelect);
    }
  });
    
    let current_salary =  $( "#current-salary-slider-range" ).slider( "values", 0 ) +"-"+ $( "#current-salary-slider-range" ).slider( "values", 1 ); 
    
    if(postedCurrentSalary ==''){
        $( "#current_salary" ).val(current_salary);
    }
    
} );

$( function() {

    let postedExpectedSalary = '{{ $expectedSalary}}';
    postedExpectedSalaryArray = [0,0];
    if(postedExpectedSalary)
    {
        postedExpectedSalaryArray = postedExpectedSalary.split("-");
    }

  $( "#expected-salary-slider-range" ).slider({
    range: true,
    min: 0,
    max: 1000000,
    step: 1000,
    values: postedExpectedSalaryArray,
    slide: function( event, ui ) {
        let expectedSalaryOnSelect =  ui.values[ 0 ] +"-"+ ui.values[ 1 ];
        $( "#expected_salary" ).val(expectedSalaryOnSelect);
    }
  });

  let expectedSalary =  $( "#expected-salary-slider-range" ).slider( "values", 0 ) +"-"+ $( "#expected-salary-slider-range" ).slider( "values", 1 );
  if(postedExpectedSalary==''){
    $( "#expected_salary" ).val(expectedSalary );
  }
  
} );
</script>
<link rel="stylesheet" href="{!! url('assets/css/range/jquery-ui.css') !!}">

<script src="{!! url('assets/js/range/jquery-ui.js') !!}"></script>

@endsection
