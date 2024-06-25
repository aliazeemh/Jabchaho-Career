<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
     #remove Document
     function removeCandidateDocument($candidateDocumentData='')
     {
         if(is_object($candidateDocumentData) && count($candidateDocumentData)>0)
         {
             $uploadFolderPath       = config('constants.files.douments');
             $filePath               = public_path($uploadFolderPath);
             foreach($candidateDocumentData as $row){
                 
                 $fileName = Arr::get($row,'file');
 
                 $fileNameWithPath = $filePath.'/'.$fileName;
                 $this->removeFile($fileNameWithPath);
 
                 $thumbnailWithPath = $filePath.'/thumbnail/'.$fileName;
                 $this->removeFile($thumbnailWithPath);
             }
         }
 
         return true;
     }



    



}
