<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Classroom;
use App\Http\Resources\Classroom as ClassroomResource;
use App\Facility;
use App\Http\Resources\Facility as FacilityResource;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($facility_id)
    {
	    
	    if($facility_id){
		    $classrooms = Classroom::where('facility_id', $facility_id)->orderBy('name', 'asc')->paginate(10);
	    } else {
		    $classrooms = Classroom::orderBy('facility_id')->paginate(10);
	    }
       				
		$classrooms->load('facility');
        return ClassroomResource::collection($classrooms);
        
        
        /*
	    //how to eager load related models via map
        $classrooms->map(function ($c) {			      
		     return $c->facility;
		});
        
        //how to eager load related model with ORM load method.  Then organize classrooms while grouped by facility
        $facility=Facility::findOrFail($facility_id)->load(['classrooms'=>function($query){$query->orderBy('name','desc');}]);
        //return new FacilityResource($facility);
        return ClassroomResource::collection($facility->classrooms);
        */
    }

	public function options($facility_id){
		if($facility_id){
		    $classrooms = Classroom::where('facility_id', $facility_id)->orderBy('name', 'asc')->get();
	    } else {
		    $classrooms = Classroom::orderBy('facility_id')->orderBy('name', 'asc')->get();
	    }
       				
		$classrooms->load('facility');
        return ClassroomResource::collection($classrooms);
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
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'facility_id' => 'required',           
        ]);
		
		if($validator->fails())
        {
	        $errors = [];
	        foreach($validator->errors()->all() as $sentence)
	        {
		        $words = explode(" ", $sentence);
		        $errors[trim($words[1])][] = $sentence;        
	        }
            //return response()->json(['errors'=>$validator->errors()->all()]);
            return response()->json(['errors'=>$errors]);
        }
              
        
        $classroom = $request->isMethod('put') ? Classroom::findOrFail($request->classroom_id) : new Classroom;
        
		$classroom->name = $request->input('name');
		$classroom->facility_id = $request->input('facility_id');
			
		if($request->isMethod('put'))
		{
			$classroom->id = $request->input('classroom_id');
		}
			
			
		if($classroom->save())
		{
			return new ClassroomResource($classroom);
		}                
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classroom = Classroom::findOrFail($id)->loadMissing('facility');
        return new ClassroomResource($classroom);
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
        $classroom = Classroom::findOrFail($id);
        if($classroom->delete()){
	        return new ClassroomResource($classroom);
        }
    }
}
