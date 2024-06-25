<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\FromAndToDateValidate;
use Illuminate\Support\Facades\Auth;

class CandidateEducationalQualificationRequest extends FormRequest
{
    
   public $last;
   public $now;

   
   public function __construct()
    {
       $this->last =  date('Y')-120; 
       $this->now= date('Y');              
    }
    
    
    
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
        
        $levelOfEducation   = $this->request->get('level_of_education');
        $percentage         = $this->request->get('percentage');
        $gpa                = $this->request->get('gpa');
        
        
        $gpaValidationConditionRule = "nullable|max:4|min:1|numeric|regex:/^\d+(\.\d{1,2})?$/";

        if(in_array($levelOfEducation,array(2,5)) &&  empty($this->request->get('is_in_progress'))  && empty($percentage) && empty($gpa) )
        {
            $gpaValidationConditionRule.= '|required';
        }
        
        if(in_array($levelOfEducation,array(3,7)) &&  empty($this->request->get('is_in_progress')) ){
            
            $gpaValidationConditionRule.= '|required';
        }

        #percentage
        $percentageValidationConditionRule = "nullable|max:100|min:1|numeric|regex:/^\d+(\.\d{1,3})?$/";

        if(in_array($levelOfEducation,array(2,5)) &&  empty($this->request->get('is_in_progress'))  && empty($percentage) && empty($gpa) )
        {
            $percentageValidationConditionRule.= '|required';
        }
        
        if(in_array($levelOfEducation,array(3,4,6,7)) &&  empty($this->request->get('is_in_progress')) ){

            $percentageValidationConditionRule.= '|required';
        }

