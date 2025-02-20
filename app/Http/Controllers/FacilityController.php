<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //set for auth

use App\Facility;

class FacilityController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth')
        	 ->except('index');
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//$nav='';
		$data = [];
	    if(Auth::check())
	    {
	    	Auth::user()->hasAnyRole(['admin']);
		    $role = Auth::user()->roles()->first()->name;
		    //$nav = "{$role}.navbar";	  
		    //$facilities = Facility::orderBy('name','ASC')->ignoreDeleted()->get(); 
		    $facilities = Facility::orderBy('name','ASC')->ignoreDeleted()->has('classrooms')->get();
		    $data = [ 
			    "nav"		 => "{$role}.navbar",
			    "facilities" => $facilities
			];		    
	    }
		
        return view('facility.index',$data);
    }

	public function admin(){
		Auth::user()->hasAnyRole(['admin']);
	    $role = Auth::user()->roles()->first()->name;
	    //$nav = "{$role}.navbar";
	    $view = "facility.{$role}";
	    $facilities = Facility::orderBy('name','ASC')->ignoreDeleted()->has('classrooms')->get();
	    $data = [
		    "nav" 		 => "{$role}.navbar",
		    "facilities" => $facilities
	    ];
	    return view($view, $data);
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
