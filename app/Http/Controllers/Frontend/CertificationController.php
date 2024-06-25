<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Frontend\CandidateCertificationRequest;
use App\Models\CandidateCertification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class CertificationController extends ProfileController
{
    /**
    * Profile Page --Certification Form --
    *
    * @param Request $request
    *
    * @return \Illuminate\Http\Response
    */
    public function certificationForm(Request $request){

        $candidateCertificationObject    = new CandidateCertification();
        
        $certificateId      = $request->route('id');
        $candidateId  = Auth::guard('candidate')->user()->id;

        $data['months']             = config('constants.months');   
        $data['booleanOptions']     = config('constants.boolean_options'); 
        
        #get all saved data w.r.t candidate id
        $data['certificateAllData'] = $candidateCertificationObject->getCandidateCertificateByCandidateId($candidateId);

        #get data w.r.t candidate id &  certificate id
        $data['certificateData']  = $candidateCertificationObject->getSingleCandidateCertificateData($certificateId);

        #Institute Name using select2 
        $data['instituteParam'] = array('name'=>'institute_name');

        #Field of study using select2 
        $data['fieldOfStudyParam'] = array('name'=>'field_of_study');

        return view('frontend.candidates.profile.certification')->with($data);
    }

     /**
     * Handle Certification save request
     *
     * @param CandidateCertificationRequest $request
     *
     * @return \Illuminate\Http\Response
     */

    public function certification(CandidateCertificationRequest $request)
    {
        try
		{
            $validateValues = $request->validated();
            $isCertificationsSaved             = Arr::get($validateValues, 'is_certifications_saved');
            $formSubmit             = Arr::get($validateValues, 'form_submit');
            
            $candidateCertificationData = '';
            if (!empty($validateValues) && !empty($isCertificationsSaved))
            {
                
                $day = 1;
                $candidateId            = Auth::guard('candidate')->user()->id;
                $certificateId          = Arr::get($validateValues, 'id');

                $fromMonths             = Arr::get($validateValues, 'from_months');
                $fromYear               = Arr::get($validateValues, 'from_year');
                $toMonths               = Arr::get($validateValues, 'to_months');
                $toYear                 = Arr::get($validateValues, 'to_year');
                $isInProgress           = Arr::get($validateValues, 'is_in_progress',0);
                

            
                $fromDate = $day.'-'.$fromMonths.'-'.$fromYear;
                $validateValues['from'] = date('Y-m-d ', strtotime($fromDate));


                if(empty($isInProgress)){
                    $toDate = $day.'-'.$toMonths.'-'.$toYear;
                    $validateValues['to'] = date('Y-m-d ', strtotime($toDate));
                    $validateValues['is_in_progress'] = 0;
                }
                
                unset($validateValues['from_months']);
                unset($validateValues['from_year']);
                unset($validateValues['to_months']);
                unset($validateValues['to_year']);
                unset($validateValues['is_certifications_saved']);
                unset($validateValues['form_submit']);



                $validateValues['candidate_id'] = $candidateId;

                #for update request
                if(!empty($certificateId)){
                    $candidateCertificationData    = CandidateCertification::where(['candidate_id'=> $candidateId, 'id' => $certificateId])->update($validateValues);

                }else{
                    $candidateCertificationData  =  CandidateCertification::create($validateValues);
                }

            }
           
            // if is Certifications Saved zero 
            $params = array('fieldName' => 'is_certifications_saved', 'fieldValue'=>$isCertificationsSaved);
            $this->updateProfileFlag($params);
 
            if($candidateCertificationData || $isCertificationsSaved==0){

                if(!empty($certificateId)){
                    $mode = "Updated";
                }else{
                    $mode = "Saved";
                } 

                if($formSubmit== "Save & Add more" )
                {
                    return redirect(route('certification.show'))->with('success', "Certification details ".$mode." successfully.");
                }
                else
                {
                    return redirect(route('professional.experience.show'))->with('success', "Certification details ".$mode." successfully.");
                }

                
            }else{
                return redirect()->back()
                ->withErrors(['error' => "Something went wrong with Certification details. Please try again later!"]);
            }
            
            
        }catch(\Exception $e)
		{
			return $this->getCustomExceptionMessage($e);
            
        }	    
    } 
    
     
    /**
     * Delete -- Certificate--
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request){

        $certificateId      = $request->route('id');
        $candidateId    = Auth::guard('candidate')->user()->id;

        $candidateCertificate =CandidateCertification::where(['candidate_id'=> $candidateId, 'id' => $certificateId])->delete();

        if(!empty($candidateCertificate)){

            $candidateCertificate =CandidateCertification::where(['candidate_id'=> $candidateId])->count();
            if($candidateCertificate ==0){
                
                $params = array('fieldName' => 'is_certifications_saved', 'fieldValue'=>0);
                $this->updateProfileFlag($params);
            }
        
            return redirect('/certification')->with('success', "Certification detail deleted successfully.");
        }else{
            return redirect()->back()
                ->withErrors(['error' => "Unable to delete Certification detail. Please try again!"]);
        }
        
    }
}
