<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
class FromAndToDateValidate implements Rule
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
      
        $fromMonths     = (int) Arr::get($postData, 'from_months');
        $fromYear       = (int) Arr::get($postData, 'from_year');
        $toMonths       = (int) Arr::get($postData, 'to_months');
        $toYear         = (int) Arr::get($postData, 'to_year');
        
        #now
        $now    = Carbon::now()->toDateString();
        $from   = Carbon::createFromFormat('Y-m-d', $fromYear.'-'.$fromMonths.'-1')->toDateString(); // do confirm the date format.
        
        $to = '';
        if(!empty($toMonths) && !empty($toYear)){
            $to     = Carbon::createFromFormat('Y-m-d', $toYear.'-'.$toMonths.'-1')->toDateString(); 
        }
        
       if($from > $now){
            $this->error = ' From date should be less than current date';
       }
       elseif(!empty($to) && $to >$now){
            $this->error = ' To date should be less then current date';
       } 
       elseif(!empty($to) && $from >$to){
        
            $this->error = ' To date should be greater than from date';
       }else{
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
        // return response()->json([
        //     'errors' => $this->error,
        //     'status' => true
        // ]);
    }
}
