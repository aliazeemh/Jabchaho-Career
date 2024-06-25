<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class SkillSetRequest extends FormRequest
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

        return [
            'name'                   => 'required|max:100|unique:skill_sets,name,'.$id,
            'description'           => 'required|max:65000', 
            'is_viewable'            => 'required|in:' . implode(',', array_keys(config('constants.boolean_options'))), 
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
            
            'name.required'                     => 'The Name field is required!',
            'name.max'                          => 'The Name must not be greater than :max characters.!',

            'description.required'              => 'The Description field is required!',
            'description.max'                   => 'The Description must not be greater than :max characters.!',

            'is_viewable.required'              => 'Please select View on search Option?',
            'is_viewable.in'                    => 'Invalid View on search Option?',
        ];
    }
}
