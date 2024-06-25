<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Rules\DateOfBirthValidation;
use App\Rules\MultiDimensionalArrayValidation;

class CandidatePersonalDetailRequest extends FormRequest
{
    
    public $last;
    public $now;
 
    
    public function __construct()
     {
        $this->last =  date('Y')-120; 
        $this->now= date('Y')-16;              
     }
    
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {        
        $countryCode = $this->request->get('country_code');

        $pakCityCondition   = 'nullable';
        $cityCondition      = 'nullable'; 

        if($countryCode==config('constants.default_country_code'))
        {
            $pakCityCondition = 'required|in:' . implode(',', array_keys(config('constants.cities')));
        }else{
            $cityCondition = 'required|max:200';
        }

        //$this->request->get('level_of_education');
        
        $ownConvenienceOptions = config('constants.own_convenience');
        $candidateId  = Auth::guard('candidate')->user()->id;
        return [
            'id'                                   => 'nullable|exists:candidate_details,id,candidate_id,'.$candidateId,
            'full_name'                            => 'required|max:50',
            'gender'                               => 'required|in:' . implode(',', array_keys(config('constants.gender_options'))), 
            'month'                                => 'required|in:' . implode(',', array_keys(config('constants.months'))), 
            'day'                                  => ['required','between:1,31','integer'],
            'year'                                 => ['required','digits:4','integer','min:'.$this->last,'max:'.$this->now,new DateOfBirthValidation()],
            'marital_status'                       => 'required|in:' . implode(',', array_keys(config('constants.marital_statuses'))), 
            'nationality'                          => 'required|in:' . implode(',', array_keys(config('constants.nationality'))), 
            'cnic'                                 => 'required_if:nationality,1|max:13|min:13|regex:/^[0-9]+$/',
            'passport'                             => 'required_if:nationality,0|max:20',
            'religion'                             => 'required|in:' . implode(',', array_keys(config('constants.religion'))), 
            'linkedin_profile'                     => 'required|max:500|url',
            'shift_id'                             => 'required|exists:shifts,id,is_enabled,1',
            'height_feet'                          => 'nullable|max:2|regex:/^[0-9]+$/', //|regex:/^\d+(\.\d{1,3})?$/
            'height_inches'                        => 'nullable|max:2|regex:/^[0-9]+$/',//|regex:/^\d+(\.\d{1,3})?$/
            'weight'                               => 'nullable|max:3|regex:/^[0-9]+$/',//|regex:/^\d+(\.\d{1,3})?$/
            'total_experience'                     => 'required|max:3|regex:/^[0-9]+$/',
            'expected_salary'                      => 'nullable|max:7|regex:/^[0-9]+$/',
            'own_convenience'                      => ['required',new MultiDimensionalArrayValidation($ownConvenienceOptions)] ,//own_convenience
            'mobile_code.*'                        => 'nullable|in:' . implode(',', config('constants.mobile_code')),
            'mobile_number.*'                      => 'nullable|max:7|min:7|regex:/^[0-9]+$/',
            'area_code'                            => 'nullable|max:7|regex:/^[0-9]+$/',
            'landline_number'                      => 'nullable|max:11|regex:/^[0-9]+$/',
            'house_no'                             => 'required|max:50',
            'street'                               => 'required|max:50',
            'area'                                 => 'required|max:200',
            'city'                                 => $cityCondition,
            'pak_city'                             => $pakCityCondition,
            'country_code'                         => 'required|in:' . implode(',', array_keys(config('constants.countries'))),

        ];
    }


