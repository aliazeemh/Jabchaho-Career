<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant; 
use App\Models\Job; 

class CheckCandidateAlreadyJobApplied implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    
    public function __construct()
    {
       //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    private $error = '';
    public function passes($attribute, $value)
    {
        $candidateId  = Auth::guard('candidate')->user()->id;
        $jobId        = (int) request()->get('job_id');

        $jobObject = new Job();
        
        $jobDetail                       = $jobObject->getValidJobDetail($jobId);

        if(!empty($jobDetail))
        {
            if(!empty($jobId))
            {            
                $applicantObject = new Applicant();
                $result = $applicantObject->isCandidateAlreadyJobApplied($candidateId,$jobId);
            
                #result empty mean number is unique
                if(empty($result)){
                    return true;
                }else{
                    $this->error = 'Already Applied For This Job!!';
                }  
                
            }else{
                $this->error = 'Invalid request!';
            }
        }else{
            $this->error = '!!!Job expired!!!';
        }
        

        


        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->error;
    }
}
