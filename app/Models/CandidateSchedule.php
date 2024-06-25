<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateSchedule extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'candidate_schedules';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'candidate_id',
        'schedule_status_id',
        'schedule_time',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];



     /**
     * Get the phone associated with the user.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }


     /**
     * Get the phone associated with the user.
     */
    public function scheduleStatus()
    {
        return $this->hasOne(CandidateScheduleStatus::class, 'id', 'schedule_status_id');
    }


    public function getCandidateSchedule($candidateId=0)
    {
        return CandidateSchedule::with(['user','scheduleStatus'])->where(['candidate_id' => $candidateId])->latest()->get();
    }
}
