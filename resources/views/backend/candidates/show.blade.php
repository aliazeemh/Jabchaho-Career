@extends('backend.layouts.app-master')
@section('content')

<div class="text-end mb-4 "><button class="btn btn-primary btn-sm" onclick="printSection()">Print</button></div>
<section style="background-color: #eee;" id="printSection" class="mb-3">
    <div class="container py-2" id="container">
        <!--//Row 1-->
        <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
            <div class="card-body text-center">
            @if(!empty(Arr::get($candidateData,'profile_image')))
                <img src="{{asset(config('constants.files.profile'))}}/{{Arr::get($candidateData,'profile_image')}}" class="rounded-circle img-fluid" style="width: 150px;" >
                @else
                    <img src="{{asset('assets/images/default/profile-large.jpg')}}" class="rounded-circle img-fluid" style="width: 150px;" >
                @endif
                
                <h5 class="my-3">{{ Arr::get($candidateData,'full_name')}}</h5>
                <p class="text-muted mb-3">{{ Arr::get($candidateData,'email')}}</p>
                <p class="text-muted mb-3">
                    @if(!empty(Arr::get($personalDetailData, 'house_no'))){{Arr::get($personalDetailData, 'house_no')}},@endif 
                    @if(!empty(Arr::get($personalDetailData, 'area'))){{Arr::get($personalDetailData, 'area')}}, @endif 
                    @if(!empty(Arr::get($personalDetailData, 'street'))){{Arr::get($personalDetailData, 'street')}}, @endif 
                    @if(array_key_exists(Arr::get($personalDetailData, 'city'), config('constants.cities')))   
                            {{config('constants.cities')[Arr::get($personalDetailData, 'city')]}}
                    @endif

                </p>
                <p class="text-muted mb-3">
                    <div class="progress">
                        <span class="progress-bar" role="progressbar" style="width: {{$profilePercentage}}%;" aria-valuenow="{{$profilePercentage}}" aria-valuemin="0" aria-valuemax="100">
                    </div>
                    <small>Progress: <span id="ContentContainer_lblProgressPercentage">{{$profilePercentage}}%</span></small>
                </p>
                
            </div>
            </div>
        
        </div>
        <!--Personal Information-->
        <div class="col-lg-8">
            <div class="card mb-4">
            <h6 class="card-header">Personal Information</h6>
            <div class="card-body">
                <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Applicant ID</p>
                </div>
                <div class="col-sm-3">
                    <p class="text-muted mb-0">{{ Arr::get($candidateData,'application_id')}}</p>
                </div>
                <div class="col-sm-3">
                    <p class="mb-0">Status</p>
                </div>
                <div class="col-sm-3">
                    <p class="text-muted mb-0">{{ Arr::get($candidateData->candidateStatus ,'name')}}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Area of Interest</p>
                </div>
                <div class="col-sm-3">
                    <p class="text-muted mb-0">{{ Arr::get($candidateData->areaOfInterestOption ,'name')}}</p>
                </div>
                <div class="col-sm-3">
                    <p class="mb-0">Country</p>
                </div>
                <div class="col-sm-3">
                    <p class="text-muted mb-0">@if($candidateData->country_code) {{ config('constants.countries.'.$candidateData->country_code) }} @endif</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Gender</p>
                </div>
                <div class="col-sm-3">
                    <p class="text-muted mb-0">
                        @if(array_key_exists(Arr::get($personalDetailData, 'gender'), config('constants.gender_options')))   
                                {{config('constants.gender_options')[Arr::get($personalDetailData, 'gender')]}}
                        @endif
                    </p>
                </div>
                <div class="col-sm-3">
                    <p class="mb-0">Birthday</p>
                </div>
                <div class="col-sm-3">
                    <p class="text-muted mb-0">
                    @if(!empty(Arr::get($personalDetailData, 'date_of_birth'))){{ date("M d, Y", strtotime(Arr::get($personalDetailData, 'date_of_birth'))) }}@endif
                    </p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Marital Status</p>
                </div>
                <div class="col-sm-3">
                    <p class="text-muted mb-0">
                        @if(array_key_exists(Arr::get($personalDetailData, 'marital_status'), config('constants.marital_statuses')))   
                            {{config('constants.marital_statuses')[Arr::get($personalDetailData, 'marital_status')]}}
                        @endif
                    </p>
                </div>
                <div class="col-sm-3">
                    <p class="mb-0">Religion</p>
                </div>
                <div class="col-sm-3">
                    <p class="text-muted mb-0">
                        @if(array_key_exists(Arr::get($personalDetailData, 'religion'), config('constants.religion')))   
                            {{config('constants.religion')[Arr::get($personalDetailData, 'religion')]}}
                        @endif
                    </p>
                </div>
                </div>
                
                <hr>

                <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Nationality</p>
                </div>
                <div class="col-sm-3">
                    <p class="text-muted mb-0">
                        @if(array_key_exists(Arr::get($personalDetailData, 'nationality'), config('constants.nationality')))   
                            {{config('constants.nationality')[Arr::get($personalDetailData, 'nationality')]}}
                        @endif
                    </p>
                </div>

                @if(Arr::get($personalDetailData, 'nationality')==1)
                <div class="col-sm-3">
                    <p class="mb-0">CNIC</p>
                </div>
                <div class="col-sm-3">
                    <p class="text-muted mb-0">{{ Arr::get($personalDetailData,'cnic')}}</p>
                </div>
                @else
                <div class="col-sm-3">
                    <p class="mb-0">Passport</p>
                </div>
                <div class="col-sm-3">
                    <p class="text-muted mb-0">{{ Arr::get($personalDetailData,'passport')}}</p>
                </div>

                @endif
                
                </div>
                
                <hr>
                <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0">Mobile</p>
                </div>
                <div class="col-sm-3">
                    <p class="text-muted mb-0">{{ Arr::get($candidateData,'mobile_number')}}</p>
                </div>

                <div class="col-sm-3">
                    <p class="mb-0">Landline Number</p>
                </div>
                <div class="col-sm-3">
                    <p class="text-muted mb-0">{{Arr::get($personalDetailData, 'landline_number')}}</p>
                </div>
                </div>


            </div>
            </div>
            <!--//Personal Information-->
        </div>


        </div>
        <!--//Row 1-->

        <!--Row 2-->
        <div class="row">
            <div class="col-md-12">
                 <!--card 0 --Skill Set-- -->
                 <div class="card mb-3">
                        <h6 class="card-header">Skill Set</h6>
                        <div class="card-body">
                            <div class="row">
                                @if(!empty($skillSets) )
                                    <div class="card-text">
                                        @foreach($skillSets as $row)
                                         <span class="badge bg-light text-dark">{{Arr::get($row->skillSet, 'name')}}</span>
                                        @endforeach
                                    </div>    
                                @endif   
                               
                            </div>   
                        </div>
                    </div>
                    <!--//card 0-->
            </div>
        </div>        
        <!--//Row 2-->

        <!--Row 3-->
        <div class="row">
            <div class="col-md-4">
                <!--card 1 --Experience-- -->
                <div class="card mb-3">
                    <h6 class="card-header">Experience</h6>
                    <div class="card-body">
                        <div class="row">
                            @if(!empty($professionalExperienceAllData))
                                @php $experienceCounter=1;@endphp
                                @foreach($professionalExperienceAllData as $row)
                                <div class="experience-data mb-1 col-form-label-sm" >
                                    <div class="card-text">{{Arr::get($row, 'company_name')}}</div>
                                    <div class="card-text">{{Arr::get($row, 'job_title')}}</div>
                                    <div class="card-text">
                                            {{ date("M Y", strtotime(Arr::get($row, 'from'))) }}
                                            -
                                            @if(Arr::get($row, 'is_present'))
                                            {{'Present'}}
                                            @else
                                            {{ date("M Y", strtotime(Arr::get($row, 'to'))) }}
                                            @endif
                                    </div>
                                    
                                </div>
                                
                                @if(count($professionalExperienceAllData) != $experienceCounter)
                                <hr>
                                @endif

                                @php $experienceCounter++; @endphp
                                @endforeach
                       
                            @endif
                            
                        </div>
                        
                        
                    </div>
                </div>
            
            <!--//card 1-->
            </div>        
            
            
            <div class="col-md-4">
            <!--card 2 --Education-- -->
                <div class="card mb-3">
                    <h6 class="card-header">Education</h6>
                    <div class="card-body">
                        <div class="row">
                            @if(!empty($educationalQualificationAllData))
                                @php $educationCounter=1;@endphp
                                @foreach($educationalQualificationAllData as $row)
                                <div class="education-data mb-1 col-form-label-sm">
                                    <div class="card-text">{{Arr::get($row, 'institute_name')}}</div>
                                    <div class="card-text">{{Arr::get($row, 'field_of_study')}}</div>
                                    <div class="card-text">
                                            {{ date("M Y", strtotime(Arr::get($row, 'from'))) }}
                                            -
                                            @if(Arr::get($row, 'is_present'))
                                            {{'Present'}}
                                            @else
                                            {{ date("M Y", strtotime(Arr::get($row, 'to'))) }}
                                            @endif
                                    </div>
                                    
                                </div>
                                @if(count($educationalQualificationAllData) != $educationCounter)
                                <hr>
                                @endif
                                @php $educationCounter++; @endphp
                                
                                @endforeach

                            @endif
                        </div>    
                    </div>
                </div>
                    
            <!--//card 2-->
            </div>


            <div class="col-md-4">
                 <!--card 3 --Diplomas-- -->
                 <div class="card mb-3">
                        <h6 class="card-header">Diplomas</h6>
                        <div class="card-body">
                            <div class="row">
                                @if(!empty($diplomaAllData))
                                    @php $diplomaCounter=1;@endphp
                                    @foreach($diplomaAllData as $row)
                                    <div class="diploma-data mb-1 col-form-label-sm">
                                        <div class="card-text">{{Arr::get($row, 'institute_name')}}</div>
                                        <div class="card-text">{{Arr::get($row, 'diploma_title')}}</div>
                                        <div class="card-text">
                                                {{ date("M Y", strtotime(Arr::get($row, 'from'))) }}
                                                -
                                                @if(Arr::get($row, 'is_present'))
                                                {{'Present'}}
                                                @else
                                                {{ date("M Y", strtotime(Arr::get($row, 'to'))) }}
                                                @endif
                                        </div>
                                    </div>

                                    @if(count($diplomaAllData) !=$diplomaCounter )
                                       <hr>
                                    @endif
                                    @php $diplomaCounter++; @endphp
                                
                                    @endforeach

                                @endif
                                
                            </div>    
                        </div>
                    </div>
                    <!--//card 3-->
            </div>





        </div>

        <!--//Row3-->

        <!--Row4-->
        <div class="row">
            
            <div class="col-md-4">
                 <!--card 4 --Certifications-- --> 
                 <div class="card mb-3">
                        <h6 class="card-header">Certifications</h6>
                        <div class="card-body">
                            <div class="row">
                                @if(!empty($certificateAllData))
                                    @php $certificateCounter=1;@endphp
                                    @foreach($certificateAllData as $row)
                                    <div class="certification-data mb-1 col-form-label-sm">
                                        <div class="card-text">{{Arr::get($row, 'institute_name')}}</div>
                                        <div class="card-text">{{Arr::get($row, 'certification_title')}}</div>
                                        <div class="card-text">
                                                {{ date("M Y", strtotime(Arr::get($row, 'from'))) }}
                                                -
                                                @if(Arr::get($row, 'is_present'))
                                                {{'Present'}}
                                                @else
                                                {{ date("M Y", strtotime(Arr::get($row, 'to'))) }}
                                                @endif
                                        </div>
                                        
                                    </div>
                               
                                    @if(count($certificateAllData) !=$certificateCounter )
                                       <hr>
                                    @endif
                                    @php $certificateCounter++; @endphp
                                    
                                    @endforeach
                                 
                                @endif
                                
                            </div>        
                        
                        </div>
                    </div>
                    <!--//card 4-->
            </div>

            <div class="col-md-4">
                <!--card 5 --Portfolio-- -->
                <div class="card mb-3">
                        <h6 class="card-header">Portfolio</h6>
                        <div class="card-body">
                            <div class="row">
                                @if(!empty($candidatePortfolioDetail))
                                    @php $portfolioDetailCounter=1;@endphp
                                    @foreach($candidatePortfolioDetail as $row)
                                    <div class="portfolio-detail-data">
                                        <div class="row mb-1 card-text">
                                            <label class="col-sm-3 col-form-label col-form-label-sm">{{Arr::get($row, 'title')}}</label>
                                            <div class="col-sm-9">
                                            <label class="col-form-label-sm">{{Arr::get($row, 'url')}}</label>
                                            </div>
                                        </div>
                                    </div>

                                    @if(count($candidatePortfolioDetail) !=$portfolioDetailCounter )
                                       <hr>
                                    @endif
                                    @php $portfolioDetailCounter++; @endphp
                                   
                                    @endforeach

                                @endif
                               
                            </div>         
                            
                        </div>
                    </div>
                  
                    <!--//card 5-->
            </div>

            <div class="col-md-4">
                 <!--card 6-->
                 <div class="card mb-3">
                        <h6 class="card-header">Family Details</h6>
                        <div class="card-body">
                            <div class="row">
                                @if(!empty($familyDetailAllData))
                                    @php $familyDetailCounter=1;@endphp
                                    @foreach($familyDetailAllData as $row)
                                    <div class="family-detail-data mb-1 col-form-label-sm">
                                      <div class="card-text">
                                            @if(!empty(Arr::get($row, 'picture')))
                                                <img src="{{asset(config('constants.files.familydetail'))}}/thumbnail/{{ Arr::get($row, 'picture') }}"   class="center" > 
                                            @else
                                                <img src="{{asset('assets/images/default/profile.jpg')}}"  class="center" >
                                            @endif
                                      </div>   
                                    
                                      <div class="card-text">
                                            @if(array_key_exists(Arr::get($row, 'relation_id'), config('constants.relation_options')))   
                                                {{config('constants.relation_options')[Arr::get($row, 'relation_id')]}}
                                            @endif    
                                       </div>
                                        <div class="card-text">{{Arr::get($row, 'name')}}</div>
                                        <div class="card-text">
                                                {{ date("M d, Y", strtotime(Arr::get($row, 'date_of_birth'))) }}
                                        </div>
                                       
                                    </div>

                                    @if(count($familyDetailAllData) !=$familyDetailCounter )
                                       <hr>
                                    @endif
                                    @php $familyDetailCounter++; @endphp
                                   
                                    @endforeach

                                @endif
                                
                            </div>    
                  
                        </div>
                    </div>
                
                    <!--//card 6-->
            </div>

        </div>
        <!--//Row4-->
    
    
    </div>
