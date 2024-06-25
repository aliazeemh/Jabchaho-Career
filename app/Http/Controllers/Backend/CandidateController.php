<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use App\Models\Candidate;
use App\Models\AreaOfInterestOption;
use App\Models\AreaOfInterestGroup as AreaOfInterestGroup;
use App\Models\CandidateSkillSet;
use App\Models\CandidateExperience;
use App\Models\CandidateReferral;
use App\Models\CandidatePortfolio;
use App\Models\CandidatePortfolioAttachment;
use App\Models\CandidatePasswordReset;
use App\Models\CandidateMobileNumber;
use App\Models\CandidateFamilyDetails;
use App\Models\CandidateExperienceFacilities;
use App\Models\CandidateEducation;
use App\Models\CandidateDocument;
use App\Models\CandidateDiploma;
use App\Models\CandidateDetail;
use App\Models\CandidateCertification;
use App\Models\CandidateShift;
use App\Models\CandidateStatus;
use App\Models\CandidateReview;
use App\Models\CandidatePhoneConversation;
use App\Models\CandidateScheduleStatus;
use App\Models\CandidateSchedule;
use Illuminate\Support\Carbon;
use App\Http\Requests\Backend\CandidateRequest;
use App\Http\Requests\Backend\CandidateReviewRequest;
use App\Http\Requests\Backend\CandidatePhoneConversationRequest;
use App\Http\Requests\Backend\CandidateScheduleRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\UploadDocumentsTrait;


class CandidateController extends Controller
{
    use UploadDocumentsTrait;  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchCondition = array();
        $filterData = array();
        
        $email = $request->query('email');
        $name  = $request->query('name');
        $areaOfInterestOptionId  = $request->query('area_of_interest_option_id');
        $dashboardFilter                = $request->query('dashboard_filter');
        
        $filterData['email']                    = $email;
        $filterData['name']                     = $name;
        $filterData['areaOfInterestOptionId']   = $areaOfInterestOptionId;
        $filterData['dashboardFilter']          = $dashboardFilter;
        
        if(!empty($email)){
            $searchCondition['email'] = $email;
        }

        if(!empty($areaOfInterestOptionId)){
            $searchCondition['area_of_interest_option_id'] = $areaOfInterestOptionId;
        }

        $searchLikeCondition = array();
        if(!empty($name)){
            $searchLikeCondition = array( array('full_name', 'like', '%'.$name.'%'));
        }
        

        $areaOfInterestGroups = new AreaOfInterestGroup();

        $areaOfInterests = $areaOfInterestGroups->getAreaOfInterests();

        $candidates = Candidate::with(['areaOfInterestOption','getCandidateResumeDocument'])->where($searchCondition)->where($searchLikeCondition);
        //dashboardFilter [all, day ,week and etc]
        if(!empty($dashboardFilter))
        {
            $datesArray = Helper::getDateByFilterValue($dashboardFilter);
 
            $startDate              = Arr::get($datesArray, 'startDate');
            $endDate                = Arr::get($datesArray, 'endDate');

            $candidates->whereBetween('created_at', [$startDate, $endDate]);
        }

        $candidates = $candidates->latest()->paginate(config('constants.per_page'));

        $data['candidates'] = $candidates;
        $data['areaOfInterests'] = $areaOfInterests;
        return view('backend.candidates.index')->with($data)->with($filterData);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areaOfInterestGroups = new AreaOfInterestGroup();

        $areaOfInterests = $areaOfInterestGroups->getAreaOfInterests();

        $data['countries'] = config('constants.countries'); #Countries from constant file
        $data['areaOfInterests'] = $areaOfInterests;

        asort($data['countries']);
        
