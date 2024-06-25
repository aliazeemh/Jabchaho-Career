<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Rules\DateOfBirthValidation;

class CandidateFamilyDetailsRequest extends FormRequest
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
        
        return [
            'id'                                   => 'nullable|exists:candidate_family_details,id,candidate_id,'.$candidateId,
            'relation_id'                          => 'required|in:' . implode(',', array_keys(config('constants.religion'))), 
            'name'                                 => 'required|max:100',
            'emergency_contact'                    => 'required|in:' . implode(',', array_keys(config('constants.boolean_options'))),
            'contact_no'                           => 'nullable|required_if:emergency_contact,1|min:11|max:11|regex:/^[0-9]+$/',
            'month'                                => 'required|in:' . implode(',', array_keys(config('constants.months'))), 
            'day'                                  => ['required','between:1,31','integer'],
            'year'                                 => ['required','digits:4','integer','min:'.$this->last,'max:'.$this->now,new DateOfBirthValidation()],
            'picture'                              => 'nullable|image|mimes:jpg,png,jpeg,gif|min:2|max:1024',
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
        return [
            //id
            'id.exists'                                 => 'The Family Details is invalid!',

            //Relation
            'relation_id.required'                      => 'The Relation field is required!',
            'relation_id.in'                            => 'The Relation is not valid!',

            //name
            'name.required'                             => 'The Name field is required!',
            'name.max'                                  => 'The Name must not be greater than :max characters.!',

            //emergency_contact
            'emergency_contact.required'                 => 'The Emergency Contact field is required!',
            'emergency_contact.in'                       => 'The Emergency Contact field is invalid!',

            //contact_no
            'contact_no.required_if'                    => 'The Contact No field is required!',
            'contact_no.max'                            => 'The Contact No must not be greater than :max characters.!',
            'contact_no.max'                            => 'The Contact No must not be greater than :max characters.!',
            'contact_no.min'                            => 'The Contact No must not be less than :min characters.!',
            'contact_no.regex'                          => 'The Contact No format is invalid.',

            //Date of Birth
            'day.required'                              => 'The Day field is required!',
            'day.between'                               => 'The Day must be between 1 and 31.',
            'day.integer'                               => 'The Day must be an integer.',

            'month.required'                            => 'The Month field is required!',
            'month.in'                                  => 'The selected Month is invalid!',

            'year.required'                             => 'The Year field is required!',
            'year.digits'                               => 'The Year  must be 4 digits!',
            'year.integer'                              => 'The Year must be an integer!',
            'year.min'                                  => 'The Year must be greater than or equal to '.$this->last.'!',
            'year.max'                                  => 'The Year must be less than or equal to '.$this->now.'!',

            #Picture
            'picture.image'      => 'The Picture must be an image [jpg,png,jpeg,gif,svg]!',
            'picture.mimes'      => 'The Picture must be a file of type: jpg,png,jpeg,gif,svg!',
            'picture.min'        => 'The Picture must be at least 2 kilobytes!',
            'picture.max'        => 'The Picture must not be greater than 1 Mb!',
        ];    
    }        
}
