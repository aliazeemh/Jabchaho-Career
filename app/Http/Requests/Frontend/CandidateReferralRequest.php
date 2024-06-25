<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CandidateReferralRequest extends FormRequest
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
        $candidateId  = Auth::guard('candidate')->user()->id;

        return [
            'id'                                   => 'nullable|exists:candidate_referrals,id,candidate_id,'.$candidateId,
            'referral_id'                          => 'required|in:' . implode(',', array_keys(config('constants.referral_options'))),
            'person_name'                          => 'nullable|required_if:referral_id,5|max:100',
            'contact_no'                           => 'nullable|required_if:referral_id,5|max:20|regex:/^[0-9]+$/',//|regex:/^[0-9]+$/
            'employee_id'                          => 'nullable|max:100',
            'reference_code'                       => 'nullable|required_if:referral_id,6|max:20|regex:/^[0-9]+$/',
            'other_medium'                         => 'nullable|required_if:referral_id,7|max:200',
            'other_name'                           => 'nullable|required_if:referral_id,7|max:100',
            'other_contact_no'                     => 'nullable|required_if:referral_id,7|max:20|regex:/^[0-9]+$/', //|regex:/^[0-9]+$/
        ];
    }


    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return 
        [
            'id.exists'                                 => 'The Referral is invalid!',
            
            'referral_id.required'                      => 'The Medium field is required!',
            'referral_id.in'                            => 'The Medium is not valid!',

            'person_name.required_if'                   => 'The Name field is required!',
            'person_name.max'                           => 'The Name must not be greater than :max characters.!',

            'contact_no.required_if'                    => 'The Contact No field is required!',
            'contact_no.max'                            => 'The Contact No must not be greater than :max characters.!',
            'contact_no.regex'                          => 'The Contact No field must be numeric!',

            'employee_id.max'                            => 'The Employee Id must not be greater than :max characters.!',

            'reference_code.required_if'                => 'The Reference Code field is required!',
            'reference_code.max'                        => 'The Reference Code must not be greater than :max characters.!',
            'reference_code.regex'                      => 'The Reference Code must be numeric!',

            'other_medium.required_if'                  => 'The Medium field is required!',
            'other_medium.max'                          => 'The Medium field must not be greater than :max characters.!',

            'other_name.required_if'                   => 'The Name field is required!',
            'other_name.max'                           => 'The Name field must not be greater than :max characters.!',

            'other_contact_no.required_if'             => 'The Contact No field is required!',
            'other_contact_no.max'                     => 'The Contact No field must not be greater than :max characters.!',
            'other_contact_no.regex'                   => 'The Contact No field must be numeric!',
        ];

    }    
}
