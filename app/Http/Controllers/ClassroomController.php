<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Facility;

class ClassroomController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
        	 //->except('index');
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
    
	public function facility($facility_id)
	{
		Auth::user()->hasAnyRole(['admin']);
	    $role = Auth::user()->roles()->first()->name;
	    $nav = "{$role}.navbar";
	    $view = "classroom.{$role}";
	    
	    //$facilities = Facility::orderBy('name','ASC')->ignoreDeleted()->get();
	    $facilities = Facility::orderBy('name','ASC')->ignoreDeleted()->has('classrooms')->get();
	    $data = [
		    'facility_id'=>$facility_id, 
		    'nav'=>$nav, 
		    'facilities'=>$facilities
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
