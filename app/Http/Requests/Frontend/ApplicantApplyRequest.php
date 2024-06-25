<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\CheckCandidateAlreadyJobApplied;
use App\Models\CandidateDocument;
use App\Models\CandidateEducation;

class ApplicantApplyRequest extends FormRequest
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
        $candidateDocumentObject = new CandidateDocument();

        $candidateId  = Auth::guard('candidate')->user()->id;
        $jobId        = $this->request->get('job_id');

        $documentName                           = config('constants.default_document');
        $documentName                           = reset($documentName);

        $resumeUploaded = $candidateDocumentObject->getDocumentName($candidateId,$documentName);

        if($resumeUploaded){
            $resumeCondition = 'nullable';
        }else{
            $resumeCondition = 'required|mimes:doc,docx,pdf,application/pdf|min:2|max:1024';
        }

        $candidateEducationObject       = new CandidateEducation;
        $candidateEducation             = $candidateEducationObject->educationCountByCandidateId($candidateId);
        if(!empty($candidateEducation)){
            $educationCondition = 'nullable';
            $fieldOfStudyCondition = 'nullable';
        }else{
            $educationCondition = 'required|in:' . implode(',', array_keys(config('constants.level_of_educations')));
            $fieldOfStudyCondition = 'required|max:100';
        }
        
        return [
            //'job_id'                                   => 'required|exists:jobs,id|unique:applicants,job_id,'.$jobId.',id,candidate_id,'.$candidateId,
            'job_id'                                     => ['required','exists:jobs,id',new CheckCandidateAlreadyJobApplied()],
            'full_name'                                  => 'required|max:50',
            'gender'                                     => 'required',
            'email'                                      => 'required|email:rfc,dns|max:50',
            'phone'                                      => 'required|min:11|max:11|regex:/^[0-9]+$/',
            'total_experience'                           => 'required|max:2|lte:40|regex:/^[0-9]+$/',
            'level_of_educations'                        => $educationCondition,
            'resume'                                     => $resumeCondition,       
            'city'                                       => 'required|in:' . implode(',', array_keys(config('constants.cities'))),   
            'field_of_study'                             => $fieldOfStudyCondition,

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

            'job_id.required'                                   => 'The Job is invalid!',
            'job_id.exists'                                     => 'The Job is invalid!',
            #'job_id.unique'                                   => 'Already Applied For This Job!!',
            
            #first_name
            'full_name.required'                                => 'The Full Name field is required!',
            'full_name.max'                                     => 'The Full Name must not be greater than :max characters.!',

            #Email Address
            'email.required'                                    => 'The Email Address is required!',
            'email.email'                                       => 'The Email Address field must be a valid email address!',
            'email.max'                                         => 'Email Address must not be greater than :max characters.',
            
            #phone
            'phone.required'                                    => 'The Phone Number field is required!',
            'phone.max'                                         => 'The Phone Number must not be greater than :max characters.!',
            'phone.min'                                         => 'The Phone Number must not be less than :min characters.!',
            'phone.regex'                                       => 'The Phone Number format is invalid.',

            #total_experience
            'total_experience.required'                         => 'The Total Experience field is required!',
            'total_experience.max'                              => 'The Total Experience must not be greater than :max characters.!',
            'total_experience.regex'                            => 'The Total Experience format is invalid.',
            'total_experience.lte'                              => 'The Total Experience must be less than or equal to :value .',

            #resume
            'resume.required'                                   => 'The Attach your resume field is required!',
            'resume.mimes'                                      => 'The Attach File must be a file of type: doc,docx,pdf !',
            'resume.min'                                        => 'The Attach File must be at least 2 kilobytes!',
            'resume.max'                                        => 'The Attach File must not be greater than 1 Mb!',

            #gender
            'gender.required'                                   => 'The Gender is required.',


            #qualification
            'level_of_education.required'                       => 'The Level of Education field is required!', 
            'level_of_education.in'                             => 'The selected Level of Education is invalid!',


            #city
            'city.required'                                     => 'The City field is required',
            'city.in'                                           => 'The City is not valid!',


            #fieldofstudy
            'field_of_study.required'                           => 'The Field of Study field is required!',
            'field_of_study.max'                                => 'The Field of Study must not be greater than :max characters.!',

        ];
    }        
}
