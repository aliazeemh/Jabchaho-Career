<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class CandidateReferral extends Model
{
    use HasFactory;

    protected $table = "candidate_referrals";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','candidate_id', 'referral_id','person_name','contact_no','employee_id','reference_code','other_medium','other_name','other_contact_no','created_at', 'updated_at'
    ];

    #get all get Candidate Diploma By Candidate Id 
    public function getCandidateReferralByCandidateId()
    {
        $candidateId  = Auth::guard('candidate')->user()->id;
        $candidateReferralData = CandidateReferral::select('id','referral_id','person_name','contact_no','employee_id','reference_code','other_medium','other_name','other_contact_no')->where('candidate_id',$candidateId)->first();
       if(!empty($candidateReferralData))
            $candidateReferralData->toArray();
        
        return $candidateReferralData;

    }
}
