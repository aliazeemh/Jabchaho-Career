<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class CandidateSigninRequest extends FormRequest
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
            'email'                         => 'required', //|max:50email:rfc,dns|
            'password'                      => 'required', //|max:20
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
                     
                #email
                'email.required'                         => 'The Email or Mobile Number is required!',
                //'email.email'                            => 'The Email Address field must be a valid email address!',
                //'email.max'                              => 'Email or Mobile Number must not be greater than 50 characters.',

                #password
                'password.required'                      => 'The Password field is required.',
                //'password.max'                           => 'The Password must not be greater than 20 characters.',
                       
         ];
    }
}
