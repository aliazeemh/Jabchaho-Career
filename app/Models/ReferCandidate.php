<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ReferCandidate extends Model
{
    use HasFactory;

    protected $table = "refer_candidates";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','candidate_full_name', 'job_type_id','area_of_interest_option_id','mobile','city_region','level_of_education','email','country_code','previous_experience','ax_code','created_at', 'updated_at'
    ];

    /**
     * Get the phone associated with the user.
     */
    public function areaOfInterestOption()
    {
        return $this->hasOne(AreaOfInterestOption::class, 'id', 'area_of_interest_option_id');
    }
}
