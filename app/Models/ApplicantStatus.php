<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantStatus extends Model
{
    use HasFactory;

    protected $table = "applicant_statuses";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name', 'is_enabled','created_at', 'updated_at'
    ];

    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'applicant_status_id', 'id');
    }
}
