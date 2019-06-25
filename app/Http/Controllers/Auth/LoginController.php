<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request; //used to overwrite authenticated
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


/*
	Original method:
	/vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php
	
	If NOT overwriting authenticated then remove this method along with use above:
	use use Illuminate\Http\Request;
*/
protected function authenticated(Request $request, $user)
{
	 //$request->session()->invalidate();
	 //redirect()->route('home');
	if ( $user->guardian->is_admin==0 ) 
	{
		// do your margic here
		if(preg_match('/checkin-login/', $_SERVER['HTTP_REFERER']))
		{
			return redirect()->action('GuardianController@checkin',['id'=>$user->guardian->id]);
		}		
	}
	
	return redirect('/home');
}


    /**
     * Where to redirect users after login.
     *
     * @var string
     
    protected $redirectTo = '/home';
	*/
	
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    protected function showCheckinLoginForm(){
	    //$carriers = DB::table('carriers')->get();
		return view('auth.checkin-login');
    }
    protected function checkinLogin(Request $request){
	    
	    
	    
    }
}
