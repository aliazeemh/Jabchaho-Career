@extends('frontend.layouts.app-master')
@section('title', 'View Profile')
@section('content')



<div class="card first-child">
    
    <!--header -->
    <div class="card-header">
        <div class="row mb-3">
            <h4 class="col-sm-12">Profile</h4>
            <div class="col-sm-6 text-center m-auto">
                <small>Progress: <span id="ContentContainer_lblProgressPercentage">{{$profilePercentage}}%</span></small>
                <br/>
                <br/>
                <div class="progress">
                    <span class="progress-bar" role="progressbar" style="width: {{$profilePercentage}}%;" aria-valuenow="{{$profilePercentage}}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>  
        </div>    
    </div>    
    <!--//header -->
    
    
    <!--body -->
    <div class="card-body">
        
    <!--Two Column-->
    <div class="container">
        <div class="row">
            <!--First column-->
                <div class="col-sm">
                    <!--card 1 --Experience-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            
                            <div class="row">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Experience</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="{{ route('professional.experience.show') }}" >Edit</a>
                                    </label>
                                </div>

                                @if(!empty($professionalExperienceAllData))
                                    @php $experienceCounter=0;@endphp
                                    @foreach($professionalExperienceAllData as $row)
                                    <div class="experience-data mb-1 col-form-label-sm"  @if($experienceCounter>=2) style="display:none" @endif>
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
                                    @php $experienceCounter++; @endphp
                                   
                                    @endforeach
                                   
                                    @if(count($professionalExperienceAllData) >2)
                                        <a id="experience-anchor" style="display:block;" class="" data-original-title="" title=""><img src="{{asset('assets/images/icons/buttons/bottom-arrow.png')}} " > See complete information</a>
                                    @endif
                                @else 
                                    <p class="col-sm-10 col-form-label col-form-label-sm"> No record Found.</p>
                                @endif
                               
                            </div>
                            
                           
                        </div>
                    </div>
                   
                    <!--//card 1-->


                    <!--card 2 --Education-- -->
                    <div class="card mb-3">
                        <div class="card-body">

                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Education</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="{{ route('educational.qualification.show') }}" >Edit</a>
                                    </label>
                                </div>
                                @if(!empty($educationalQualificationAllData))
                                    @php $educationCounter=0;@endphp
                                    @foreach($educationalQualificationAllData as $row)
                                    <div class="education-data mb-1 col-form-label-sm" @if($educationCounter>=2) style="display:none" @endif>
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
                               
                                    @php $educationCounter++; @endphp
                                   
                                    @endforeach
                                    
                                    @if(count($educationalQualificationAllData) >2)
                                        <a id="education-anchor" style="display:block;" class="" data-original-title="" title=""><img src="{{asset('assets/images/icons/buttons/bottom-arrow.png')}} " > See complete information</a>
                                    @endif
                                @else 
                                    <p class="col-sm-10 col-form-label col-form-label-sm"> No record Found.</p>
                                @endif
                               
                            </div>    
                        
                        
                           
                        </div>
                    </div>
                    
                    <!--//card 2-->


                    <!--card 3 --Diplomas-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Diplomas</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="{{ route('diploma.show') }}" >Edit</a>
                                    </label>
                                </div>
                                @if(!empty($diplomaAllData))
                                    @php $diplomaCounter=0;@endphp
                                    @foreach($diplomaAllData as $row)
                                    <div class="diploma-data mb-1 col-form-label-sm" @if($diplomaCounter>=2) style="display:none" @endif>
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
                               
                                    @php $diplomaCounter++; @endphp
                                   
                                    @endforeach
                                
                                    @if(count($diplomaAllData) >2)
                                        <a id="diploma-anchor" style="display:block;" class="" data-original-title="" title=""><img src="{{asset('assets/images/icons/buttons/bottom-arrow.png')}} " > See complete information</a>
                                    @endif
                                @else 
                                    <p class="col-sm-10 col-form-label col-form-label-sm"> No record Found.</p>
                                @endif
                                
                            </div>    
                        </div>
                    </div>
                    <!--//card 3-->

                     <!--card 4 --Certifications-- --> 
                     <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Certifications</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="{{ route('certification.show') }}" >Edit</a>
                                    </label>
                                </div>
                                @if(!empty($certificateAllData))
                                    @php $certificateCounter=0;@endphp
                                    @foreach($certificateAllData as $row)
                                    <div class="certification-data mb-1 col-form-label-sm" @if($certificateCounter>=2) style="display:none" @endif>
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
                               
                                    @php $certificateCounter++; @endphp
                                   
                                    @endforeach
                                 
                                    @if(count($certificateAllData) >2)
                                        <a id="certification-anchor" style="display:block;" class="" data-original-title="" title=""><img src="{{asset('assets/images/icons/buttons/bottom-arrow.png')}} " > See complete information</a>
                                    @endif
                                @else 
                                    <p class="col-sm-10 col-form-label col-form-label-sm"> No record Found.</p>
                                @endif
                                
                            </div>        
                        
                        </div>
                    </div>
                    <!--//card 4-->

                    <!--card 5 --Portfolio-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Portfolio</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="{{ route('portfolio.show') }}" >Edit</a>
                                    </label>
                                </div>
                                @if(!empty($candidatePortfolioDetail))
                                    @php $portfolioDetailCounter=0;@endphp
                                    @foreach($candidatePortfolioDetail as $row)
                                    <div class="portfolio-detail-data" @if($portfolioDetailCounter>=2) style="display:none" @endif>
                                        <div class="row mb-1 card-text">
                                            <label class="col-sm-3 col-form-label col-form-label-sm">{{Arr::get($row, 'title')}}</label>
                                            <div class="col-sm-9">
                                            <label class="col-form-label-sm">{{Arr::get($row, 'url')}}</label>
                                            </div>
                                        </div>
                                    </div>
                               
                                    @php $portfolioDetailCounter++; @endphp
                                   
                                    @endforeach
                                   
                                    @if(count($candidatePortfolioDetail) >2)
                                        <a id="portfolio-detail-anchor" style="display:block;" class="" data-original-title="" title=""><img src="{{asset('assets/images/icons/buttons/bottom-arrow.png')}} " > See complete information</a>
                                    @endif
                                @else 
                                    <p class="col-sm-10 col-form-label col-form-label-sm"> No record Found.</p>
                                @endif
                               
                            </div>         
                            
                        </div>
                    </div>
                  
                    <!--//card 5-->


                     <!--card 6 --Skill Set-- -->
                     <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Skill Set</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="{{ route('skillset.show') }}" >Edit</a>
                                    </label>
                                </div>
                                @if(!empty($skillSets) )
                                    <div class="card-text">
                                        @foreach($skillSets as $row)
                                         <span class="badge bg-light text-dark">{{Arr::get($row->skillSet, 'name')}}</span>
                                        @endforeach
                                    </div>    
                                @else 
                                    <p class="col-sm-10 col-form-label col-form-label-sm"> No record Found.</p>
                                @endif   
                               
                            </div>   
                        </div>
                    </div>
                    <!--//card 6-->


                </div>
            <!--//First column-->


            <!--Second column-->
            <div class="col-sm">
                 <!--card 1 --Personal Information-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Personal Information</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="{{ route('personal.details.show') }}" >Edit</a>
                                    </label>
                                </div>
                            </div>   
                            
                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Gender</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm">
                                @if(array_key_exists(Arr::get($personalDetailData, 'gender'), config('constants.gender_options')))   
                                        {{config('constants.gender_options')[Arr::get($personalDetailData, 'gender')]}}
                                @endif
                                    </label>
                                </div>
                            </div>
                            
                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Birthday</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm"> @if(!empty(Arr::get($personalDetailData, 'date_of_birth'))){{ date("M d, Y", strtotime(Arr::get($personalDetailData, 'date_of_birth'))) }}@endif</label>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Marital Status</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm"> @if(array_key_exists(Arr::get($personalDetailData, 'marital_status'), config('constants.marital_statuses')))   
                                        {{config('constants.marital_statuses')[Arr::get($personalDetailData, 'marital_status')]}}
                                @endif</label>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Nationality</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm">
                                @if(array_key_exists(Arr::get($personalDetailData, 'nationality'), config('constants.nationality')))   
                                            {{config('constants.nationality')[Arr::get($personalDetailData, 'nationality')]}}
                                    @endif
                                </label>
                                </div>
                            </div>
                            @if(Arr::get($personalDetailData, 'nationality')==1)
                            <div class="row mb-1">
                                <label for="CNIC" class="col-sm-5 col-form-label col-form-label-sm">CNIC</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm">{{Arr::get($personalDetailData, 'cnic')}}</label>
                                </div>
                            </div>
                            @else
                            <div class="row mb-1">
                                <label for="Passport" class="col-sm-5 col-form-label col-form-label-sm">Passport</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm">{{Arr::get($personalDetailData, 'passport')}}</label>
                                </div>
                            </div>
                            @endif

                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Religion</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm">
                                    @if(array_key_exists(Arr::get($personalDetailData, 'religion'), config('constants.religion')))   
                                            {{config('constants.religion')[Arr::get($personalDetailData, 'religion')]}}
                                    @endif
                                </label>
                                </div>
                            </div>

                        </div>
                    </div>
                
                    <!--//card 1-->


                    <!--card 2 --Contact Information-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Contact Information</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="{{ route('personal.details.show') }}" >Edit</a>
                                    </label>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Mobile Number</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm">{{Arr::get(Auth::guard('candidate')->user(), 'mobile_number')}}</label>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Landline Number</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm">{{Arr::get($personalDetailData, 'landline_number')}}</label>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Email Address</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm">{{Arr::get(Auth::guard('candidate')->user(), 'email')}}</label>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label for="EmailAddress" class="col-sm-5 col-form-label col-form-label-sm">Address</label>
                                <div class="col-sm-7">
                                <label class="col-form-label-sm">{{Arr::get($personalDetailData, 'house_no')}} {{Arr::get($personalDetailData, 'area')}} {{Arr::get($personalDetailData, 'street')}} 
                                @if(array_key_exists(Arr::get($personalDetailData, 'city'), config('constants.cities')))   
                                        {{config('constants.cities')[Arr::get($personalDetailData, 'city')]}}
                                @endif
                                </label>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!--//card 2-->


                    <!--card 3-->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <h4 class="col-sm-10 col-form-label col-form-label-sm">Family Details</h4>
                                <div class="col-sm-2">
                                    <label class="col-form-label-sm text-end">
                                        <a class="btn btn-primary btn-sm" href="{{ route('family.details.show') }}" >Edit</a>
                                    </label>
                                </div>
                                @if(!empty($familyDetailAllData))
                                    @php $familyDetailCounter=0;@endphp
                                    @foreach($familyDetailAllData as $row)
                                    <div class="family-detail-data mb-1 col-form-label-sm" @if($familyDetailCounter>=2) style="display:none" @endif>
                                      <div class="card-text">
                                            @if(!empty(Arr::get($row, 'picture')))
                                                <img src="{{asset(config('constants.files.familydetail'))}}/thumbnail/{{ Arr::get($row, 'picture') }}" > 
                                            @else
                                                <img src="{{asset('assets/images/default/profile.jpg')}}" >
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
                               
                                    @php $familyDetailCounter++; @endphp
                                   
                                    @endforeach
                                
                                    @if(count($familyDetailAllData) >2)
                                        <a id="family-detail-anchor" style="display:block;" class="" data-original-title="" title=""><img src="{{asset('assets/images/icons/buttons/bottom-arrow.png')}} " > See complete information</a>
                                    @endif
                                @else 
                                    <p class="col-sm-10 col-form-label col-form-label-sm"> No record Found.</p>
                                @endif
                                
                            </div>    
                  
                        </div>
                    </div>
                
                    <!--//card 3-->
            </div>
            <!--//Second column-->


        </div>
    </div>
    <!--//Two Column-->


    </div>
     <!--//body -->

</div>

<script>
   $(document).on('click', '#experience-anchor', function () {
        $('#experience-anchor').hide();
        $('.experience-data').show();

   });


   $(document).on('click', '#education-anchor', function () {
        $('#education-anchor').hide();
        $('.education-data').show();

   });


   $(document).on('click', '#diploma-anchor', function () {
        $('#diploma-anchor').hide();
        $('.diploma-data').show();

   });

   //certification

   $(document).on('click', '#certification-anchor', function () {
        $('#certification-anchor').hide();
        $('.certification-data').show();

   });

   //portfolio-detail
   $(document).on('click', '#portfolio-detail-anchor', function () {
        $('#portfolio-detail-anchor').hide();
        $('.portfolio-detail-data').show();

   });

   //family-detail
   $(document).on('click', '#family-detail-anchor', function () {
        $('#family-detail-anchor').hide();
        $('.family-detail-data').show();

   });
</script>    
@endsection