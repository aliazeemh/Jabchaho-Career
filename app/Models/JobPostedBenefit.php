<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPostedBenefit extends Model
{
    use HasFactory;

      /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_posted_benefits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','job_id','job_benefit_id','created_by','created_at'];

    /**
     * Get the phone associated with the user.
     */
    public function jobBenefit()
    {
        return $this->hasOne(JobBenefit::class, 'id', 'job_benefit_id')->where(['is_enabled' => 1]);
    }
}
