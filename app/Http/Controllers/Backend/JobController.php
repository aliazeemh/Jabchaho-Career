<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job; 
use App\Models\JobBenefit;
use App\Models\JobPostedBenefit;
use App\Models\JobComments;
use App\Models\JobStatus;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Backend\JobRequest;
use App\Http\Requests\Backend\JobCommentRequest;
use App\Models\AreaOfInterestGroup as AreaOfInterestGroup;
use App\Models\AreaOfInterestOption;
use App\Models\JobType;
use Illuminate\Support\Carbon;
use App\Helpers\Helper;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $searchCondition = array();
        $filterData = array();
        
        $title            = $request->query('title');
        $cityId           = $request->query('city_id'); //
        $jobStatusId      = $request->query('job_status_id');
        $dashboardFilter  = $request->query('dashboard_filter');

        $filterData['title']                    = $title;
        $filterData['cityId']                   = $cityId;
        $filterData['jobStatusId']              = $jobStatusId;
        $filterData['dashboardFilter']          = $dashboardFilter;


        $searchLikeCondition = array();
        if(!empty($title)){
            $searchLikeCondition = array( array('title', 'like', '%'.$title.'%'));
        }


        if(!empty($cityId)){
            $searchCondition['city_id'] = $cityId;
        }

        $activeJobsCondition = false;
        if(!empty($jobStatusId)){
            if($jobStatusId == config('constants.job_statuses.active_jobs'))
            {
                $activeJobsCondition = true;
            }
            else{
                $searchCondition['job_status_id'] = $jobStatusId;
            }
           
        }

        $now                        = Carbon::now()->toDateString(); 
        $query                      = Job::with(['jobStatus'])->withCount('applicant')->where($searchCondition)->where($searchLikeCondition);

        if($activeJobsCondition)
        {
            $query->where('start_date', '<=', $now)->where('end_date', '>=', $now)->where(['job_status_id'=>config('constants.job_statuses.approved')]);
        }

        //dashboardFilter [all, day ,week and etc]
        if(!empty($dashboardFilter))
        {
            $datesArray = Helper::getDateByFilterValue($dashboardFilter);
 
            $startDate              = Arr::get($datesArray, 'startDate');
            $endDate                = Arr::get($datesArray, 'endDate');

            $query->where('start_date', '<=', $now)->where('end_date', '>=', $now)->whereBetween('created_at', [$startDate, $endDate])->where(['job_status_id'=>config('constants.job_statuses.approved')]);
        }
                                    
        $jobs                       =   $query->latest()->paginate(config('constants.per_page'));  

        //$jobs                       = Job::with(['jobStatus'])->withCount('applicant')->where($searchCondition)->where($searchLikeCondition)->latest()->paginate(config('constants.per_page'));
        
        $data['cities']             = config('constants.cities');
        $data['jobStatuses']        = JobStatus::select('id','name')->orderBy('name', 'asc')->get();
        $data['jobs']               = $jobs;

        return view('backend.jobs.index')->with($data)->with($filterData);;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jobBenefit                  = new JobBenefit();
        $areaOfInterestGroups        = new AreaOfInterestGroup();
        $jobTypeObject               = new JobType();  

        $data = array();
        $data['cities']             = config('constants.cities');
        $data['jobBenefits']        = $jobBenefit->getJobBenefits();
        $data['areaOfInterests']    = $areaOfInterestGroups->getAreaOfInterests();
        #All enabled  jobs types
        $data['jobTypes']           = $jobTypeObject->getAllEnabledJobTypes();

        return view('backend.jobs.create')->with($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {
        $validateValues = $request->validated();

        //Get area of interest group id on the basis of Area Of Interest Option id
        $areaOfIntrestGroupData = AreaOfInterestOption::select('area_of_interest_group_id')->where(['id' =>Arr::get($validateValues, 'area_of_interest_option_id') ])->first();
        
        $jobData = Job::create(array_merge($request->only('title','city_id','area_of_interest_group_id','area_of_interest_option_id','job_type_id', 'responsibility','requirement','start_date','end_date'),[
            'created_by' => auth()->id(),
            'job_status_id' => config('constants.job_statuses.pending_approval'),
            'area_of_interest_group_id' => Arr::get($areaOfIntrestGroupData, 'area_of_interest_group_id')
        ]));

        if(!empty($jobData))
        {
            $jobBenefitIds  = Arr::get($validateValues, 'job_benefit_id');

            $jobPostedBenefitData = array();
            if(!empty($jobBenefitIds)){
                foreach($jobBenefitIds as $jobBenefitId){
                    $jobPostedBenefitData[] = array
                    (
                            'job_id'                => Arr::get($jobData, 'id'),
                            'job_benefit_id'        => $jobBenefitId
                    );   
                }
            }

            if(!empty($jobPostedBenefitData)){
                JobPostedBenefit::insert($jobPostedBenefitData);
            }

        }

        return redirect()->route('jobs.index')
            ->withSuccess(__('Job created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        $jobCommentsObject           = new JobComments();

        
        $data = array();
        $jobId                      = Arr::get($job, 'id');
        $data['jobStatusName']      = JobStatus::select('name')->where(['id' =>Arr::get($job, 'job_status_id') ])->first();
        $data['jobPostedBenefits']  = JobPostedBenefit::with('jobBenefit')->where(['job_id' => Arr::get($job, 'id') ])->get();
        $data['jobcityName']        = config('constants.cities.'.Arr::get($job, 'city_id'));
        $data['jobComments']        = $jobCommentsObject->getJobComments($jobId);
        $data['jobStatuses']        = JobStatus::select('id','name')
                                        ->whereNotIn('id', [config('constants.job_statuses.pending_approval'), config('constants.job_statuses.active_jobs')  ])
                                        ->get();
        $data['job']                = $job;


        return view('backend.jobs.show')->with($data);
    }


    /**
     * comment on the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function commentJob(JobCommentRequest $request, Job $job){

        $validateValues = $request->validated();
        
        $jobStatusId  = Arr::get($validateValues, 'job_status_id');

        $comment      = Arr::get($validateValues, 'comment');
        $jobId        = Arr::get($job, 'id');
        
        //Comments add
        JobComments::create([
            'job_status_id'     => $jobStatusId,
            'comment'           => $comment, 
            'created_by'        => auth()->id(),
             'job_id'           => $jobId,
        ]);

        //update status on job table

        $jobData = $job->update([
            'job_status_id' => $jobStatusId,
            'updated_by' => auth()->id()
        ]);

        return redirect()->back()->with('success', "Comment Added successfully.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        $jobBenefit                  = new JobBenefit();
        $areaOfInterestGroups        = new AreaOfInterestGroup();
        $jobTypeObject               = new JobType(); 

        $data = array();
        $jobId  = Arr::get($job, 'id');
        
        $data['job']                = $job;
        $data['cities']             = config('constants.cities');
        $data['jobBenefits']        = $jobBenefit->getJobBenefits();
        $data['areaOfInterests']    = $areaOfInterestGroups->getAreaOfInterests();
        $data['jobPostedBenefits']  =  JobPostedBenefit::where(['job_id' => $jobId ])->get();
        #All enabled  jobs types
        $data['jobTypes']           = $jobTypeObject->getAllEnabledJobTypes();
 

        return view('backend.jobs.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(JobRequest $request, Job $job)
    {
        $validateValues = $request->validated();

        //Get area of interest group id on the basis of Area Of Interest Option id
        $areaOfIntrestGroupData = AreaOfInterestOption::select('area_of_interest_group_id')->where(['id' =>Arr::get($validateValues, 'area_of_interest_option_id') ])->first();
        
        $jobData = $job->update(array_merge($request->only('title','city_id','area_of_interest_group_id','area_of_interest_option_id','job_type_id', 'responsibility','requirement','start_date','end_date'),[
            'updated_by' => auth()->id(),
            'job_status_id' => config('constants.job_statuses.pending_approval'),
            'area_of_interest_group_id' => Arr::get($areaOfIntrestGroupData, 'area_of_interest_group_id')
        ]));

        if(!empty($jobData))
        {
            $jobBenefitIds  = Arr::get($validateValues, 'job_benefit_id');

            $jobPostedBenefitData = array();
            if(!empty($jobBenefitIds)){
                foreach($jobBenefitIds as $jobBenefitId){
                    $jobPostedBenefitData[] = array
                    (
                            'job_id'                => Arr::get($job, 'id'),
                            'job_benefit_id'        => $jobBenefitId
                    );   
                }
            }

            JobPostedBenefit::where(['job_id'=> Arr::get($job, 'id')])->delete();
            if(!empty($jobPostedBenefitData)){
                JobPostedBenefit::insert($jobPostedBenefitData);
            }

            //

            $comment      = Arr::get($validateValues, 'comment');
            
            //Comments add
            JobComments::create([
                'job_status_id'     => config('constants.job_statuses.pending_approval'),
                'comment'           => $comment, 
                'created_by'        => auth()->id(),
                'job_id'           => Arr::get($job, 'id')
            ]);

        }



        return redirect()->route('jobs.index')
        ->withSuccess(__('Job updated successfully.'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CandidateReview  $candidateReview
     * @return \Illuminate\Http\Response
     */
    public function jobCommentDestroy(Request $request)
    {
        if(Auth::user()->hasRole('admin'))
        {
            $jobCommentId = (int) $request->segment(4);

            JobComments::where(['id'=>$jobCommentId])->delete();
            return redirect()->back()->with('success', "Comment Removed Successfully.");
        } 
        else
        {
            return redirect()->back()
            ->withErrors("Sorry you don't have permission to remove");
        }   

       
    }

}
