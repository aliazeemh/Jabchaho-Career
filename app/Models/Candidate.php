<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;


class Candidate extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'candidates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'application_id',
        'google_id',
        'facebook_id',
        'full_name',
        'email',
        'password',
        'mobile_number',
        'country_code',
        'area_of_interest_option_id',
        'profile_image',
        'cover_image',
        'ip',
        'status_id',
        'created_by',
        'updated_by'
       
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
    ];

    /**
     * Always encrypt password when it is updated.
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Get the phone associated with the user.
     */
    public function candidateStatus()
    {
        return $this->hasOne(CandidateStatus::class, 'id', 'candidate_status_id');
    }


     /**
     * Get the phone associated with the user.
     */
    public function areaOfInterestOption()
    {
        return $this->hasOne(AreaOfInterestOption::class, 'id', 'area_of_interest_option_id');
    }

    public function candidateDocument()
    {
        return $this->belongsTo(CandidateDocument::class, 'id', 'candidate_id');
    }

    //get candidate Resume Document
    public function getCandidateResumeDocument() {
		return $this->candidateDocument()->where('document_name','=', 'resume');
	}

    /**
     * checkk mobile is unique 
     */

    public function isUniqueMobileNumber($postData=array(),$id=0){

       
        $countryCode	            = Arr::get($postData, 'country_code');
        $mobileCode	                = Arr::get($postData, 'mobile_code');
        $mobileNumber	            = Arr::get($postData, 'mobile_number');
        $intMobileNumber	        = Arr::get($postData, 'int_mobile_number');

        if($countryCode == config('constants.default_country_code')){
            $conditionArray = [['mobile_number','=',$mobileCode.$mobileNumber],['id','<>',$id]];
        }else{
            $conditionArray = [['mobile_number','=',$intMobileNumber],['id','<>',$id]];
        }
    
        $result = Candidate::where($conditionArray)->get()->count();
    
        return $result;
    } 

    #candidate profile percentage 
    public function getCandidateProfilePercentage($candidateId=0)
    {
       $data                       = array();
       $candidateData              = Candidate::with(['candidateStatus','areaOfInterestOption'])->where('id',$candidateId)->first();
       
       #Profile Form saved flags
       $isExperienceSaved          = Helper::retunOneIfzero(Arr::get($candidateData, 'is_experience_saved'));
       $isEducationSaved           = Helper::retunOneIfzero(Arr::get($candidateData, 'is_education_saved'));
       $isDiplomaSaved             = Helper::retunOneIfzero(Arr::get($candidateData, 'is_diplomas_saved'));
       $isCertificationsSaved      = Helper::retunOneIfzero(Arr::get($candidateData, 'is_certifications_saved'));
       $isSkillSetSaved            = Helper::retunOneIfzero(Arr::get($candidateData, 'is_skill_set_saved'));
       $isPortfolioSaved           = Helper::retunOneIfzero(Arr::get($candidateData, 'is_portfolio_saved'));
       $isPersonalDetailsSaved     = Helper::retunOneIfzero(Arr::get($candidateData, 'is_personal_details_saved'));
       $isReferralSaved            = Helper::retunOneIfzero(Arr::get($candidateData, 'is_referral_saved'));
       $isUploadDocumentSaved      = Helper::retunOneIfzero(Arr::get($candidateData, 'is_upload_document_saved'));
       $isFamilyDetailsSaved       = Helper::retunOneIfzero(Arr::get($candidateData, 'is_family_details_saved'));
       
       $profilePercentage           = ($isExperienceSaved+$isEducationSaved+$isDiplomaSaved+$isCertificationsSaved+$isSkillSetSaved+$isPortfolioSaved+$isPersonalDetailsSaved+$isReferralSaved+$isUploadDocumentSaved+$isFamilyDetailsSaved)*10;
       $data['candidateData']       = $candidateData;
       $data['profilePercentage']   = $profilePercentage;
  

       if($profilePercentage == 100 && Arr::get($candidateData, 'candidate_status_id') == 1)
       {
            
            Candidate::where(['id'=>$candidateId])->update(['candidate_status_id'=>2]);
       }
 
       return $data;
    }


    public function getCandidateProfileData($candidateId=0)
    {
        $candidateExperienceObject          = new CandidateExperience();
        $candidateEducationObject           = new CandidateEducation();
        $candidateDiplomaObject             = new CandidateDiploma();
        $candidateCertificationObject       = new CandidateCertification();
        $candidatePortfolioObject           = new CandidatePortfolio();
        $candidateSkillSet                  = new CandidateSkillSet();
        $candidateDetailObject              = new CandidateDetail();
        $candidateFamilyDetailsObject       = new CandidateFamilyDetails();
        
        $data                                       = array();
        $candidateProfilePercentage                 = $this->getCandidateProfilePercentage($candidateId);
 
        $data['candidateData']                      = $candidateProfilePercentage['candidateData'];
        $data['profilePercentage']                  = $candidateProfilePercentage['profilePercentage'];
        #get all saved data w.r.t candidate id
        $data['professionalExperienceAllData']      = $candidateExperienceObject->getCandidateExperiencesByCandidateId($candidateId);
        #get all saved data w.r.t candidate id
        $data['educationalQualificationAllData']    = $candidateEducationObject->getCandidateEducationsByCandidateId($candidateId);
        #get all saved data w.r.t candidate id
        $data['diplomaAllData']                     = $candidateDiplomaObject->getCandidateDiplomasByCandidateId($candidateId);
        #get all saved data w.r.t candidate id
        $data['certificateAllData']                 = $candidateCertificationObject->getCandidateCertificateByCandidateId($candidateId);
        #get all saved data w.r.t candidate id
        $data['candidatePortfolioDetail']           =  $candidatePortfolioObject->getCandidatePortfolioDetailByCandidateId($candidateId);
        #get all saved data w.r.t candidate id
        $data['skillSets']                          = $candidateSkillSet->getCandidateSkillSetByCandidateId($candidateId);

        #get all saved data w.r.t candidate id
        $data['personalDetailData']                 = $candidateDetailObject->getCandidateDetail($candidateId);

        #get all saved data w.r.t candidate id
        $data['familyDetailAllData']                = $candidateFamilyDetailsObject->getCandidateFamilyDetailsByCandidateId($candidateId);
    
        return $data;
    }

    function getSocialliteCandidate($params=array())
    {

        $socialiteField	            = Arr::get($params, 'socialiteField');
        $socialiteUserId	        = Arr::get($params, 'socialiteUserId');
        $socialiteUserEmail	        = Arr::get($params, 'socialiteUserEmail');
        
        return $isCandidate = Candidate::where($socialiteField, '=', $socialiteUserId)->orWhere('email', $socialiteUserEmail)->whereNotNull('email')->first();
    }

}
