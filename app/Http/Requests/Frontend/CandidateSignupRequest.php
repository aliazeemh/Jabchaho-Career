<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\MobileNumberCustomValidation;
use Validator;

class CandidateSignupRequest extends FormRequest
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
            'full_name'                     => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'email'                         => 'required|email:rfc,dns|unique:candidates,email|max:50',
            'country_code'                  => 'required|in:' . implode(',', array_keys(config('constants.countries'))),
            'mobile_code'                   => 'required_if:country_code,==,'.config('constants.default_country_code').'|in:' . implode(',', config('constants.mobile_code')),// mobile code validation
            'mobile_number' =>[
                'required_if:country_code,==,'.config('constants.default_country_code'),
                'max:7',
                'min:7',
                'regex:/^[0-9]+$/',
                'nullable',
                new MobileNumberCustomValidation()
            ],
            'int_mobile_number'             => [
                'required_unless:country_code,'.config('constants.default_country_code'),
                'max:12',
                'min:12',
                'regex:/^[0-9]+$/',
                'nullable',
                new MobileNumberCustomValidation()
            ],
            'password'                      => 'required|min:6|max:20',
            'confirm_password'              => 'required|same:password|min:6|max:20',
            'area_of_interest_option_id'    => 'required|exists:area_of_interest_options,id',
            'resume'                        => 'required|mimes:jpeg,jpg,pdf,application/pdf|min:1|max:1024', 
            'g-recaptcha-response'          => 'required|captcha'
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
                       #mobile_code
                       'mobile_code.required_if'                => 'Please select Mobile Code!',
                       'mobile_code.in'                         => 'The selected Mobile Code is invalid!',
                       #mobile_number
                       'mobile_number.required_if'              => 'The Mobile Number field is required!',
                       'mobile_number.max'                      => 'The Mobile Number must not be greater than :max characters.!',
                       'mobile_number.min'                      => 'The Mobile Number must not be less than :min characters.!',
                       'mobile_number.regex'                    => 'The Mobile Number format is invalid.',
                       #int_mobile_number
                       'int_mobile_number.required_unless'      => 'The Mobile Number field is required!',
                       'int_mobile_number.max'                  => 'The Mobile Number must not be greater than :max characters.!',
                       'int_mobile_number.min'                  => 'The Mobile Number must not be less than :min characters.!',
                       'int_mobile_number.regex'                => 'The Mobile Number format is invalid.',
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
                        #resume
                        'resume.required'                       => 'The CV field is required!',
                        'resume.mimes'                          => 'The CV must be a file of type: jpeg,jpg,pdf!',
                        'resume.min'                            => 'The CV File must be at least 1 kilobytes!',
                        'resume.max'                            => 'The CV File must not be greater than 1 Mb!',
                       #g-recaptcha-response
                       'g-recaptcha-response.required'          => 'The Captcha field is required!',// 
                       'g-recaptcha-response.captcha'           => 'Failed to validate the Captcha.',// 
         ];
    }
}
