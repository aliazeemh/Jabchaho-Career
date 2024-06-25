<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UploadDocumentNameValidation implements Rule
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

        $selectedDocument               = Arr::get($postData, 'selected');

        $defaultDocument                = config('constants.default_document'); //resume" ,"bank_statement","nic"
        
        if(!in_array($selectedDocument,$defaultDocument)){

            $requiredDocumentsTableWise      = config('constants.required_document'); 
            
            $explodedDocumentName   =  explode('-',$selectedDocument);

            $documentKey            = Arr::get($explodedDocumentName,0,''); //salary_slip
            $tableActionId          = Arr::get($explodedDocumentName,1,0); //1
            $tableName              = Arr::get($explodedDocumentName,2,''); //candidate_experiences
            $index                  = Arr::get($explodedDocumentName,3,'');


           $requiredDocumentTableWiseKey =  array_keys($requiredDocumentsTableWise);
         
   
            //Check table name is validate
            if (!in_array($tableName,$requiredDocumentTableWiseKey)){
                $this->error = ' !! Invalid request !!';
            }else{

                // validate index on the basis of table
                if($tableName == config('constants.candidate_documents_tables.candidate_educations')){ //candidate_documents_tables
                    if(!array_key_exists($index,config('constants.level_of_educations')))
                    {
                      $index = -1;
                    }
                }
                
                //check documentKey is valid
                $requiredDocumentSingleTableWise = array();
                if(!empty($requiredDocumentsTableWise[$tableName])){
                    if(!empty($requiredDocumentsTableWise[$tableName][$index])){
                        $requiredDocumentSingleTableWise = $requiredDocumentsTableWise[$tableName][$index]; 
                    }
                }

                if (!array_key_exists($documentKey,$requiredDocumentSingleTableWise)){
                    $this->error = ' !! Invalid request !!';
                }else{

                    $candidateId                    = Auth::guard('candidate')->user()->id;
                    //check action id
                    $isexists = \DB::table($tableName)->where(['candidate_id'=> $candidateId, 'id' => $tableActionId])->get()->count();
                    if(!$isexists){
                        $this->error = ' !! Invalid request !!';
                    }else{
                        return true;
                    }
                }

            }
           
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
    }
}
