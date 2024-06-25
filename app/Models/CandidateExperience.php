<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidateExperience extends Model
{
    use HasFactory;

    protected $table = "candidate_experiences";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','candidate_id', 'company_name','company_website', 'job_title','job_city_country','job_type_id',
        'responsibilities','reason_for_leaving','from','to','is_present','current_salary','initial_salary','created_at', 'updated_at'
    ];

    /**
     * Get the post that owns the comment.
     */
    public function candidate()
    {
        return $this->belongsToMany(Candidate::class,'candidate_experiences','id');
    }


    /**
     * Get the phone associated with the user.
     */
    public function candidateExperienceFacilities()
    {
        return $this->hasMany(CandidateExperienceFacilities::class, 'candidate_experience_id','id');
    }

    #get all get Candidate Experiences By Candidate Id 
    public function getCandidateExperiencesByCandidateId($candidateId=0,$fields=array()){
        
        $selectColumns = ['id','company_name','job_title','from','to','is_present'];
        if(!empty($fields)){
            $selectColumns = $fields;
        }
       return CandidateExperience::where('candidate_id',$candidateId)->get($selectColumns)->toArray();
    }

    
    #get get Candidate Experience By Candidate Id  & Experience Id
    public function getSingleCandidateExperienceData($candidateExperienceId=0){
        $candidateId  = Auth::guard('candidate')->user()->id;
        return CandidateExperience::with('candidateExperienceFacilities')->where(['candidate_experiences.candidate_id'=> $candidateId, 'candidate_experiences.id' => $candidateExperienceId])->first();
    }
    

}
