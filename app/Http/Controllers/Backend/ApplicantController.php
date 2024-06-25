<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\Job; 
use App\Models\Applicant; 
use App\Models\ApplicantStatus;
use App\Models\CandidateDocument;
use App\Models\ApplicantComments; 
use App\Http\Requests\Backend\ApplicantCommentRequest;
use App\Helpers\Helper;
use Illuminate\Support\Carbon;

class ApplicantController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $searchCondition = array();
        $searchLikeCondition = array();
        $filterData = array();
        
        $title                          = $request->query('title');
        $name                           = $request->query('name');
        $applicantsStatusId             = $request->query('applicant_status_id');
        $jobId                          = $request->query('job_id');
        $totalExperience                = $request->query('total_experience');
        $selectedLevelOfEducation       = $request->query('level_of_education');
        $selectedGender                 = $request->query('gender');
        $currentSalary                  = $request->query('current_salary');
        $expectedSalary                 = $request->query('expected_salary');
        $selectedCity                   = $request->query('city');
        $selectedMaritalStatus          = $request->query('marital_status');
        $dashboardFilter                = $request->query('dashboard_filter');

        $filterData['title']                            = $title;
        $filterData['name']                             = $name;
        $filterData['applicantsStatusId']               = $applicantsStatusId;
        $filterData['totalExperience']                  = $totalExperience;
        $filterData['selectedLevelOfEducation']         = $selectedLevelOfEducation;
        $filterData['jobId']                            = $jobId;
        $filterData['selectedGender']                   = $selectedGender;
        $filterData['currentSalary']                    = $currentSalary;
        $filterData['expectedSalary']                   = $expectedSalary;
        $filterData['selectedCity']                     = $selectedCity;
        $filterData['selectedMaritalStatus']            = $selectedMaritalStatus;
        $filterData['dashboardFilter']                  = $dashboardFilter;

        if(!empty($applicantsStatusId)){
            $searchCondition['applicant_status_id'] = $applicantsStatusId;
        }

        if(!empty($jobId)){
            $searchCondition['job_id'] = $jobId;
        }

        if(!empty($name)){
            $searchLikeCondition = array( array('full_name', 'like', '%'.$name.'%'));
        }

        $applicants = Applicant::with(['job','candidate'])
        ->whereHas('job',function($query) use ($title) {
            $query->where( array( array('title', 'like', '%'.$title.'%')));
          })
        ->whereHas('candidate',function($query) use ($totalExperience) {
            if(isset($totalExperience))
            {
                if(array_key_exists($totalExperience,config('constants.experience_range_condition'))){
                    
                    $rangeArray = config('constants.experience_range_condition')[$totalExperience]; //[0,2]
                    $query->whereBetween('total_experience', $rangeArray);
                }
            }
        })
        ->where($searchCondition)->where($searchLikeCondition);

        //Current Salary wise search
        if(isset($currentSalary) && $currentSalary !='0-0')
        {
            $currentSalaryRangeArray = explode('-',$currentSalary);

            $applicants->whereHas('CandidateExperience',function($query) use ($currentSalaryRangeArray) {
                $query->whereBetween('current_salary', $currentSalaryRangeArray);
                //$query->where(array('is_present' => 1));
            });
        }
        
        //Expected Salary wise search
        if(isset($expectedSalary) && $expectedSalary !='0-0')
        {
            $expectedSalaryRangeArray = explode('-',$expectedSalary);

            $applicants->whereHas('candidateDetail',function($query) use ($expectedSalaryRangeArray) {
                $query->whereBetween('expected_salary', $expectedSalaryRangeArray); 
            });
        }

        //Gender wise Search
        if(isset($selectedGender))
        {
            $applicants->whereHas('candidateDetail',function($query) use ($selectedGender) {
                    $query->where( array( array('gender', '=', $selectedGender)));    
            });
        }

        //city wise search
        if(isset($selectedCity))
        {
            $applicants->whereHas('candidateDetail',function($query) use ($selectedCity) {
                    $query->where( array( array('city', '=', $selectedCity)));    
            });
        }

        //marital_status wise search
        if(isset($selectedMaritalStatus))
        {
            $applicants->whereHas('candidateDetail',function($query) use ($selectedMaritalStatus) {
                    $query->where( array( array('marital_status', '=', $selectedMaritalStatus)));    
            });
        }

       
         //Level of education wise search
        if(!empty($selectedLevelOfEducation))
        {
            $applicants->whereHas('candidateEducation',function($query) use ($selectedLevelOfEducation) {
                    $query->where( array( array('level_of_education', '=', $selectedLevelOfEducation)));    
            });
        }

        //dashboardFilter [all, day ,week and etc]
        if(!empty($dashboardFilter))
        {
            $datesArray = Helper::getDateByFilterValue($dashboardFilter);
 
            $startDate              = Arr::get($datesArray, 'startDate');
            $endDate                = Arr::get($datesArray, 'endDate');

            $applicants->whereBetween('created_at', [$startDate, $endDate]);
        }
        //echo $applicants->toSql(); exit;

        
        $applicants=$applicants->latest()->paginate(config('constants.per_page'));
              
        $data['applicants']               = $applicants;
        $data['applicantsStatuses']       = ApplicantStatus::select('id','name')->get();
        $data['levelOfEducations']        = config('constants.level_of_educations');
        $data['experience']               = config('constants.experience_range');
        $data['genderOptions']            = config('constants.gender_options');
        $data['cities']                   = config('constants.cities');
        $data['maritalStatuses']          = config('constants.filter_marital_statuses');

        return view('backend.applicants.index')->with($data)->with($filterData);
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function show(Applicant $applicant)
    {
        $candidateDocumentObject = new CandidateDocument();
        $applicantCommentsObject = new ApplicantComments();
        
        $data = array();
        $jobId                            = Arr::get($applicant, 'job_id');
        $candidateId                      = Arr::get($applicant, 'candidate_id');
        $applicantId                      = Arr::get($applicant, 'id');

        $documentName                     = config('constants.default_document');
        $documentName                     = reset($documentName);
    
        $data['applicant']                = $applicant;
        $data['job']                      = Job::select('title')->where(['id' =>$jobId ])->first();
        $data['resume']                   = $candidateDocumentObject->getDocumentName($candidateId,$documentName);
        $data['applicantsStatuses']       = ApplicantStatus::select('id','name')->get();
        $data['applicantComments']        = $applicantCommentsObject->getApplicantComments($applicantId);

        return view('backend.applicants.show')->with($data);
    }

    /**
     * comment on the specified resource.
     *
     *  @param  \App\Models\Applicant  $applicant
     *  @return \Illuminate\Http\Response
     */
    public function applicantComment(ApplicantCommentRequest $request, Applicant $applicant){

        $validateValues = $request->validated();
        
        $applicantStatusId  = Arr::get($validateValues, 'applicant_status_id');

        $comment      = Arr::get($validateValues, 'comment');
        $applicantId  = Arr::get($applicant, 'id');
        
        //Comments add
        ApplicantComments::create([
            'applicant_status_id'       => $applicantStatusId,
            'comment'                   => $comment, 
            'created_by'                => auth()->id(),
            'applicant_id'              => $applicantId,
        ]);

        //update status on applicant table
        $applicantData = $applicant->update([
            'applicant_status_id' => $applicantStatusId
        ]);

        return redirect()->back()->with('success', "Comment Added successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CandidateReview  $candidateReview
     * @return \Illuminate\Http\Response
     */
    public function applicantCommentDestroy(Request $request)
    {
        if(Auth::user()->hasRole('admin'))
        {
            $applicantCommentId = (int) $request->segment(4);

            ApplicantComments::where(['id'=>$applicantCommentId])->delete();
            return redirect()->back()->with('success', "Comment Removed Successfully.");
        } 
        else
        {
            return redirect()->back()
            ->withErrors("Sorry you don't have permission to remove");
        }   

       
    }
}