        return [
            'id'                                   => 'nullable|exists:candidate_educations,id,candidate_id,'.$candidateId,
            'institute_name'                       => 'required|max:100',
            'level_of_education'                   => 'required|in:' . implode(',', array_keys(config('constants.level_of_educations'))),
            'board'                                => 'required_if:level_of_education,4,6|nullable|in:' . implode(',', array_keys(config('constants.boards'))),
            'field_of_study'                       => 'required|max:100', 
            'majors'                               => 'required',//|max:100
            'from_months'                          => 'required|in:' . implode(',', array_keys(config('constants.months'))), 
            //'from_year'                          => 'required|digits:4|integer|min:'.$this->last.'|max:'.$this->now,  
            'from_year'                            =>  ['required','digits:4','integer','min:'.$this->last,'max:'.$this->now, new FromAndToDateValidate],
            'to_months'                            => 'required_without:is_in_progress|nullable|in:' .implode(',', array_keys(config('constants.months'))),
            'to_year'                              => 'required_without:is_in_progress|nullable|digits:4|integer|min:'.$this->last.'|max:'.$this->now,
            'percentage'                           =>  $percentageValidationConditionRule,//'required_without:is_in_progress|max:5|integer', 
            'gpa'                                  =>  $gpaValidationConditionRule,  //'required_if:level_of_education,2,3,5,7| TODO
            'grade'                                => 'nullable|in:' . implode(',', config('constants.grades')), 
            'position'                             => 'required|in:' . implode(',', array_keys(config('constants.boolean_options'))),
            'scholarships'                         => 'required|in:' . implode(',', array_keys(config('constants.boolean_options'))),
           
             //option but valid
            'final_result'                         => 'nullable|boolean',
            'drop_out'                             => 'nullable|boolean',
            'is_in_progress'                       => 'nullable|boolean',
            'level_grade_a'                        => 'nullable|in:' . implode(',', config('constants.o_a_level_grades')),
            'level_grade_b'                        => 'nullable|in:' . implode(',', config('constants.o_a_level_grades')),
            'level_grade_c'                        => 'nullable|in:' . implode(',', config('constants.o_a_level_grades')),
            
            'extra_curricular_activities'          => 'nullable|max:65000',

            'form_submit'                          => 'nullable', 
                             
        ];
    }


     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        $levelOfEducation   = $this->request->get('level_of_education');
        $percentage         = $this->request->get('percentage');
        $gpa                = $this->request->get('gpa');
        
        $gpaRequiredMessage = 'The CGPA field is required!';
        if(in_array($levelOfEducation,array(2,5)) &&  empty($this->request->get('is_in_progress'))  && empty($percentage) && empty($gpa) )
        {
            $gpaRequiredMessage =config('constants.cgpa_percentage_error');
        }
        
        
        $percentageRequiredMessage = 'The Percentage field is required!';
        if(in_array($levelOfEducation,array(2,5)) &&  empty($this->request->get('is_in_progress'))  && empty($percentage) && empty($gpa) )
        {
            $percentageRequiredMessage = config('constants.cgpa_percentage_error');
        }
        
        
        return [
            'id.exists'                                 => 'The Educational Qualification is invalid!',
            'institute_name.required'                     => 'The Institute Name field is required!',
            'institute_name.max'                          => 'The Institute Name must not be greater than :max characters.!',

            'level_of_education.required'                 => 'The Level of Education field is required!', 
            'level_of_education.in'                       => 'The selected Level of Education is invalid!',

            'board.required_if'                           => 'The Board Name field is required!',
            'board.in'                                    => 'The selected Board Name is invalid!',
            
            'field_of_study.required'                     => 'The Field of Study field is required!',
            'field_of_study.max'                          => 'The Field of Study must not be greater than :max characters.!',

            'majors.required'                             => 'The Majors field is required!',
            //'majors.max'                                  => 'The Majors must not be greater than :max characters.!',

            'from_months.required'                      => 'The Duration From Month field is required!',
            'from_months.in'                            => 'The selected Duration From Month is invalid!',

            'from_year.required'                        => 'The Duration From Year field is required!',
            'from_year.digits'                          => 'The Duration From Year  must be 4 digits!',
            'from_year.integer'                         => 'The Duration From Year must be an integer!',
            'from_year.min'                             => 'The Duration From Year must be greater than or equal to '.$this->last.'!',
            'from_year.max'                             => 'The Duration From Year must be less than or equal to '.$this->now.'!',
            
            'to_months.required_without'                => 'The Duration To Month field is required!',
            'to_months.in'                              => 'The selected Duration To Month is invalid!',

            'to_year.required_without'                  => 'The Duration To Year field is required!',
            'to_year.digits'                            => 'The Duration To Year  must be 4 digits!',
            'to_year.integer'                           => 'The Duration To Year must be an integer!',
            'to_year.min'                               => 'The Duration To Year must be greater than or equal to '.$this->last.'!',
            'to_year.max'                               => 'The Duration To Year must be less than or equal to '.$this->now.'!',

            'percentage.required'                       => $percentageRequiredMessage,
            'percentage.max'                            => 'The Percentage must not be greater than :max !',
            'percentage.min'                            => 'The Percentage must be greater than :min!',
            'percentage.numeric'                        => 'The Percentage must be numeric!',
            'percentage.regex'                          => 'The Percentage format is invalid!',

            'grade.in'                                  => 'The Grade is invalid!',

            'position.required'                         => 'The Position Achieve field is required!',
            'position.in'                               => 'The Position Achieve field is invalid!',

            'scholarships.required'                     => 'The Scholarships Received field is required!',
            'scholarships.in'                           => 'The Scholarships Received field is invalid!',

            'extra_curricular_activities.max'          => 'The Extra Curricular Activities must not be greater than :max characters.!',
            
            'gpa.required'                             => $gpaRequiredMessage,
            'gpa.max'                                  => 'The CGPA must not be greater than :max .!',
            'gpa.numeric'                              => 'The CGPA must be numeric!',
            'gpa.min'                                  => 'The CGPA must be greater than :min!',
            'gpa.regex'                                => 'The CGPA format is invalid!',



            'final_result.boolean'                     => 'The Final Result/Transcript Awaited is invalid!!',
            'drop_out.boolean'                         => 'The Drop Out is invalid!',
            'is_in_progress.boolean'                   => 'The In progress is invalid!',
            'level_grade_a.in'                         => 'The Select Grades A is invalid!',
            'level_grade_b.in'                         => 'The Select Grades B is invalid!',
            'level_grade_c.in'                         => 'The Select Grades C is invalid!',

        ];    
    }     
}