</section>

<!--tabs -->
<style>
.row {
    margin-right: 30px !important;
    margin-left: 0px !important;
}
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
.col-sm-2{
    margin-top:7px !important;
}
</style>


<div class="tab">
  <button id="ReviewButton" class="tablinks"  onclick="openTab(event, 'Review')">Review</button>
  <button id="PhoneButton" class="tablinks"  onclick="openTab(event, 'Phone')">Phone</button>
  <button id="ScheduleButton" class="tablinks"  onclick="openTab(event, 'Schedule')">Schedule</button>
  <button id="DocumentButton" class="tablinks"  onclick="openTab(event, 'Document')">Documents</button>
  <button id="PortfolioButton" class="tablinks"  onclick="openTab(event, 'Portfolio')">Portfolio</button>
</div>
<!--Review-->
<div id="Review" class="tabcontent mb-3">
    <h3>Review</h3>
    @if(Auth::user()->can('candidates.reviewStore'))
    <div class="container">
        <div class="row">
            <div class="col mt-4">
                <form class="py-2 px-4" action="{{ route('candidates.reviewStore') }}" style="box-shadow: 0 0 10px 0 #ddd;" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" name="candidate_id" value="{{ Arr::get($candidateData,'id')}}">
                    <div class="form-group row mt-4">
                        <div class="col">
                            <textarea class="form-control" name="review" rows="3" cols="50" placeholder="Enter your review here..." >{{ old('conversation') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button class="btn btn-sm py-2 px-3 btn-info">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif


    @if(!empty($reviews))
        
        @foreach($reviews as $review)
        <div class="container">
            <div class="row">
                <div class="col mt-4">
                    <div class="py-2 px-2" style="box-shadow: 0 0 10px 0 #ddd;">
                        <div class="row">
                            <div class="col-sm-1"><h5>{{ ucwords(Arr::get($review->user,'name'))}} </h5></div>
                            <div class="col-sm-2">@if(!empty(Arr::get($review, 'created_at'))){{ date("M d, Y H:i:s", strtotime(Arr::get($review, 'created_at'))) }}@endif </div>
                        </div>
                        <p class="font-weight-bold ">{{ Arr::get($review,'review')}}</p>
                        @if(Auth::user()->hasRole('admin'))
                        
                        {!! Form::open(['method' => 'DELETE','route' => ['candidates.reviewDestroy', $review->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                        {!! Form::hidden('candidate_id',Arr::get($candidateData,'id'))  !!}
                        {!! Form::submit('Remove', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                        
                        @endIf
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

<!--Review-->
<div id="Phone" class="tabcontent mb-3">
  <h3>Phone Conversation</h3>
    @if(Auth::user()->can('candidates.phoneConversationStore'))
        <div class="container">
            <div class="row">
                <div class="col mt-4">
                    <form class="py-2 px-4" action="{{ route('candidates.phoneConversationStore') }}" style="box-shadow: 0 0 10px 0 #ddd;" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="candidate_id" value="{{ Arr::get($candidateData,'id')}}">
                        <div class="form-group row mt-4">
                            <div class="col">
                                <textarea class="form-control content" name="conversation" rows="3" cols="50" placeholder="Enter your phone conversation here..." >{{ old('conversation') }}</textarea>
                            </div>
                        </div>
                        <div class="mt-3 text-end">
                            <button class="btn btn-sm py-2 px-3 btn-info">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if(!empty($conversations))
        
        @foreach($conversations as $conversation)
        <div class="container">
            <div class="row">
                <div class="col mt-4">
                    <div class="py-2 px-2" style="box-shadow: 0 0 10px 0 #ddd;">
                        <div class="row">
                            <div class="col-sm-1"><h5>{{ ucwords(Arr::get($conversation->user,'name'))}} </h5></div>
                            <div class="col-sm-2">@if(!empty(Arr::get($conversation, 'created_at'))){{ date("M d, Y H:i:s", strtotime(Arr::get($conversation, 'created_at'))) }}@endif </div>
                        </div>
                        <p class="font-weight-bold ">{!! Arr::get($conversation, 'conversation') !!} </p>
                        @if(Auth::user()->hasRole('admin'))

                        {!! Form::open(['method' => 'DELETE','route' => ['candidates.phoneConversationDestroy', $conversation->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                        {!! Form::hidden('candidate_id',Arr::get($candidateData,'id'))  !!}
                        {!! Form::submit('Remove', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                        
                        
                        @endIf
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif

</div>

<div id="Schedule" class="tabcontent mb-3">
  <h3>Schedule</h3>
    
    @if(Auth::user()->can('candidates.scheduleStore'))
        <form class="py-2 px-4" action="{{ route('candidates.scheduleStore') }}" style="box-shadow: 0 0 10px 0 #ddd;" method="POST" autocomplete="off">
            @csrf
            <input type="hidden" name="candidate_id" value="{{ Arr::get($candidateData,'id')}}">
            <div class="row mb-3">
                <label for="schedule_time" class="form-label">Schedule Time</label>
                <input id="schedule" name="schedule_time" class="form-control" type="text" placeholder="Schedule Time" value="{{ old('schedule_time') }}" readonly="true">
            </div>
            <div class="row mb-3">
                <label for="schedule_status_id" class="form-label">Status</label>
            
                <select class="form-control form-control-sm" id="schedule_status_id"  name="schedule_status_id" >
                    <option value=''>Select Status</option>
                    @if(!empty($candidateScheduleStatuses) )
                        @foreach($candidateScheduleStatuses as $candidateScheduleStatus)
                            @if(old('schedule_status_id') == Arr::get($candidateScheduleStatus, 'id'))
                                <option value="{{ trim(Arr::get($candidateScheduleStatus, 'id')) }}" selected>{{trim(Arr::get($candidateScheduleStatus, 'name'))}}</option> 
                            @else
                                <option  value="{{trim(Arr::get($candidateScheduleStatus, 'id'))}}" >{{trim(Arr::get($candidateScheduleStatus, 'name'))}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="mt-3 text-end">
                <button class="btn btn-sm py-2 px-3 btn-info">Submit</button>
            </div>
        </form>
    @endif

    @if(!empty($candidateSchedules))
        
        @foreach($candidateSchedules as $candidateSchedule)
        <div class="container">
            <div class="row">
                <div class="col mt-4">
                    <div class="py-2 px-2" style="box-shadow: 0 0 10px 0 #ddd;">
                        <div class="row">
                            <div class="col-sm-1"><h5>{{ ucwords(Arr::get($candidateSchedule->user,'name'))}} </h5></div>
                            <div class="col-sm-2">@if(!empty(Arr::get($candidateSchedule, 'created_at'))){{ date("M d, Y H:i:s", strtotime(Arr::get($candidateSchedule, 'created_at'))) }}@endif </div>
                        </div>
                        <p class="font-weight-bold ">Schedule Time : {{ date("M d, Y H:i", strtotime(Arr::get($candidateSchedule, 'schedule_time'))) }} </p>
                        <p class="font-weight-bold ">Schedule Status: {{Arr::get($candidateSchedule->scheduleStatus, 'name') }} </p>
                        @if(Auth::user()->hasRole('admin'))

                        {!! Form::open(['method' => 'DELETE','route' => ['candidates.scheduleDestroy', $candidateSchedule->id],'style'=>'display:inline','onsubmit' => 'return ConfirmDelete()']) !!}
                        {!! Form::hidden('candidate_id',Arr::get($candidateData,'id'))  !!}
                        {!! Form::submit('Remove', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                        
                        
                        @endIf
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif
  
</div>


<div id="Document" class="tabcontent mb-3">
    <hr class="bg-danger border-2 border-top border-danger">
    <h3 class="h3"><b>Personal Documents</b></h3>
    <hr class="bg-danger border-2 border-top border-danger">
    @if(!empty($defaultDocumentArray))
        @foreach($defaultDocumentArray as $row) 
            <div class="container">
                <div class="row">
                    <div class="col mt-4">
                        <div class="py-2 px-2" style="box-shadow: 0 0 10px 0 #ddd;">
                            <div>
                                <label class="col-5 col-form-label col-form-label">{{Helper::replaceUnderscoreWithSpaceAndUpperCaseFirstCharacter($row['document_name'])}}</label>
                                @if(Helper::isFileExtensionForIcon(Arr::get($row,'file')))
                                    <img class="center" src="{{asset(config('constants.files.filetypes'))}}/{{Helper::isFileExtensionForIcon(Arr::get($row,'file'))}}" >
                                @else
                                    <img class="center" src="{{asset(config('constants.files.douments'))}}/thumbnail/{{Arr::get($row,'file')}}" >
                                @endif
                                <a class="" onclick="return confirm('Do you wish to remove?')" href="{{ route('candidate.document.delete',['candidateId' => Arr::get($candidateData,'id'), 'id' => Arr::get($row,'id')])}}"><span class="fa fa-remove"></span></a>
                                <a class="downloadFile" data-filepath="{{asset(config('constants.files.douments'))}}/{{Arr::get($row,'file')}}">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    @php $defaultRemainingDocumentName = Helper::defaultRemainingDocumentName($defaultDocumentArray); @endphp
    @foreach($defaultRemainingDocumentName as $r)
        <div class="container">
            <div class="row">
                <div class="col mt-4">
                    <div class="py-2 px-2" style="box-shadow: 0 0 10px 0 #ddd;">
                        <div>
                            <label class="col-5 col-form-label col-form-label">{{Helper::replaceUnderscoreWithSpaceAndUpperCaseFirstCharacter($r)}}</label>
                            <p class="p">Document Not Uploaded!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @if(!empty($candidateExperienceRequiredDocments))
        <hr class="bg-danger border-2 border-top border-danger">
        <h3 class="h3"><b>Experience Documents</b></h3>
        <hr class="bg-danger border-2 border-top border-danger">
        @foreach($candidateExperienceRequiredDocments as $key=>$value)
            <div class="container">
                <div class="row">
                    <div class="col mt-4">
                        <div class="py-2 px-2" style="box-shadow: 0 0 10px 0 #ddd;">
                            <div>
                                @php $candidateExperiences = false;  @endphp
                                @if(!empty(Arr::get($dynamicDocumentsArray,'candidate_experiences')))
                                    @if(!empty(Arr::get($dynamicDocumentsArray['candidate_experiences'],$key)))
                                        @php $candidateExperiences = Arr::get($dynamicDocumentsArray['candidate_experiences'],$key); @endphp
                                    @endif 
                                @endif
                                <label for="{{$value}}" class="col-5 col-form-label col-form-label">{{Helper::replaceUnderscoreWithSpaceAndUpperCaseFirstCharacter($value)}}</label>
                                @if(!empty($candidateExperiences))
                                    @if(Helper::isFileExtensionForIcon(Arr::get($candidateExperiences,'file')))
                                        <img class="center" src="{{asset(config('constants.files.filetypes'))}}/{{Helper::isFileExtensionForIcon(Arr::get($candidateExperiences,'file'))}}" >
                                    @else
                                        <img class="center" src="{{asset(config('constants.files.douments'))}}/thumbnail/{{Arr::get($candidateExperiences,'file')}}" >
                                    @endif
                                    <a class="" onclick="return confirm('Do you wish to remove?')" href="{{ route('candidate.document.delete',['candidateId' => Arr::get($candidateData,'id'), 'id' => Arr::get($candidateExperiences, 'id')])}}"><span class="fa fa-remove"></span></a>
                                    <a class="downloadFile" data-filepath="{{asset(config('constants.files.douments'))}}/{{Arr::get($candidateExperiences,'file')}}">Download</a>
                                @else
                                    <p class="p">Document Not Uploaded!</p>
                                @endif      
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    @if(!empty($candidateEducationalQualificationDocments))
        <hr class="bg-danger border-2 border-top border-danger">
        <h3 class="h3"><b>Educational Documents</b></h3>
        <hr class="bg-danger border-2 border-top border-danger">
        @foreach($candidateEducationalQualificationDocments as $key=>$value)
            @php $candidateEducations = false;  @endphp
            @if(!empty(Arr::get($dynamicDocumentsArray,'candidate_educations')))
                @if(!empty(Arr::get($dynamicDocumentsArray['candidate_educations'],$key)))
                    @php $candidateEducations = Arr::get($dynamicDocumentsArray['candidate_educations'],$key); @endphp
                @endif   
            @endif
            <div class="container">
                <div class="row">
                    <div class="col mt-4">
                        <div class="py-2 px-2" style="box-shadow: 0 0 10px 0 #ddd;">
                            <div>
                                <label for="{{$value}}" class="col-5 col-form-label col-form-label">{{Helper::replaceUnderscoreWithSpaceAndUpperCaseFirstCharacter($value)}}</label>
                                @if(!empty($candidateEducations))
                                    @if(Helper::isFileExtensionForIcon(Arr::get($candidateEducations,'file')))
                                        <img class="center" src="{{asset(config('constants.files.filetypes'))}}/{{Helper::isFileExtensionForIcon(Arr::get($candidateEducations,'file'))}}" >
                                    @else
                                        <img class="center" src="{{asset(config('constants.files.douments'))}}/thumbnail/{{Arr::get($candidateEducations,'file')}}" >
                                    @endif
                                    <a class="" onclick="return confirm('Do you wish to remove?')" href="{{ route('candidate.document.delete',['candidateId' => Arr::get($candidateData,'id'), 'id' => Arr::get($candidateEducations, 'id')])}}"><span class="fa fa-remove"></span></a>
                                    <a class="downloadFile" data-filepath="{{asset(config('constants.files.douments'))}}/{{Arr::get($candidateEducations,'file')}}">Download</a>
                                @else
                                    <p class="p">Document Not Uploaded!</p>    
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        @endforeach
    @endif  
</div>

<div id="Portfolio" class="tabcontent mb-3">
    <hr class="bg-danger border-2 border-top border-danger">
    <h3 class="h3"><b>Portfolio Attachments</b></h3>
    <hr class="bg-danger border-2 border-top border-danger">
    @if(!empty($candidateAttachments))
        @foreach($candidateAttachments as $r)
            <div class="container">
                <div class="row">
                    <div class="col mt-4">
                        <div class="py-2 px-2" style="box-shadow: 0 0 10px 0 #ddd;">
                            <div>
                                @if(Helper::isFileExtensionForIcon(Arr::get($r,'file')))
                                    <img class="center" src="{{asset(config('constants.files.filetypes'))}}/{{Helper::isFileExtensionForIcon(Arr::get($r,'file'))}}" >
                                @else
                                    <img class="center" src="{{asset(config('constants.files.portfolio'))}}/thumbnail/{{Arr::get($r,'file')}}" >
                                @endif
                                <a class="" onclick="return confirm('Do you wish to remove?')" href="{{ route('candidate.portfolio.delete',['candidateId' => Arr::get($candidateData,'id'), 'id' => Arr::get($r,'id')])}}"><span class="fa fa-remove"></span></a>
                                <a class="downloadFile" data-filepath="{{asset(config('constants.files.portfolio'))}}/{{Arr::get($r,'file')}}">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p class="p">Portfolios Not Uploaded!</p> 
    @endif
</div>

<!--tabs-->
<script>

@if(!old('candidate_id'))
   
$(document).ready(function(){
    @if(!Session::get('success'))
        localStorage.clear();
    @endif
});
@endif

let storageTabName= localStorage.getItem('tab_name');
if(storageTabName)
{
    openTab('', storageTabName);
    $('.tablinks').removeClass('active');
    $('#'+storageTabName+'Button').addClass('active');
}
else{
    openTab('', 'Review');
    $('.tablinks').removeClass('active');
    $('#ReviewButton').addClass('active');
}


function openTab(evt, tabName) 
{
  // set item in localstorage
  localStorage.setItem("tab_name", tabName);
  
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  
  document.getElementById(tabName).style.display = "block";
  if(evt)
  {
    for (i = 0; i < tablinks.length; i++) 
    {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    evt.currentTarget.className += " active";
  }
  
}





    function printSection()
    {
       var printContents = document.getElementById("printSection").innerHTML;
       var originalContents = document.body.innerHTML;
       document.body.innerHTML = "<html><head><title></title></head><body>" + printContents + "</body>";
       window.print();
       document.body.innerHTML = originalContents;
    } 


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
<!--Editor-->
<link href="{!! url('assets/bootstrap/css/bootstrap_3.4.1.min.css') !!}" rel="stylesheet">
<link href="{!! url('assets/css/summernote.min.css') !!}" rel="stylesheet">
<script src="{!! url('assets/js/summernote.min.js') !!}"></script>
<script>
$( document ).ready(function() {
    
    $('.content').summernote({

    height:300,

    });
    

});
$(document).on('click', '.downloadFile', function (e) {
            e.preventDefault();  //stop the browser from following
    
            var filepath = $(this).attr('data-filepath');
            window.open(filepath , '_blank');
        });

</script>   
<!--Editor-->

<script src="{!! url('assets/js/datetimepicker/moment.min.js') !!}"></script>
<link href="{!! url('assets/css/datetimepicker/jquery.datetimepicker.min.css') !!}" rel="stylesheet" />
<script src="{!! url('assets/js/datetimepicker/jquery.datetimepicker.full.min.js') !!}"></script>
<script>
jQuery.datetimepicker.setDateFormatter({
  parseDate: function(date, format) {
    var d = moment(date, format);
    return d.isValid() ? d.toDate() : false;
  },
  formatDate: function(date, format) {
    return moment(date).format(format);
  }
});


//try to use different date format
$("#schedule").datetimepicker({
  step: 5, //minutes
  format: 'DD-MM-YYYY H:mm',
  formatTime: "H:mm",
  formatDate: "DD/MM/YYYY",
  minDate : 0,
  minTime:0, //default value set

  onSelectDate:function (currentDateTime) {
    var d = new Date();
    var todayDate = d.getDate();

   var minTime = 0;
    if (currentDateTime.getDate() != todayDate) { 
        minTime = false;
    }
    else{
        $('#schedule').val( d.getDate()+"-"+(d.getMonth()+1)+"-"+d.getFullYear()+" "+d.getHours()+":"+d.getMinutes());
    }
    
        this.setOptions({
        minTime:minTime
    });
  },

});

</script>
@endsection
