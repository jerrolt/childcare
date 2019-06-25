<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Facility;
use App\Http\Resources\Facility as FacilityResource;

use App\Classroom;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$facilities = Facility::ignoreDeleted()->paginate(10);
		$facilities->load('classrooms');
		$facilities->load('students');
		$facilities->load('timecards');
        return FacilityResource::collection($facilities);
    }

    /**
	 *  full list for FORM dropdown select options
	 */
	public function options(){
		$facilities = Facility::orderBy('name','ASC')->ignoreDeleted()->get();
		return FacilityResource::collection($facilities);
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
            'name' => 'required|min:3|max:50',
            'address' => 'required|max:50',
            'city' => 'required|min:3|max:25',
            'state' => 'required|min:2|max:2',
            'zipcode' => 'required|min:5|max:15',
            'phone' => 'required|min:10|max:20'            
        ]);
        
        if($validator->fails())
        {
	        $errors = [];
	        foreach($validator->errors()->all() as $sentence)
	        {
		        $words = explode(" ", $sentence);
		        $errors[trim($words[1])][] = $sentence;        
	        }
            return response()->json(['errors'=>$errors]);
        }
                
        $facility = $request->isMethod('put') ? Facility::findOrFail($request->facility_id) : new Facility;
        if($request->isMethod('put'))
        {			
	        $facility->id = $request->input('facility_id');
	        $facility->name = $request->input('name');			
			$facility->address = $request->input('address');
			$facility->city = $request->input('city');
			$facility->state = $request->input('state');				
			$facility->zipcode = $request->input('zipcode');
			$facility->phone = $request->input('phone');
			$facility->carrier_id = $request->input('carrier_id');
        }
        if($request->isMethod('post'))
        {
	        $facility->name = $request->input('name');			
			$facility->address = $request->input('address');
			$facility->city = $request->input('city');
			$facility->state = $request->input('state');				
			$facility->zipcode = $request->input('zipcode');
			$facility->phone = $request->input('phone');
			$facility->carrier_id = $request->input('carrier_id');
        }
        if($facility->save())
		{
			return new FacilityResource($facility);
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
		$facility = Facility::findOrFail($id);
		return new FacilityResource($facility);
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
        $facility = Facility::findOrFail($id);
        $facility->deleted_at = date('Y-m-d H:i:s');
        if($facility->save())
		{
			return new FacilityResource($facility);
		}
    }
}
