<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Frontend\CandidateFamilyDetailsRequest;
use App\Models\CandidateFamilyDetails;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image as Image;

class FamilyDetailController extends ProfileController
{
    public function familyDetailForm(Request $request){


        $candidateFamilyDetailsObject = new CandidateFamilyDetails();

        $candidateFamilyDetailId        = $request->route('id');
        $candidateId  = Auth::guard('candidate')->user()->id;

        $data['relationOptions']        = config('constants.relation_options'); 
        $data['months']                 = config('constants.months');
        $data['maritalStatuses']        = config('constants.marital_statuses');
        $data['occupationOptions']      =  config('constants.occupation_options');
        $data['booleanOptions']         = config('constants.boolean_options'); 

        #get all saved data w.r.t candidate id
        $data['familyDetailAllData']    = $candidateFamilyDetailsObject->getCandidateFamilyDetailsByCandidateId($candidateId);

        #get data w.r.t candidate id &  candidate Family Detail Id
        $data['familyDetailData']       = $candidateFamilyDetailsObject->getSingleCandidateFamilyDetailData($candidateFamilyDetailId);

     
        return view('frontend.candidates.profile.family-detail')->with($data);
    }


    public function familyDetail(CandidateFamilyDetailsRequest $request)
    {
        
        try
		{
            $validateValues = $request->validated();
            if (!empty($validateValues))
            {
                $candidateId                            = Auth::guard('candidate')->user()->id;
                
                $candidateFamilyDetailId                = Arr::get($validateValues, 'id');
                $day                                    = (int) Arr::get($validateValues, 'day');
                $month                                  = (int) Arr::get($validateValues, 'month');
                $year                                   = (int)Arr::get($validateValues, 'year');
                $formSubmit                             = Arr::get($validateValues, 'form_submit');

                $validateValues['date_of_birth']       = Carbon::createFromFormat('Y-m-d', $year.'-'.$month.'-'.$day)->toDateString();

                //Picture upload
                if(!empty($validateValues['picture']))
                {
                    
                    $uploadFolderPath                   = config('constants.files.familydetail');
                    $filePath                           = public_path($uploadFolderPath);
                    $picture                            = $request->file('picture');
    
                    $newName                            = rand().'-'.time().'-'.$candidateId. '.' . $picture->getClientOriginalExtension();
                    
                    $picture->move(public_path($uploadFolderPath), $newName);
                    Image::make(public_path($uploadFolderPath).'/'.$newName)->resize(84, 84)->save(public_path($uploadFolderPath.'thumbnail/' . $newName));
    
                    $validateValues['picture']          = $newName;

                    $this->removeOldPictureFromDirectory($candidateFamilyDetailId);
                }
                
                $validateValues['candidate_id'] = $candidateId;

                unset($validateValues['day']);
                unset($validateValues['month']);
                unset($validateValues['year']);
                unset($validateValues['form_submit']);


                #for update request
                if(!empty($candidateFamilyDetailId)){
                    $candidateFamilyDetailData    = CandidateFamilyDetails::where(['candidate_id'=> $candidateId, 'id' => $candidateFamilyDetailId])->update($validateValues);

                }else{
                    $candidateFamilyDetailData    = CandidateFamilyDetails::create($validateValues);
                }
              
            }    
           
            // if FamilyDetail saveed 
            $params = array('fieldName' => 'is_family_details_saved', 'fieldValue'=>1);
            $this->updateProfileFlag($params);

            if($candidateFamilyDetailData){

                if(!empty($candidateFamilyDetailId)){
                    $mode = "Updated";
                }else{
                    $mode = "Saved";
                } 
                
                
                if($formSubmit== "Save & Add more" )
                {
                    return redirect()->route('family.details.show')->with('success', "Family details ".$mode." successfully.");
                }
                else
                {
                    return redirect(route('upload.documents.show'))->with('success', "Family details ".$mode." successfully.");
                }
                
            }else{
                return redirect()->back()
                ->withErrors(['error' =>"Something went wrong with Family details. Please try again later!"]);
            }
        
        
        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }	  

    }


       /**
     * Delete -- Diploma--
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request){
        $candidateFamilyDetailId      = $request->route('id');
        $candidateId    = Auth::guard('candidate')->user()->id;

        $this->removeOldPictureFromDirectory($candidateFamilyDetailId);
        $candidateFamilyDetail =CandidateFamilyDetails::where(['candidate_id'=> $candidateId, 'id' => $candidateFamilyDetailId])->delete();
        
        if(!empty($candidateFamilyDetail)){

            $candidateFamilyDetailCount =CandidateFamilyDetails::where(['candidate_id'=> $candidateId])->count();
            if($candidateFamilyDetailCount ==0){
                
                $params = array('fieldName' => 'is_family_details_saved', 'fieldValue'=>0);
                $this->updateProfileFlag($params);
            }
        
            return redirect('/family-details')->with('success', "Family Detail deleted successfully.");
        }else{
            return redirect()->back()
                ->withErrors(['error' =>"Unable to delete Family Detail. Please try again!"]);
        }
    } 

     /**
     * profileImageRemove
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */

    public function pictureRemove(Request $request){
        
        try
		{
            $candidateId                  = Auth::guard('candidate')->user()->id;
            $candidateFamilyDetailId      = $request->route('id');

            $uploadFolderPath = config('constants.files.familydetail');
            $filePath = public_path($uploadFolderPath);
            $this->removeOldPictureFromDirectory($candidateFamilyDetailId);
            $updated = CandidateFamilyDetails::where(['candidate_id'=> $candidateId, 'id' => $candidateFamilyDetailId])->update(['picture'=> '']);

            return redirect()->back()->with('success', "Picture deleted successfully.");

        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }	
        
    }


    #remove Old Picture
    public function removeOldPictureFromDirectory($candidateFamilyDetailId=0)
    {
        $candidateFamilyDetailsObject = new CandidateFamilyDetails();
        $oldPicturedata = $candidateFamilyDetailsObject->getCandidateFamilyDetailPictureById($candidateFamilyDetailId);
        
        $uploadFolderPath                   = config('constants.files.familydetail');
        $oldPictureWithPath                 = $uploadFolderPath.Arr::get($oldPicturedata, 'picture');
        $oldThumbnailWithPath               = $uploadFolderPath.'thumbnail/'.Arr::get($oldPicturedata, 'picture');
    
        if(\File::exists($oldPictureWithPath)){
            \File::delete($oldPictureWithPath);
        }

        if(\File::exists($oldThumbnailWithPath)){
            \File::delete($oldThumbnailWithPath);
        }
        return true;    
    }
}
