<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Frontend\CandidateReferralRequest;
use App\Models\CandidateReferral;

class ReferralController extends ProfileController
{
    /**
    * Profile Page --Referral Form --
    *
    * @param Request $request
    *
    * @return \Illuminate\Http\Response
    */
    
    public function referralForm(){
        
        $candidateReferralObject    = new CandidateReferral();
        
        $data['referralOptions'] = config('constants.referral_options'); 
        $data['referralData']    = $candidateReferralObject->getCandidateReferralByCandidateId() ;

        return view('frontend.candidates.profile.referral')->with($data);
    }


    /**
     * Handle Diploma save request
     *
     * @param CandidateReferralRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function referral(CandidateReferralRequest $request){
        try
		{
            $validateValues                 = $request->validated();
            $candidateId                    = Auth::guard('candidate')->user()->id;
            $referralId                     = Arr::get($validateValues, 'id');
            $validateValues['candidate_id'] = $candidateId;

            #for update request
            if(!empty($referralId)){
                $mode = "Updated";
                $candidateReferralData    = CandidateReferral::where(['candidate_id'=> $candidateId, 'id' => $referralId])->update($validateValues);

            }else{
                $mode = "Saved";
                $candidateReferralData    = CandidateReferral::create($validateValues);
            }
            $params = array('fieldName' => 'is_referral_saved', 'fieldValue'=>1);
            $this->updateProfileFlag($params);
            return redirect(route('family.details.show'))->with('success', "Referral ".$mode." successfully.");
            
            
        }catch(\Exception $e)
		{
			return $this->getCustomExceptionMessage($e);
            
        }	  
    }
}