         /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
         return [
            'id.exists'                                 => 'The Personal Detail is invalid!',
            'full_name.required'                        => 'The Your Name field is required!',
            'full_name.max'                             => 'The Your Namee must not be greater than :max characters.!',

            'gender.required'                           => 'The Gender field is required!',
            'gender.in'                                 => 'The Gender is not valid!',

            'day.required'                              => 'The Day field is required!',
            'day.between'                               => 'The Day must be between 1 and 31.',
            'day.integer'                               => 'The Day must be an integer.',

            'month.required'                            => 'The Month field is required!',
            'month.in'                                  => 'The selected Month is invalid!',

            'year.required'                             => 'The Year field is required!',
            'year.digits'                               => 'The Year  must be 4 digits!',
            'year.integer'                              => 'The Year must be an integer!',
            'year.min'                                  => 'The Year must be greater than or equal to '.$this->last.'!',
            'year.max'                                  => 'The Year must be less than or equal to '.$this->now.'!',

            //marital_status
            'marital_status.required'                   => 'The Marital Status field is required!',
            'marital_status.in'                         => 'The selected Marital Status is invalid!',

            //nationality
            'nationality.required'                      => 'The Nationality field is required!',
            'nationality.in'                            => 'The selected Nationality is invalid!',

            //cnic
            'cnic.required_if'                          => 'The CNIC field is required!',
            'cnic.max'                                  => 'The CNIC must not be greater than :max characters.!',
            'cnic.min'                                  => 'The CNIC must not be less than :min characters.!',
            'cnic.*.regex'                              => 'The CNIC must be numeric!',

            //passport
            'passport.required_if'                      => 'The Passport field is required!',
            'passport.max'                              => 'The Passport must not be greater than :max characters.!',

            //religion
            'religion.required'                         => 'The Religion field is required!',
            'religion.in'                               => 'The Religion is not valid!',

            //linkedin_profile
            'linkedin_profile.required'                 => 'The Linkedin Profile field is required!',
            'linkedin_profile.max'                      => 'The Linkedin Profile must not be greater than :max characters.!',
            'linkedin_profile.url'                      => 'The Linkedin Profile must be a valid Link.',

            //shift_id
            'shift_id.required'                         => 'The Shift Availability field is required!',
            'shift_id.exist'                            => 'The Shift Availability is invalid!',

            //Height Feet 
            'height_feet.max'                            => 'The Height in feet must not be greater than :max !',
            'height_feet.regex'                          => 'The Height in feet must be numeric!',

            //Height Inches
            'height_inches.max'                          => 'The Height in inches must not be greater than :max !',
            'height_inches.regex'                        => 'The Height in inches must be numeric!',

            //weight
            'weight.max'                                 => 'The Weight must not be greater than :max !',
            'weight.regex'                               => 'The Weight must be numeric!',

            #total_experience
            'total_experience.required'                       => 'The Total Experience field is required!',
            'total_experience.max'                            => 'The Total Experience must not be greater than :max characters.!',
            'total_experience.regex'                          => 'The Total Experience format is invalid.',

            //expected_salary
            'expected_salary.max'                        => 'The Expected Salary must not be greater than :max !',
            'expected_salary.regex'                      => 'The Expected Salary must be numeric!',

            //own_convenience
            'own_convenience.required'                   => 'The Own Convenience field is required!',
            'own_convenience.in'                         => 'The Own Convenience is not valid!',

            //Mobile Number
            'mobile_code.*.in'                           => 'The Mobile Code is invalid!',
            
            'mobile_number.*.max'                        => 'The Mobile must not be greater than :max !',
            'mobile_number.*.min'                        => 'The Mobile must not be less than :min !',
            'mobile_number.*.regex'                      => 'The Mobile must be numeric!',

            //Landline Number
            'area_code.max'                              => 'The Area code must not be greater than :max !',
            'area_code.regex'                            => 'The Area code must be numeric!',

            'landline_number.max'                        => 'The Number must not be greater than :max !',
            'landline_number.regex'                      => 'The Number must be numeric!',
            
            //HouseNo
            'house_no.required'                          => 'The House No field is required!',
            'house_no.max'                               => 'The House No must not be greater than :max characters.!',

            //street
            'street.required'                            => 'The Block/Street field is required!',
            'street.max'                                 => 'The Block/Street must not be greater than :max characters.!',

            //area
            'area.required'                              => 'The Area field is required!',
            'area.max'                                   => 'The Area must not be greater than :max characters.!',

            //City
            'city.required'                              => 'The City field is required',
            'city.max'                                   => 'The City must not be greater than :max characters.!',

            //pak_city
            'pak_city.required'                          => 'The City field is required',
            'pak_city.in'                                => 'The City is not valid!',

            'country_code.required'                      => 'Please select Country!',
            'country_code.in'                            => 'The selected Country is invalid!',
        ];    
    }     

}
