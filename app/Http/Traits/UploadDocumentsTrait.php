<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Models\CandidateDocument;
use App\Models\CandidateExperience;
use App\Models\CandidateEducation;
use App\Models\Candidate;
use App\Models\CandidatePortfolio;
use App\Models\CandidatePortfolioAttachment;
use Illuminate\Support\Arr;
use Intervention\Image\Facades\Image as Image;

trait UploadDocumentsTrait {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function candidateResumeAndDocumentsUpload($candidateId=0,$file='',$documentName='') 
    {
        $savedFilePath  = array();
        $allFilesData   = array();
        
        if(!empty($file))
        {
            $uploadFolderPath       = config('constants.files.douments'); //CHANGE
            $filetypesIconPath      = config('constants.files.filetypes');
            $fileExtensionForIcon   = config('constants.file_extension_for_icon');
            $fileExtensionForResize = config('constants.file_extension_for_resize');
            $filePath               = public_path($uploadFolderPath);
            
            //get table name and table action id from document name
            $tableName = '';
            $tableActionId =0;
            if(!empty($documentName)){

                $explodedDocumentName   =  explode('-',$documentName);
                $tableActionId          = Arr::get($explodedDocumentName,1,0);
                $tableName              = Arr::get($explodedDocumentName,2,'');
            }

            $candidateAttachment = array(); 
            //insert document
            $candidateAttachments = array(
                                'candidate_id'      => $candidateId,
                                'table_name'        => $tableName,
                                'table_action_id'   => $tableActionId,
                                'document_name'     => $documentName,
                                'original_file'     => $file->getClientOriginalName(),
                                'file'              => ''
            );

            $candidateDocument = CandidateDocument::create($candidateAttachments);
                
            if(!empty($candidateDocument))
            {

                $id = Arr::get($candidateDocument,'id');
                $url = route('document.delete',$id);

                //$fileExtension = strtolower($file->getClientOriginalExtension());
                $fileExtension = strtolower($file->guessExtension()?$file->guessExtension():$file->getClientOriginalExtension());
                $newName = rand().'-'.time().'-'.$candidateId.'-'.$id.'.' .$fileExtension; 
                $file->move(public_path($uploadFolderPath), $newName);

                    
                $savedFilePath['id']        = $id;
                $savedFilePath['url']       = $url;
                $savedFilePath['file_path'] = asset($uploadFolderPath.$newName);
                if(in_array($fileExtension,$fileExtensionForIcon))
                {
                    $savedFilePath['diaplay_image_path'] = asset($filetypesIconPath).'/'.$fileExtension.'.png';

                }else{
                    
                    if(in_array($fileExtension,$fileExtensionForResize))
                    {
                        Image::make(public_path($uploadFolderPath).'/'.$newName)->resize(84, 84)->save(public_path($uploadFolderPath.'thumbnail/' . $newName));
                        $savedFilePath['diaplay_image_path'] = asset($uploadFolderPath.'thumbnail/' . $newName);
                    }
                    else
                    {
                        $savedFilePath['diaplay_image_path'] = asset($filetypesIconPath).'/file.png';
                    }
                    
                
                }

                CandidateDocument::where(['candidate_id'=> $candidateId, 'id' => $id])->update(['file'=>$newName]);
            }

        }

        return $savedFilePath;
    }
    
    #get saved documents with default and dynamic array.
    function getSavedDocuments($candidateId=0){
    
    
        $candidateDocumentObject    = new CandidateDocument();
        $candidateDocuments  =  $candidateDocumentObject->getCandidateAttachmentsByCandidateId($candidateId);
        
        $result                 = array();
        $defaultDocumentArray   = array();
        $dynamicDocumentsArray  = array();

        //
        if(!empty($candidateDocuments))
        {
            $defaultDocument                = config('constants.default_document'); //resume" ,"bank_statement","nic"
            
            foreach($candidateDocuments as $row){

                $documentName                = Arr::get($row,'document_name');
                $tableName                   = Arr::get($row,'table_name');
                $tableActionId               = Arr::get($row,'table_action_id');

                if(in_array($documentName,$defaultDocument)){
                    $defaultDocumentArray[$documentName] = $row;
                }
                else{
                    $dynamicDocumentsArray[$tableName][$documentName] = $row;
                }
            }

            
        }

        $result  =['defaultDocumentArray' => $defaultDocumentArray, 'dynamicDocumentsArray' =>$dynamicDocumentsArray];

        return $result;
    }
    function getProfessionalExperienceDocuments($candidateId=0){
            
        $candidateExperienceRequiredDocments = array();

        //check Professional Experience is saved
        $candidateData = Candidate::where(['id' => $candidateId])->first()->toArray();
        
        $isExperienceSaved = ''; 
        if(!empty($candidateData))
        {
            $isExperienceSaved = $candidateData['is_experience_saved'];
        }

        if(!empty($isExperienceSaved))
        {

            $candidateExperienceObject    = new CandidateExperience();
            $fields = ['id','company_name'];
            $candidateExperiences = $candidateExperienceObject->getCandidateExperiencesByCandidateId($candidateId,$fields);
           
            if(!empty($candidateExperiences)){

                # professional Experience Documents define in a constant 
                $professionalExperienceDocuments   = config('constants.required_document.candidate_experiences'); 
                //get first index
                 $professionalExperienceDocuments   = reset($professionalExperienceDocuments);

                foreach($candidateExperiences as $row){

                    $professionalExperienceId       = Arr::get($row,'id',0);
                    $companyName                    = Arr::get($row,'company_name');
                    
                    if (strlen($companyName) > 30)
                            $companyName = substr($companyName, 0, 30) . '...';
                    
                    #make key=>value docuemnts
                    if(!empty($professionalExperienceDocuments)){

                        foreach($professionalExperienceDocuments as $key => $value){
                            $candidateExperienceRequiredDocments[$key.'-'.$professionalExperienceId.'-candidate_experiences-1'] = $companyName.' - '.$value;
                        }    

                    }
                    
                }
            }

        }

        return $candidateExperienceRequiredDocments;

    }


