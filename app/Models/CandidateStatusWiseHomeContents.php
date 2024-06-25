<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateStatusWiseHomeContents extends Model
{
    use HasFactory;

    protected $table = "candidate_status_wise_home_contents";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','title', 'content','candidate_status_id','is_enabled','created_by','updated_by','created_at', 'updated_at'
    ];

    /**
    * Get the phone associated with the user.
    */
    
    public function candidateStatus()
    {
        return $this->hasOne(CandidateStatus::class, 'id', 'candidate_status_id');
    }



    public function getHomeContentStatusIdWise($candidateStatusId=0)
    {
        return CandidateStatusWiseHomeContents::where(['candidate_status_id'=>$candidateStatusId])->first();
    }
}
