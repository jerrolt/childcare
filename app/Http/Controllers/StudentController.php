<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PDF;

use Illuminate\Support\Facades\Auth; //set for auth
use Illuminate\Support\Facades\DB;
use App\Facility;
use App\Guardian;

use App\Timecard;
use App\Student;

class StudentController extends Controller
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
        //
    }
        
    
    public function admin()
    {
	    //echo "Im here. admin.<br/>";die();
	    Auth::user()->hasAnyRole(['admin']);
	    $role = Auth::user()->roles()->first()->name;
	    
	    $view = "student.{$role}";
	    //echo $view;
	    //
	    $facilities = Facility::orderBy('name','ASC')->ignoreDeleted()->has('classrooms')->get();
	    $data = [
		    "nav" 		 => "{$role}.navbar",
		    "facilities" => $facilities
	    ];
	    //echo $view."<br/>".print_r($data,1)."<br/>";
	    //die();
	    return view($view, $data);
    }
	
	// /admin/students/guardian/{guardian_id}
	public function guardian($guardian_id)
	{
		Auth::user()->hasAnyRole(['admin']);
	    $role = Auth::user()->roles()->first()->name;
	    $view = "student.guardian-{$role}";
	    $facilities = Facility::orderBy('name','ASC')->ignoreDeleted()->has('classrooms')->get();
	    $data = [
		    "guardian_id" => $guardian_id,
		    "nav" 		  => "{$role}.navbar",
		    "facilities"  => $facilities
	    ];
	    return view($view, $data);		
	}
	
	// /admin/students/classroom/{classroom_id}
	public function classroom($classroom_id)
	{
		Auth::user()->hasAnyRole(['admin']);
	    $role = Auth::user()->roles()->first()->name;
	    $view = "student.classroom-{$role}";
	    $facilities = Facility::orderBy('name','ASC')->ignoreDeleted()->has('classrooms')->get();
	    $data = [
		    "classroom_id" => $classroom_id,
		    "nav" 		  => "{$role}.navbar",
		    "facilities"  => $facilities
	    ];
	    return view($view, $data);		
	}


	
	/**
	 *	Child Activity Report - for the Guardian view
	 *
	 */
	public function activity(){
		$view = "student.activity-guardian";
		//echo $view;
		//die();
		$guardian = Guardian::where("user_id",Auth::user()->id)->get();
		//print "<pre>".print_r($guardian->id,1)."</pre>";die();
		
		$data = [
			"nav" 		  => "guardian.navbar",
			"guardian_id" => $guardian[0]->id
		];
		//echo $view."<br/>";
		//echo "<pre>".print_r($data,1)."</pre>";
		//die();
		return view($view, $data);
	}
	/**
	 *	Child Activity Report - for the Admin view
	 *
	 */
	public function activity_admin()
	{
		$view = "student.activity-admin";
		$data = [
			"nav" 		  => "admin.navbar",
		];
				
		return view($view, $data);		
	}



	/**
	 *	summary_pdf PDF 
	 *   Ex: "/summary-pdf/{student_id}/{from}/{to}"
	 *
	 */
	public function summary_pdf($student_id, $from, $to)
	{				
		$nodes = []; //timecards within one attendance cycle.  (checkin - checkout cycle)
		$timecards = [];
		$fields = [
			'timecards.*', 
			DB::raw("CONCAT(guardians.firstname,' ',guardians.lastname) AS guardian_name"),
			'facilities.name AS facility_name'
		];
	
		$query = Timecard::select($fields)
			->join('guardians', 'guardians.id', '=', 'timecards.guardian_id')
			->join('facilities', 'facilities.id', '=', 'timecards.facility_id')
			->where('student_id', $student_id)
			->whereDate('action_at', '>=', $from)
			->whereDate('action_at', '<=', $to)
			->orderBy('student_id')
			->orderBy('action_at','DESC');
			
		$timecards = $query->get();
				
		$action = [
			'student'    => null,
			'checkin'    => null,
			'checkout'   => null,
			'activities' => [],
			'time'       => null,
			'total'      => 0
		];
		
		
		$from = $to = time();
		$total = 0;  //new
		
		foreach($timecards as $timecard)
		{
			$action['student'] = $timecard->student;
			if($timecard->is_checkin)
			{
				
				//new - dont show PENDING timecards in reports - 
				//PENDING tc's should only be on the current day
				if($timecard->confirmed_at!=null) 
				{									
					$from = strtotime($timecard->action_at);
					$tl = $to - $from;//new
					$action['time'] = $this->time_elapsed($tl);//$tl new
					
					//new
					$total = $total + $tl; //new
					$action['checkin'] = $timecard;
					//$blocks[] = $block; //add to chain of blocks
					array_push($nodes, $action);
					$action = [
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
				$action['checkout'] = $timecard;
				$to = strtotime($timecard->action_at);				
			}
			else
			{
				$action['activities'][] = $timecard;
			}			
		}


//echo "total: {$total}";
		if($total > 60) //more than a minute
		{
			$resp = [
				'total' => $this->time_elapsed_no_days($total),
				'nodes' => $nodes
			];
		}
		else
		{
			$resp = [
				'total' => $this->time_elapsed_no_days(0),
				'nodes' => $nodes
			];
		}	    
//echo $resp['nodes'][0];
//die();	    
	    $fname = preg_replace("/[^a-zA-Z0-9]+/", "", $resp['nodes'][0]['student']['firstname']);
	    $lname = preg_replace("/[^a-zA-Z0-9]+/", "", $resp['nodes'][0]['student']['lastname']);
	    $filename = $fname."-".$lname."_".date('YMd',$from)."-summary.pdf";
	    
		// Send data to the view using loadView function of PDF facade
	    $pdf = PDF::loadView('pdf.summary', $resp);
	    
	    // If you want to store the generated pdf to the server then you can use the store function
	    //$pdf->save(storage_path().'_filename.pdf');
	    
	    // Finally, you can download the file using download function
	    return $pdf->download($filename);	 	    
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 *   /absentee-pdf/{date}
	 */
	public function absentee_pdf($date)
	{
		$fields = [
			'timecards.*'
		];
		$query = Timecard::select($fields)->whereDate('action_at', '=', $date);
				
		//check role: if guardian role only query guardian's students, otherwise all students for admin role
		$is_admin = Auth::user()->guardian->is_admin;	
		if(!$is_admin)
		{
			$query->join('guardian_student', 'guardian_student.student_id', '=', 'timecards.student_id')
			->where('guardian_student.guardian_id', '=', Auth::user()->guardian->id);	
		}
			
		$timecards = $query->get();
		
			
			
			
			
		$checkedins=[];		
		foreach($timecards as $t)
		{
			$checkedins[$t->student_id]=$t->student_id;
		}
		
		
		$facility = count($timecards)>0 ? (Facility::findOrFail($timecards[0]->facility_id))->name : null;
		
		$absent=[];		
		$query = Student::select(['students.*']);		
		if(count($checkedins)>0)
		{	
			foreach($checkedins as $k=>$v)
			{
				$query->where('students.id','!=', $k);
			}
		}		
		$absent = $query->orderBy('students.lastname','ASC')->orderBy('students.firstname','ASC')->get();
		
		
		
		$present=[];
		if(count($checkedins)>0)
		{		
			$query = Student::select(['students.*']);
			
			$i=0;		 
			foreach($checkedins as $k=>$v)
			{
				$i++;
				if($i>0)
					$query->orWhere('id','=', $k);
				else
					$query->where('id','=', $k);
			}	
			$present=$query->get();
		}

		$nothere = [];
		foreach($absent as $s)
		{
			$nothere[] = $name = $s->lastname.", ".$s->firstname . ($s->mi!=null?$s->mi:"");
			$active[] = $name;
		}
		
		$here = [];
		foreach($present as $s)
		{
			$here[] = $name = $s->lastname.", ".$s->firstname . ($s->mi!=null?$s->mi:"");
			$active[] = $name;
		}	
		
		$resp =[
			'facility'=>$facility, 
			'date'=>date('D, M d, Y',strtotime($date)), 
			'active'=>$active, 
			'absent'=>$nothere, 
			'present'=>$here
		];
		
		$pdf = PDF::loadView('pdf.absentee', $resp);		
		$filename = date('YMd',strtotime($date))."-absentee.pdf";
		return $pdf->download($filename);
	}
	
	
	
	
	
	
	
	
	/**
	 *  Gateway to Student ID Bage (PDF Version)
	 *
	 */
	public function badge($student_id)
	{
		$student =  Student::findOrFail($student_id);
		$data = [
			'student'=>$student
		];
		
		$pdf = PDF::loadView('pdf.badge', $data);
		$filename = $student->firstname."-".$student->lastname."-badge.pdf";
		return $pdf->download($filename);		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 *   /attendance-pdf/{student_id}/{date}
	 */	
	public function attendance_pdf($date)
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
			->whereDate('action_at', '=', $date);
		
		
		
		
		//Is Auth::user() a guardian.is_admin=1 OR guardian.is_admin=0
		//IF NOT is_admin whereIn
		if(Auth::user()->guardian->is_admin==0)
		{
			$qu = DB::select(DB::raw('select g.id from guardians g WHERE g.is_admin=1 OR g.user_id='.Auth::user()->id));
			$range = [];
			foreach($qu as $q)
			{
				$range[] = $q->id; //echo $q->id."<br>";
			}
				
			if(!empty($range))
			{
				$query->whereIn('timecards.guardian_id', $range);
			}							
		}
		
		
		
		
		
		//->whereDate('action_at', '<=', $request->to);
		/*
		if(isset($request->students) && !empty($request->students))
		{	
			$query = $query->whereIn('student_id', $request->students);
		}
		*/
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
		$total = 0;  
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

		if($total > 60) //more than a minute
		{
			$resp = [
				'total' => $this->time_elapsed_no_days($total),
				'blocks' => $blocks,
				'date' => date('D, M d, Y',strtotime($date))
			];
		}
		else
		{
			$resp = [
				'total' => $this->time_elapsed_no_days(0),
				'blocks' => $blocks,
				'date' => date('D, M d, Y',strtotime($date))
			];
		}
		
		
		//return response()->json($blocks);
		//return response()->json($resp);
		
		
		
		
		$pdf = PDF::loadView('pdf.attendance', $resp);
		$filename = date('YMd',strtotime($date))."-attendance.pdf";
		return $pdf->download($filename);
	}


	/* 
		gets the number of timecards per day.  this tells vuejs whether to show a link or not.  we dont want links to pdfs that have NO records 
	*/
	public function get_attendance_pdf_timecard_count($from, $to)
	{		
		
		
		
		if(Auth::user()->guardian->is_admin==0)
		{
			$res = DB::select(DB::raw("SELECT DISTINCT DATE(tc.action_at) day FROM timecards tc, guardians g WHERE g.id=tc.guardian_id AND tc.action_at > '".$from." 00:00:00' AND tc.action_at<='".$to." 23:59:59' AND (g.is_admin=1 OR g.user_id=".Auth::user()->id.") ORDER BY day"
			));
			return $res;
		}
		
		//, COUNT(tc.id) as num GROUP BY day 
		
		
		$res = DB::select(DB::raw("SELECT DISTINCT DATE(tc.action_at) day FROM timecards tc WHERE tc.action_at > '".$from." 00:00:00' AND tc.action_at<='".$to." 23:59:59' ORDER BY day"
			));
		return $res;
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
    
    
    
    
    
    
}
