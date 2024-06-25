<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SkillSet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Http\Requests\Backend\SkillSetRequest;

class SkillSetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $filterData = array();
        
        $name        = $request->query('name');
        $isViewable  = $request->query('is_viewable');

        $filterData['name']                     = $name;
        $filterData['isViewable']              = $isViewable;

        $searchCondition = array();
        if(!empty($name)){
            $searchCondition['name'] = $name;
        }

        if(isset($isViewable)){
            $searchCondition['is_viewable'] = $isViewable;
        }
        
        $skillSets = SkillSet::where($searchCondition)->latest()->paginate(config('constants.per_page'));
        $data['skillSets'] = $skillSets;
        $data['booleanOptions']     = config('constants.boolean_options'); 
        return view('backend.skill_sets.index')->with($data)->with($filterData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['booleanOptions']     = config('constants.boolean_options'); 
        return view('backend.skill_sets.create')->with($data);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SkillSetRequest $request)
    {
        SkillSet::create(array_merge($request->only('name','description','is_viewable'),[
            'created_by' => auth()->id()
        ]));

        return redirect()->route('skill_sets.index')
            ->withSuccess(__('Skill Set created successfully.'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SkillSet  $skillSet
     * @return \Illuminate\Http\Response
     */
    public function edit(SkillSet $skillSet)
    {
        $data['skillSet'] = $skillSet;
        $data['booleanOptions']     = config('constants.boolean_options'); 
        return view('backend.skill_sets.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SkillSet  $skillSet
     * @return \Illuminate\Http\Response
     */
    public function update(SkillSetRequest $request, SkillSet $skillSet)
    {
        $skillSet->update(array_merge($request->only('name','description','is_viewable'),[
            'updated_by' => auth()->id()
        ]));

        return redirect()->route('skill_sets.index')
            ->withSuccess(__('Skill Set updated successfully.'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SkillSet  $skillSet
     * @return \Illuminate\Http\Response
     */
    public function destroy(SkillSet $skillSet)
    {
        $skillSet->delete();

        return redirect()->route('skill_sets.index')
            ->withSuccess(__('Skill Set deleted successfully.'));
    }


}
