<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use DB;
use App\Helpers\Helper;

class Applicant extends Model
{
    use HasFactory;

    protected $table = "applicants";


    /**
     * Get the job associated with the applicants.
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }


    /**
     * Get the candidate associated with the applicants.
     */
    public function candidate()
    {
        return $this->hasOne(Candidate::class, 'id', 'candidate_id');
    }

    /**
     * Get the CandidateEducation associated with the applicants.
     */
    public function candidateEducation()
    {
        return $this->hasMany(CandidateEducation::class,'candidate_id','candidate_id');

    }

    /**
     * Get the Candidate Detail associated with the applicants.
     */

    public function candidateDetail()
    {
        return $this->hasMany(CandidateDetail::class,'candidate_id','candidate_id');

    }

    /**
     * Get the Candidate Experience associated with the applicants.
     */

     public function CandidateExperience()
     {
         return $this->hasMany(CandidateExperience::class,'candidate_id','candidate_id');
 
     }

    /**
     * Get the candidate associated with the applicants.
     */
    public function applicantStatus()
    {
        return $this->hasOne(ApplicantStatus::class, 'id', 'applicant_status_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','candidate_id', 'job_id','applicant_status_id','full_name','email','phone','created_at', 'updated_at'
    ];


    function isCandidateAlreadyJobApplied($candidateId=0,$jobId=0){
        
        $result = Applicant::where(['candidate_id'=>$candidateId,'job_id'=>$jobId])->get()->count();
        return $result;
    }


    function getApplicantJobs($candidateId=0){
        return Applicant::with(['job'])->where(['candidate_id'=>$candidateId])->get();
    }

    function applicantCount($params=array())
    {
        if(!empty($params['startDate']) && !empty($params['endDate']))
        {
            $startDate  = $params['startDate'];
            $endDate    = $params['endDate'];

            $result = Applicant::whereBetween('created_at', [$startDate, $endDate])->count();
        }
        else
        {
            $result = Applicant::count(); 
        }
        
        return $result;
    }

    function applicantsCountByStatus($params = array())
    {
        if( Arr::get($params, 'applicant_status_id'))
        {   
            $wherecondition['applicant_status_id'] = Arr::get($params, 'applicant_status_id');
        }

        if(!empty($params['startDate']) && !empty($params['endDate']))
        {
            $startDate  = $params['startDate'];
            $endDate    = $params['endDate'];
            $result = Applicant::whereBetween('created_at', [$startDate, $endDate])->where($wherecondition)->get()->count();
        }
        else{
            $result = Applicant::where($wherecondition)->get()->count();
        }    
        
        $result = Applicant::where($wherecondition)->get()->count();
        return $result;
    }

    //Get Data w.r.t year and group by month
    function applicantsRespectToYearAndStatus($params=array())
    {
        $result = $wherecondition = array();
         
        $year   = Arr::get($params, 'year');
 
        if(Arr::get($params, 'applicant_status_id'))
        {
            $wherecondition['applicant_status_id'] = Arr::get($params, 'applicant_status_id');
        }
        
        $data = Applicant::select(
            DB::raw("
            count(DISTINCT (email)) as total,
            MONTH(updated_at) month
            ")
        )
        ->whereYear('updated_at', '=', $year)
        ->where($wherecondition)
        ->groupBy('month')
        ->get()->toArray();

        if(!empty($data))
        {
            foreach($data as $row){
                $result[Arr::get($row, 'month')] = Arr::get($row, 'total');
            }
        }
        return $result;
    }


    function applicantStatusCount($params = array())
    {  
        $wherecondition ='';
        $applicantStatusesWithCounts = ApplicantStatus::select('name')->withCount(['applicants' => function ($query) use ($params) {
             if(!empty($params['startDate']) && !empty($params['endDate']))
            {
                $startDate  = $params['startDate'];
                $endDate    = $params['endDate'];
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }   

        }])->get();
        
        $statusCount = array();
        if(!empty($applicantStatusesWithCounts))
        {
            foreach($applicantStatusesWithCounts as $row)
            {
                $name = str_replace(' ', '', Arr::get($row, 'name'));
                $statusCount[$name] = Arr::get($row, 'applicants_count');
            }
        }
        
        return $statusCount;
    }

    function applicantJobCount($candidateId=0)
    {
        $currentDate = now()->toDateString();
        return Applicant::whereDate('created_at', '=', $currentDate)->where('candidate_id', $candidateId)->count();
    }
}
