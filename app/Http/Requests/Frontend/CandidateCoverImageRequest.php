<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class CandidateCoverImageRequest extends FormRequest
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
            'cover_image' => 'image|mimes:jpg,png,jpeg,gif|min:2|max:2048|dimensions:min_width=300,min_height=300',
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
                     
                #Cover
                'cover_image.image'      => 'Please select cover Image!',
                'cover_image.mimes'      => 'The Cover Image must be a file of type: jpg,png,jpeg,gif,svg!',
                'cover_image.min'        => 'The Cover Image must be at least 2 kilobytes!',
                'cover_image.max'        => 'The Cover Image must not be greater than 2 Mb!',
                'cover_image.dimensions' => 'The Cover Image must be at least :min_width x :min_height pixels pixels!',
         
         ];
    }


    /**
    * Get the error messages for the defined validation rules.*
    * @return array
    */
    protected function failedValidation(Validator $validator)
    {
        //return response()->json(['errors' => $validator->errors()->all()]);
        throw new HttpResponseException(response()->json([
        'errors' => $validator->errors()->all(),
        'status' => true
        ]));
    }
}
