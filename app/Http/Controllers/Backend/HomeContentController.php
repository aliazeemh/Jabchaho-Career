<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CandidateStatus;
use App\Models\CandidateStatusWiseHomeContents;
use App\Http\Requests\Backend\HomeContentRequest;

class HomeContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homeContents           = CandidateStatusWiseHomeContents::with('CandidateStatus')->latest()->paginate(config('constants.per_page'));
 
        $data['homeContents']   = $homeContents;
        return view('backend.home_content.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $candidateStatusObject       = new CandidateStatus();
        
        $data['candidateStatuses']   = $candidateStatusObject->getCandidateStatus();
        
        return view('backend.home_content.create')->with($data);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeContentRequest $request)
    {
        CandidateStatusWiseHomeContents::create(array_merge($request->only('candidate_status_id','title', 'content'),[
            'created_by' => auth()->id()
        ]));

        return redirect()->route('home_content.index')
            ->withSuccess(__('Home Content created successfully.'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CandidateStatusWiseHomeContents  $homeContent
     * @return \Illuminate\Http\Response
     */
    public function show(CandidateStatusWiseHomeContents $homeContent)
    {
        $data = array();
        
        $id =(int) \Request::segment(4);
        $homeContent = CandidateStatusWiseHomeContents::with('candidateStatus')->where(['id'=>$id])->first();
        $data['homeContent'] =$homeContent;
        return view('backend.home_content.show')->with($data);
    }


     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CandidateStatusWiseHomeContents  $homeContent
     * @return \Illuminate\Http\Response
     */
    public function edit(CandidateStatusWiseHomeContents $homeContent)
    {
        
        $data = array();

        $candidateStatusObject       = new CandidateStatus();
        
        $data['candidateStatuses']   = $candidateStatusObject->getCandidateStatus();
        $data['homeContent']        = $homeContent;

        return view('backend.home_content.edit')->with($data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CandidateStatusWiseHomeContents  $homeContent
     * @return \Illuminate\Http\Response
     */
    public function update(HomeContentRequest $request, CandidateStatusWiseHomeContents $homeContent)
    {
        $homeContent->update(array_merge($request->only('candidate_status_id','title', 'content'),[
            'updated_by' => auth()->id()
        ]));

        return redirect()->route('home_content.index')
        ->withSuccess(__('Home Content updated successfully.'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CandidateStatusWiseHomeContents  $homeContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(CandidateStatusWiseHomeContents $homeContent)
    {
        $homeContent->delete();

        return redirect()->route('home_content.index')
        ->withSuccess(__('Home Content deleted successfully.'));
    }
}
