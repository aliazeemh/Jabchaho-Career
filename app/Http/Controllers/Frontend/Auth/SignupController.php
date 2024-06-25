<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Candidate;
use App\Http\Requests\Frontend\CandidateSignupRequest;
use App\Models\AreaOfInterestGroup as AreaOfInterestGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Helpers\Helper;
use App\Http\Traits\UploadDocumentsTrait;

class SignupController extends Controller
{
    use UploadDocumentsTrait; 
    /**
     * Display signup Form.
     *
     * @return \Illuminate\Http\Response
     */
    public function signupForm()
    {
       
        try
		{
            $data = array();

            $areaOfInterestGroups = new AreaOfInterestGroup();

            $areaOfInterests = $areaOfInterestGroups->getAreaOfInterests();

            $data['mobileCodes'] = config('constants.mobile_code');
            $data['countries'] = config('constants.countries'); #Countries from constant file
            $data['areaOfInterests'] = $areaOfInterests;

            asort($data['countries']);

            return view('frontend.auth.signup')->with($data);

        }catch(\Exception $e)
		{
			return $this->getCustomExceptionMessage($e);
        }	    
    }

    /**
     * Handle account registration request
     *
     * @param CandidateSignupRequest $request
     *
     * @return \Illuminate\Http\Response
     */

    public function signup(CandidateSignupRequest $request)
    {
        try
		{
        
            $validateValues = $request->validated();

            if (!empty($validateValues))
            {

                $countryCode = Arr::get($validateValues, 'country_code');
                $mobileCode = Arr::get($validateValues, 'mobile_code');
                $mobileNumber = Arr::get($validateValues, 'mobile_number');
                $intMobileNumber = Arr::get($validateValues, 'int_mobile_number');

                if ($countryCode == config('constants.default_country_code'))
                {
                    $validateValues['mobile_number'] = $mobileCode . $mobileNumber;
                }
                else
                {
                    $validateValues['mobile_number'] = $intMobileNumber;
                }

                unset($validateValues['int_mobile_number']);
                unset($validateValues['mobile_code']);

                $validateValues['ip'] = $request->ip();


                $candidate = Candidate::create($validateValues);
                $candidateId = Arr::get($candidate, 'id');

                #applicant id
                $applicationId = Helper::getApplicationId($candidateId);

                #update candidate application id
                Candidate::where(['id' => $candidateId])->update(['application_id' => $applicationId]);

                #resume upload
                if($candidateId)
                {
                    $file           = Arr::get($validateValues,'resume');
                    $documentName   = 'resume';
                    
                    $savedFilePath  = $this->candidateResumeAndDocumentsUpload($candidateId,$file,$documentName);
                }
                
                Auth::guard('candidate')->login($candidate);


                return redirect('/home')->with('success', "Account successfully Created.");

            }
            else
            {
                return redirect()->action([SignupController::class , 'signup'])
                    ->withErrors(['error' => "Whoops, looks like something went wrong."]);

            }
        }catch(\Exception $e)
		{
			return $this->getCustomExceptionMessage($e);
        }	     

    }

    #refresh captacha
    public function refreshCaptcha()
    {
        try
		{ 
            return response()->json(['captcha' => captcha_img() ]);
        
        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
        } 
    }
    
}
