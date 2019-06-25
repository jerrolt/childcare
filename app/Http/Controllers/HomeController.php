<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //set for auth

//use Illuminate\Support\Facades\DB;

use App\User;
use App\Guardian;
use App\Facility;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $nav='';
	    $view = 'home'; //default is home.blade.php
		    
	    if(Auth::check())
	    {
	    	Auth::user()->hasAnyRole(['admin','guardian']);
		    $role = Auth::user()->roles()->first()->name;
		    $facilities = Facility::orderBy('name','ASC')->ignoreDeleted()->has('classrooms')->get();
		    
		    $data = [
			    "nav" 		 => "{$role}.navbar",
			    "facilities" => $facilities,
			    "user_id"=>Auth::user()->id
		    ];
		    		    
		    switch($role){
			    case 'admin':   
			    
			    	//old   
			    	$view = "admin.dashboard";
			    	
			    	//new
			    	/*
			    	$view = "guardian.checkin";
			    	$data['guardian_id'] = Auth::user()->guardian->id;
			    	$data['role'] = $role;
			    	$data['layout'] = 'layouts.app';
			    	*/
			    	break;
			    
			    case 'guardian':  
			    				    				    	
			    	//old
			    	//$view = "guardian.dashboard";
			    	//$data['guardian_id'] = Auth::user()->guardian->id;
			    	
			    	//new - show em the guardian/checkin/{id}
			    	$view = "guardian.checkin";
			    	$data['guardian_id'] = Auth::user()->guardian->id;
			    	$data['role'] = $role;
			    	$data['layout'] = 'layouts.app';
			    	
			    	break;
		    } 
	    }
	    

	    
	    return view($view, $data);
    }
}
