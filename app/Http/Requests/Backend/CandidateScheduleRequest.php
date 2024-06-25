<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CandidateScheduleRequest extends FormRequest
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
            'schedule_time'               => 'required|date_format:d-m-Y H:i|after_or_equal:' . date(DATE_ATOM),
            'schedule_status_id'          => 'required|exists:candidate_schedule_statuses,id'  
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
            'schedule_time.required'         => 'The Schedule Time field is required!',
            'schedule_time.date_format'      => 'The Schedule Time format is invalid!',
            'schedule_time.after_or_equal'   => 'The Schedule Time must be a date after or equal to Now',
            'schedule_status_id.required'    => 'The Schedule Status field is required!',
            'schedule_status_id.exists'      => 'The Schedule Status field is Invalid!',
        ];
    }
}
