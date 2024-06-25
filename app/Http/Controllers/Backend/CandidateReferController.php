<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JobType;
use App\Models\AreaOfInterestOption;
use App\Models\AreaOfInterestGroup as AreaOfInterestGroup;
use App\Http\Requests\Frontend\CandidateReferRequest;
use App\Models\ReferCandidate;
use Illuminate\Support\Arr;

class CandidateReferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchCondition = array();
        $filterData = array();
        
        $mobile = $request->query('mobile');
        $name  = $request->query('name');
        $areaOfInterestOptionId  = $request->query('area_of_interest_option_id');
        
        $filterData['mobile']                   = $mobile;
        $filterData['name']                     = $name;
        $filterData['areaOfInterestOptionId']   = $areaOfInterestOptionId;
        
        if(!empty($mobile))
        {
            $searchCondition['mobile'] = $mobile;
        }

        if(!empty($areaOfInterestOptionId)){
            $searchCondition['area_of_interest_option_id'] = $areaOfInterestOptionId;
        }

        $searchLikeCondition = array();
        if(!empty($name)){
            $searchLikeCondition = array( array('candidate_full_name', 'like', '%'.$name.'%'));
        }


        $areaOfInterestGroups = new AreaOfInterestGroup();

        $areaOfInterests = $areaOfInterestGroups->getAreaOfInterests();

        $data['levelOfEducations']      = config('constants.level_of_educations'); 
        $data['previousExperience']     = config('constants.previous_experience');
        $data['referCandidates']        = ReferCandidate::with(['areaOfInterestOption'])->where($searchCondition)->where($searchLikeCondition)->latest()->paginate(config('constants.per_page'));
        $data['areaOfInterests']        = $areaOfInterests;
        return view('backend.candidates.referred.index')->with($data)->with($filterData);
    }    


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReferCandidate  $refercandidate
     * @return \Illuminate\Http\Response
     */
    public function show(ReferCandidate $refercandidate)
    {
        $data = array();
        $data['areaOfInterestOption']   = AreaOfInterestOption::select('name')->where(['id'=>Arr::get($refercandidate, 'area_of_interest_option_id')])->first();
        $data['jobType']                = JobType::select('name')->where(['id'=>Arr::get($refercandidate, 'job_type_id')])->first();
        $data['levelOfEducation']       = config('constants.level_of_educations'.'.'.(Arr::get($refercandidate, 'level_of_education')));
        $data['previousExperience']     = config('constants.previous_experience'.'.'.(Arr::get($refercandidate, 'previous_experience')));
        $data['country']                = config('constants.countries'.'.'.(Arr::get($refercandidate, 'country_code')));
        $data['refercandidate']         = $refercandidate;
        return view('backend.candidates.referred.show')->with($data);
    }

}
