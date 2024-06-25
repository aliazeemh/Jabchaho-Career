<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateExperienceFacilities extends Model
{
    use HasFactory;
    protected $table = "candidate_experience_facilities";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','candidate_experience_id','facility_option_id','created_at','updated_at'
    ];

}
