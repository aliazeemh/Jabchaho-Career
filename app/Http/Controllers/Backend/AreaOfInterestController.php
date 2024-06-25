<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AreaOfInterestGroup;
use App\Models\AreaOfInterestOption;
use App\Http\Requests\Backend\AreaOfInterestGroupRequest;
use App\Http\Requests\Backend\AreaOfInterestOptionRequest;
class AreaOfInterestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function groupIndex()
    {
        $areaOfInterestGroups = AreaOfInterestGroup::latest()->paginate(config('constants.per_page'));
        $data['booleanOptions']     = config('constants.boolean_options'); 
        $data['areaOfInterestGroups'] = $areaOfInterestGroups;

        return view('backend.area_of_interests.groups.index')->with($data);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function groupCreate()
    {
        $data['booleanOptions']     = config('constants.boolean_options'); 
        return view('backend.area_of_interests.groups.create')->with($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function groupStore(AreaOfInterestGroupRequest $request)
    {
        AreaOfInterestGroup::create(array_merge($request->only('name', 'is_enabled'),[
            'created_by' => auth()->id()
        ]));

        return redirect()->route('area_of_interest_groups.index')
            ->withSuccess(__('Area Of Interest Group created successfully.'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AreaOfInterestGroup  $areaOfInterestGroup
     * @return \Illuminate\Http\Response
     */
    public function groupEdit(AreaOfInterestGroup $areaOfInterestGroup)
    {
        $data['booleanOptions']     = config('constants.boolean_options'); 
        $data['areaOfInterestGroup'] = $areaOfInterestGroup;
        return view('backend.area_of_interests.groups.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AreaOfInterestGroup  $areaOfInterestGroup
     * @return \Illuminate\Http\Response
     */
    public function groupUpdate(AreaOfInterestGroupRequest $request, AreaOfInterestGroup $areaOfInterestGroup)
    {
        $areaOfInterestGroup->update(array_merge($request->only('name', 'is_enabled'),[
            'updated_by' => auth()->id()
        ]));

        return redirect()->route('area_of_interest_groups.index')
            ->withSuccess(__('Area Of Interest Group updated successfully.'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AreaOfInterestGroup  $areaOfInterestGroup
     * @return \Illuminate\Http\Response
     */
    public function groupDestroy(AreaOfInterestGroup $areaOfInterestGroup)
    {
        AreaOfInterestOption::where(['area_of_interest_group_id'=>$areaOfInterestGroup->id])->delete();
        $areaOfInterestGroup->delete();

        return redirect()->route('area_of_interest_groups.index')
            ->withSuccess(__('Area Of Interest Group deleted successfully.'));
    }


    //Options
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function optionIndex()
    {
        $areaOfInterestGroups = new AreaOfInterestGroup();

        $areaOfInterestOptions = $areaOfInterestGroups->getAreaOfInterestsOptionsWithGroupName();
        
        $data['booleanOptions']     = config('constants.boolean_options'); 
        $data['areaOfInterestOptions'] = $areaOfInterestOptions;

        return view('backend.area_of_interests.options.index')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function optionCreate()
    {
        $areaOfInterestGroups = AreaOfInterestGroup::select('id','name')->where(['is_enabled'=>1])->get();
        $data['booleanOptions']         = config('constants.boolean_options'); 
        $data['areaOfInterestGroups']   = $areaOfInterestGroups;
        return view('backend.area_of_interests.options.create')->with($data);
    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function optionStore(AreaOfInterestOptionRequest $request)
    {
        AreaOfInterestOption::create(array_merge($request->only('name', 'is_enabled','area_of_interest_group_id'),[
            'created_by' => auth()->id()
        ]));

        return redirect()->route('area_of_interest_options.index')
            ->withSuccess(__('Area Of Interest Option created successfully.'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AreaOfInterestOption  $areaOfInterestOption
     * @return \Illuminate\Http\Response
     */
    public function optionEdit(AreaOfInterestOption $areaOfInterestOption)
    {
        
        $areaOfInterestGroups           = AreaOfInterestGroup::select('id','name')->where(['is_enabled'=>1])->get();
        $data['booleanOptions']         = config('constants.boolean_options'); 
        $data['areaOfInterestGroups']   = $areaOfInterestGroups;
        $data['areaOfInterestOption']   = $areaOfInterestOption;
        
        return view('backend.area_of_interests.options.edit')->with($data);
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AreaOfInterestOption  $areaOfInterestOption
     * @return \Illuminate\Http\Response
     */
    public function optionUpdate(AreaOfInterestOptionRequest $request, AreaOfInterestOption $areaOfInterestOption)
    {
        $areaOfInterestOption->update(array_merge($request->only('name', 'is_enabled','area_of_interest_group_id'),[
            'updated_by' => auth()->id()
        ]));

        return redirect()->route('area_of_interest_options.index')
        ->withSuccess(__('Area Of Interest Option Updated successfully.'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AreaOfInterestOption  $areaOfInterestOption
     * @return \Illuminate\Http\Response
     */
    public function optionDestroy(AreaOfInterestOption $areaOfInterestOption)
    {
        $areaOfInterestOption->delete();

        return redirect()->route('area_of_interest_options.index')
            ->withSuccess(__('Area Of Interest Option deleted successfully.'));
    }

    


}
