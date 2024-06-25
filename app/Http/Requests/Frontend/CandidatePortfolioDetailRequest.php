<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CandidatePortfolioDetailRequest extends FormRequest
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
        if(!empty($this->request->get('is_portfolio_saved')) && array_key_exists($this->request->get('is_portfolio_saved'),config('constants.boolean_options')))
        {
            return [
                'id'                      => 'nullable|exists:candidate_diplomas,id,candidate_id,'.$candidateId,
                'is_portfolio_saved'      => 'required|in:' . implode(',', array_keys(config('constants.boolean_options'))),
                'title.*'                   => 'nullable|max:200',
                'url.*'                    => 'nullable|url|max:500',
            ];

        }else{
            return [
                'is_portfolio_saved'      => 'required|in:' . implode(',', array_keys(config('constants.boolean_options'))),
            ];
        }
    }



     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
         return [
                # is_portfolio_saved
                'is_portfolio_saved.required'          => 'Please select Do you have a portfolio?',
                'is_portfolio_saved.in'                => 'Invalid Do you have a portfolio? !',
            
                #title
                'title.*.max'               => 'The Title must not be greater than :max characters.!',

                #url
                'url.*.max'                => 'The Url must not be greater than :max characters.!',
                'url.*.url'                => 'The Url must be a valid URL.',
         ];
    }
}
