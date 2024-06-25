<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Job; 
use App\Models\Applicant;
use App\Models\JobPostedBenefit;
use App\Models\CandidateDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\AreaOfInterestGroup as AreaOfInterestGroup;
use App\Models\CandidateDetail;
use App\Models\CandidateEducation;
use App\Models\JobType;

class JobController extends Controller
{
    //Landing Page For Jobs
    public function landingPage(Request $request)
    {
        $data = array();
        
        $areaOfInterestGroups           = new AreaOfInterestGroup();
        $jobObject                      = new Job();
        $jobTypeObject                  = new JobType();  

        $data['cities']                             = config('constants.cities');
        $data['areaOfInterestGroups']               = $areaOfInterestGroups->getAllEnabledgetAreaOfInterestGroups();
        #All enabled  jobs types
        $data['jobTypes']                           = $jobTypeObject->getAllEnabledJobTypes();
        $data['jobsCountViaAreaOfInterestGroups']   = $jobObject->jobCountViaAreaOfInterestGroup();
        $data['methodName']                         = $request->route()->getActionMethod();
        
        return view('frontend.jobs.landing_page')->with($data);
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array();

        $searchCondition = array();
        $filterData = array();
        $searchLikeCondition = array();
        
        $title      = $request->query('title');
        $city       = $request->query('city');
        $category   = $request->query('category');
        $jobType    = $request->query('jobType');
      
        
        $filterData['title']                    = $title;
        $filterData['city']                     = $city;
        $filterData['category']                 = $category;
        $filterData['jobTypeSelectedId']        = $jobType;
        
        
        if(!empty($title)){
            $searchLikeCondition = array( array('title', 'like', '%'.$title.'%'));
        }
        
        if(!empty($city)){
            $searchCondition['city_id'] = $city;
        }

        if(!empty($category)){
            $searchCondition['area_of_interest_group_id'] = $category;
        }

        if(!empty($jobType)){
            $searchCondition['job_type_id'] = $jobType;
        }

    
        $areaOfInterestGroups           = new AreaOfInterestGroup();
        $jobTypeObject                  = new JobType();  

        $now    = Carbon::now()->toDateString();
        $jobs                       = Job::select('id','title','city_id','area_of_interest_group_id','job_type_id','start_date','end_date','created_at')
                                            ->where(['job_status_id'=>config('constants.job_statuses.approved')])
                                            ->where('start_date', '<=', $now) 
                                            ->where('end_date', '>=', $now)
                                            ->where($searchCondition)->where($searchLikeCondition)
                                            ->latest()->paginate(config('constants.per_page'));
        
        $data['jobs']                       = $jobs;
        $data['cities']                     = config('constants.cities');
        $data['areaOfInterestGroups']       = $areaOfInterestGroups->getAllEnabledgetAreaOfInterestGroups();
        $data['jobTypes']                   = $jobTypeObject->getAllEnabledJobTypes();
        $data['methodName']                 = $request->route()->getActionMethod();

        if(!empty(Auth::guard('candidate')->user()->id))
        {
            return view('frontend.jobs.auth_list')->with($data)->with($filterData);;
        }
        else{
            return view('frontend.jobs.list')->with($data)->with($filterData);;
        }
        
    } 

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function jobDetail(Request $request)
    {
        $data = array();

       
        $jobObject = new Job();
        $applicantObject = new Applicant();
        
        
        $jobId                          = $request->id;
        $jobDetail                      = $jobObject->getValidJobDetail($jobId);

        if(!empty($jobDetail))
        {
            $data['jobcityName']             = config('constants.cities.'.Arr::get($jobDetail, 'city_id'));
            $data['jobPostedBenefits']       = JobPostedBenefit::with('jobBenefit')->where(['job_id' => Arr::get($jobDetail, 'id') ])->get();
            $data['jobDetail']               = $jobDetail;
            $data['alreadyApplied']          = 0;
           
            if(!empty(Auth::guard('candidate')->user()->id)){
                $candidateId                     = Auth::guard('candidate')->user()->id;
                $data['alreadyApplied']          = $applicantObject->isCandidateAlreadyJobApplied($candidateId,$jobId);
                return view('frontend.jobs.auth_detail')->with($data);
            }
            else{
                return view('frontend.jobs.detail')->with($data);
            }  
            
        }else
        {
            return redirect()->route('jobs.list')->withErrors(['error' =>"!!!Job expired!!!"]);
        }
    }

    /**
     * apply for the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function applyForJob(Job $job)
    {
        
        $now    = Carbon::now()->toDateString();
        $jobObject = new Job();
        
        $jobDetail                       = $jobObject->getValidJobDetail($job->id);

        if(!empty($jobDetail))
        {
            $candidateDocumentObject = new CandidateDocument();
            
            $data = array();
            $candidateId                            = Auth::guard('candidate')->user()->id;
            $documentName                           = config('constants.default_document');
            $documentName                           = reset($documentName);

            $personalDetailObject                   = new CandidateDetail;
            $personalDetailData                     = $personalDetailObject->getCandidateDetail($candidateId);
            $candidateEducationObject               = new CandidateEducation;
            $candidateEducationCount                = $candidateEducationObject->educationCountByCandidateId($candidateId);


            $data['job']                            = $job;
            $data['resume']                         = $candidateDocumentObject->getDocumentName($candidateId, $documentName);
            $data['personalDetailData']             = $personalDetailData;
    
            $data['job']                            = $job;
            $data['resume']                         = $candidateDocumentObject->getDocumentName($candidateId,$documentName);
            $data['educationCount']                 = $candidateEducationCount;
            $data['educationalQualificationData']   = $candidateEducationObject->getCandidateEducationsByCandidateId($candidateId);

            #Field of study using select2 
            $data['fieldOfStudyParam'] = array('name'=>'field_of_study');

            return view('frontend.jobs.applyForJob')->with($data);
        }else{
            return redirect()->route('jobs.list')->withErrors(['error' =>"!!!Job expired!!!"]);
        }
    }


    /**
     * Job history.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {
        $applicantObject = new Applicant();
        $data                                   = array();
        $candidateId                            = Auth::guard('candidate')->user()->id;
        $candidateJobAppliedData                = $applicantObject->getApplicantJobs($candidateId);
        $data['candidateJobAppliedData']        = $candidateJobAppliedData;

        return view('frontend.jobs.candidate_history')->with($data);
       
    } 


     /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function historyJobDetail(Request $request)
    {
        $data = array();

       
        $jobObject = new Job();
        $applicantObject = new Applicant();
        
        
        $jobId                          = $request->jobId;

        $jobDetail                      = Job::where(['id' => $jobId])->first(); 
        $candidateId                    = Auth::guard('candidate')->user()->id;
        
        $data['jobcityName']             = config('constants.cities.'.Arr::get($jobDetail, 'city_id'));
        $data['jobPostedBenefits']       = JobPostedBenefit::with('jobBenefit')->where(['job_id' => Arr::get($jobDetail, 'id') ])->get();
        $data['jobDetail']               = $jobDetail;
    
        $data['alreadyApplied']          = $applicantObject->isCandidateAlreadyJobApplied($candidateId,$jobId);
        return view('frontend.jobs.partials.detail')->with($data);
       
    }
}
