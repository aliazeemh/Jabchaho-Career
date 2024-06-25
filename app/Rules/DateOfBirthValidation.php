<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class DateOfBirthValidation implements Rule
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
        $postData = request()->all();

        $day                = (int)  Arr::get($postData, 'day');
        $month              = (int)  Arr::get($postData, 'month');
        $year               = (int)  Arr::get($postData, 'year');
       
        if (!checkdate($month, $day, $year)) {
            $this->error = 'Please select valid Date of Birth!';
        }
        else{
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
