<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FacilityGroup;
use App\Models\FacilityOption;
use App\Http\Requests\Backend\FacilityGroupRequest;
use App\Http\Requests\Backend\FacilityOptionRequest;
class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function groupIndex()
    {
        $facilityGroups = FacilityGroup::latest()->paginate(config('constants.per_page'));
        $data['booleanOptions']     = config('constants.boolean_options'); 
        $data['facilityGroups'] = $facilityGroups;

        return view('backend.facilities.groups.index')->with($data);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function groupCreate()
    {
        $data['booleanOptions']     = config('constants.boolean_options'); 
        return view('backend.facilities.groups.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function groupStore(FacilityGroupRequest $request)
    {
        FacilityGroup::create(array_merge($request->only('name', 'is_enabled'),[
            'created_by' => auth()->id()
        ]));

        return redirect()->route('facility_groups.index')
            ->withSuccess(__('Facility Group created successfully.'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FacilityGroup  $facilityGroup
     * @return \Illuminate\Http\Response
     */
    public function groupEdit(FacilityGroup $facilityGroup)
    {
        $data['booleanOptions']     = config('constants.boolean_options'); 
        $data['facilityGroup'] = $facilityGroup;
        return view('backend.facilities.groups.edit')->with($data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FacilityGroup  $facilityGroup
     * @return \Illuminate\Http\Response
     */
    public function groupUpdate(FacilityGroupRequest $request, FacilityGroup $facilityGroup)
    {
        $facilityGroup->update(array_merge($request->only('name', 'is_enabled'),[
            'updated_by' => auth()->id()
        ]));

        return redirect()->route('facility_groups.index')
            ->withSuccess(__('Facility Group updated successfully.'));
    }


    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacilityGroup  $facilityGroup
     * @return \Illuminate\Http\Response
     */
    public function groupDestroy(FacilityGroup $facilityGroup)
    {
        FacilityOption::where(['facility_group_id'=>$facilityGroup->id])->delete();
        $facilityGroup->delete();

        return redirect()->route('facility_groups.index')
            ->withSuccess(__('Facility Group deleted successfully.'));
    }

     //Options


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function optionIndex()
    {
        $facilityGroup = new FacilityGroup();

        $facilityOptions = $facilityGroup->getfacilitiesOptionsWithGroupName();
        
        $data['booleanOptions']     = config('constants.boolean_options'); 
        $data['facilityOptions'] = $facilityOptions;

        return view('backend.facilities.options.index')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function optionCreate()
    {
        $facilityGroups = FacilityGroup::select('id','name')->where(['is_enabled'=>1])->get();
        $data['booleanOptions']         = config('constants.boolean_options'); 
        $data['facilityGroups']         = $facilityGroups;
        return view('backend.facilities.options.create')->with($data);
    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function optionStore(FacilityOptionRequest $request)
    {
        FacilityOption::create(array_merge($request->only('name', 'is_enabled','facility_group_id'),[
            'created_by' => auth()->id()
        ]));

        return redirect()->route('facility_options.index')
            ->withSuccess(__('Facility Option created successfully.'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FacilityOption  $facilityOption
     * @return \Illuminate\Http\Response
     */
    public function optionEdit(FacilityOption $facilityOption)
    {
        
        $facilityGroups                 = FacilityGroup::select('id','name')->where(['is_enabled'=>1])->get();
        $data['booleanOptions']         = config('constants.boolean_options'); 
        $data['facilityGroups']         = $facilityGroups;
        $data['facilityOption']         = $facilityOption;
        
        return view('backend.facilities.options.edit')->with($data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FacilityOption  $facilityOption
     * @return \Illuminate\Http\Response
     */
    public function optionUpdate(FacilityOptionRequest $request, FacilityOption $facilityOption)
    {
        $facilityOption->update(array_merge($request->only('name', 'is_enabled','area_of_interest_group_id'),[
            'updated_by' => auth()->id()
        ]));

        return redirect()->route('facility_options.index')
        ->withSuccess(__('Facility Option Updated successfully.'));
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacilityOption  $facilityOption
     * @return \Illuminate\Http\Response
     */
    public function optionDestroy(FacilityOption $facilityOption)
    {
        $facilityOption->delete();

        return redirect()->route('facility_options.index')
            ->withSuccess(__('Facility Option deleted successfully.'));
    }



}
