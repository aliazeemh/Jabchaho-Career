<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidateEducation extends Model
{
    use HasFactory;

    protected $table = "candidate_educations";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','candidate_id', 'institute_name','level_of_education','board','field_of_study','level_grade_a','level_grade_b','level_grade_c','majors','from','to','is_in_progress','final_result','drop_out','percentage','gpa','grade','position','scholarships','extra_curricular_activities','created_at', 'updated_at'
    ];


    #get all get Candidate Education By Candidate Id 
    public function getCandidateEducationsByCandidateId($candidateId=0,$fields=array()){
        $selectColumns = ['id','institute_name','field_of_study','from','to','is_in_progress'];
        if(!empty($fields)){
            $selectColumns = $fields;
        }
       return CandidateEducation::where('candidate_id',$candidateId)->get($selectColumns)->toArray();
    }


    #get get Candidate Education By Candidate Id  & Experience Id
    public function getSingleCandidateEducationData($candidateEducationId=0){
        $candidateId  = Auth::guard('candidate')->user()->id;
        return CandidateEducation::where(['candidate_id'=> $candidateId, 'id' => $candidateEducationId])->first();
    }


    public function educationCountByCandidateId($candidateId=0)
    {
        return CandidateEducation::where(['candidate_id'=>$candidateId])->count();
    }
}
