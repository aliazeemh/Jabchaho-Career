<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    #excetion response
    public function getCustomExceptionMessage($exception='')
    {
        
        \Log::info($exception);
        //return '******Whoops, looks like something went wrong*****';
        return view('frontend.includes.exceptions.500');
	}

    #Remove image
    public function removeFile($fileNameWithPath='')
    {

        try{

            if(\File::exists($fileNameWithPath)){
                \File::delete($fileNameWithPath);
            }

            return true;

        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }	
    }

    #profile flag save on the basis of form submit in candidate table i.e [is_experience_saved,is_education_saved ...] 
    function updateProfileFlag($params=array()){
 

        $fieldName              = Arr::get($params, 'fieldName');
        $fieldValue             = Arr::get($params, 'fieldValue',0);
        $paramCandidateId       = Arr::get($params, 'candidateId',0);

        if(!empty($fieldName) && isset($fieldValue))
        {
            if(!empty($paramCandidateId))
            {
                $candidateId            = $paramCandidateId; 
            }
            else
            {
                $candidateId            = Auth::guard('candidate')->user()->id; 
            }
             

            $flagForUpdate          = [$fieldName =>$fieldValue ]; 
            $candidate              = Candidate::where(['id' => $candidateId])->update($flagForUpdate);

            if($candidate)
            {
                return true;
            }
        }
    
    
        return false;
    }

}
