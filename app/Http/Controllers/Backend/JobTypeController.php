<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobType;
use App\Http\Requests\Backend\JobTypeRequest;

class JobTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobTypes                   = JobType::latest()->paginate(config('constants.per_page'));
        $data['jobTypes']           = $jobTypes;
        $data['booleanOptions']     = config('constants.boolean_options'); 

        return view('backend.job_types.index')->with($data);
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
        return view('backend.job_types.create')->with($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobTypeRequest $request)
    {
      
        
        if($request->input('is_checked') == 1){
            $jobTypeObject = new JobType();
            $jobTypeObject->updateIsChecked();
        }
        
        JobType::create(array_merge($request->only('name','is_enabled', 'is_checked'),[
            'created_by' => auth()->id()
        ]));

        return redirect()->route('job_types.index')
            ->withSuccess(__('Job Type created successfully.'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobType  $jobType
     * @return \Illuminate\Http\Response
     */
    public function show(JobType $jobType)
    {
        $data = array();
        $data['booleanOptions']     = config('constants.boolean_options'); 
        $data['jobType']            = $jobType;
        return view('backend.job_types.show')->with($data);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobType  $jobType
     * @return \Illuminate\Http\Response
     */
    public function edit(JobType $jobType)
    {
        $data = array();
        $data['booleanOptions']     = config('constants.boolean_options'); 
        $data['jobType']            = $jobType;
        return view('backend.job_types.edit')->with($data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobType  $jobType
     * @return \Illuminate\Http\Response
     */
    public function update(JobTypeRequest $request, JobType $jobType)
    {
        if($request->input('is_checked') == 1){
            $jobTypeObject = new JobType();
            $jobTypeObject->updateIsChecked();
        }
        
        $jobType->update(array_merge($request->only('name','is_enabled', 'is_checked'),[
            'updated_by' => auth()->id()
        ]));

        return redirect()->route('job_types.index')
        ->withSuccess(__('Job Type updated successfully.'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobType  $jobType
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobType $jobType)
    {
        $jobType->delete();

        return redirect()->route('job_types.index')
            ->withSuccess(__('Job Type deleted successfully.'));
    }

}
