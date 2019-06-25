<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Timecard;
use App\Http\Resources\Timecard as TimecardResource;

use App\TimecardChange;
use App\Http\Resources\TimecardChange as TimecardChangeResource;

use App\Guardian;
use App\Http\Resources\Guardian as GuardianResource;

use App\User;
use App\Student;
use App\Http\Resources\Student as StudentResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

//Mail and Txt messaging
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentDropoff;
use App\Mail\StudentPickup;

class TimecardController extends Controller
{
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
     * List of Timecards 
     *
     * @return \Illuminate\Http\Response
     
    public function report(Request $request)
    {
	    $timecards = [];		
		if(isset($request->students) && !empty($request->students))
		{
			$timecards = Timecard::whereRaw("DATE(action_at) >= '{$request->from}' AND DATE(action_at) <= '{$request->to}' AND student_id IN(".join(',',$request->students).")")->orderBy('student_id','ASC')->orderBy('action_at','ASC')->get();
		}
		else  
		{
			$timecards = Timecard::whereRaw("DATE(action_at) >= '{$request->from}' AND DATE(action_at) <= '{$request->to}'")->orderBy('student_id','ASC')->orderBy('action_at','ASC')->get();
		}	
		$timecards->load('guardian')->load('student')->load('facility');
		
		foreach($timecards as $k=>$tc)
		{
			$timecards[$k]->action_at=date('m/d/Y g:i a',strtotime($tc->action_at));
		}
			
		return TimecardResource::collection($timecards);
    }
***/

