<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidate;
use App\Models\CandidateDetail;
use App\Models\Shift;
use App\Models\CandidateShift;
use App\Models\CandidateMobileNumber;
use Illuminate\Support\Carbon;
use App\Http\Requests\Frontend\CandidatePersonalDetailRequest;


class PersonalDetailController extends ProfileController
{
    /**
    * Profile Page --Personal Detail Form --
    *
    * @param Request $request
    *
    * @return \Illuminate\Http\Response
    */
    public function personalDetailForm(Request $request){

        $candidateDetailObject        = new CandidateDetail();
        $shiftObject                  = new Shift();
        $candidateShiftObject         = new CandidateShift();
        $candidateMobileNumberObject  = new CandidateMobileNumber();
        
        $candidateId                    = Auth::guard('candidate')->user()->id;

        $data['months']                 = config('constants.months');
        $data['genderOptions']          = config('constants.gender_options');
        $data['maritalStatuses']        = config('constants.marital_statuses');
        $data['nationality']            = config('constants.nationality');
        $data['religions']              = config('constants.religion');//religion
        $data['mobileCodes']            = config('constants.mobile_code');
        $data['countries']              = config('constants.countries'); #Countries from constant file
        $data['cities']                 = config('constants.cities');
        $data['ownConvenience']        = config('constants.own_convenience');//own_convenience
        
        $data['personalDetailData']     = $candidateDetailObject->getCandidateDetail($candidateId);
        $data['shifts']                 = $shiftObject->getShifts();
        $data['candidateShifts']        = $candidateShiftObject->getCandidateShifts();
        $data['candidateMobileNumbers'] = $candidateMobileNumberObject->getCandidateMobileNumbers();
        
        return view('frontend.candidates.profile.personal-detail')->with($data);
    } 
    
    
     /**
     * Handle Diploma save request
     *
     * @param CandidatePersonalDetailRequest $request
     *
     * @return \Illuminate\Http\Response
     */

