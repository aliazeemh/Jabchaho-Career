<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidateDiploma extends Model
{
    use HasFactory;

    protected $table = "candidate_diplomas";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','candidate_id', 'institute_name','diploma_title','field_of_study','from','to','is_in_progress','created_at', 'updated_at'
    ];

    #get all get Candidate Diploma By Candidate Id 
    public function getCandidateDiplomasByCandidateId($candidateId=0){
       return CandidateDiploma::select('id','institute_name','diploma_title','from','to','is_in_progress')->where('candidate_id',$candidateId)->get()->toArray();
    }


    #get get Candidate Education By Candidate Id  & Experience Id
    public function getSingleCandidateDiplomaData($candidateDiplomaId=0){
        $candidateId  = Auth::guard('candidate')->user()->id;
        return CandidateDiploma::where(['candidate_id'=> $candidateId, 'id' => $candidateDiplomaId])->first();
    }

}
