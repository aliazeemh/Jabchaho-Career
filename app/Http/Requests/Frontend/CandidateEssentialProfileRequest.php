<?php

namespace App\Http\Requests\Frontend;
use App\Models\Candidate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\CandidateDocument;
use Illuminate\Support\Arr;

class CandidateEssentialProfileRequest extends FormRequest
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
        $candidateId = 0;
        $resumeCondition = 'required';
        
        $socialiteField = \Session::get('socialiteField'); //google_id
        $socialiteUser = \Session::get('socialiteUser');
        
        
        $params = array();
        $params['socialiteField']       = $socialiteField;
        $params['socialiteUserId']      = $socialiteUser->getId();
        $params['socialiteUserEmail']   = $socialiteUser->getEmail();

       
        $candidateObject                = new Candidate();
        $isCandidate                    = $candidateObject->getSocialliteCandidate($params);
        
        if(!empty($isCandidate))
        {
            $candidateId                   = Arr::get($isCandidate, 'id',0);
            
            if(!empty($candidateId))
            {
                $candidateDocumentObject      = new CandidateDocument();
            
                $documentName                  = config('constants.default_document');
                $documentName                  = reset($documentName);
    
                $candidateResume = $candidateDocumentObject->getDocumentName($candidateId,$documentName);
                if(!empty(Arr::get($candidateResume, 'file')))
                {
                    $resumeCondition = 'nullable';
                }
            }
           
        }
        
        return [
            'candidate_full_name'                     => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'email'                                   => 'required|email:rfc,dns|unique:candidates,email,'.$candidateId.'|max:50',
            'mobile'                                  => 'required|min:11|max:11|unique:candidates,mobile_number,'.$candidateId.'|regex:/^[0-9]+$/',
            'country_code'                            => 'required|in:' . implode(',', array_keys(config('constants.countries'))),
            'area_of_interest_option_id'              => 'required|exists:area_of_interest_options,id',
            'resume'                                  => $resumeCondition.'|mimes:jpeg,jpg,pdf,application/pdf|min:1|max:1024', 
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
            'candidate_full_name.required'                     => 'The Candidate Full Name field is required!',
            'candidate_full_name.max'                          => 'The Candidate Full Name must not be greater than :max characters.',
            'candidate_full_name.regex'                        => 'The Candidate Full Name format is invalid',

            #email
            'email.required'                                   => 'The Email Address is required!',
            'email.email'                                      => 'The Email Address field must be a valid email address!',
            'email.unique'                                     => 'Sorry, This Email Address is already used by another user. Please try with different one, thank you.',
            'email.max'                                        => 'Email Address must not be greater than :max characters.',
            #mobile
            'mobile.required'                                  => 'The Mobile Number field is required!',
            'mobile.max'                                       => 'The Mobile Number must not be greater than :max characters.!',
            'mobile.min'                                       => 'The Mobile Number must not be less than :min characters.!',
            'mobile.regex'                                     => 'The Mobile Number format is invalid.',
            'mobile.unique'                                    => 'The Mobile Number has already been taken.',

            #country_code
            'country_code.required'                            => 'Please select Country!',
            'country_code.in'                                  => 'The selected Country is invalid!',

            #area_of_interest_option_id
            'area_of_interest_option_id.required'              => 'Please select Area of Interest!',
            'area_of_interest_option_id.exists'                => 'The selected Area of Interest is invalid!',


            #resume
            'resume.required'                                 => 'The Attach your resume field is required!',
            'resume.mimes'                                    => 'The Attach File must be a file of type: doc,docx,pdf !',
            'resume.min'                                      => 'The Attach File must be at least 2 kilobytes!',
            'resume.max'                                      => 'The Attach File must not be greater than 1 Mb!',

        ];      
    }    
}
