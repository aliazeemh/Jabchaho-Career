<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;
use DB;

class Job extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'jobs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','job_status_id','title','city_id','area_of_interest_group_id','area_of_interest_option_id','job_type_id','responsibility','requirement','start_date','end_date','created_by','updated_by','created_at','updated_at'];

    /**
     * Get the phone associated with the user.
     */
    public function jobStatus()
    {
        return $this->hasOne(JobStatus::class, 'id', 'job_status_id');
    }


      /**
     * Get the applicants associated with the Job
     */
    public function applicant()
    {
        return $this->hasMany(Applicant::class);
    }


    function getJobDetail($jobId=0){
        return Job::select('id','title','city_id','area_of_interest_group_id','area_of_interest_option_id','job_type_id','responsibility','requirement','start_date','end_date',)->with(['jobStatus'])->where(['id'=>$jobId])->first();
    }


    function getValidJobDetail($jobId=0){
        
        $now    = Carbon::now()->toDateString();

        return Job::where([ 'job_status_id' => config('constants.job_statuses.approved'), 'id' => $jobId])       
        ->where('start_date', '<=', $now) 
        ->where('end_date', '>=', $now) 
        ->first();
    }


    public function jobCountViaAreaOfInterestGroup()
    {
        $result = array();
        $now    = Carbon::now()->toDateString();
       
        $jobCountViaAreaOfInterestGroup = Job::select('area_of_interest_groups.id',DB::raw('count(jobs.id) as total'))->join("area_of_interest_groups", "jobs.area_of_interest_group_id" , "=", "area_of_interest_groups.id" )
        ->where(['area_of_interest_groups.is_enabled'=> 1,'jobs.job_status_id' => config('constants.job_statuses.approved')])
        ->where('start_date', '<=', $now) 
        ->where('end_date', '>=', $now) 
        ->groupBy('area_of_interest_groups.id')
        ->get();

        if(!empty($jobCountViaAreaOfInterestGroup))
        {
            foreach($jobCountViaAreaOfInterestGroup as $row){
                $result[Arr::get($row, 'id')] = Arr::get($row, 'total');
            }
        }

        return $result;

    }  

    function getAllActiveJobCount($params=array()){
        
        $now    = Carbon::now()->toDateString();

        if(!empty($params['startDate']) && !empty($params['endDate']))
        {
            $startDate  = $params['startDate'];
            $endDate    = $params['endDate'];

            return Job::where([ 'job_status_id' => config('constants.job_statuses.approved')])       
            ->where('start_date', '<=', $now) 
            ->where('end_date', '>=', $now) 
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        }else{
            
            return Job::where([ 'job_status_id' => config('constants.job_statuses.approved')])       
            ->where('start_date', '<=', $now) 
            ->where('end_date', '>=', $now) 
            ->count();
        }
       

        
    }

}