	/** 
	 *	Period summary - TESTing
	 */
	//public function block_report($from,$to,$students){
	public function block_report(Request $request)
	{ 		
		$blocks = []; //timecards within one attendance cycle.  (checkin - checkout cycle)
		$timecards = [];
		$fields = [
			'timecards.*', 
			DB::raw("CONCAT(guardians.firstname,' ',guardians.lastname) AS guardian_name"),
			'facilities.name AS facility_name'
		];
		

		
		$query = Timecard::select($fields)
			->join('guardians', 'guardians.id', '=', 'timecards.guardian_id')
			->join('facilities', 'facilities.id', '=', 'timecards.facility_id')
			
			//->where('confirmed_by','>',0)
			
			->whereDate('action_at', '>=', $request->from)
			->whereDate('action_at', '<=', $request->to);
		if(isset($request->students) && !empty($request->students))
		{	
			//$student_ids = explode('-',$students);
			//$query = $query->whereIn('student_id', $student_ids);
			$query = $query->whereIn('student_id', $request->students);
		}
		$timecards = $query->orderBy('student_id')
			->orderBy('action_at','DESC')
			->get();
				
		$block = [
			'student'    => null,
			'checkin'    => null,
			'checkout'   => null,
			'activities' => [],
			'time'       => null,
			'total'      => 0
		];
		
		$from = $to = time();
		
		//new
		$total = 0;  //new
		//new
		
		foreach($timecards as $timecard)
		{
			$block['student'] = $timecard->student;
			if($timecard->is_checkin)
			{
				if($timecard->confirmed_at!=null)
				{
												
					$from = strtotime($timecard->action_at);
					$tl = $to - $from;//new
					$block['time'] = $this->time_elapsed($tl);//$tl new
					
					//new
					$total = $total + $tl; //new
					//print "TimeDiff:{$tl} -- LineTotal:{$total}\n";
					//new
					
					$block['checkin'] = $timecard;
					$blocks[] = $block; //add to chain of blocks
					$block = [
						'student'    => null,
						'checkin'    => null,
						'checkout'   => null,
						'activities' => [],
						'time'       => null,
						'total'      => 0
					];
					$from = $to = time();
				}
			}			
			elseif($timecard->is_checkout)
			{
				$block['checkout'] = $timecard;
				$to = strtotime($timecard->action_at);
			}
			else{
				$block['activities'][] = $timecard;
			}			
		}

		//list($date, $time) = explode($timecard->action_at);
		//$time = date('Y-m-d',strtotime($timecard->action_at));
/**
Total HOURS: 36.028888888889
Total Minutes: 1.7333333333333
TOTAL DIFF:129704 -- 12h 1m

		//new - set and totals
		$totalhours = $total / 3600;
		$totalminutes = (($total % 3600) / 60);
		$totalsecs = (($total % 3600) % 60);
		print "Total HOURS: {$totalhours}\n";
		print "Total Minutes: {$totalminutes}\n";
		print "Total Secs: {$totalsecs}\n";
		
		print "TOTAL DIFF:{$total} -- " . $this->time_elapsed_no_days($total) ."\n";
		die();
		**/
		
		//new
		/*
		if(count($timecards)>0)
		{
			$blocks[0]['total'] = $this->time_elapsed_no_days($total); //new
		}	
		else 
		{
			$blocks[] = ['total'=>0];
			//array_push($blocks, ['total'=>0]);
		}	
		//new
		*/
		if($total > 60) //more than a minute
		{
			$resp = [
				'total' => $this->time_elapsed_no_days($total),
				'blocks' => $blocks
			];
		}
		else
		{
			$resp = [
				'total' => $this->time_elapsed_no_days(0),
				'blocks' => $blocks
			];
		}
		
		
		//return response()->json($blocks);
		return response()->json($resp);
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
	    //print "<pre>".print_r($request,1)."</pre>";die();
	  
        $timecard = new Timecard();	        
		$timecard->guardian_id = $request->guardian_id;		
		$timecard->student_id  = $request->student_id;				
		$timecard->facility_id = $request->facility_id;
		$timecard->action_at   = date('Y-m-d H:i:s');
		$timecard->is_checkin  = ($request->action=='checkin') ? '1' : '0';
		$timecard->is_checkout = ($request->action=='checkout') ? '1' : '0';		
		$timecard->notes       = strlen($request->notes)>0 ? $request->notes : '';
		
		  
		//NEW - IF admin just confirm the action ELSE set defaults
	    $guardian = Guardian::findOrFail($request->guardian_id);
		if($guardian->user->roles()->first()->name == 'admin' && $timecard->is_checkin)
		{
			$timecard->confirmed_at = $timecard->action_at;
			$timecard->confirmed_by = $guardian->user->id;
		}
		//echo "IM HERE YO";
       //die();
		if(isset($request->confirmed_by))
		{
			$guardian = Guardian::findOrFail($request->confirmed_by);
			if($guardian->user->roles()->first()->name == 'admin')
			{
				$timecard->confirmed_at = $timecard->action_at;
				$timecard->confirmed_by = $guardian->user->id;
			}
		}
   
       
        if($timecard->save())
		{
			switch($request->action)
			{
				case 'checkin': 
					Mail::to($timecard->guardian->getMsgAddress())->send(new StudentDropoff($timecard));
					break;
								
				case 'checkout':
					Mail::to($timecard->guardian->getMsgAddress())->send(new StudentPickup($timecard));
					break;
			}
			
			return new TimecardResource($timecard);
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
        $timecard = Timecard::findOrFail($id);
        $timecard->load('guardian')->load('student')->load('facility');
        return new TimecardResource($timecard);
    }
    
    /**
     * Save changes to Timecard entry
     *
     * @param  Request $request
     * @return TimecardChangeResource
     */    
	public function save(Request $request)
	{
		$timecard = Timecard::findOrFail($request->timecard_id);
		
		//confirm the request
		if($request->action=="confirm")
		{
			$timecard_old = "{'guardian_id':'".$timecard->guardian_id."','facility_id':'".$timecard->facility_id."','student_id':'".$timecard->student_id."','action_at':'".$timecard->action_at."','is_checkin':'".$timecard->is_checkin."','is_checkout':'".$timecard->is_checkout."','confirmed_at':'".$timecard->confirmed_at."','confirmed_by':'".$timecard->confirmed_by."'}";
		
			$timecard->id = $request->timecard_id;
			$timecard->guardian_id = $request->guardian_id;
			$timecard->facility_id = $request->facility_id;
			$timecard->action_at = date('Y-m-d H:i:s',strtotime($request->action_at));
			
			$timecard->confirmed_at = date('Y-m-d H:i:s',time());
			$timecard->confirmed_by = $request->confirmed_by;
			if($timecard->save())
			{
				//return new TimecardResource($timecard);
				$timecard_new = "{'guardian_id':'".$timecard->guardian_id."','facility_id':'".$timecard->facility_id."','student_id':'".$timecard->student_id."','action_at':'".$timecard->action_at."','is_checkin':'".$timecard->is_checkin."','is_checkout':'".$timecard->is_checkout."','confirmed_at':'".$timecard->confirmed_at."','confirmed_by':'".$timecard->confirmed_by."'}";
			}
		
		
			$changes = new TimecardChange();
			$changes->timecard_id = $request->timecard_id;
			$changes->user_id = $request->confirmed_by;
			$changes->timecard_old = $timecard_old;
			$changes->timecard_new = $timecard_new;
			if($changes->save()){
				return new TimecardChangeResource($changes);
			}
			//echo "<pre>".print_r($timecard,1)."</pre>";
			//die();
		}
		
		
		else
		{
				
		
			$timecard_old = "{'guardian_id':'".$timecard->guardian_id."','facility_id':'".$timecard->facility_id."','student_id':'".$timecard->student_id."','action_at':'".$timecard->action_at."','is_checkin':'".$timecard->is_checkin."','is_checkout':'".$timecard->is_checkout."','confirmed_at':'".$timecard->confirmed_at."','confirmed_by':'".$timecard->confirmed_by."'}";
			
			$timecard->id = $request->timecard_id;
			$timecard->guardian_id = $request->guardian_id;
			$timecard->facility_id = $request->facility_id;
			$timecard->action_at = date('Y-m-d H:i:s',strtotime($request->action_at));
			if($timecard->save())
			{
				//return new TimecardResource($timecard);
				$timecard_new = "{'guardian_id':'".$timecard->guardian_id."','facility_id':'".$timecard->facility_id."','student_id':'".$timecard->student_id."','action_at':'".$timecard->action_at."','is_checkin':'".$timecard->is_checkin."','is_checkout':'".$timecard->is_checkout."','confirmed_at':'".$timecard->confirmed_at."','confirmed_by':'".$timecard->confirmed_by."'}";
			}
		
		
			$changes = new TimecardChange();
			$changes->timecard_id = $request->timecard_id;
			$changes->user_id = $request->user_id;
			$changes->timecard_old = $timecard_old;
			$changes->timecard_new = $timecard_new;
			if($changes->save()){
				return new TimecardChangeResource($changes);
			}
		}
		
		
		
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
	 * time_elapsed - calculate a time gap (hours and minutes passed) 
	 * based on the seconds provided.
	 *
	 * @param   int       $secs
	 * @return  string 
	 **/ 
	protected function time_elapsed($secs)
	{
		$ret = [];
	    $bit = array(
	        'h' => $secs / 3600 % 24,
	        'm' => $secs / 60 % 60
	    );	
	    
	    
	    //handle cases where total time is 1m.  If $secs < 60 && $secs > 0
	    if(!count($ret) && $secs < 60)
        {
	        $ret[] = '1m';
        } 
               
	    foreach($bit as $k => $v)
	    {
			if($v > 0)
	        { 
	        	$ret[] = $v . $k;
	        }  	        
	    }	       	        
	    return join(' ', $ret);
    }
 
	protected function time_elapsed_no_days($secs)
	{
		$ret = [];
	    $bit = array(
	        'Hrs' => floor($secs / 3600),
	        'Mins' => $secs / 60 % 60
	    );	
	    
	    
	    //handle cases where total time is 1m.  If $secs < 60 && $secs > 0
	    if(!count($ret) && $secs < 60)
        {
	        $ret[] = '0m';
        } 
               
	    foreach($bit as $k => $v)
	    {
			if($v > 0)
	        { 
	        	$ret[] = $v . " ".$k;
	        }  	        
	    }	       	        
	    return join(' - ', $ret);
    } 
 
    
    
    
	public function guardian_summary($guardian_id)
	{
		$data = [];
		$date = date('Y-m-d');
		$total_in = 0;  //running total of students activily checked in
		
		$guardian = Guardian::findOrFail($guardian_id); 
		foreach($guardian->students as $s)
		{
			$ids[] = $s->id;
		}
		
		
		     
        
		$timecards = Student::select('*')->leftJoin('timecards', function($join){
			$join->on('students.id','=','timecards.student_id');
		})
		->whereRaw("DATE(timecards.action_at) = '{$date}' AND (timecards.is_checkin=1 OR timecards.is_checkout=1) AND students.id IN(".join(',',$ids).")")	
		->orderBy('timecards.student_id', 'ASC')
		->orderBy('timecards.action_at','DESC')
		->get();
		
		
		foreach($timecards as $tc)
		{
			
					if(!isset($data[$tc->student_id]))
						$data[$tc->student_id] = [];

					if($tc->is_checkout)
					{ 
						if(isset($data[$tc->student_id]['status']))
						{
							$data[$tc->student_id]['timecards'][] = $tc;
						}
						else 
						{
							$data[$tc->student_id] = [
								'name' => $tc->firstname." ".$tc->lastname,
								'status' => 'out', 
								'facility'=>$tc->facility, 
								'timecards'=>[]
							];
							$data[$tc->student_id]['timecards'][] = $tc;
						}
						//continue;
					}
					
					if($tc->is_checkin)
					{
						if(isset($data[$tc->student_id]['status']))
						{
							$data[$tc->student_id]['timecards'][] = $tc;							
						} 
						else 
						{
							$data[$tc->student_id] = [
								'name' => $tc->firstname." ".$tc->lastname,
								'status' => 'in', 
								'facility'=>$tc->facility, 
								'timecards'=>[]
							];
							$data[$tc->student_id]['timecards'][] = $tc;
							
							//NEW
							$total_in += 1;
						}
						//break;
					}
		}
		
		//NEW calculate checked in time total for all students
		foreach($data as $student_id=>$student_data)
		{
			if($student_data['status']=='in')
			{
				$duration_secs = time() - strtotime($student_data['timecards'][0]->action_at);				
				$data[$student_id]['total'] = $this->time_elapsed($duration_secs);
				$data[$student_id]['timecards'][0]->action_at = date_format(date_create($student_data['timecards'][0]->action_at),"h:i A");
			}
			else //out
			{
				$duration_secs = strtotime($student_data['timecards'][0]->action_at) - strtotime($student_data['timecards'][1]->action_at);
				$data[$student_id]['total'] = $this->time_elapsed($duration_secs);
				
				$data[$student_id]['timecards'][0]->action_at = date_format(date_create($student_data['timecards'][0]->action_at),"h:i A");
				$data[$student_id]['timecards'][1]->action_at = date_format(date_create($student_data['timecards'][1]->action_at),"h:i A");
			}
		}
				
		return response()->json(['total_in'=>$total_in, 'students'=>$data]);
	}
    
    
    /** 
	 * GET /api/timecard/current_status
	 * Used in the AJAX call from ADMIN dashboard /home 
	 **/
    public function current_status()
    {    
	    $checkins=0;
	    $checkouts=0;
	    $logbook = array();
	    $date = date('Y-m-d'); //2018-09-27 test date
	    
	    $actions = Student::select('*')->leftJoin('timecards', function($join){
			$join->on('students.id','=','timecards.student_id');
		})
		//->whereRaw("DATE(timecards.action_at) = '{$date}' AND (timecards.is_checkin=1 OR timecards.is_checkout=1)")	
		
		->whereDate('timecards.action_at', $date)
		->where(function($query){
			$query->where('timecards.is_checkin', 1)->orWhere('timecards.is_checkout', 1);
		})
				
		->orderBy('timecards.student_id', 'ASC')
		->orderBy('timecards.action_at','DESC')
		->get();
	    
	    foreach($actions as $act)
	    {
		    //echo "<pre>".print_r($act,1)."</pre>";
		    //die();
		    if(!isset($logbook[$act['student_id']]))
		    {				
				$logbook[$act['student_id']] = [
					"name"  => "{$act['firstname']} {$act['lastname']}",
					"image" => $act['image']?$act['image']:null,
					
					"facility_id" => $act['facility_id'],
					"guardian_id" => $act['guardian_id'],
					"student_id"  => $act['student_id']
				];			    	
		    }
		    		    
		    if($act['is_checkout'])
			{		
				if(!isset($logbook[$act['student_id']]['checkin']))
				{
					$checkouts++;
					$logbook[$act['student_id']]['checkout'] = $act['action_at'];
					$logbook[$act['student_id']]['time_out'] = date_format(date_create($act['action_at']),"h:i A");
					$logbook[$act['student_id']]['status'] = 0;
				}				
	    	}
	    	
	    	if($act['is_checkin'])
	    	{		
		    	if(!isset($logbook[$act['student_id']]['checkin']))
				{
			    	$checkins++;
			    	$logbook[$act['student_id']]['checkin'] = $act['action_at'];
			    	
			    	$logbook[$act['student_id']]['confirmed'] = $act['confirmed_at']; //new
			    	$logbook[$act['student_id']]['timecard_id'] = $act['id']; //new
			    	
			    	$logbook[$act['student_id']]['time_in'] = date_format(date_create($act['action_at']),"h:i A");
			    	
			    	if(!isset($logbook[$act['student_id']]['checkout']))
			    	{
				    	$logbook[$act['student_id']]['status'] = 1;
			    	}
				}
	    	}
	    		    	
	    	if( isset($logbook[$act['student_id']]['checkin']) && !isset($logbook[$act['student_id']]['total']) )
	    	{
		    	if(!isset($logbook[$act['student_id']]['checkout']))
		    	{
			    	/*
			    	$logbook[$act['student_id']]['total'] = [
						'hours' => date('G', time()) - date('G', strtotime($logbook[$act['student_id']]['checkin'])),
						'mins'  => date('i', time()) - date('i', strtotime($logbook[$act['student_id']]['checkin']))
					];
					*/
										
					$duration_secs = time() - strtotime($logbook[$act['student_id']]['checkin']);
					$logbook[$act['student_id']]['total'] = $this->time_elapsed($duration_secs);

				}
				else
				{
					/*
					$logbook[$act['student_id']]['total'] = [
						'hours' => date('G', strtotime($logbook[$act['student_id']]['checkout'])) - date('G', strtotime($logbook[$act['student_id']]['checkin'])),
						'mins'  => date('i', strtotime($logbook[$act['student_id']]['checkout'])) - date('i', strtotime($logbook[$act['student_id']]['checkin']))
					];
					*/
					
					$duration_secs = strtotime($logbook[$act['student_id']]['checkout']) -  strtotime($logbook[$act['student_id']]['checkin']);
					$logbook[$act['student_id']]['total'] = $this->time_elapsed($duration_secs);
				}				 
	    	}
	    	
	    }

		$data = [
			'total_checked_in' => $checkins - $checkouts,
			'students' => $logbook
		];	    
	    
	    return response()->json($data);
	    
	    
	    
	    
	    /********************
		    
		SELECT * FROM students LEFT JOIN timecards ON students.id=timecards.student_id WHERE DATE(timecards.action_at) = '2018-09-27' ORDER BY timecards.student_id ASC, timecards.action_at DESC;
		
	    $date = date('Y-m-d'); //2018-09-28 test date
	    
	    $checkins = Student::select('*')->leftJoin('timecards', function($join){
			$join->on('students.id','=','timecards.student_id');
		})
		->whereRaw("DATE(timecards.action_at) = '{$date}' AND timecards.is_checkin=1")
		->orderBy('timecards.student_id', 'ASC')
		->orderBy('timecards.action_at','DESC')
		->get();
		
		
		//echo "<pre>".print_r($checkins,1)."</pre>";
		//die();
		
		$checkouts = Student::select('*')->leftJoin('timecards', function($join){
			$join->on('students.id','=','timecards.student_id');
		})
		->whereRaw("DATE(timecards.action_at) = '{$date}' AND timecards.is_checkout=1")
		->orderBy('timecards.student_id', 'ASC')
		->orderBy('timecards.action_at','DESC')
		->get();
		
		$students = [];
		foreach($checkins as $ci)
		{
			if(!isset($students[$ci['student_id']])) 
			{
				$students[$ci['student_id']] = [
					'name'    => "{$ci['firstname']} {$ci['lastname']}",
					'checkin' => $ci['action_at'],
					'time_in' => date_format(date_create($ci['action_at']),"h:i A")
				];
			}
		}
		
		foreach($checkouts as $co)
		{
			if(isset($students[$co['student_id']]) && !isset($students[$co['student_id']]['checkout'])) 
			{
				$students[$co['student_id']]['checkout'] = $co['action_at'];
				$students[$co['student_id']]['time_out'] = date_format(date_create($co['action_at']),"h:i A");				
				$students[$co['student_id']]['total'] = [
					'hours' => date('G', strtotime($co['action_at'])) - date('G', strtotime($students[$co['student_id']]['checkin'])),
					'mins'  => date('i', strtotime($co['action_at'])) - date('i', strtotime($students[$co['student_id']]['checkin']))
				];
				
				$students[$co['student_id']]['status'] = 0;
			}
			
			//floating point, precision 2 decimals
		}
		
		
		foreach($students as $id=>$student)
		{
			if(!isset($student['total']))
			{
				$h = date('G') - date('G', strtotime($students[$co['student_id']]['checkin']));
				$m = date('i') - date('i', strtotime($students[$co['student_id']]['checkin']));
				if($m < 0)
				{
					--$h;
					$m = 60 + $m;
				}
				
				$students[$id]['total'] = [
					'hours' => $h,
					'mins'  => $m
				];
				$students[$id]['status'] = 1;
			}
		}
		
		
		$data = [
			'total_checked_in' => count($checkins) - count($checkouts),
			'students' => $students
		];
		return response()->json($data);
		************




	    $date = date('Y-m-d'); //2018-09-26 test date
	    
	    $activities = Student::select('*')->leftJoin('timecards', function($join){
			$join->on('students.id','=','timecards.student_id');
		})
		->whereRaw("DATE(timecards.action_at) = '{$date}' AND (timecards.is_checkin=1 OR timecards.is_checkout=1)")
		->orderBy('timecards.student_id', 'ASC')
		->orderBy('timecards.action_at','DESC')
		->get();


//return count($activities);

		$students = [];
		$checkins = 0;
		$checkouts = 0;
		foreach($activities as $a)
		{
			
			
			//return response()->json($a);
			if( $a['is_checkout']==1 && !isset($students[$a['student_id']]) && !isset($students[$a['student_id']]['checkout']))
			{
				$students[$a['student_id']]['checkout'] = $a['action_at'];
				$students[$a['student_id']]['time_out'] = date_format(date_create($a['action_at']),"h:i A");				
				
				
				$students[$a['student_id']]['total'] = [
					'hours' => date('G', strtotime($a['action_at'])) - date('G', strtotime($students[$a['student_id']]['checkin'])),
					'mins'  => date('i', strtotime($a['action_at'])) - date('i', strtotime($students[$a['student_id']]['checkin']))
				];
			
				
				$students[$a['student_id']]['status'] = 0;
			}
			
			
			if( $a['is_checkin']==1 && !isset($students[$a['student_id']]) ) 
			{
				$students[$a['student_id']] = [
					'name'    => "{$a['firstname']} {$a['lastname']}",
					'checkin' => $a['action_at'],
					'time_in' => date_format(date_create($a['action_at']),"h:i A")
				];
			}
			
			
			if(isset($a['is_checkin']) && !empty($students[$a['student_id']]['checkin'])) 
				++$checkins;
				
			if(isset($a['is_checkout']) && !empty($students[$a['student_id']]['checkout'])) 
				++$checkouts;
		}
	
		//die(count($students));
		
		
		foreach($students as $id=>$student)
		{			
			if(!isset($student['total']))
			{
				
				if(isset($students[$id]['checkin']) && !isset($students[$id]['checkout']))
				{
					$h = date('G') - date('G', strtotime($students[$id]['checkin']));
					$m = date('i') - date('i', strtotime($students[$id]['checkin']));
					if($m < 0)
					{
						--$h;
						$m = 60 + $m;
					}
					
					$students[$id]['total'] = [
						'hours' => $h,
						'mins'  => $m
					];
					$students[$id]['status'] = 1;					
				}

			}
		}
		
		
		$data = [
			'total_checked_in' => count($checkins) - count($checkouts),
			'students' => $students
		];
		return response()->json($data);		
		
******************************************/


    } //end current_status
    
    
    
    
    
    
    
    
    
    
    
    /** 
	 * GET /api/timecard/sync/2
	 * Update Guardians Timecard records.  Checkout any open Checkin. Delete any unconfirmed checkins
	 *
	 *   only does it for students of the specified guaridian - function sync($id)
	 **/
	public function sync($id)
    {
	    $today = date('Y-m-d');	    
        $guardian = Guardian::findOrFail($id);
        $options = [];
        
        //die(count($guardian->students));
        foreach($guardian->students as $student)
        {
	        $timecards = Timecard::where('student_id', $student->id)->orderBy('action_at','DESC')->get();
	        //echo count($timecards);
	        //die();
	        
	        if(count($timecards)>0)
	        {         
		        foreach($timecards as $timecard)
		        {
			        $day = explode(" ",$timecard->action_at);
			        $student_options = [
				    	'student_id' => $timecard->student_id,
				    	'actions'    => ['checkin','activity']
			        ];
			        
			        //SCENARIO - TIMECARD action_at NOT TODAY(YESTERDAY most likely)
			        //         - TIMECARD.is_checkin==1 and NO CHECKOUT timecard (it's the last timecard for student)
			        //
			        //         - IF TIMECARD.confirmed_at==null AND confirmed_by==0? zap the timecard before anything else
			        //         - ELSE IF TIMECARD.confirmed_at!=null AND confirmed_by>0? autocheckout student before anything else
			        if($day[0] != $today)
			        {
				        if($timecard->is_checkin)
				        {
					        //AUTO CHECKOUT student 
					        if($timecard->confirmed_at!=null)
					        {
						    	$tc = new Timecard();
								$tc->guardian_id = $timecard->guardian_id;		
								$tc->student_id  = $timecard->student_id;				
								$tc->facility_id = $timecard->facility_id;
								$tc->action_at   = "{$day[0]} 23:59:59";
								$tc->is_checkin  = '0';
								$tc->is_checkout = '1';		
								$tc->notes       = "AUTO CHECKOUT: {$day[0]} 23:59:59";
								$tc->save(); 
					        }
					        //DELETE the UNCONFIRMED timecard by id
					        else
					        {
						        DB::delete('DELETE FROM timecards WHERE id = ?', [$timecard->id]);
					        }
					        	
					        $options[] = $student_options;			        
					        break;
				        }
				        
				        if($timecard->is_checkout)
				        {
					        $options[] = $student_options;
					        break;
				        }
				        continue;
			        } 
			        else 
			        {
				        if($timecard->is_checkin)
				        {
					        $options[] = [
						    	'student_id' => $timecard->student_id,
						    	'actions'    => ['checkout','activity']
					        ];
					        break;
				        }
				        
				        if($timecard->is_checkout)
				        {
					        $options[] = $student_options;
					        break;
				        }
				        continue;
			        }
			        		        
		        } //end timecard loop
	        }
	        if(count($options)>0 && $options[count($options)-1]['student_id'] != $student->id){
		        $options[] = [
			    	'student_id' => $student->id,
			    	'actions'    => ['checkin','activity']
		        ];
	        }
	        
	        if(!count($options)){
		        $options[] = [
			    	'student_id' => $student->id,
			    	'actions'    => ['checkin','activity']
		        ];
	        }
        } //end student loop
        
        return response()->json($options);
    }
    







/** 
 * GET /api/timecard/sync-all
 * Update Student Timecard records.  Checkout any open Checkin. 
 **/
public function sync_all()
{
	$today = date('Y-m-d');	    
    $students = Student::all();
	$options = [];
	
	foreach($students as $student)
	{
		$timecards = Timecard::where('student_id', $student->id)->orderBy('action_at','DESC')->get();
	    if($timecards)	
	    {
			foreach($timecards as $timecard)
			{
				list($date, $time) = explode(" ",$timecard->action_at);
			    $student_options = [
			    	'student_id' => $timecard->student_id,
			    	'actions'    => ['checkin','activity']
		        ];
				if($date != $today)
				{
			        if($timecard->is_checkin)
			        {
				        //AUTO CHECKOUT student 
				        if($timecard->confirmed_at!=null)
				        {
					    	$tc = new Timecard();
							$tc->guardian_id = $timecard->guardian_id;		
							$tc->student_id  = $timecard->student_id;				
							$tc->facility_id = $timecard->facility_id;
							$tc->action_at   = "{$day[0]} 23:59:59";
							$tc->is_checkin  = '0';
							$tc->is_checkout = '1';		
							$tc->notes       = "AUTO CHECKOUT: {$day[0]} 23:59:59";
							$tc->save(); 
				        }
				        //DELETE the UNCONFIRMED timecard by id
				        else
				        {
					        DB::delete('DELETE FROM timecards WHERE id = ?', [$timecard->id]);
				        }
				        				        				        
				        $options[] = $student_options;			        
				        break;
			        }
			        
			        if($timecard->is_checkout)
			        {
				        $options[] = $student_options;
				        break;
			        }
			        continue;
				}
				else
				{
			        if($timecard->is_checkin)
			        {
				        $options[] = [
					    	'student_id' => $timecard->student_id,
					    	'actions'    => ['checkout','activity']
				        ];
				        break;
			        }
			        
			        if($timecard->is_checkout)
			        {
				        $options[] = $student_options;
				        break;
			        }
			        continue;					
				}
			}	    
	    }
	    
	    if(count($options)>0 && $options[count($options)-1]['student_id'] != $student->id){
	        $options[] = [
		    	'student_id' => $student->id,
		    	'actions'    => ['checkin','activity']
	        ];
        }
        if(!count($options))
        {
	        $options[] = [
		    	'student_id' => $student->id,
		    	'actions'    => ['checkin','activity']
	        ];
        }
        
	}//student foreach
	
	return response()->json($options);
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
