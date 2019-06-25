<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Guardian;

use App\Carrier; //new
use Illuminate\Support\Facades\DB;//new


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
           // 'mi' => 'string|max:1', new
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            
            //new
            'phone' => 'required|string|min:10|max:15'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            //'name' => $data['name'],
            'firstname' => $data['firstname'],
            'lastname'  => $data['lastname'],
            //'mi'        => $data['mi'], new
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            
            //new
            'phone' => $data['phone'],
            'account_number' => preg_replace("/[^a-zA-Z0-9]+/", "", $data['phone']),
            
            'status' => 'pending'
        ]);        
        $user->roles()->attach(Role::where('name','guardian')->first());
        
        /** NEW - Create a guardian record for the registered user **/
        $guardian = new Guardian;
        $guardian->firstname = $data['firstname'];
		$guardian->lastname = $data['lastname'];
		//$guardian->mi = $request->input('mi');				
		//$guardian->suffix = $request->input('suffix');			
		//$guardian->address = $request->input('address');
		//$guardian->city = $request->input('city');
		//$guardian->state = $request->input('state');				
		//$guardian->zipcode = $request->input('zipcode');
		//$phone = preg_replace("/[^a-zA-Z0-9]+/", "", $request->input('phone'));
		$guardian->phone = $data['phone'];				
		//$guardian->phone_carrier = $request->input('phone_carrier');
		$guardian->carrier_id = $data['carrier_id']; //required for guarian
        $guardian->user()->associate($user);
        $guardian->save();
        return $user;
    }
    
    
    /**
	 *  Custom registration form/view for Guardian
	 *
	 *  https://laracasts.com/discuss/channels/laravel/laravel-55-how-to-add-dropdown-menu-to-authregister
	 *	https://laracasts.com/discuss/channels/laravel/change-the-loginregister-url-in-laravel-55?page=0
	 *
	 */
	protected function showRegistrationForm()
	{
		$carriers = DB::table('carriers')->get();
		return view('auth.register', ['carriers' => $carriers]);
	} 
	 
	 
	 
	 
}
