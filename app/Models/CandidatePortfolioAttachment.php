<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidatePortfolioAttachment extends Model
{
    use HasFactory;
    protected $table = "candidate_portfolio_attachments";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','candidate_id', 'original_file','file','created_at', 'updated_at'
    ];

    #get all get Candidate PortfolioDetail By Candidate Id 
    public function getCandidatePortfolioAttachmentsByCandidateId($candidateId=0){
       return CandidatePortfolioAttachment::select('id','file')->where('candidate_id',$candidateId)->get()->toArray();
    }
    
}
