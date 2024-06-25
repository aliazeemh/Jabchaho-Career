<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantComments extends Model
{
    use HasFactory;

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'applicant_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','applicant_id','applicant_status_id','comment','created_by','updated_by','created_at','updated_at'];


    /**
     * Get the applicant_comments associated with the user.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

     /**
     * Get the applicant_comments associated with the applicant_status.
     */
    public function applicantStatus()
    {
        return $this->hasOne(ApplicantStatus::class, 'id', 'applicant_status_id');
    }

    public function getApplicantComments($applicantId=0)
    {
        return ApplicantComments::with(['user','applicantStatus'])->where(['applicant_id' => $applicantId])->orderBy('id', 'DESC')->get();
    }
}
