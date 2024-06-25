<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\CandidateDocument;
use App\Models\CandidatePortfolio;
use App\Models\CandidatePortfolioAttachment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Frontend\CandidateCoverImageRequest;
use App\Http\Requests\Frontend\CandidateProfileImageRequest;
use App\Http\Requests\Frontend\CandidatePortfolioAttachmentRequest;
use App\Http\Requests\Frontend\CandidateUploadDocumentRequest;
use Illuminate\Support\Arr;
use Intervention\Image\Facades\Image as Image;
use App\Http\Traits\UploadDocumentsTrait;

class ManageFileController extends ProfileController
{
    use UploadDocumentsTrait; 
    
    /**
     * Cover Image Upload
     *
     * @param CandidateCoverImageRequest $request
     *
     * @return \Illuminate\Http\Response
     */

    
    public function coverImageUpload(CandidateCoverImageRequest $request){
                
        try
		{
            $validateValues = $request->validated();

            if (!empty($validateValues))
            {
                $candidateId = Auth::guard('candidate')->user()->id;
                $uploadFolderPath = config('constants.files.cover');
                $filePath = public_path($uploadFolderPath);
                $image = $request->file('cover_image');
                $newName = rand().'-'.$candidateId. '.' . $image->getClientOriginalExtension();
                $image->move(public_path($uploadFolderPath), $newName);
                
           
                $fieldName='cover_image';
                $this->updateImage($filePath,$fieldName,$newName);
            
                $image = '<div id="uX1" class="bgSave wallbutton blackButton">Save Cover</div><img src="'.asset($uploadFolderPath.$newName).'" id="timelineBGload" class="headerimage ui-corner-all" style="top:0px"/>';
                return $image; 

                
                

            }
        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }	
    }

     /**
     * cover Image postion update
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */

    public function coverImagePositionUpdate(Request $request){
        $candidateId = Auth::guard('candidate')->user()->id;
        $position = $request->input('position');
        Candidate::where(['id' => $candidateId])->update(['cover_image_position'=>$position]);

        return $position;
    }

    /**
     * profile image upload
     *
     * @param CandidateProfileImageRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function profileImageUpload(CandidateProfileImageRequest $request){

        try
		{
            $validateValues = $request->validated();

            if (!empty($validateValues))
            {
                $candidateId = Auth::guard('candidate')->user()->id;
                $uploadFolderPath = config('constants.files.profile');
                $filePath = public_path($uploadFolderPath);
                $image = $request->file('profile_image');

                $newName = rand().'-'.$candidateId. '.' . $image->getClientOriginalExtension();
                $image->move(public_path($uploadFolderPath), $newName);

                $fieldName='profile_image';
                $this->updateImage($filePath,$fieldName,$newName);

                return asset($uploadFolderPath.$newName); 
                
            }
        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }	
    }   

    /**
     * profileImageRemove
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */

    public function profileImageRemove(Request $request){
        
        try
		{
            $newName = '';
            $uploadFolderPath = config('constants.files.profile');
            $filePath = public_path($uploadFolderPath);
            $fieldName='profile_image';
            $updated = $this->updateImage($filePath,$fieldName,$newName);
            if($updated){
                return true;
            }else{
                return response()->json(['errors' => "Unable to remove Profile image. Please try again!"]);
            }
        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }	
        
    }

    
    /**
     * profileImageRemove
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */

    public function coverImageRemove(Request $request){
        
        try
		{
            $newName = '';
            $uploadFolderPath = config('constants.files.cover');
            $filePath = public_path($uploadFolderPath);
            $fieldName='cover_image';
            $updated = $this->updateImage($filePath,$fieldName,$newName);
            if($updated){
                return true;
            }else{
                return response()->json(['errors' => "Unable to remove Cover image. Please try again!"]);
            }
        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }	
        
    }


    /**
     * Image update 
     *
     * @param filePath $fieldName $fieldValue
     *
     * @return \Illuminate\Http\Response
     */
    public function updateImage($filePath='', $fieldName='',$fieldValue=''){
        try{
            #remove old image
            $candidateId = Auth::guard('candidate')->user()->id;
            $candidateData = Candidate::where('id', $candidateId)->first();
            $image = Arr::get($candidateData, $fieldName);
            $fileNameWithPath = $filePath.'/'.$image;
            $this->removeFile($fileNameWithPath);

            #update new file name
            $updated = $candidateData->update([$fieldName=>$fieldValue]);
            return $updated;

        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }	
    }
    


