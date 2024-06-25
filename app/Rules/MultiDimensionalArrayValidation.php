<?php
  
namespace App\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
  
class MultiDimensionalArrayValidation implements Rule
{
    
    public function __construct($constantArray=array())
    {
        $this->constantArray = $constantArray;
    }
    
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    private $error = '';
    public function passes($attribute, $postValues)
    {
        $attribute = ucfirst($attribute);
        $valueNotExist = false;
        
        if(!empty($postValues)) 
        {
            foreach($postValues as $postValue)
            {
                if(!array_key_exists($postValue, $this->constantArray))
                {
                    $valueNotExist = true;
                    $this->error = 'The :attribute is Invalid!.';
                    break;
                }
            }
        }


        if(!$valueNotExist){
            return true;
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