<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobComments extends Model
{
    use HasFactory;

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','job_id','job_status_id','comment','created_by','updated_by','created_at','updated_at'];


     /**
     * Get the job_comments associated with the user.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

     /**
     * Get the job_comments associated with the JobStatus.
     */
    public function jobStatus()
    {
        return $this->hasOne(JobStatus::class, 'id', 'job_status_id');
    }

    public function getJobComments($jobId=0)
    {
        return JobComments::with(['user','jobStatus'])->where(['job_id' => $jobId])->orderBy('id', 'DESC')->get();
    }
}
