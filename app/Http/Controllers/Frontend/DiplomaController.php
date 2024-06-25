<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Frontend\CandidateDiplomaRequest;
use App\Models\CandidateDiploma;

class DiplomaController extends ProfileController
{
   /**
    * Profile Page --Diploma Form --
    *
    * @param Request $request
    *
    * @return \Illuminate\Http\Response
    */
    public function diplomaForm(Request $request){

        $candidateDiplomaObject    = new CandidateDiploma();
        
        $diplomaId  = $request->route('id');
        $candidateId  = Auth::guard('candidate')->user()->id;

        $data['months']    = config('constants.months');
        $data['booleanOptions']         = config('constants.boolean_options'); 
        
        #get all saved data w.r.t candidate id
        $data['diplomaAllData'] = $candidateDiplomaObject->getCandidateDiplomasByCandidateId($candidateId);

        #get data w.r.t candidate id &  diploma id
        $data['diplomaData']  = $candidateDiplomaObject->getSingleCandidateDiplomaData($diplomaId);

        #Institute Name using select2 
        $data['instituteParam'] = array('name'=>'institute_name');

        #Field of study using select2 
        $data['fieldOfStudyParam'] = array('name'=>'field_of_study');
                    
        return view('frontend.candidates.profile.diploma')->with($data);
    }

     /**
     * Handle Diploma save request
     *
     * @param CandidateDiplomaRequest $request
     *
     * @return \Illuminate\Http\Response
     */

    public function diploma(CandidateDiplomaRequest $request)
    {
        try
		{
            $validateValues = $request->validated();
            $isDiplomasSaved             = Arr::get($validateValues, 'is_diplomas_saved');
            $formSubmit                  = Arr::get($validateValues, 'form_submit');
            $candidateDiplomaData = '';
            if (!empty($validateValues) && !empty($isDiplomasSaved))
            {
                
                $day = 1;
                $candidateId            = Auth::guard('candidate')->user()->id;
                $diplomaId              = Arr::get($validateValues, 'id');

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
                unset($validateValues['is_diplomas_saved']);
                unset($validateValues['form_submit']);


                $validateValues['candidate_id'] = $candidateId;

                #for update request
                if(!empty($diplomaId)){
                    $candidateDiplomaData    = CandidateDiploma::where(['candidate_id'=> $candidateId, 'id' => $diplomaId])->update($validateValues);

                }else{
                    $candidateDiplomaData    = CandidateDiploma::create($validateValues);
                }

            }
           
            // if is_diplomas_saved zero 
            $params = array('fieldName' => 'is_diplomas_saved', 'fieldValue'=>$isDiplomasSaved);
            $this->updateProfileFlag($params);
 
            if($candidateDiplomaData || $isDiplomasSaved==0){

                if(!empty($diplomaId)){
                    $mode = "Updated";
                }else{
                    $mode = "Saved";
                }  
                
                if($formSubmit== "Save & Add more" )
                {
                    return redirect(route('diploma.show'))->with('success', "Diploma details ".$mode." successfully.");
                }
                else
                {
                    return redirect(route('certification.show'))->with('success', "Diploma details ".$mode." successfully.");
                }
                
               
            }else{
                return redirect()->back()
                ->withErrors(['error' =>"Something went wrong with Diploma details. Please try again later!"]);
            }
            
            
        }catch(\Exception $e)
		{
			return $this->getCustomExceptionMessage($e);
            
        }	    
    } 
    
    
       /**
     * Delete -- Diploma--
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request){

        $diplomaId      = $request->route('id');
        $candidateId    = Auth::guard('candidate')->user()->id;

        $candidateDiploma =CandidateDiploma::where(['candidate_id'=> $candidateId, 'id' => $diplomaId])->delete();

        if(!empty($candidateDiploma)){

            $candidateDiplomaCount =CandidateDiploma::where(['candidate_id'=> $candidateId])->count();
            if($candidateDiplomaCount ==0){
                
                $params = array('fieldName' => 'is_diplomas_saved', 'fieldValue'=>0);
                $this->updateProfileFlag($params);
            }
        
            return redirect('/diploma')->with('success', "Diploma deleted successfully.");
        }else{
            return redirect()->back()
                ->withErrors(['error' =>"Unable to delete Diploma. Please try again!"]);
        }
        
    }
}
