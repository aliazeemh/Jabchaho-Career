<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Frontend\CandidateChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Models\Candidate;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    /**
     * Handle account registration request
     *
     * @param CandidateChangePasswordRequest $request
     *
     * @return \Illuminate\Http\Response
     */

    public function changePassword(CandidateChangePasswordRequest $request)
    {
        try
		{

            $validateValues = $request->validated();

            if (!empty($validateValues))
            {
                $newPassword = Arr::get($validateValues, 'new_password');
                $input['password']   = Hash::make($newPassword);
            
                $updatedPassword = Candidate::where(['id' => Auth::guard('candidate')->user()->id])->update($input);
                if($updatedPassword)
                { 
                    return response()->json(['success' => "Password has been changed Successfully!"]);
                }
                else
                {
                    return response()->json(['errors' => "Unable to changed password. Please try again!"]);
                } 
            }
            else
            {
                return response()->json(['errors' => "Whoops, looks like something went wrong."]);
            }
        
        }catch(\Exception $e)
		{
			return $this->getCustomExceptionMessage($e);
            
        }	    
    }
}
