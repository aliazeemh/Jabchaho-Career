<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidatePortfolio extends Model
{
    use HasFactory;
    protected $table = "candidate_portfolios";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','candidate_id', 'title','url','created_at', 'updated_at'
    ];

    #get all get Candidate PortfolioDetail By Candidate Id 
    public function getCandidatePortfolioDetailByCandidateId($candidateId=0){
       return CandidatePortfolio::select('id','title','url')->where('candidate_id',$candidateId)->get()->toArray();
    }
}