    /**
     * Portfolio Files upload 
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function portfolioAttachmentsUpload(CandidatePortfolioAttachmentRequest $request){

        try
		{
            $validateValues = $request->validated();

            if (!empty($validateValues))
            {
                $savedFilePath = array();
                $allFilesData = array();
                $candidateId = Auth::guard('candidate')->user()->id;
                $uploadFolderPath = config('constants.files.portfolio'); //CHANGE
                $filetypesIconPath = config('constants.files.filetypes');
                $fileExtensionForIcon = config('constants.file_extension_for_icon');
                $fileExtensionForResize = config('constants.file_extension_for_resize');
                $filePath = public_path($uploadFolderPath);
                //$portfolio = $request->file('portfolio');

                $files = Arr::get($validateValues,'attachment');
                $candidateAttachment = array(); 
                if(!empty($files))
                {
                    foreach ($files as $file) 
                    {
                        //insert document
                        $candidateAttachments = array(
                                            'candidate_id'      => $candidateId,
                                            'original_file'     => $file->getClientOriginalName(),
                                            'file'              => ''
                        );

                        $candidatePortfolioAttachment = CandidatePortfolioAttachment::create($candidateAttachments);
                         
                        if(!empty($candidatePortfolioAttachment)){

                            $id = Arr::get($candidatePortfolioAttachment,'id');
                            $url = route('attachment.delete',$id);

                            //$fileExtension = strtolower($file->getClientOriginalExtension());
                            $fileExtension = strtolower($file->guessExtension()?$file->guessExtension():$file->getClientOriginalExtension());
                            $newName = rand().'-'.time().'-'.$candidateId.'-'.$id.'.' .$fileExtension; 
                            $file->move(public_path($uploadFolderPath), $newName);

                                
                            $savedFilePath['id'] = $id;
                            $savedFilePath['url'] = $url;
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

                            CandidatePortfolioAttachment::where(['candidate_id'=> $candidateId, 'id' => $id])->update(['file'=>$newName]);
                        }

                        $allFilesData[] = $savedFilePath;
                    }

                    
                    // if is_portfolio_saved zero 
                    $params = array('fieldName' => 'is_portfolio_saved', 'fieldValue'=>1);////CHANGE
                    $this->updateProfileFlag($params);
                }

                return response()->json($allFilesData);
                
            }else{
                return false;
            }





        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }
    }

    
    /**
     * portfolioAttachmentRemove
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function portfolioAttachmentRemove(Request $request){
        
        try
		{
            $candidateId            = Auth::guard('candidate')->user()->id;
            $id                     = $request->route('id');

            $deleted = $this->removeCandidatePortfoliosByIds($candidateId,$id);
            if($deleted)
            {
                return redirect()->back()->with('success', "Attachment deleted successfully.");
                
            }else
            {
                return redirect()->back()
                ->withErrors(['error' =>"Unable to remove attachment. Please try again!"]);
            }
        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }	
        
    }

    /**
     * upload documents 
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadDocuments(CandidateUploadDocumentRequest $request){
      
        try
		{
            $validateValues = $request->validated();

            if (!empty($validateValues))
            {
                $candidateId = Auth::guard('candidate')->user()->id;
                $file = Arr::get($validateValues,'attachment');
                $documentName = Arr::get($validateValues,'selected');
                
                //Trait method
                $savedFilePath = $this->candidateResumeAndDocumentsUpload($candidateId,$file,$documentName);
                
                if(!empty($file))
                {
                    // if is_portfolio_saved zero 
                    $params = array('fieldName' => 'is_upload_document_saved', 'fieldValue'=>1);////CHANGE
                    $this->updateProfileFlag($params);
                }

                return response()->json($savedFilePath);
                
            }else{
                return false;
            }

        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }
    } 
    
    /**
     * candidateDocumentRemove
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function candidateDocumentRemove(Request $request)
    {
         
        try
		{
            $candidateId            = Auth::guard('candidate')->user()->id;
            $id                     = $request->route('id');
            $deleted = $this->removeCandidateDocumentByIds($candidateId,$id);
            if($deleted)
            {

                return redirect()->back()->with('success', "Uploaded Document deleted successfully.");
            }
            else{
                return redirect()->back()
                ->withErrors(['error' =>"Unable to remove Uploaded Document. Please try again!"]);
        }
 
        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }	
    }


}
