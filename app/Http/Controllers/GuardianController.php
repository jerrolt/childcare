<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//use App\User;
use App\Guardian;
use App\Facility;

class GuardianController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth')
        	 ->except('index','scan','tmp','fplogin','checkin','identify');
    }
		



    /**
     * Guardian CRUD Management Tool - Admin Scope. 
     *
     * @return \Illuminate\Http\Response
     */
	public function admin(){
	    Auth::user()->hasAnyRole(['admin']);
	    $role = Auth::user()->roles()->first()->name;
	    $view = "guardian.{$role}";
	    $facilities = Facility::orderBy('name','ASC')->ignoreDeleted()->has('classrooms')->get();
	    $data = [
		    "nav" 		 => "{$role}.navbar",
		    "facilities" => $facilities
	    ];
	    return view($view, $data);		
	}
	
    /**
     * Authenticated guardian's list of children(students)
     * 
     * @return \Illuminate\Http\Response
     */	
    public function students(){
	    $user = Auth::user();
	    //echo  $user->hasAnyRole(['guardian']); die();
	    $role = $user->roles()->first()->name;
	    $guardian=Guardian::where('user_id',$user->id)->first();	   
	    $view = "guardian.student";	    	    	    
	    $data = [
			'nav'		  => "{$role}.navbar",
			'guardian_id' => $guardian->id
		];							
		return view($view, $data);		
    }

    /**
     * Fingerprint Scanner UI - utility/tool
     *   -loaded in iframe
     * @return \Illuminate\Http\Response
     */
	public function scan($guardian_id){
		$view = "guardian.scan";
		$data = [
		    "guardian_id"  => $guardian_id
		];
		return view($view, $data);
	}






	/**
	 *
	 *  Remove after testing fingerprint scanner
	 *
	 */
	public function tmp($guardian_id){
		$view = "tmp.body";
		$data = [
		    "guardian_id"  => $guardian_id
		];
		return view($view, $data);
	}



	public function identify() {
		$view = "auth.identify";
		return view($view,['nav'=>'']);
	}




    /**
     * Fingerprint Scanner UI - admin utility/tool used to add/edit a guardians fingerprint.  Used 
     *		when a new guardian has been added or getting an updated fingerprint scan
     *		-loaded in iframe
     *   
     * @return \Illuminate\Http\Response
     */
	public function fplogin(){
		$view = "auth.fplogin";
		return view($view,['nav'=>'']);	
	}
	
	
    /**
     * checkin - get the guardian object and render the checkin view 
     * 		displayed when guardian scans fingerprint to checkin a kid
     *
	 * @param  int  $guardian_id
	 *
     * @return \Illuminate\Http\Response
     */
	public function checkin($guardian_id){					
		$guardian  	 = Guardian::findOrFail($guardian_id);
		
/*		
		//UNCOMMENT LIVE/PRODUCTION 
		//COMMENT OUT IN DEV or TEST
		
	    if(!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], "/guardian/fingerprint-login") === false)
	    {
			header("Location: /guardian/fingerprint-login");
			die();
	    }
*/
		$data = [
			'nav'		  => '',
			'guardian_id' => $guardian_id,
			'role'		  => $guardian->user->roles()->first()->name,
			'layout' 	  => 'layouts.modal'
		];			
		
		
		$view = "guardian.checkin";
		return view($view, $data);
	}
	
	
	
	
	
	
	
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }	
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    

}
