<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class CandidateFamilyDetails extends Model
{
    use HasFactory;
    protected $table = "candidate_family_details";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','candidate_id', 'relation_id','name','emergency_contact','contact_no','date_of_birth','status_id','qualification','occupation_id','designation','company_or_institute','picture','created_at', 'updated_at'
    ];

    #get all get Candidate Family detail By Candidate Id 
    public function getCandidateFamilyDetailsByCandidateId($candidateId=0){
       return CandidateFamilyDetails::select('id','relation_id','name','date_of_birth','picture')->where('candidate_id',$candidateId)->get()->toArray();
    }

    #get Candidate Family detail  Candidate Id  & Family detail Id
    public function getSingleCandidateFamilyDetailData($candidateFamilyDetailId=0){
        $candidateId  = Auth::guard('candidate')->user()->id;
        return CandidateFamilyDetails::where(['candidate_id'=> $candidateId, 'id' => $candidateFamilyDetailId])->first();
    }

    #get picture name  Candidate Id  & Family detail Id
    public function getCandidateFamilyDetailPictureById($candidateFamilyDetailId=0){
        $candidateId  = Auth::guard('candidate')->user()->id;
        return CandidateFamilyDetails::select('picture')->where(['candidate_id'=> $candidateId, 'id' => $candidateFamilyDetailId])->first();
    }
}
