<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Frontend\CandidateSigninRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class SigninController extends Controller
{
   /**
     * Display register Form.
     *
     * @return \Illuminate\Http\Response
     */
    public function signinForm()
    {
        try
		{
            return view('frontend.auth.signin');
        }catch(\Exception $e)
		{
			return $this->getCustomExceptionMessage($e);
        }	     
    }

    /**
     * Handle account registration request
     *
     * @param CandidateSigninRequest $request
     *
     * @return \Illuminate\Http\Response
     */

    public function signin(CandidateSigninRequest $request)
    {
        try
		{
            $input = $request->all();
            $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';
            //$credentials = $request->only('email', 'password');
            $credentials = array(
                $fieldType => $input['email'],
                'password' => $input['password']
            );

            if (Auth::guard('candidate')->attempt($credentials))
            {
                if(!empty(Session::get('lastUrl'))){
                    return redirect(Session::get('lastUrl'));
                }else{
                    return redirect('/home');
                }
                
            }
            return redirect()->action([SigninController::class , 'signin'])
            ->withInput()->withErrors(['error' => 'These credentials do not match our records.!']);
        }catch(\Exception $e)
		{
			return $this->getCustomExceptionMessage($e);
        }	    
    }
}
