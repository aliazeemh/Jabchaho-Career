<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class CandidateProfileImageRequest extends FormRequest
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
            //'profile_image' => 'image|mimes:jpg,png,jpeg,gif|min:2|max:1024|dimensions:min_width=160,min_height=160,max_width=300,max_height=300',
            'profile_image' => 'image|mimes:jpg,png,jpeg,gif|min:2|max:1024',
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
                'profile_image.image'      => 'Please select a Profile Image!',
                'profile_image.mimes'      => 'The Profile Image must be a file of type: jpg,png,jpeg,gif,svg!',
                'profile_image.min'        => 'The Profile Image must be at least 2 kilobytes!',
                'profile_image.max'        => 'The Profile Image must not be greater than 1 Mb!',
                //'profile_image.dimensions' => 'The Profile Image must be at least :min_width x :min_height, :max_width x :max_height pixels!',
         
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
