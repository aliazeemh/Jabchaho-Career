<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateScheduleStatus extends Model
{
    use HasFactory;

    protected $table = "candidate_schedule_statuses";

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'id','name', 'is_enabled','created_at', 'updated_at'
   ];
}
