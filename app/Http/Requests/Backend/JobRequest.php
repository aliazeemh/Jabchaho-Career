<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
        $id =(int) \Request::segment(4);
        
        $commentCondition = '';
        if(!empty($id)){
            $commentCondition = 'required|max:65000';
        }
        
        return [
            'title'                         => 'required|max:200',
            'city_id'                       => 'required|in:' . implode(',', array_keys(config('constants.cities'))),
            'area_of_interest_option_id'    => 'required|exists:area_of_interest_options,id',
            'job_type_id'                   => 'required|exists:job_types,id',
            'responsibility'                => 'required|max:4294967200',
            'requirement'                   => 'required|max:4294967200',
            'start_date'                    => 'required|date',
            'end_date'                      => 'required|date|after:start_date',
            'job_benefit_id'                => 'required|exists:job_benefits,id,is_enabled,1',
            'comment'                       => $commentCondition
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
            
            //title
            'title.required'                     => 'The Title field is required!',
            'title.max'                          => 'The Title must not be greater than :max characters.!',

            //city
            'city_id.required'                   => 'The City field is required',
            'city_id.in'                         => 'The City is not valid!',

            //area_of_interest_option_id
            'area_of_interest_option_id.required' => 'The Category field is required!',
            'area_of_interest_option_id.exists'   => 'The Category field is Invalid!',

            //job_type_id
            'job_type_id.required'               => 'The Job type field is required!',
            'job_type_id.exists'                 => 'The Job type field is Invalid!',

            //responsibility
            'responsibility.required'            => 'The Responsibilities field is required!',
            'responsibility.max'                 => 'The Responsibilities must not be greater than :max characters.!',

            //requirement
            'requirement.required'               => 'The Requirements field is required!',
            'requirement.max'                    => 'The Requirements must not be greater than :max characters.!',

            //Benefits
            'job_benefit_id.required'           => 'The Benefits field is required!',
            'job_benefit_id.exists'             => 'The Benefits is invalid!',

            //Start Date
            'start_date.required'               => 'The Start Date field is required!',
            'start_date.date'                   => 'The Start date is not a valid date!',

            //END Date
            'end_date.required'                 => 'The End Date field is required!',
            'end_date.date'                     => 'The End Date is not a valid date!',
            'end_date.after'                    => 'The End date must be a date after Start date.',

            //comment
            'comment.required'            => 'The Comment field is required!',
            'comment.max'                 => 'The Comment must not be greater than :max characters.!',
        ];
    }
}