        return view('backend.candidates.create')->with($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CandidateRequest $request)
    {
        $candidate = Candidate::create(array_merge($request->only('full_name', 'email', 'country_code','mobile_number','area_of_interest_option_id','password'),[
            'created_by' => auth()->id()
        ]));

        $candidateId = Arr::get($candidate, 'id');

        $applicationId = Helper::generateRandomCapitalAlphabets(10).'-'.$candidateId;
        #update candidate application id
        Candidate::where(['id' => $candidateId])->update(['application_id' => $applicationId]);

        return redirect()->route('candidates.index')
            ->withSuccess(__('Candidate created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data                              = array();
        $candidateId                       = (int) $request->segment(4);
        
        $candidateObject                    = new Candidate();
        $candidateReviewObject              = new CandidateReview();
        $candidatePhoneConversationObject   = new CandidatePhoneConversation();
        $candidateScheduleObject            = new CandidateSchedule();

        $candidateData                                              = $candidateObject->getCandidateProfileData($candidateId);
        $candidateReviews['reviews']                                = $candidateReviewObject->getCandidateReview($candidateId);
        $candidateConversation['conversations']                     = $candidatePhoneConversationObject->getCandidatePhoneConversation($candidateId);
        $candidateScheduleStatus['candidateScheduleStatuses']       = CandidateScheduleStatus::select('id','name')->get();
        $candidateSchedules['candidateSchedules']                   = $candidateScheduleObject->getCandidateSchedule($candidateId);
        $candidateSavedDocuments                                    = $this->getSavedDocuments($candidateId);
        $candidateExperienceRequiredDocments['candidateExperienceRequiredDocments']                        = $this->getProfessionalExperienceDocuments($candidateId);
        $candidateEducationalQualificationDocments['candidateEducationalQualificationDocments']                  = $this->getEducationalQualificationDocuments($candidateId);
        $candidatePortfolioAttachmentsObject    = new CandidatePortfolioAttachment();
        $candidatePortfolioAttachments['candidateAttachments']       =  $candidatePortfolioAttachmentsObject->getCandidatePortfolioAttachmentsByCandidateId($candidateId);

        //Full data of candidate
        $data = array_merge($candidateData,$candidateReviews,$candidateConversation,$candidateScheduleStatus,$candidateSchedules,$candidateSavedDocuments,$candidateExperienceRequiredDocments,$candidateEducationalQualificationDocments,$candidatePortfolioAttachments);
        return view('backend.candidates.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidate  $Candidate
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidate $candidate)
    {
        $areaOfInterestGroups = new AreaOfInterestGroup();

        $areaOfInterests = $areaOfInterestGroups->getAreaOfInterests();

        $data['countries'] = config('constants.countries'); #Countries from constant file
        $data['areaOfInterests'] = $areaOfInterests;
        $data['candidate']  = $candidate;


        asort($data['countries']);
        
        
        return view('backend.candidates.edit')->with($data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function update(CandidateRequest $request, Candidate $candidate)
    {
        
        $password = $request->input('password');

        if(!empty($password) && !is_null($password)){
            $postCandidate = array_merge($request->only('full_name', 'email', 'country_code','mobile_number','area_of_interest_option_id','password'),[
                'updated_by' => auth()->id()
            ]);
        }else{
            $postCandidate = array_merge($request->only('full_name', 'email', 'country_code','mobile_number','area_of_interest_option_id'),[
                'updated_by' => auth()->id()
            ]);

        }

        $candidate->update($postCandidate);

        return redirect()->route('candidates.index')
            ->withSuccess(__('Candidate updated successfully.'));
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidate $candidate)
    {
        
        try 
        {
            \DB::beginTransaction();
        
                $candidateId = Arr::get($candidate, 'id');
                
                $candidateExperienceData    = CandidateExperience::where(['candidate_id'=> $candidateId])->get();
                
                $candidateExperienceIds = array();
                if(!empty($candidateExperienceData)){
                    foreach($candidateExperienceData as $row){
                        $candidateExperienceIds[] = $row->id;
                    }
                }
                
                CandidateSkillSet::where(['candidate_id' => $candidateId])->delete();
                CandidateReferral::where(['candidate_id' => $candidateId])->delete();
                CandidatePortfolio::where(['candidate_id' => $candidateId])->delete();
                CandidatePortfolioAttachment::where(['candidate_id' => $candidateId])->delete();
                CandidatePasswordReset::where(['candidate_id' => $candidateId])->delete();
                CandidateMobileNumber::where(['candidate_id' => $candidateId])->delete();
                CandidateFamilyDetails::where(['candidate_id' => $candidateId])->delete();
                CandidateExperienceFacilities::whereIn('candidate_experience_id',$candidateExperienceIds)->delete();
                CandidateExperience::where(['candidate_id' => $candidateId])->delete();
                CandidateEducation::where(['candidate_id' => $candidateId])->delete();
                CandidateDocument::where(['candidate_id' => $candidateId])->delete();
                CandidateDiploma::where(['candidate_id' => $candidateId])->delete();
                CandidateDetail::where(['candidate_id' => $candidateId])->delete();
                CandidateCertification::where(['candidate_id' => $candidateId])->delete();
                CandidateShift::where(['candidate_id' => $candidateId])->delete();
                CandidateReview::where(['candidate_id' => $candidateId])->delete();
                $candidate->delete();

            \DB::commit();
        } catch (Throwable $e) {
            \DB::rollback();
        }    

        return redirect()->route('candidates.index')
            ->withSuccess(__('Candidate deleted successfully.'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CandidateReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function reviewStore(CandidateReviewRequest $request)
    {
        $candidateReview = CandidateReview::create(array_merge($request->only('candidate_id', 'review'),[
            'created_by' => auth()->id()
        ]));

        return redirect()->back()->with('success', "Review Added successfully.");

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CandidateReview  $candidateReview
     * @return \Illuminate\Http\Response
     */
    public function reviewDestroy(Request $request)
    {
        if(Auth::user()->hasRole('admin'))
        {
            $candidateReviewId = (int) $request->segment(4);

            $candidateId = $request->input('candidate_id');

            CandidateReview::where(['id'=>$candidateReviewId,'candidate_id' =>$candidateId])->delete();
            return redirect()->back()->with('success', "Review Removed Successfully.");
        } 
        else
        {
            return redirect()->back()
            ->withErrors("Sorry you don't have permission to remove");
        }   

       
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function phoneConversationStore(CandidatePhoneConversationRequest $request)
    {
        $candidateReview = CandidatePhoneConversation::create(array_merge($request->only('candidate_id', 'conversation'),[
            'created_by' => auth()->id()
        ]));

        return redirect()->back()->with('success', "Phone Conversation Added Successfully.");

    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CandidateReview  $candidateReview
     * @return \Illuminate\Http\Response
     */
    public function phoneConversationDestroy(Request $request)
    {
        if(Auth::user()->hasRole('admin'))
        {
            $candidateConversationId = (int) $request->segment(4);

            $candidateId = $request->input('candidate_id');
    
            CandidatePhoneConversation::where(['id'=>$candidateConversationId,'candidate_id' =>$candidateId])->delete();
            return redirect()->back()->with('success', "Phone Conversation Removed successfully.");
        }
        else
        {
            return redirect()->back()
            ->withErrors("Sorry you don't have permission to remove");
        }
       
       

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CandidateScheduleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function candidateScheduleStore(CandidateScheduleRequest $request)
    {   
        $candidateSchedule = CandidateSchedule::create(array_merge($request->only('candidate_id', 'schedule_status_id'),['schedule_time' => date('Y-m-d H:i', strtotime($request->schedule_time))],[
            'created_by' => auth()->id()
        ]));

        return redirect()->back()->with('success', "Candidate Schedule Added Successfully.");

    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CandidateReview  $candidateReview
     * @return \Illuminate\Http\Response
     */
    public function scheduleDestroy(Request $request)
    {
        if(Auth::user()->hasRole('admin'))
        {
            
            $candidatescheduleId = (int) $request->segment(4);

            $candidateId = $request->input('candidate_id');

            CandidateSchedule::where(['id'=>$candidatescheduleId,'candidate_id' =>$candidateId])->delete();
            return redirect()->back()->with('success', "Schedule Removed successfully.");
        }else
        {
            return redirect()->back()
            ->withErrors("Sorry you don't have permission to remove");
        }
        
        
    }
    public function candidateDocumentRemoveByIds($candidateId,$id)
    {
        try
		{
            $deleted = $this->removeCandidateDocumentByIds($candidateId,$id);
            if($deleted)
            {

                return redirect()->back()->with('success', "Uploaded Document deleted successfully.");
            }
            else{
                return redirect()->back()
                ->withErrors(['error' =>"Unable to remove Uploaded Document. Please try again!"]);
        }
 
        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }	
    }
    public function candidatePortfolioRemoveByIds($candidateId,$id)
    {
        try
		{
            $deleted = $this->removeCandidatePortfoliosByIds($candidateId,$id);
            if($deleted)
            {

                return redirect()->back()->with('success', "Uploaded Document deleted successfully.");
            }
            else{
                return redirect()->back()
                ->withErrors(['error' =>"Unable to remove Uploaded Document. Please try again!"]);
        }
 
        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }	
    }

}