    function getEducationalQualificationDocuments($candidateId=0){
        $candidateEducationalQualificationDocments = array();

        //check Professional Experience is saved
        $candidateData = Candidate::where(['id' => $candidateId])->first()->toArray();
        
        $isEducationSaved = ''; 
        if(!empty($candidateData))
        {
            $isEducationSaved = $candidateData['is_education_saved'];
        }
        
        if(!empty($isEducationSaved)){

            $candidateEducationObject    = new CandidateEducation();
            $fields = ['id','institute_name','level_of_education'];
            $candidateEducation =  $candidateEducationObject->getCandidateEducationsByCandidateId($candidateId,$fields);
           
            if(!empty($candidateEducation)){

                 # Candidate Educations Documents define in a constant 
                 $candidateEducationsDocuments   = config('constants.required_document.candidate_educations'); 
                 
                foreach($candidateEducation as $educationRow){

                    $educationId                    = Arr::get($educationRow,'id',0);
                    $instituteName                  = Arr::get($educationRow,'institute_name');
                    $levelOfEducation               = Arr::get($educationRow,'level_of_education');
                    

                    if (strlen($instituteName) > 30)
                            $instituteName = substr($instituteName, 0, 30) . '...';

                    #make key=>value docuemnts
                    if(!empty($candidateEducationsDocuments[$levelOfEducation])){

                        
                        foreach($candidateEducationsDocuments[$levelOfEducation] as $educationKey => $educationValue){
                            $candidateEducationalQualificationDocments[$educationKey.'-'.$educationId.'-candidate_educations-'.$levelOfEducation] = $instituteName.' - '.$educationValue;
                        }    

                    }


                }

            }

        }

        return $candidateEducationalQualificationDocments;

    }
    public function removeCandidateDocumentByIds($candidateId=0,$id=0)
    {
        $uploadFolderPath       = config('constants.files.douments');
        $filePath               = public_path($uploadFolderPath);
        $deleted                = false;
        
        $fileName = ''; $deleted = 0;
        $candidateDocument = CandidateDocument::where(['candidate_id'=> $candidateId, 'id' => $id])->first();
        if(!empty($candidateDocument)){
            $fileName = Arr::get($candidateDocument,'file');

           $deleted = $candidateDocument->delete();
        }
        
        if($deleted){

            $fileNameWithPath = $filePath.'/'.$fileName;
            $this->removeFile($fileNameWithPath);

            $thumbnailWithPath = $filePath.'/thumbnail/'.$fileName;
            $this->removeFile($thumbnailWithPath);

            $candidateDocumentCount =$candidateDocument->where(['candidate_id'=> $candidateId])->count();
            if($candidateDocumentCount ==0){
                
                $params = array('fieldName' => 'is_upload_document_saved', 'fieldValue'=>0,'candidateId'=>$candidateId);
                $this->updateProfileFlag($params);
            }
        }
        return $deleted;

    
    } 
    public function removeCandidatePortfoliosByIds($candidateId=0,$id=0)
    {

        $uploadFolderPath       = config('constants.files.portfolio');
        $filePath               = public_path($uploadFolderPath);
        $deleted                = false;
        
        $fileName = ''; $deleted = 0;
        $candidatePortfolioAttachment = CandidatePortfolioAttachment::where(['candidate_id'=> $candidateId, 'id' => $id])->first();
        if(!empty($candidatePortfolioAttachment)){
            $fileName = Arr::get($candidatePortfolioAttachment,'file');

           $deleted = $candidatePortfolioAttachment->delete();
        }

        if($deleted)
        {

            $fileNameWithPath = $filePath.'/'.$fileName;
            $this->removeFile($fileNameWithPath);

            $thumbnailWithPath = $filePath.'/thumbnail/'.$fileName;
            $this->removeFile($thumbnailWithPath);

            $candidatePortfolioAttachmentCount =$candidatePortfolioAttachment->count();
            $candidatePortfolioCount =CandidatePortfolio::where(['candidate_id'=> $candidateId])->count();
            if($candidatePortfolioAttachmentCount ==0 && $candidatePortfolioCount ==0){
                
                $params = array('fieldName' => 'is_portfolio_saved', 'fieldValue'=>0,'candidateId'=>$candidateId);
                $this->updateProfileFlag($params);
            }
        }

        return $deleted;
    }


}       