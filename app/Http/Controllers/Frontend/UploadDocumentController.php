<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CandidateDocument;
use App\Models\CandidateExperience;
use App\Models\CandidateEducation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use App\Http\Traits\UploadDocumentsTrait;

class UploadDocumentController extends ProfileController
{
    use UploadDocumentsTrait; 
    
    #uploadDocumentsForm
    public function uploadDocumentsForm()
    {
        $data                                               = array();
        
        $candidateId                                        = Auth::guard('candidate')->user()->id;
        $candidateSavedDocuments                            = $this->getSavedDocuments($candidateId);
        $candidateExperienceRequiredDocments                = $this->getProfessionalExperienceDocuments($candidateId);
        $candidateEducationalQualificationDocments          = $this->getEducationalQualificationDocuments($candidateId);
        
        $data['defaultDocumentArray']                       = Arr::get($candidateSavedDocuments,'defaultDocumentArray');;
        $data['dynamicDocumentsArray']                      = Arr::get($candidateSavedDocuments,'dynamicDocumentsArray');;
        $data['candidateExperienceRequiredDocments']        = $candidateExperienceRequiredDocments;
        $data['candidateEducationalQualificationDocments']  = $candidateEducationalQualificationDocments;

        return view('frontend.candidates.profile.upload-document')->with($data);
    }

    //get dynamic file fields for  Professional Experience Documents
       

    #is_upload_document_saved mark saved =1
    public function uploadDocumentsMarkSaved()
    {
        $candidateId            = Auth::guard('candidate')->user()->id;  

        if(!empty($candidateId))
        {
             // if is_portfolio_saved zero 
            $params = array('fieldName' => 'is_upload_document_saved', 'fieldValue'=>1);////CHANGE
            $this->updateProfileFlag($params);
        }

        return redirect()->route('portfolio.show')
            ->withSuccess(__('Upload Documents Saved successfully.'));
       
    }
}