    public function personalDetail(CandidatePersonalDetailRequest $request)
    {
        try
		{
            $validateValues = $request->validated();
            
            if(!empty($validateValues)){
                
                $candidateId                            = Auth::guard('candidate')->user()->id;

                $day                                    = (int) Arr::get($validateValues, 'day');
                $month                                  = (int) Arr::get($validateValues, 'month');
                $year                                   = (int) Arr::get($validateValues, 'year');
                
                //candidates
                $candidates['full_name']                = Arr::get($validateValues, 'full_name');
                $candidates['total_experience']         = Arr::get($validateValues, 'total_experience');  
                $countryCode                            = Arr::get($validateValues, 'country_code'); 
                
                //candidate_details
                $id                                     = Arr::get($validateValues, 'id');

                $height = 0;
                if(!empty(Arr::get($validateValues, 'height_feet')) || !empty(Arr::get($validateValues, 'height_inches')))
                {
                    $height = Arr::get($validateValues, 'height_feet').".".Arr::get($validateValues, 'height_inches'); 
                }

                $landlineNumber ='';

                if(!empty(Arr::get($validateValues, 'area_code')) ||!empty(Arr::get($validateValues, 'landline_number')))
                {
                    $landlineNumber =Arr::get($validateValues, 'area_code').'-'.Arr::get($validateValues, 'landline_number');
                }

                $commaSepratedOwnConvenience = '';
                if(!empty(Arr::get($validateValues, 'own_convenience')))
                {
                    $commaSepratedOwnConvenience = implode(',', Arr::get($validateValues, 'own_convenience')); 
                }

                $candidateDetail['id']                  = $id; 
                $candidateDetail['candidate_id']        = $candidateId; 
                $candidateDetail['gender']              = Arr::get($validateValues, 'gender'); 
                $candidateDetail['date_of_birth']       = Carbon::createFromFormat('Y-m-d', $year.'-'.$month.'-'.$day)->toDateString();
                $candidateDetail['marital_status']      = Arr::get($validateValues, 'marital_status'); 
                $candidateDetail['nationality']         = Arr::get($validateValues, 'nationality'); 
                $candidateDetail['cnic']                = Arr::get($validateValues, 'cnic'); 
                $candidateDetail['passport']            = Arr::get($validateValues, 'passport'); 
                $candidateDetail['religion']            = Arr::get($validateValues, 'religion'); 
                $candidateDetail['linkedin_profile']    = Arr::get($validateValues, 'linkedin_profile'); 
                $candidateDetail['height']              = $height;
                $candidateDetail['weight']              = Arr::get($validateValues, 'weight'); 
                $candidateDetail['expected_salary']     = Arr::get($validateValues, 'expected_salary'); 
                $candidateDetail['own_convenience']     = $commaSepratedOwnConvenience;
                $candidateDetail['landline_number']     = $landlineNumber; 
                $candidateDetail['house_no']            = Arr::get($validateValues, 'house_no'); 
                $candidateDetail['street']              = Arr::get($validateValues, 'street'); 
                $candidateDetail['area']                = Arr::get($validateValues, 'area'); 
                $candidates['country_code']             = $countryCode;
                
                if($countryCode==config('constants.default_country_code'))
                {
                    $candidateDetail['city']                = Arr::get($validateValues, 'pak_city'); 
                }
                else{
                    $candidateDetail['city']                = Arr::get($validateValues, 'city'); 
                }
                
                
                //cadidate_shifts
                $shiftIdsArray                          = Arr::get($validateValues, 'shift_id');
                
                //candidate_mobile_numbers
                $mobileCodeArray                        = Arr::get($validateValues, 'mobile_code');
                $mobileNumberArray                      = Arr::get($validateValues, 'mobile_number');

                //cadidate_shifts
                $cadidateShifts = array();
                if(!empty($shiftIdsArray)){

                    foreach($shiftIdsArray  as $shiftId){
                        $cadidateShifts[] = array
                        (
                                'candidate_id'  => $candidateId,
                                'shift_id'      => $shiftId
                        );        
                    } 
                }


                //candidate_mobile_numbers
                $candidateMobileNumbers = array();
                if(!empty($mobileCodeArray) || !empty($mobileNumberArray) ){
                
                    foreach($mobileCodeArray  as $key => $value){
                        $candidateMobileNumbers[] = array
                        (
                                'candidate_id'      => $candidateId,
                                'mobile_code'       => $value,
                                'mobile_number'     => $mobileNumberArray[$key]
                        );        
                    }
                }
                
                
                //Update Candidate
                $candidateData    = Candidate::where(['id' => $candidateId])->update($candidates);

                #Insert/Update Candidate detail
                if(!empty($id)){
                    $candidateDetailData    = CandidateDetail::where(['candidate_id'=> $candidateId, 'id' => $id])->update($candidateDetail);

                }else{
                    $candidateDetailData    = CandidateDetail::create($candidateDetail);
                }

                //Delete and Add Shifts
                CandidateShift::where(['candidate_id'=> $candidateId])->delete();
                if(!empty($cadidateShifts)){
                    CandidateShift::insert($cadidateShifts);
                }


                //Delete and Add candidate mobile numbers
                CandidateMobileNumber::where(['candidate_id'=> $candidateId])->delete();
                if(!empty($candidateMobileNumbers)){
                    CandidateMobileNumber::insert($candidateMobileNumbers);
                }


                // if is_portfolio_saved zero 
                $params = array('fieldName' => 'is_personal_details_saved', 'fieldValue'=>1);
                $this->updateProfileFlag($params);
                
                return redirect(route('educational.qualification.show'))->with('success', "Personal Details saved successfully.");
            }

        }catch(\Exception $e)
		{
			return $this->getCustomExceptionMessage($e);
            
        }	    
    }     
}
