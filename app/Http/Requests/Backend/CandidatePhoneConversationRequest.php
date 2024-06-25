<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CandidatePhoneConversationRequest extends FormRequest
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
            'conversation'               => 'required|max:4294967200',
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
            
            //review
            'conversation.required'            => 'The Phone Conversation field is required!',
            'conversation.max'                 => 'The Phone Conversation must not be greater than :max characters.!',

        ];
    }

}
