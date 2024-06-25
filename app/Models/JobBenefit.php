<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobBenefit extends Model
{
    use HasFactory;
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_benefits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','name','is_enabled','created_by','updated_by','created_at','updated_at'];


    public function getJobBenefits(){
        return JobBenefit::where(['is_enabled' => 1])->get();
    }

    
}
