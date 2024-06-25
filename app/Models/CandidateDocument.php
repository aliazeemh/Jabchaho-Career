<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidateDocument extends Model
{
    use HasFactory;
    protected $table = "candidate_documents";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','candidate_id','table_name','table_action_id','document_name','original_file','file','created_at', 'updated_at'
    ];

    #get all get Candidate Diploma By Candidate Id 
    public function getCandidateAttachmentsByCandidateId($candidateId=0){
       return CandidateDocument::select('id','file','document_name','table_name','table_action_id')->where(['candidate_id'=>$candidateId])->get()->toArray();
    }


    function getDocumentName($candidateId=0,$documentName=''){
        return CandidateDocument::select('id','file')->where(['candidate_id' =>$candidateId,'document_name'=>$documentName])->first();
    }
}
