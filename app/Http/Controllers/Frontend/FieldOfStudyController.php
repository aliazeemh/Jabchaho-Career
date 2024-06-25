<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FieldOfStudy;

class FieldOfStudyController extends Controller
{
    public function searchFieldOfStudy(Request $request)
    {
        $fieldOfStudy = [];

        if($request->has('q')){
            $search = $request->q;
            $fieldOfStudy =FieldOfStudy::select("id", "name")
                    ->where('name', 'LIKE', "%$search%")
                    ->where('is_enable','=',1)
                    ->get();
        }
        return response()->json($fieldOfStudy);
    }
}
