<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobBenefit;
use App\Http\Requests\Backend\JobBenefitRequest;

class JobBenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['jobBenefits']        = JobBenefit::latest()->paginate(config('constants.per_page'));
        $data['booleanOptions']     = config('constants.boolean_options'); 

        return view('backend.job_benefits.index')->with($data);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $data['booleanOptions']     = config('constants.boolean_options'); 
        return view('backend.job_benefits.create')->with($data);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobBenefitRequest $request)
    { 
        JobBenefit::create(array_merge($request->only('name','is_enabled'),[
            'created_by' => auth()->id()
        ]));

        return redirect()->route('job_benefits.index')
            ->withSuccess(__('Job Benefit created successfully.'));
    }


     /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobBenefit  $jobBenefit
     * @return \Illuminate\Http\Response
     */
    public function show(JobBenefit $jobBenefit)
    {
        $data = array();
        $data['booleanOptions']     = config('constants.boolean_options'); 
        $data['jobBenefit']            = $jobBenefit;
        return view('backend.job_benefits.show')->with($data);
    }


      /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobBenefit  $jobBenefit
     * @return \Illuminate\Http\Response
     */
    public function edit(JobBenefit $jobBenefit)
    {
        $data = array();
        $data['booleanOptions']     = config('constants.boolean_options'); 
        $data['jobBenefit']            = $jobBenefit;
        return view('backend.job_benefits.edit')->with($data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobBenefit  $jobBenefit
     * @return \Illuminate\Http\Response
     */
    public function update(JobBenefitRequest $request, JobBenefit $jobBenefit)
    {
        $jobBenefit->update(array_merge($request->only('name','is_enabled'),[
            'updated_by' => auth()->id()
        ]));

        return redirect()->route('job_benefits.index')
        ->withSuccess(__('Job Benefit updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobBenefit  $jobBenefit
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobBenefit $jobBenefit)
    {
        $jobBenefit->delete();

        return redirect()->route('job_benefits.index')
            ->withSuccess(__('Job Benefit deleted successfully.'));
    }

}
