<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\User;
use App\Models\Candidate;
use App\Models\Job;
use App\Helpers\Helper;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() 
    {
        try
        {
            $data = $params = array();
            return view('backend.home.index')->with($data);

        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }
    }

    /**
     * Handle Graph data Request request
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    function getJobsGraphData(Request $request)
    {
        try
        {
            $data                           = array();
            $dataset                        = array();
            $year                           = date('Y');
            $shortlistedId                  = config('constants.applicant_status_id.shortlisted');
            $onHoldId                       = config('constants.applicant_status_id.on_hold');

            if(!empty($request->get('year')))
            {
                $year  = $request->get('year');
            }

            $applicantObject                = new Applicant();

            #applicants
            $params['year']                 = $year;
            $applicants                     = $applicantObject->applicantsRespectToYearAndStatus($params);

            #shortlisted
            $params['year']                 = $year;
            $params['applicant_status_id']  = $shortlistedId;
            $shortlisted                    = $applicantObject->applicantsRespectToYearAndStatus($params);

            #On Hold
            $params['year']                 = $year;
            $params['applicant_status_id']  = $onHoldId;
            $onHold                         = $applicantObject->applicantsRespectToYearAndStatus($params);

            
        
            $dataset = array( 
                    [
                        'label'             => 'Applicants',
                        'backgroundColor'   => "#8e5ea2",
                        'data'              => Helper::monthDataMergeWithDefaultMonthArray($applicants)
                    ],
                    [
                        'label'             => 'Shortlisted',
                        'backgroundColor'   => "#30c7ec",
                        'data'              => Helper::monthDataMergeWithDefaultMonthArray($shortlisted)
                    ],
                    [
                        'label'             => 'On Hold',
                        'backgroundColor'   => "#0ba360",
                        'data'              => Helper::monthDataMergeWithDefaultMonthArray($onHold)
                    ]

            );        

            return response()->json($dataset);
        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }

        
    }

    /**
     * Count data Request
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    function getCountData(Request $request)
    {
        try
        {
            $data = $params = array();

            $applicantObject = new Applicant();
            $jobObject = new Job();

            $filterValue = '';
            $applicantStatusCount = array();
            if(!empty($request->get('filterValue')))
            {
                $filterValue  = $request->get('filterValue');
                
                $datesArray = Helper::getDateByFilterValue($filterValue);
 
                $startDate              = Arr::get($datesArray, 'startDate');
                $endDate                = Arr::get($datesArray, 'endDate');

                $usersCount             = User::whereBetween('created_at', [$startDate, $endDate])->count();
                $candidateCount         = Candidate::whereBetween('created_at', [$startDate, $endDate])->count();

                $params['startDate']    = $startDate;
                $params['endDate']      = $endDate;
                               
                $jobs                   = $jobObject->getAllActiveJobCount($params);
                $applicants             = $applicantObject->applicantCount($params);
                
                $applicantStatusCount   = $applicantObject->applicantStatusCount($params);
            }
            else
            {
                $usersCount         = User::count();
                $candidateCount     = Candidate::count();
                $jobs               = $jobObject->getAllActiveJobCount();
                $applicants         = $applicantObject->applicantCount();

                $applicantStatusCount   = $applicantObject->applicantStatusCount($params);
            }

            $data['users']                  = $usersCount;
            $data['candidates']             = $candidateCount;
            $data['jobs']                   = $jobs;
            $data['applicants']             = $applicants;

           $data =  array_merge($data,$applicantStatusCount);

            return response()->json($data);

        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
            
        }
    }    

}
