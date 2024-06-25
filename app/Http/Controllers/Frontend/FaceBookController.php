<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class FaceBookController extends Controller
{
    /**
     * Login Using Facebook
     */
    public function loginUsingFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callbackFromFacebook(Request $request)
    {
        try 
        {
            #if there is any error then redirect to sign in page.
            if ($request->has('error') || $request->has('error_code')) 
            {
                return redirect(route('signin.show'))->withErrors(['error' => "Something went wrong. Please try again later!"]);
            }
             
            $socialiteUser = Socialite::driver('facebook')->stateless()->user();

            if (!empty($socialiteUser)) 
            {
                //put value in session google_id && socialiteUser data
                \Session::put('socialiteField', 'facebook_id');
                \Session::put('socialiteUser', $socialiteUser);
                
                return redirect(route('candidate.essential.profile')); 

                
            } else 
            {
                return redirect()->route('signin.show')->withErrors(['error' => "Unable to find User. Please try again!"]);
            }

        }  
        catch(\Exception $e)
        {
            return redirect(route('signin.show'))->withErrors(['error' => "Something went wrong. Please try again later!"]);
        }
    }
}
