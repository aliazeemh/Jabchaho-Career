<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobType;
use App\Models\FacilityGroup;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\CandidateExperience;
use App\Models\CandidateExperienceFacilities;
use App\Models\CandidateDocument;

use App\Http\Requests\Frontend\CandidateProfessionalExperienceRequest;

class ProfessionalExperienceController extends ProfileController
{
     /**
     * Profile Page --Professional Experience --
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function professionalExperienceForm(Request $request){

        $facilityGroupObject          = new FacilityGroup();
        $candidateExperienceObject    = new CandidateExperience();
        $jobTypeObject                = new JobType();    

        $data['months']                 = config('constants.months');
        $data['booleanOptions']         = config('constants.boolean_options'); 
        $candidateExperienceId  = $request->route('id');
        $candidateId  = Auth::guard('candidate')->user()->id;

        #get facilities with option data
        $data['facilityGroupWithOptions'] = $facilityGroupObject->getFacilityGroupWithOptions();
       
        #All enabled  jobs types
        $data['jobTypes'] = $jobTypeObject->getAllEnabledJobTypes();
       
        #get all saved data w.r.t candidate id
        $data['professionalExperienceAllData'] = $candidateExperienceObject->getCandidateExperiencesByCandidateId($candidateId);
       
        #get data w.r.t candidate id &  candidate_experiences id
        $data['professionalExperienceData']  = $candidateExperienceObject->getSingleCandidateExperienceData($candidateExperienceId);

        #Company Name using select2 
        $data['companyName'] = array('name'=>'company_name');

        #Job Title using select2 
        $data['jobTitle'] = array('name'=>'job_title');

     
        return view('frontend.candidates.profile.professional-experience')->with($data);
    }

    /**
     * Handle account registration request
     *
     * @param CandidateProfessionalExperienceRequest $request
     *
     * @return \Illuminate\Http\Response
     */

    public function professionalExperience(CandidateProfessionalExperienceRequest $request)
    {
        try
		{
            $validateValues = $request->validated();
            
            $isExperienceSaved             = Arr::get($validateValues, 'is_experience_saved');
            $formSubmit                    = Arr::get($validateValues, 'form_submit');
            $candidateExperienceData = '';
            if (!empty($validateValues) && !empty($isExperienceSaved))
            {
                
                $day = 1;
                $candidateId            = Auth::guard('candidate')->user()->id;

                $candidateExperienceId  = Arr::get($validateValues, 'id');
             
                $fromMonths             = Arr::get($validateValues, 'from_months');
                $fromYear               = Arr::get($validateValues, 'from_year');
                $toMonths               = Arr::get($validateValues, 'to_months');
                $toYear                 = Arr::get($validateValues, 'to_year');
                $isPresent              = Arr::get($validateValues, 'is_present');
                $facilityGroups         = Arr::get($validateValues, 'facilityGroup',array());
                
                $fromDate = $day.'-'.$fromMonths.'-'.$fromYear;
                $validateValues['from'] = date('Y-m-d ', strtotime($fromDate));


                if(empty($isPresent)){
                    $toDate = $day.'-'.$toMonths.'-'.$toYear;
                    $validateValues['to'] = date('Y-m-d ', strtotime($toDate));
                    $validateValues['is_present'] = 0;
                }
                
                unset($validateValues['from_months']);
                unset($validateValues['from_year']);
                unset($validateValues['to_months']);
                unset($validateValues['to_year']);
                unset($validateValues['is_experience_saved']);
                unset($validateValues['facilityGroup']);
                unset($validateValues['form_submit']);


                $validateValues['candidate_id'] = $candidateId;
                #for update request
                if(!empty($candidateExperienceId)){
                    $candidateExperienceData    = CandidateExperience::where(['candidate_id'=> $candidateId, 'id' => $candidateExperienceId])->update($validateValues);

                }else{
                    $candidateExperienceData    = CandidateExperience::create($validateValues);
                }
                
                $candidateExperienceFacilitiesData  = array();
                
                #for update request
                if(!empty($candidateExperienceId)){
                
                    CandidateExperienceFacilities::where(['candidate_experience_id' => $candidateExperienceId])->delete();
                    $lastInsertId = $candidateExperienceId;

                }else{
                    #Candidate Experience
                    $lastInsertId   = Arr::get($candidateExperienceData, 'id');
                }    
                    
                if(!empty($facilityGroups))
                {   
                    foreach($facilityGroups as $facilityGroup){
                        $candidateExperienceFacilitiesData[] = array(
                            'candidate_experience_id' =>$lastInsertId,
                            'facility_option_id' => $facilityGroup,
                        );
                    }

                    $candidateExperienceFacilities = CandidateExperienceFacilities::insert($candidateExperienceFacilitiesData);

                }

            }
           
            // if experience zero 
            $params = array('fieldName' => 'is_experience_saved', 'fieldValue'=>$isExperienceSaved);
            $this->updateProfileFlag($params);

            if(!empty($candidateExperienceId)){
                $mode = "Updated";
            }else{
                $mode = "Saved";
            }    
          
            if($candidateExperienceData || $isExperienceSaved==0 ){
                if($formSubmit== "Save & Add more" )
                {
                    return redirect()->back()->with('success', "Professional Experience ".$mode." successfully.");
                }
                else
                {
                    return redirect(route('skillset.show'))->with('success', "Professional Experience ".$mode." successfully.");
                }
                
            }else{
                return redirect('/professional-experience')
                ->withErrors(['error' =>"Something went wrong with Professional Experience. Please try again later!"]);
            }
            
            
        }catch(\Exception $e)
		{
			return $this->getCustomExceptionMessage($e);
            
        }	    
    }


     /**
     * Profile Page --Professional Experience --
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request){

        $candidateExperienceId  = $request->route('id');
        $candidateId            = Auth::guard('candidate')->user()->id;


        $candidateExperience = CandidateExperience::where(['candidate_id'=> $candidateId, 'id' => $candidateExperienceId])->first();
        if(!empty($candidateExperience)){
            
            //Delete candidate experience
            try 
            {
                \DB::beginTransaction();
            
                CandidateExperienceFacilities::where(['candidate_experience_id' => $candidateExperienceId])->delete();
                $candidateDocumentData = CandidateDocument::where(['candidate_id'=> $candidateId, 'table_name'=>config('constants.candidate_documents_tables.candidate_experiences'), 'table_action_id' => $candidateExperienceId])->get();
                $candidateExperience->delete();
                if(is_object($candidateDocumentData) && count($candidateDocumentData)>0){
                    foreach($candidateDocumentData as $candidateDocumentRow){
                        $candidateDocumentRow->delete();
                    }    
                }
                
                \DB::commit();

                $this->removeCandidateDocument($candidateDocumentData);

            
            } catch (Throwable $e) {
                \DB::rollback();
            }
           
           
            

            $candidateExperienceCount =CandidateExperience::where(['candidate_id'=> $candidateId])->count();
            if($candidateExperienceCount ==0){
                
                $params = array('fieldName' => 'is_experience_saved', 'fieldValue'=>0);
                $this->updateProfileFlag($params);
            }

            return redirect('/professional-experience')->with('success', "Professional Experience deleted successfully.");
        }else{
            return redirect()->back()
                ->withErrors(['error' =>"Unable to delete Professional Experience. Please try again!"]);
        }
        
        
    } 

}
