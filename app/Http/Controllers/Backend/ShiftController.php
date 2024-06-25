<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Http\Requests\Backend\ShiftRequest;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['shifts'] = Shift::latest()->paginate(config('constants.per_page'));
        $data['booleanOptions']     = config('constants.boolean_options'); 
        return view('backend.shifts.index')->with($data);
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
        $data['timeSlots']             = config('constants.time_slots');   
        return view('backend.shifts.create')->with($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShiftRequest $request)
    {
        Shift::create(array_merge($request->only('name', 'from', 'to','is_enabled'),[
            'created_by' => auth()->id()
        ]));

        return redirect()->route('shifts.index')
            ->withSuccess(__('Shifts created successfully.'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        $data['booleanOptions']     = config('constants.boolean_options'); 
        $data['timeSlots']          = config('constants.time_slots');  
        $data['shift']              = $shift;   
        return view('backend.shifts.show')->with($data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function edit(Shift $shift)
    {
        $data['booleanOptions']     = config('constants.boolean_options'); 
        $data['timeSlots']          = config('constants.time_slots');  
        $data['shift']              = $shift;   
        return view('backend.shifts.edit')->with($data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shift  $Shift
     * @return \Illuminate\Http\Response
     */
    public function update(ShiftRequest $request, Shift $shift)
    {
        $shift->update(array_merge($request->only('name', 'from', 'to','is_enabled'),[
            'updated_by' => auth()->id()
        ]));

        return redirect()->route('shifts.index')
            ->withSuccess(__('Shift updated successfully.'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shift $shift)
    {
        $shift->delete();

        return redirect()->route('shifts.index')
            ->withSuccess(__('Shift deleted successfully.'));
    }

}
