<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Companies;

class CompanyController extends Controller
{
    public function searchCompanies(Request $request)
    {
        $company = [];

        if($request->has('q')){
            $search = $request->q;
            $company =Companies::select("id", "name")
                    ->where('name', 'LIKE', "%$search%")
                    ->where('is_enable','=',1)
                    ->get();
        }
        return response()->json($company);
    }
}
