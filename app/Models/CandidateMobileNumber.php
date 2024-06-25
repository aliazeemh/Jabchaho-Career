<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidateMobileNumber extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'candidate_mobile_numbers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','candidate_id','mobile_code','mobile_number','created_at','updated_at'];



    public function getCandidateMobileNumbers()
    {
        $candidateId            = Auth::guard('candidate')->user()->id;
        return CandidateMobileNumber::select('id','mobile_code','mobile_number')->where(['candidate_id' =>$candidateId])->get()->toArray();
    }
}
