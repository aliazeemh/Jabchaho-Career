<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class JobTypeRequest extends FormRequest
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
            'name'                  => 'required|max:100|unique:job_types,name,'.$id,
            'is_enabled'            => 'required|in:' . implode(',', array_keys(config('constants.boolean_options'))), 
            'is_checked'            => 'required|in:' . implode(',', array_keys(config('constants.boolean_options'))), 
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
            
            'name.required'                    => 'The Name field is required!',
            'name.max'                         => 'The Name must not be greater than :max characters.!',
            'name.unique'                      => 'The Name has already been taken.',

            'is_enabled.required'              => 'Please select Enable Option?',
            'is_enabled.in'                    => 'Invalid Enable Option? !',

            'is_checked.required'              => 'Please select Default Checked?',
            'is_checked.in'                    => 'Invalid Default Checked? !',


        ];
    }
}
