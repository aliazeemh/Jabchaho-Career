<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class JobCommentRequest extends FormRequest
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
            'job_status_id'         => 'required|exists:job_statuses,id', ////65000
            'comment'               => 'required|max:65000',
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
            
            //Status
            'job_status_id.required'          => 'The Status field is required!',
            'job_status_id.exists'             => 'The Status is invalid!',

            //comment
            'comment.required'            => 'The Comment field is required!',
            'comment.max'                 => 'The Comment must not be greater than :max characters.!',

        ];
    }
}
