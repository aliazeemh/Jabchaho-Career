<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class CandidatePortfolioAttachmentRequest extends FormRequest
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
            'attachment.*'            => 'nullable|mimes:jpeg,jpg,png,gif,bmp,psd,doc,docx,xls,xlsx,zip,rar,ppt,pptx,pdf,mp3|min:2|max:1024', 
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
                     
                #attachment
                'attachment.*.mimes'      => 'The Attach File must be a file of type: jpeg,jpg,png,gif,bmp,psd,doc,docx,xls,xlsx,zip,rar,ppt,pptx,pdf,mp3 !',
                'attachment.*.min'        => 'The Attach File must be at least 2 kilobytes!',
                'attachment.*.max'        => 'The Attach File must not be greater than 1 Mb!',
         ];
    }


    /**
    * Get the error messages for the defined validation rules.*
    * @return array
    */
    protected function failedValidation(Validator $validator)
    { 
        throw new HttpResponseException(response()->json([
        'errors' => $validator->errors()->all(),
        'status' => true
        ]));
    }
}
