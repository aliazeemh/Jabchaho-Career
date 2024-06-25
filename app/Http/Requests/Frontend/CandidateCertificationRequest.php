<?php

namespace App\Http\Requests\Frontend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\FromAndToDateValidate;

class CandidateCertificationRequest extends FormRequest
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

        if(!empty($this->request->get('is_certifications_saved')) && array_key_exists($this->request->get('is_certifications_saved'),config('constants.boolean_options')))
        {
            return [
                'id'                                   => 'nullable|exists:candidate_certifications,id,candidate_id,'.$candidateId,
                'is_certifications_saved'              => 'required|in:' . implode(',', array_keys(config('constants.boolean_options'))), 
                'institute_name'                       => 'required|max:100',
                'certification_title'                  => 'required|max:100', 
                'field_of_study'                       => 'required|max:100',
                'from_months'                          => 'required|in:' . implode(',', array_keys(config('constants.months'))), 
                //'from_year'                            => 'required|digits:4|integer|min:'.$this->last.'|max:'.$this->now,  
                'from_year'                            => ['required','digits:4','integer','min:'.$this->last,'max:'.$this->now, new FromAndToDateValidate],
                'to_months'                            => 'required_without:is_in_progress|nullable|in:' .implode(',', array_keys(config('constants.months'))),
                'to_year'                              => 'required_without:is_in_progress|nullable|digits:4|integer|min:'.$this->last.'|max:'.$this->now,
                'courses_papers_total'                 =>  'required_with:is_in_progress|nullable|digits_between:1,2|integer',
                'courses_papers_cleared'               =>  'required_with:is_in_progress|nullable|digits_between:1,2|integer',
                 //option but valid  
                'is_in_progress'                       => 'nullable|boolean',
                'form_submit'                          => 'nullable', 

                ''
            ];
        }else{
            return [
                'is_certifications_saved'              => 'required|in:' . implode(',', array_keys(config('constants.boolean_options'))),
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
            'id.exists'                                 => 'The Certifications is invalid!',
            'is_certifications_saved.required'          => 'Please select Do you have any certifications?',
            'is_certifications_saved.in'                => 'Invalid Do you have any certifications? !',
            'institute_name.required'                   => 'The Institute Name field is required!',
            'institute_name.max'                        => 'The Institute Name must not be greater than :max characters.!',

            'certification_title.required'              => 'The Certification Title field is required!',
            'certification_title.max'                   => 'The Certification Title must not be greater than :max characters.!',
            
            'field_of_study.required'                   => 'The Field of Study field is required!',
            'field_of_study.max'                        => 'The Field of Study must not be greater than :max characters.!',

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

            'courses_papers_total.required_with'        => 'The Total field is required!',
            'courses_papers_total.max'                  => 'The Total must not be greater than :max characters.!',
            'courses_papers_total.numeric'              => 'The Total field must be numeric!',

            'courses_papers_cleared.required_with'      => 'The Cleared field is required!',
            'courses_papers_cleared.max'                => 'The Cleared must not be greater than :max characters.!',
            'courses_papers_cleared.numeric'            => 'The Cleared field must be numeric!',

            'is_in_progress.boolean'                    => 'The In progress is invalid!',
        ];    
    }    
}
