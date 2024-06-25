<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Frontend\ApplicantApplyRequest;
use App\Models\Applicant;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;
use App\Models\CandidateDetail;
use App\Models\CandidateEducation;

class ApplicantController extends Controller
{
    public function apply(ApplicantApplyRequest $request)
    {
        try
		{
            $validateValues = $request->validated();
            $applicantObject = new Applicant;
            if (!empty($validateValues))
            {
                $candidateId                            = Auth::guard('candidate')->user()->id;
                $candidateEmail                         = Auth::guard('candidate')->user()->email;
                $candidateMobile                        = Auth::guard('candidate')->user()->mobile_number;
                $totalExperience                        = Auth::guard('candidate')->user()->total_experience;

                $validateValues['candidate_id']         = $candidateId;
                $validateValues['applicant_status_id']  = 1; //Applied
                $gender                                 = $request->input('gender');
                $qualification                          = $request->input('level_of_educations');
                $city                                   = $request->input('city');
                $fieldOfStudy                           = $request->input('field_of_study');
                $jobCount                               = $applicantObject->applicantJobCount($candidateId);
                
                // Update or create candidate_details
                CandidateDetail::updateOrCreate(['candidate_id' => $candidateId], ['gender' => $gender, 'city' => $city]);


                if(!empty($qualification))
                {
                    // Insert qualification into candidate_educations
                    CandidateEducation::create(['candidate_id' => $candidateId, 'level_of_education' => $qualification, 'field_of_study' => $fieldOfStudy]);
                }


                //Candidate email is empty
                if(empty($candidateEmail))
                {
                    //check given email is already exist in  Candidate table.

                    $isCandidateExist = Candidate::where(['email' => $validateValues['email']])->count();
                    
                    if($isCandidateExist)
                    {
                        return redirect()->back()->withErrors(['error' => "This email ".$validateValues['email']." is already exist. Please try with different one!"] );
                    }
                    else
                    {
                        #update candidate email if empty
                        Candidate::where(['id' => $candidateId])->update(['email' => $validateValues['email']]);
                    }
                    
                }


                //Candidate Mobile is empty
                if(empty($candidateMobile))
                {
                    //check given Mobile is already exist in  Candidate table.

                    $isCandidateMobileExist = Candidate::where(['mobile_number' => $validateValues['phone']])->count();
                    
                    if($isCandidateMobileExist)
                    {
                        return redirect()->back()->withErrors(['error' => "This Mobile ".$validateValues['phone']." is already exist. Please try with different one!"] );
                    }
                    else
                    {
                        #update candidate Mobile if empty
                        Candidate::where(['id' => $candidateId])->update(['mobile_number' => $validateValues['phone']]);
                    }
                    
                }
                
                //Total Experience
                Candidate::where(['id' => $candidateId])->update(['total_experience' => $validateValues['total_experience']]);
                
                #unset total_experience from Applicant array
                unset($validateValues['total_experience']);
                if($jobCount == config('constants.job_limit'))
                {
                    return redirect()->back()->withErrors(['error' => "You've hit the daily limit for job applications. Please wait 24 hours before trying again!"]);
                }
                else
                {
                    $applicant    = Applicant::create($validateValues);
                }

                

                if($applicant)
                {
                    return redirect()->back()->with('success', "Thank you for submitting your job application form");
                }else{
                    return redirect()->back()->withErrors(['error' => "Unable to Applied. Please try again!"]);
                }
            }

        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }	
    }
}
