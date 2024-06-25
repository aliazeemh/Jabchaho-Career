<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class CandidateReferRequest extends FormRequest
{
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
        return [
            'candidate_full_name'                     => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'job_type_id'                             => 'nullable|exists:job_types,id',
            'area_of_interest_option_id'              => 'required|exists:area_of_interest_options,id',
            'mobile'                                  => 'required|max:12|unique:refer_candidates,mobile|regex:/^[0-9]+$/',
            'city_region'                             => 'nullable|max:50',
            'level_of_education'                      => 'required|in:' . implode(',', array_keys(config('constants.level_of_educations'))),
            'email'                                   => 'nullable|email:rfc,dns|max:50',
            'country_code'                            => 'nullable|in:' . implode(',', array_keys(config('constants.countries'))),
            'previous_experience'                     => 'required|in:' . implode(',', array_keys(config('constants.level_of_educations'))),
            'ax_code'                                 => 'nullable|max:50',
            'g-recaptcha-response'                    => 'required|captcha'
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

            #full_name
            'candidate_full_name.required'                     => 'The Candidate Full Name field is required!',
            'candidate_full_name.max'                          => 'The Candidate Full Name must not be greater than :max characters.',
            'candidate_full_name.regex'                        => 'The Candidate Full Name format is invalid',

            //job_type_id
            'job_type_id.exists'                              => 'The Job Category field is Invalid!',
             
            #area_of_interest_option_id
            'area_of_interest_option_id.required'              => 'Please select Area of Interest!',
            'area_of_interest_option_id.exists'                => 'The selected Area of Interest is invalid!',

            #mobile
            'mobile.required'                                  => 'The Mobile Number field is required!',
            'mobile.max'                                       => 'The Mobile Number must not be greater than :max characters.!',
            'mobile.regex'                                     => 'The Mobile Number format is invalid.',
            'mobile.unique'                                  => 'The Mobile Number has already been taken.',

            #city_region
            'city_region.max'                                  => 'The City/Region must not be greater than :max characters.!',

            #level_of_education
            'level_of_education.required'                      => 'The Education Level field is required!', 
            'level_of_education.in'                            => 'The selected Education Level is invalid!',

            #email
            'email.email'                                      => 'The Candidate Email field must be a valid email address!',
            'email.max'                                        => 'Candidate Email must not be greater than :max characters.',

            #country_code
            'country_code.in'                                  => 'The Job Seeking Country is invalid!',

            #previous_experience
            'previous_experience.required'                     => 'The Previous Experience field is required!', 
            'previous_experience.in'                           => 'The selected Previous Experience is invalid!',

            #ax_code
            'ax_code.max'                                      => 'The AX Code must not be greater than :max characters.!',

             #g-recaptcha-response
             'g-recaptcha-response.required'                   => 'The Captcha field is required!',// 
             'g-recaptcha-response.captcha'                    => 'Failed to validate the Captcha.',// 


        ];      
    }    
            
}
