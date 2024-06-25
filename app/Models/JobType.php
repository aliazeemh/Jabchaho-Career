<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','name','is_enabled','is_checked','created_by','updated_by','created_at','updated_at'];


    #get all Job types 

    public function getAllEnabledJobTypes(){

        return JobType::where('is_enabled',1)->get();
    }

    public function updateIsChecked(){
        return JobType::where(['is_checked'=>1])->Update(['is_checked'=>0]);
    }
}
