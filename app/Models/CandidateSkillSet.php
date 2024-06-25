<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidateSkillSet extends Model
{
    use HasFactory;

    protected $table = "candidate_skill_sets";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','candidate_id', 'skill_set_id','created_at', 'updated_at'
    ];


    /**
     * Get the phone associated with the user.
     */
    public function skillSet()
    {
        return $this->hasOne(SkillSet::class, 'id', 'skill_set_id');
    }


    #get all get Candidate Diploma By Candidate Id 
    public function getCandidateSkillSetByCandidateId($candidateId=0)
    {
       return CandidateSkillSet::with(['skillSet'])->where('candidate_id',$candidateId)->get();
    }
}
