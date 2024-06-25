<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MobileNumberCustomValidation;
class CandidateRequest extends FormRequest
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
        $method = $this->request->get('_method');
        
        $passwordCondition = '';
        $confirmPasswordCondition = '';
        if($method=='patch')
        {
            $passwordCondition          = 'nullable|min:6|max:20';
            if(!empty($this->request->get('password')) && !is_null($this->request->get('password')))
            {
                $confirmPasswordCondition   = 'required|same:password|min:6|max:20';
            }else{
                $confirmPasswordCondition   = 'nullable|same:password|min:6|max:20';
            }

            return [
                'password'                      => $passwordCondition,
                'confirm_password'              => $confirmPasswordCondition,
            ];

           
        }
        else
        {
            $passwordCondition          = 'required|min:6|max:20';
            $confirmPasswordCondition   = 'required|same:password|min:6|max:20';

            return [
                'full_name'                     => 'required|max:50|regex:/^[\pL\s\-]+$/u',
                'email'                         => 'required|email:rfc,dns|max:50|unique:candidates,email,'.$id,
                'country_code'                  => 'required|in:' . implode(',', array_keys(config('constants.countries'))),
                'mobile_number' =>[
                    'required',
                    'max:18',
                    'regex:/^[0-9]+$/',
                    new MobileNumberCustomValidation($id)
                ],
                'password'                      => $passwordCondition,
                'confirm_password'              => $confirmPasswordCondition,
                'area_of_interest_option_id'    => 'required|exists:area_of_interest_options,id',
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
                       #full_name
                       'full_name.required'                     => 'The Full Name field is required!',
                       'full_name.max'                          => 'The Full Name must not be greater than :max characters.',
                       'full_name.regex'                        => 'The Full Name format is invalid',
                       #email
                       'email.required'                         => 'The Email Address is required!',
                       'email.email'                            => 'The Email Address field must be a valid email address!',
                       'email.unique'                           => 'Sorry, This Email Address is already used by another user. Please try with different one, thank you.',
                       'email.max'                              => 'Email Address must not be greater than :max characters.',
                       #country_code
                       'country_code.required'                  => 'Please select Country!',
                       'country_code.in'                        => 'The selected Country is invalid!',
                       #mobile_number
                       'mobile_number.required'                 => 'The Mobile Number field is required!',
                       'mobile_number.max'                      => 'The Mobile Number must not be greater than :max characters.!',
                       'mobile_number.regex'                    => 'The Mobile Number format is invalid.',
                       
                       #password
                       'password.required'                      => 'The Password field is required.',
                       'password.min'                           => 'The Password must be at least 6 characters.',
                       'password.max'                           => 'The Password must not be greater than :max characters.',
                       #confirm_password
                       'confirm_password.required'              => 'The Confirm Password field is required.',
                       'confirm_password.same'                  => 'The Confirm Password and Password must match.',
                       'confirm_password.min'                   => 'The Confirm Password must be at least :min characters.',
                       'confirm_password.max'                   => 'The Confirm Password must not be greater than :max characters.',
                       #area_of_interest_option_id
                       'area_of_interest_option_id.required'    => 'Please select Area of Interest!',
                       'area_of_interest_option_id.exists'      => 'The selected Area of Interest is invalid!',
                ];
    }

}
