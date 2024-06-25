<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\CandidateEducation;
use App\Models\CandidateDocument;
use App\Http\Requests\Frontend\CandidateEducationalQualificationRequest;

class EducationalQualificationController extends ProfileController
{
    /**
    * Profile Page --Educational Qualification --
    *
    * @param Request $request
    *
    * @return \Illuminate\Http\Response
    */
   public function educationalQualificationForm(Request $request){

        
        $candidateEducationObject    = new CandidateEducation();
    
    
        $data['levelOfEducations']   = config('constants.level_of_educations'); 
        $data['months']              = config('constants.months'); 
        $data['grades']              = config('constants.grades'); 
        $data['OALevelGrades']       = config('constants.o_a_level_grades'); 
        $data['boards']              = config('constants.boards'); 
        $data['booleanOptions']      = config('constants.boolean_options'); 

        $candidateEducationId  = $request->route('id');
        $candidateId  = Auth::guard('candidate')->user()->id;

        #get all saved data w.r.t candidate id
        $data['educationalQualificationAllData'] = $candidateEducationObject->getCandidateEducationsByCandidateId($candidateId);

        #get data w.r.t candidate id &  candidate_experiences id
        $data['educationalQualificationData']  = $candidateEducationObject->getSingleCandidateEducationData($candidateEducationId);

        #Institute Name using select2 
        $data['instituteParam'] = array('name'=>'institute_name');

        #Field of study using select2 
        $data['fieldOfStudyParam'] = array('name'=>'field_of_study');
                  
        return view('frontend.candidates.profile.educational-qualification')->with($data);
    }


    /**
     * Handle Educational Qualification save request
     *
     * @param CandidateEducationalQualificationRequest $request
     *
     * @return \Illuminate\Http\Response
     */

    public function educationalQualification(CandidateEducationalQualificationRequest $request)
    {
        try
		{
            $validateValues = $request->validated();
            if (!empty($validateValues))
            {
                
                $day = 1;
                $candidateId            = Auth::guard('candidate')->user()->id;
                $candidateEducationId   = Arr::get($validateValues, 'id');

                $fromMonths             = Arr::get($validateValues, 'from_months');
                $fromYear               = Arr::get($validateValues, 'from_year');
                $toMonths               = Arr::get($validateValues, 'to_months');
                $toYear                 = Arr::get($validateValues, 'to_year');
                $isInProgress           = Arr::get($validateValues, 'is_in_progress',0);
                $finalResult            = Arr::get($validateValues, 'final_result',0);
                $dropOut                = Arr::get($validateValues, 'drop_out',0);
                $formSubmit             = Arr::get($validateValues, 'form_submit');

                if(!empty(Arr::get($validateValues, 'majors'))){
                    $validateValues['majors'] = implode (", ", Arr::get($validateValues, 'majors'));
                }
                
                $fromDate = $day.'-'.$fromMonths.'-'.$fromYear;
                $validateValues['from'] = date('Y-m-d ', strtotime($fromDate));


                if(empty($isInProgress)){
                    $toDate = $day.'-'.$toMonths.'-'.$toYear;
                    $validateValues['to'] = date('Y-m-d ', strtotime($toDate));
                    $validateValues['is_in_progress'] = 0;
                }

                if(empty($finalResult))
                {
                    $validateValues['final_result'] = 0;
                }

                if(empty($dropOut))
                {
                    $validateValues['drop_out'] = 0;
                }
                
                unset($validateValues['from_months']);
                unset($validateValues['from_year']);
                unset($validateValues['to_months']);
                unset($validateValues['to_year']);
                unset($validateValues['form_submit']);


                $validateValues['candidate_id'] = $candidateId;

                 #for update request
                 if(!empty($candidateEducationId)){
                    $candidateEducationData    = CandidateEducation::where(['candidate_id'=> $candidateId, 'id' => $candidateEducationId])->update($validateValues);

                }else{
                    $candidateEducationData    = CandidateEducation::create($validateValues);
                }

                if(!empty($candidateEducationData)){

                    if(!empty($candidateEducationId)){
                        $mode = "Updated";
                    }else{
                        $mode = "Saved";
                    }   
                    
                    // if experience zero 
                    $params = array('fieldName' => 'is_education_saved', 'fieldValue'=>1);
                    $this->updateProfileFlag($params);

                    if($formSubmit== "Save & Add more" )
                    {
                        return redirect(route('educational.qualification.show'))->with('success', "Educational Qualification ".$mode." successfully.");
                    }
                    else
                    {
                        return redirect(route('diploma.show'))->with('success', "Educational Qualification ".$mode." successfully.");
                    }
                   
                }else{
                    return redirect()->back()
                    ->withErrors(['error' =>"Something went wrong with Educational Qualification. Please try again later!"]);
                }
                
            }    
    
        }catch(\Exception $e)
		{
			return $this->getCustomExceptionMessage($e);
            
        }	        
    }


     /**
     * Delete -- Educational Qualification--
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request){

        $candidateEducationId  = $request->route('id');
        $candidateId           = Auth::guard('candidate')->user()->id;

        $candidateEducation =CandidateEducation::where(['candidate_id'=> $candidateId, 'id' => $candidateEducationId])->delete();
        if(!empty($candidateEducation)){

            $candidateDocumentData = CandidateDocument::where(['candidate_id'=> $candidateId, 'table_name'=>config('constants.candidate_documents_tables.candidate_educations'), 'table_action_id' => $candidateEducationId])->get();
            
            if(is_object($candidateDocumentData) && count($candidateDocumentData)>0){
                foreach($candidateDocumentData as $candidateDocumentRow){
                    $candidateDocumentRow->delete();
                }  

                $this->removeCandidateDocument($candidateDocumentData);  
            }
            $candidateEducationCount =CandidateEducation::where(['candidate_id'=> $candidateId])->count();
            if($candidateEducationCount ==0){
                
                $params = array('fieldName' => 'is_education_saved', 'fieldValue'=>0);
                $this->updateProfileFlag($params);
            }
        
            return redirect('/educational-qualification')->with('success', "Educational Qualification deleted successfully.");
        }else{
            return redirect()->back()
                ->withErrors(['error' =>"Unable to delete Educational Qualification. Please try again!"]);
        }
        
    }
}
