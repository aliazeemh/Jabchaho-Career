<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CandidateReviewRequest extends FormRequest
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
            'review'               => 'required|max:4294967200',
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
            
            //review
            'review.required'            => 'The Review field is required!',
            'review.max'                 => 'The Review must not be greater than :max characters.!',

        ];
    }

}
