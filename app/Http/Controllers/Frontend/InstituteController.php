<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institute;

class InstituteController extends Controller
{
    public function searchInstitutes(Request $request)
    {
        $institute = [];

        if($request->has('q')){
            $search = $request->q;
            $institute =Institute::select("id", "name")
                    ->where('name', 'LIKE', "%$search%")
                    ->where('is_enable','=',1)
                    ->get();
        }
        return response()->json($institute);
    }
}
