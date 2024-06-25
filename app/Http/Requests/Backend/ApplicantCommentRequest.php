<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ApplicantCommentRequest extends FormRequest
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
            'applicant_status_id'         => 'required|exists:applicant_statuses,id',
            'comment'                     => 'required|max:65000',
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
            'applicant_status_id.required'      => 'The Status field is required!',
            'applicant_status_id.exists'        => 'The Status is invalid!',

            //comment
            'comment.required'            => 'The Comment field is required!',
            'comment.max'                 => 'The Comment must not be greater than :max characters.!',

        ];
    }
}
