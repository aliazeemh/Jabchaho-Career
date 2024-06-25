<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\TipAndGuide;

class TipAndGuideRequest extends FormRequest
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
            'title'     => 'required|max:200|unique:tips_and_guides,title,'.$id,
            'summary'   => 'required|max:65000',
            'content'   => 'required|max:4294967200',
            'publish'   => 'nullable'
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
            'title.required'                     => 'The Title field is required!',
            'title.max'                          => 'The Title must not be greater than :max characters.!',
            'title.unique'                       => 'The Title has already been taken.',

            'summary.required'                   => 'The Summary field is required!',
            'summary.max'                        => 'The Summary must not be greater than :max characters.!',

            'content.required'                   => 'The Content field is required!',
            'content.max'                        => 'The Content must not be greater than :max characters.!',

         ];
    }     
}
