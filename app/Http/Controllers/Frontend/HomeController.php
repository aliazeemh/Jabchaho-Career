<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Candidate;
use App\Models\CandidateStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\CandidateStatusWiseHomeContents;
use App\Models\AreaOfInterestGroup as AreaOfInterestGroup;
use App\Http\Requests\Frontend\CandidateEssentialProfileRequest;
use App\Models\CandidateDocument;
use App\Helpers\Helper;
use App\Http\Traits\UploadDocumentsTrait;

class HomeController extends Controller
{
    use UploadDocumentsTrait; 
    
    /**
     * Home Page
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try
		{ 
           $candidateObject                         = new Candidate();

           $candidateStatusWiseHomeContentsObject   = new CandidateStatusWiseHomeContents();

           $candidateId                             = Auth::guard('candidate')->user()->id;
           $candidateStatusId                       = Auth::guard('candidate')->user()->candidate_status_id;

           $candidateProfilePercentage                 = $candidateObject->getCandidateProfilePercentage($candidateId);
            
           $data['homeContent']                        = $candidateStatusWiseHomeContentsObject->getHomeContentStatusIdWise($candidateStatusId);
           $data['candidateData']                      = $candidateProfilePercentage['candidateData'];
           $data['profilePercentage']                  = $candidateProfilePercentage['profilePercentage'];

           return view('frontend.candidates.home')->with($data);
        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
        }	
    }
    
    public function candidateEssentialProfileForm()
    {
        $data = array(); 

        // Retrieve value from the session
        $socialiteField = \Session::get('socialiteField'); //google_id
        $socialiteUser = \Session::get('socialiteUser');
        $loadView =false;
        if (!empty($socialiteUser)) 
        {
            $candidateObject              = new Candidate();
            $candidateDocumentObject      = new CandidateDocument();
            $areaOfInterestGroups         = new AreaOfInterestGroup();
            
            $candidateResume = '';
            
            $params = array();
            $params['socialiteField']       = $socialiteField;
            $params['socialiteUserId']      = $socialiteUser->getId();
            $params['socialiteUserEmail']   = $socialiteUser->getEmail();

            $isCandidate = $candidateObject->getSocialliteCandidate($params);
            
            if(!empty($isCandidate))
            {
                
    
                $candidateId                   = Arr::get($isCandidate, 'id');
                $documentName                  = config('constants.default_document');
                $documentName                  = reset($documentName);

                $candidateResume = $candidateDocumentObject->getDocumentName($candidateId,$documentName);
               
                if(empty(Arr::get($isCandidate, 'full_name'))|| empty(Arr::get($isCandidate, 'email')) || empty(Arr::get($isCandidate, 'mobile_number')) || empty(Arr::get($isCandidate, 'country_code')) || empty(Arr::get($isCandidate, 'area_of_interest_option_id')) || empty(Arr::get($candidateResume, 'file')) )
                {
                    $loadView = true;
                }
            }
            else
            {   
                $loadView = true;
            }

            #load view if user is not created or empty any required field
            if(!empty($loadView))
            {
                $areaOfInterests                = $areaOfInterestGroups->getAreaOfInterests();

                $data['fullName']                   = Arr::get($isCandidate, 'full_name')?Arr::get($isCandidate, 'full_name'):$socialiteUser->getName();
                $data['email']                      = Arr::get($isCandidate, 'email')?Arr::get($isCandidate, 'email'):$socialiteUser->getEmail();
                $data['mobile']                     = Arr::get($isCandidate, 'mobile_number');
                $data['countryCode']                = Arr::get($isCandidate, 'country_code');
                $data['areaOfInterestOptionId']     = Arr::get($isCandidate, 'area_of_interest_option_id');
        
                $data['mobileCodes'] = config('constants.mobile_code');
                $data['countries'] = config('constants.countries'); #Countries from constant file
                $data['areaOfInterests'] = $areaOfInterests;
    
                asort($data['countries']);
                $data['resume']                 = $candidateResume;

                return view('frontend.candidates.candidate-essential-profile')->with($data);
            }
            else
            {
                if(!empty(Arr::get($isCandidate, 'email')) && empty(Arr::get($isCandidate, $socialiteField)) )
                {
                    $saveCandidate = Candidate::where('email',  $socialiteUser->getEmail())->whereNull($socialiteField)->update([
                        $socialiteField => $socialiteUser->getId(),
                    ]);
                }
                $candidateId = Arr::get($isCandidate, 'id');
                return $this->loginByCandidateId($candidateId);
            }
        }
        else
        {
            return redirect()->route('signin.show')->withErrors(['error' => "Unable to find User. Please try again!"]);
        }      
    }


    public function loginByCandidateId($candidateId=0)
    {
        Auth::guard('candidate')->loginUsingId($candidateId);

        session()->forget('socialiteField');
        session()->forget('socialiteUser');
        
        if(!empty(Session::get('lastUrl'))){
            return redirect(Session::get('lastUrl'));
        }else{
            return redirect('/home');
        }
    }


    /**
     * Handle Certification save request
     *
     * @param CandidateEssentialProfileRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function candidateEssentialProfile(CandidateEssentialProfileRequest $request)
    {
        try
		{
            // Retrieve the JSON response from the session
            $socialiteField = \Session::get('socialiteField'); //google_id
            $socialiteUser = \Session::get('socialiteUser');
            
            $validateValues = $request->validated();
            
            $fullName               = Arr::get($validateValues, 'candidate_full_name');
            $email                  = Arr::get($validateValues, 'email');
            $mobile                 = Arr::get($validateValues, 'mobile');
            $countryCode            = Arr::get($validateValues, 'country_code');
            $areaOfInterestOptionId = Arr::get($validateValues, 'area_of_interest_option_id');
        
            $ip = $request->ip();

            $saveCandidate = Candidate::updateOrCreate(['email' =>$email],[

                $socialiteField => $socialiteUser->getId(),
                'full_name' =>$fullName,
                'email' => $email,
                'mobile_number' => $mobile,
                'country_code'=>$countryCode,
                'area_of_interest_option_id' =>$areaOfInterestOptionId,
                'ip' =>$ip
            ]);

            $candidateId = Arr::get($saveCandidate, 'id');

            $candidate = Candidate::find($candidateId);
            
            // Check if the candidate application_id not found
            if (!isset($candidate->application_id)) 
            {
                #applicant id
                $applicationId = Helper::getApplicationId($candidateId);
                
                #update candidate application id
                Candidate::where(['id' => $candidateId])->update(['application_id' => $applicationId]);
            }

            #resume upload
            if($candidateId)
            {
                $file           = Arr::get($validateValues,'resume');
                if(!empty($file))
                {
                    $documentName                  = config('constants.default_document');
                    $documentName                  = reset($documentName);
                    $savedFilePath                 = $this->candidateResumeAndDocumentsUpload($candidateId,$file,$documentName);
                }
                
            }
       
            return $this->loginByCandidateId($candidateId);

        }catch(\Exception $e)
		{
			return $this->getCustomExceptionMessage($e);
            
        }	 
    }
}
