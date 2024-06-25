<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidateCertification extends Model
{
    use HasFactory;

    protected $table = "candidate_certifications";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','candidate_id', 'institute_name','certification_title','field_of_study','from','to','is_in_progress','courses_papers_total','courses_papers_cleared','created_at', 'updated_at'
    ];

    #get all get Candidate Diploma By Candidate Id 
    public function getCandidateCertificateByCandidateId($candidateId=0){
       return CandidateCertification::select('id','institute_name','certification_title','from','to','is_in_progress')->where('candidate_id',$candidateId)->get()->toArray();
    }


    #get get Candidate Education By Candidate Id  & Experience Id
    public function getSingleCandidateCertificateData($candidateCertificateId=0){
        $candidateId  = Auth::guard('candidate')->user()->id;
        return CandidateCertification::where(['candidate_id'=> $candidateId, 'id' => $candidateCertificateId])->first();
    }
}
