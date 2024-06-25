<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidateShift extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cadidate_shifts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','candidate_id','shift_id','created_at','updated_at'];



    public function getCandidateShifts()
    {
        $candidateId            = Auth::guard('candidate')->user()->id;
        return CandidateShift::select('id','shift_id')->where(['candidate_id' =>$candidateId])->get();
    }
}
