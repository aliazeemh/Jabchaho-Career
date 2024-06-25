<?php

namespace App\Rules;
use App\Models\Candidate;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class MobileNumberCustomValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $id;
    public function __construct($id=0)
    {
        $this->id = $id;
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
        $postData = request()->all();
     
        if(!empty($postData))
        {            
            $candidateObject = new Candidate();
            $result =  $candidateObject->isUniqueMobileNumber($postData,$this->id);
        
            #result empty mean number is unique
            if(empty($result)){
                return true;
            }else{
                $this->error = 'Mobile Number is already exist.';
            }  
            
        }else{
            $this->error = 'Invalid request!';
        }

        return false;

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
