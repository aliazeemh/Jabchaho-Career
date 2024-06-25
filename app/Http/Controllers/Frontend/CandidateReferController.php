<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JobType;
use App\Models\AreaOfInterestGroup as AreaOfInterestGroup;
use App\Http\Requests\Frontend\CandidateReferRequest;
use App\Models\ReferCandidate;

class CandidateReferController extends Controller
{
    /**
    * Candidate Refer Form --
    *
    * @param Request $request
    *
    * @return \Illuminate\Http\Response
    */
    
    public function candidateReferForm()
    {
        $data = array();
        $jobTypeObject                = new JobType();  
        $areaOfInterestGroups         = new AreaOfInterestGroup();

        $areaOfInterests = $areaOfInterestGroups->getAreaOfInterests();

        #All enabled  jobs types
        $data['jobTypes']               = $jobTypeObject->getAllEnabledJobTypes();
        $data['areaOfInterests']        = $areaOfInterests;
        $data['levelOfEducations']      = config('constants.level_of_educations'); 
        $data['countries']              = config('constants.countries'); #Countries from constant file
        $data['previousExperience']     = config('constants.previous_experience');
        asort($data['countries']);

        return view('frontend.candidates.refer.candidate-refer')->with($data);
    }

    /**
     * Handle Refer Candidate request
     *
     * @param CandidateReferRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    function candidateRefer(CandidateReferRequest $request)
    {
        try
		{
        
            $validateValues = $request->validated();
            if (!empty($validateValues))
            {
                ReferCandidate::create($validateValues);
                return redirect()->back()->with('success', "Referred Candidate successfully.");
            }
            else
            {
                return redirect()->back()
                    ->withErrors(['error' => "Whoops, looks like something went wrong."]);
            }

        }catch(\Exception $e)
		{
			return $this->getCustomExceptionMessage($e);
        }	

    }

}
