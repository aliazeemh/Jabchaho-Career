<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class HomeContentRequest extends FormRequest
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
        return [
            'candidate_status_id'       => 'required|unique:candidate_status_wise_home_contents,candidate_status_id,'.$id,
            'title'                     => 'required|max:200',
            'content'                   => 'required|max:4294967200',
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
            
            'candidate_status_id.required'      => 'The Status field is required!',
            'candidate_status_id.unique'        => 'The Status has already been taken.',

            'title.required'                     => 'The Title field is required!',
            'title.max'                          => 'The Title must not be greater than :max characters.!',

            'content.required'                   => 'The Content field is required!',
            'content.max'                        => 'The Content must not be greater than :max characters.!',

         ];
    }     
}
