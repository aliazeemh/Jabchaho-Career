<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\FromAndToDateValidate;

class CandidateProfessionalExperienceRequest extends FormRequest
{
   public $last;
   public $now;

   
   public function __construct()
    {
       $this->last =  date('Y')-120; 
       $this->now= date('Y');              
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
        $candidateId  = Auth::guard('candidate')->user()->id;

        if(!empty($this->request->get('is_experience_saved')) && array_key_exists($this->request->get('is_experience_saved'),config('constants.boolean_options')))
        {
            return 
            [
                'id'                                   => 'nullable|exists:candidate_experiences,id,candidate_id,'.$candidateId,
                'is_experience_saved'                  => 'required|in:' . implode(',', array_keys(config('constants.boolean_options'))), 
                'company_name'                         => 'required|max:100',
                'job_title'                            => 'required|max:100',
                'job_city_country'                     => 'required|max:200', 
                'from_months'                          => 'required|in:' . implode(',', array_keys(config('constants.months'))), 
                //'from_year'                            => 'required|digits:4|integer|min:'.$this->last.'|max:'.$this->now,
                'from_year'                            => ['required','digits:4','integer','min:'.$this->last,'max:'.$this->now, new FromAndToDateValidate],//'required|digits:4|integer|min:'.$this->last.'|max:'.$this->now,   
                'to_months'                            => 'required_without:is_present|nullable|in:' .implode(',', array_keys(config('constants.months'))),
                'to_year'                              => 'required_without:is_present|nullable|digits:4|integer|min:'.$this->last.'|max:'.$this->now, //FromAndToDateValidate
                //'to_year'                              => ['required_without:is_present','nullable','digits:4','integer','min:'.$this->last,'max:'.$this->now, new FromAndToDateValidate],//'required_without:is_present|nullable|digits:4|integer|min:'.$this->last.'|max:'.$this->now,
                'current_salary'                       => 'required|regex:/^[0-9]+$/|max:7', 
                'initial_salary'                       => 'required|regex:/^[0-9]+$/|max:7', 

                'job_type_id'                          => 'required|exists:job_types,id,is_enabled,1',
                //option but valid
                'company_website'                      => 'nullable|url|max:100',
                'facilityGroup'                        => 'nullable|exists:facility_options,id,is_enabled,1', 
                'responsibilities'                     => 'nullable|max:65000',
                'reason_for_leaving'                   => 'nullable|max:65000',
                'is_present'                           => 'nullable|boolean',
                'form_submit'                          => 'nullable',                    
            ];
        }else{
            return [
                'is_experience_saved'                  => 'required|in:' . implode(',', array_keys(config('constants.boolean_options'))),
                'form_submit'                          => 'nullable', 
            ];
        }
    }


    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
         return [
            
            'id.exists'                                 => 'The Professional Experience is invalid!',
            'is_experience_saved.required'              => 'Please Select Do you have professional experience?',
            'is_experience_saved.in'                    => 'Invalid Do you have professional experience? !',

            'company_name.required'                     => 'The Company Name field is required!',
            'company_name.max'                          => 'The Company Name must not be greater than :max characters.!',

            'job_title.required'                        => 'The Job Title field is required!',
            'job_title.max'                             => 'The Job Title must not be greater than :max characters.!',

            'job_city_country.required'                 => 'The Job City field is required!',
            'job_city_country.max'                      => 'The Job City must not be greater than :max characters.!',


            'from_months.required'                      => 'The Duration From Month field is required!',
            'from_months.in'                            => 'The selected Duration From Month is invalid!',

            'from_year.required'                        => 'The Duration From Year field is required!',
            'from_year.digits'                          => 'The Duration From Year  must be 4 digits!',
            'from_year.integer'                         => 'The Duration From Year must be an integer!',
            'from_year.min'                             => 'The Duration From Year must be greater than or equal to '.$this->last.'!',
            'from_year.max'                             => 'The Duration From Year must be less than or equal to '.$this->now.'!',
            
            'to_months.required_without'                => 'The Duration To Month field is required!',
            'to_months.in'                              => 'The selected Duration To Month is invalid!',

            'to_year.required_without'                  => 'The Duration To Year field is required!',
            'to_year.digits'                            => 'The Duration To Year  must be 4 digits!',
            'to_year.integer'                           => 'The Duration To Year must be an integer!',
            'to_year.min'                               => 'The Duration To Year must be greater than or equal to '.$this->last.'!',
            'to_year.max'                               => 'The Duration To Year must be less than or equal to '.$this->now.'!',

            'current_salary.required'                   => 'The Current Salary field is required!',
            'current_salary.max'                        => 'The Current Salary must not be greater than :max characters.!',
            'current_salary.regex'                      => 'The Current Salary needs to be an entire number.',

            'initial_salary.required'                   => 'The Initial Salary field is required!',
            'initial_salary.max'                        => 'The Initial Salary must not be greater than :max characters.!',
            'initial_salary.regex'                      => 'The Initial Salary needs to be an entire number.',

            'job_type_id.required'                      => 'The Job Type field is required!',
            'job_type_id.exists'                        => 'The Job Type field is invalid!',

            'company_website.url'                       => 'The Company Website must be a valid URL.',
            'company_website.max'                       => 'The Company Website must not be greater than :max characters.!',

            'facilityGroup.exists'                      => 'Please select valid facility.!', 

            'responsibilities.max'                      => 'The Responsibilities must not be greater than :max characters.!',
            'reason_for_leaving.max'                    => 'The Reson For Leaving must not be greater than :max characters.!',

            'is_present.boolean'                        => 'The Currently working here is invalid!',
         ];    
    }     
}
