<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobTitle;

class JobTitleController extends Controller
{
    public function searchjobTitle(Request $request)
    {
        $jobTitle = [];

        if($request->has('q')){
            $search = $request->q;
            $jobTitle =JobTitle::select("id", "name")
                    ->where('name', 'LIKE', "%$search%")
                    ->where('is_enable','=',1)
                    ->get();
        }
        return response()->json($jobTitle);
    }
}
