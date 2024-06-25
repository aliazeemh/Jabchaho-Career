<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CandidateDetail extends Model
{
    use HasFactory;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'candidate_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'candidate_id',
        'gender',
        'date_of_birth',
        'marital_status',
        'nationality',
        'cnic',
        'passport',
        'religion',
        'linkedin_profile',
        'height',
        'weight',
        'expected_salary',
        'own_convenience',
        'landline_number',
        'house_no',
        'street',
        'area',
        'city',
        'created_at',
        'updated_at'
    ];

    function getCandidateDetail($candidateId=0){
        return CandidateDetail::select('id','gender','date_of_birth','marital_status','nationality','cnic','passport','religion','linkedin_profile','height','weight','expected_salary','own_convenience','landline_number','house_no','street','area','city')->where(['candidate_id'=>$candidateId])->first();
    }
}
