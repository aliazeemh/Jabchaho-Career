<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Http\Requests\Frontend\CandidateForgotPasswordRequest;
use App\Models\Candidate;
use App\Models\CandidatePasswordReset;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
class ForgotPasswordController extends Controller
{
    /**

     * Forget Password form.

     *

     * @return \Illuminate\Http\Response

     */

    public function forgotPasswordForm()
    {

        try
		{ 
            return view('frontend.auth.passwords.forgot');
        }catch(\Exception $e)
        {
            return $this->getCustomExceptionMessage($e);
        }	
        
    }

    /**
     * Handle account registration request
     *
     * @param CandidateForgotPasswordRequest $request
     *
     * @return \Illuminate\Http\Response
     */

    public function forgotPassword(CandidateForgotPasswordRequest $request)
    {
        try
		{
            $errorMessage = '';
            $email      		= $request->input('email');
            $candidateData      = Candidate::where('email', $email)->first();

            if(empty($candidateData))
            {
                $errorMessage	= 'Sorry, we were unable to locate this email in our database.';
            }
            else
            { 
                $token 				= Helper::generateAlphaNumeric(64).time();
                $candidateId = Arr::get($candidateData, 'id',0);
                if(!empty($candidateId))
                {
                    $token = $token.".".$candidateId;
                }

                $candidate    = CandidatePasswordReset::updateOrCreate( ['candidate_id' => $candidateId],['token'=>$token]);
                if($candidate)
                {
                    Mail::send('frontend.emails.forgotPassword', ['token' => $token,'fullName'=>$candidateData['full_name']], function($message) use($request){
                        $message->to($request->email);
                        $message->subject('Reset Password');
                    });

                    return redirect('/forgot-password')->with('success', "We have e-mailed your password reset link!");
                }else{
                    $errorMessage  = 'Unable to password reset. Please try again!';
                }
            }    

            return redirect('/forgot-password')->withInput()->withErrors(['error'=> $errorMessage]);


        }catch(\Exception $e)
		{
			return $this->getCustomExceptionMessage($e);
        }	    
    }
}
