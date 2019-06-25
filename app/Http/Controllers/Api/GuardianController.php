<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Guardian;
use App\Http\Resources\Guardian as GuardianResource;

use App\Student;
use App\Http\Resources\Student as StudentResource;

use App\Timecard;
use App\Http\Resources\Timecard as TimecardResource;

use App\User;
use App\Role;

use Illuminate\Support\Facades\DB;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $guardian_users_ids = [];
		$results = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->select('users.id', 'users.status','roles.name')
            ->where('roles.name','=','guardian')
            ->get();
           // echo "<pre>".print_r($results,1)."</pre>"; die();
        foreach($results as $k=>$gu)
        {
	        $guardian_users_ids[] = $gu->id;
        }
        
		//Get only role guardian users NOT role admin guardians
		$where = "user_id IN(".join(',',$guardian_users_ids).")";
        $guardians = Guardian::whereRaw($where)->orderBy('lastname','asc')->paginate(10);
        $guardians->load('user')->load('students');
        
        //echo "<pre>".print_r($guardians,1)."</pre>"; die();
             		
        $guardians->map(function ($g) {	
	    	$g->students->map(function($s){
		    	$s->facility;
		    	$s->classroom;
		    	return;
	        });		      
		    return;
		});
		
        return GuardianResource::collection($guardians);
    }
    	
    /**
	 * Use to get all guardians w/o pagination. Used in FORM SELECT (NO admin-guardians)
	 */
    public function options()
    {
        $guardians = Guardian::select('guardians.id','guardians.firstname','guardians.lastname','guardians.mi','users.status')
        ->join('users', 'users.id', '=', 'guardians.user_id')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->whereRaw("roles.name='guardian'")         
        ->orderBy('guardians.lastname','asc')
        ->get();
        //$guardians->load('user');
	
        return GuardianResource::collection($guardians);
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
        //Validation here
        $validations = [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'mi' => 'sometimes|nullable|string|max:1',
            
            'address' => 'required|max:50',
            'city' => 'required|min:3|max:25',
            'state' => 'required|min:2|max:2',
            'zipcode' => 'required|min:5|max:15',
            'phone' => 'required|min:10|max:20'      
	    ];
	    
        if($request->isMethod('post')){
	        $validations['email'] = 'required|string|email|max:255|unique:users';
	        $validations['password'] = 'required|string|min:6|confirmed';     
        }

		$validator = \Validator::make($request->all(), $validations);
        
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
        
        //save guardian
        $guardian = $request->isMethod('put') ? Guardian::findOrFail($request->guardian_id) : new Guardian;
        if($request->isMethod('put'))
        {
	        $user = User::findOrFail($guardian->user_id);
	        $user->firstname = $request->input('firstname');
			$user->lastname = $request->input('lastname');
			$user->mi = $request->input('mi');
			$user->address = $request->input('address');
			$user->city = $request->input('city');
			$user->state = $request->input('state');				
			$user->zipcode = $request->input('zipcode');
			//$phone = preg_replace("/[^a-zA-Z0-9]+/", "", $request->input('phone'));
			$user->phone = $request->input('phone');
			$user->save();
			
	        $guardian->id = $request->input('guardian_id');
	        $guardian->firstname = $request->input('firstname');
			$guardian->lastname = $request->input('lastname');
			$guardian->mi = $request->input('mi');				
			$guardian->suffix = $request->input('suffix');			
			$guardian->address = $request->input('address');
			$guardian->city = $request->input('city');
			$guardian->state = $request->input('state');				
			$guardian->zipcode = $request->input('zipcode');
			//$phone = preg_replace("/[^a-zA-Z0-9]+/", "", $request->input('phone'));
			$guardian->phone = $request->input('phone');				
			//$guardian->phone_carrier = $request->input('phone_carrier');
			$guardian->carrier_id = $request->input('carrier_id');
        }
        if($request->isMethod('post'))
        {
	        $user = User::create([
	            'firstname' => $request->input('firstname'),
	            'lastname'  => $request->input('lastname'),
	            'mi'        => $request->input('mi'),
	            
	            'address'	=> $request->input('address'),
	            'city'		=> $request->input('city'),
	            'state'		=> $request->input('state'),
	            'zipcode'	=> $request->input('zipcode'),
	            'phone'		=> $request->input('phone'),
	            
	            'email' => $request->input('email'),
	            'password' => bcrypt($request->input('password')),
	            'status' => 'active'
	        ]);        
	        $user->roles()->attach(Role::where('name','guardian')->first());
	        	        
	        $guardian->firstname = $request->input('firstname');
			$guardian->lastname = $request->input('lastname');
			$guardian->mi = $request->input('mi');				
			$guardian->suffix = $request->input('suffix');			
			$guardian->address = $request->input('address');
			$guardian->city = $request->input('city');
			$guardian->state = $request->input('state');				
			$guardian->zipcode = $request->input('zipcode');
			//$phone = preg_replace("/[^a-zA-Z0-9]+/", "", $request->input('phone'));
			$guardian->phone = $request->input('phone');				
			//$guardian->phone_carrier = $request->input('phone_carrier');
			$guardian->carrier_id = $request->input('carrier_id');
	        $guardian->user()->associate($user);
        }
        
        if($guardian->save())
		{
			//$student->guardians()->sync($request->guardians);	//organize guardians, include id and relationship					
			return new GuardianResource($guardian);
		}
    }







public function status(Request $request)
{
	if($request->isMethod('put'))
    {
        //$guardian = Guardian::findOrFail($request->guardian_id);
        $user = User::findOrFail($request->user_id);        
        $user->status = $request->status;
		if($user->save())
		{
			$guardian = Guardian::findOrFail($request->guardian_id);
			$guardian->load('user');
			return new GuardianResource($guardian);
		}			
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
        $guardian = Guardian::findOrFail($id);
        $guardian->load('user')->load('students');
    	$guardian->students->map(function($s){
	    	$s->facility;
	    	$s->classroom;
	    	$s->load('guardians');
        });		
        
        //echo "<pre>".print_r($guardian->students,1)."</pre>";      
        return new GuardianResource($guardian);
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
     * Upload, resize and create a thumbnail of the users image
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */    
    public function upload(Request $request){
	    $validator = \Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'guardian_id' => 'required|numeric'     
        ]);		
        
        
        //complete validation
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
        
        

	    list($w,$h,$t)=getimagesize(request()->image);
	            
        $original = time().'_o.'.request()->image->getClientOriginalExtension();
               
        request()->image->move(public_path('images/guardians'), $original);

		$imageName = time().'.'.request()->image->getClientOriginalExtension();
          
        //resample image 400w or smaller and create a 50x50 thumbnail       
        if($w > 400 || $h > 400)
        {
			$this->image_resize(public_path('images/guardians')."/".$original, public_path('images/guardians')."/".$imageName, 400, 400, 1);
		}
		else
		{
			$this->image_resize(public_path('images/guardians')."/".$original, public_path('images/guardians')."/".$imageName, $w, $h, 1);	
		}
        
        $this->image_resize(public_path('images/guardians')."/".$original, public_path('images/guardians')."/thumb_".$imageName, 50, 50, 1);
        
        
        
        $guardian = Guardian::findOrFail($request->guardian_id);
             
        
        //remove the original
        if(file_exists(public_path('images/guardians')."/".$original))
        	unlink(public_path('images/guardians')."/".$original); 
        
        //remove the old thumb and fullsize
        if($guardian->image)
        {
	        if(file_exists(public_path('images/guardians')."/thumb_".$guardian->image))
	        	unlink(public_path('images/guardians')."/thumb_".$guardian->image);
	        	
	        if(file_exists(public_path('images/guardians')."/".$guardian->image))
				unlink(public_path('images/guardians')."/".$guardian->image);
        }       
        
        //set and save the new image
        $guardian->image = $imageName; 
        if($guardian->save())
		{
			return new GuardianResource($guardian);
		}
	}
	
	
	
	
	
	
	
	
	
	
	public function saveFingerprint(Request $request) {
		$guardian = Guardian::findOrFail($request->guardian_id);	    
	    //$guardian->fingerprint_png = base64_decode($filedata);	    
	    $guardian->fingerprint_png = $request->fingerprint_png;
	    if($guardian->save())
		{
			return new GuardianResource($guardian);
		}		
	}
	public function identify(Request $request){
		
	}
	public function loadFingerprints()
	{
		//echo "load-fingerprints";
		//die();
		$guardians = Guardian::select('id','fingerprint_png','fingerprint_raw','firstname','lastname')->get();
		return GuardianResource::collection($guardians);
	}
	
	
	
	
	
	
	
	/**
	 *	API PUT - Save(update) Fingerprint to Guardian record
	 *
	 *	@param 	Request
	 *	@return GuardianResource
	 *
	 */
	public function fingerprint(Request $request)
	{     
		/** code for creating a file from the PNG POST   
        $filedata = $request->fingerprint;
        $filename = 'g_'.$request->guardian_id.'_fp3.png';
        list($mime, $filedata) = explode(';', $filedata);
        //list(,$filedata) = explode(',', $filedata);
        if($filedata != "")
        {
	        \Storage::put($filename,$filedata);
        }
        //return response()->json(['id'=>$request->guardian_id,'fingerprint'=>$request->fingerprint]);
        **/
        
        /**
	    How to display a PNG image from database in blade templates
	      
	     {{--<img src="data:image/png;base64,'.base64_encode( $item->image  ).'"/>;--}}  
	        
	    **/
	    
	    // BELOW HEADER BEGINS THE PNG - use the explode() methods to remove that header and then base64_decode
	    // data:image/png;base64,
	    //$filedata = $request->fingerprint;
	    //list($mime, $filedata) = explode(';', $filedata);
	    //list(,$filedata) = explode(',', $filedata);
	    
	    $guardian = Guardian::findOrFail($request->guardian_id);
	    //$guardian->fingerprint_raw = $filename;
	    //$guardian->fingerprint_raw = base64_decode($filedata);	    
	    $guardian->fingerprint_raw = $request->fingerprint;
	    if($guardian->save())
		{
			return new GuardianResource($guardian);
		}

	}
	
	/**
   	 *  Query for list of DAILY activities associated with all Students of specified Guardian 
	 *  
	 *  Page URL: /guardian/checkin/1
	 *	Used in AJAX calls: /api/guardian/students_activities/1/2018-09-12
	 *
	 
	public function students_activities($id, $date)
	{
		//	
		$guardian = Guardian::findOrFail($id);
		$student_ids = array();
		foreach($guardian->students as $s)
		{
			$student_ids[] = $s->id;
		}
		
		$date = $date ? $date : date('Y-m-d'); //2018-09-12 test date
		$timecards = Timecard::whereRaw("DATE(action_at) = '{$date}'")->whereIn('student_id', $student_ids)
			->orderBy('student_id', 'ASC')->orderBy('action_at','DESC')
			->get();
		$timecards->load('facility');
		$timecards->load('guardian');
		$timecards->load('student');
		
		
		$otc = array();
		foreach($guardian->students as $k=>$s)
		{
			$otc[$k] = [
				'student' => $s,
				'data' => []
			];
			foreach($timecards as $timecard)
			{
				if($timecard->student_id == $s->id)
					$otc[$k]['data'][] = $timecard; 
			}
		}
		
		return response()->json($otc);		
		//return TimecardResource::collection($timecards);
	}
	*/





	public function student_options($guardian_id)
	{
		$guardian = Guardian::findOrFail($guardian_id);
		$students=[];
		foreach($guardian->students as $student)
		{
			$student->load('facility');
			$students[] = [
				'option' => $this->_get_action_choice($student->timecards, (count($student->timecards)-1)), 
				'last' => $this->_today_last_period($student->id),
				'profile' => $student
			];
		}	
		
		return response()->json($students);
	}
	
	private function _today_last_period($student_id)
	{
		$today = date('Y-m-d');
		$timecards = Timecard::whereDate('action_at', $today)				
				->where('student_id', $student_id)
				->where(function($query){
					$query->where('is_checkin', 1)->orWhere('is_checkout', 1);
				})
				->orderBy('action_at', 'DESC')
				->get();
		
		
		
		$period = [];
		$total = count($timecards);

		for($x=0; $x < $total; $x++)
		{
			$tc = $timecards[$x];
			if($tc->is_checkin)
			{
				$period['in'] = $tc;
				$period['time_in'] = date("g:i A", strtotime($tc->action_at));
				if(!isset($period['out']))
				{					
					$period['out'] = null;
					$period['time_out'] = null;
				}	
				
				//totals
				$period['total'] = null;
				if($period['time_out']!=null && $period['time_in']!=null)
					$period['total'] = $this->time_elapsed( strtotime($period['time_out']) - strtotime($period['time_in']) );
				if($period['time_out']==null && $period['time_in']!=null)
					$period['total'] = $this->time_elapsed( time() - strtotime($period['time_in']) );
				return $period;	
			}
			$period['out'] = $tc;	
			$period['time_out'] = date("g:i A", strtotime($tc->action_at));
		}

		$period = ['in' => null, 'time_in'=>null, 'out' => null, 'time_out'=>null];
		return $period;
	}
	
	
	//this works
	private function _get_action_choice($timecards, $key)
	{
		$today = date('Y-m-d');
		if($key < 0)
		{
			return 'in';
		}
		$timecard = $timecards[$key];
		list($date, $time) = explode(' ', $timecard->action_at);
		if($date === $today)
		{
			if($timecard->is_checkin) 
			{  
				return 'out';
			} 
			elseif($timecard->is_checkout || !$key) 
			{ 
				return 'in';
			} 
			else
			{				
				return $this->_get_action_choice($timecards, --$key);					
			}				
		}
		return 'in';
	}
	 
	private function time_elapsed($secs)
	{
		$ret = [];
	    $bit = array(
	        'h' => $secs / 3600 % 24,
	        'm' => $secs / 60 % 60
	    );	        
	    foreach($bit as $k => $v)
	    {
			if($v > 0)
	        { 
	        	$ret[] = $v . $k;
	        }  
	    }	       	        
	    return join(' ', $ret);
    }	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	/** Retrieve and calculate checkin/checkout time totals and a GRAND TOTAL
	 *  DELETE THIS METHOD - NOT USED
	 * 
	 * 
	public function daily_activity_totals($student_id, $date)
	{
		$timecards = Timecard::whereRaw("DATE(action_at) = '{$date}' AND (is_checkin=1 OR is_checkout=1)")->where('student_id', $student_id)
			->orderBy('action_at','ASC')
			->get();
		
		if(count($timecards))
		{
			$intervals = [];
			$int =[];
			$total = $start = $stop = 0;
			foreach($timecards as $tc)
			{
				 
				if($tc->is_checkin) { 
					$start = strtotime($tc->action_at);
					$int['start'] = $tc->action_at;					
				}
				if($tc->is_checkout){
					$stop = strtotime($tc->action_at);
					$total = $stop - $start;
					$hours = $total / 3600;
					$mins = ($total - ($hours * 3600)) / 60;
					$secs = $total - ($mins * 60);
					
					$int['stop'] = $tc->action_at;
					$int['total'] = [
						'hours' => $hours,
						'mins' => $mins,
						'secs' => $secs
					];
					
					//reset interval trackers
					$intervals[] = $int;  //push interval onto stack
					$int = []; 
					$total = $start = $stop = 0;  
				} 
			}
			
			
		}
		echo "<pre>WHAT<br/></pre>";
		echo count($timecards);
		die();
		
		
		return 0;
	}
	*/
	
	
	
	
	
	/**
	 *  Resize an image
	 *
	 */
	protected function image_resize($src, $dst, $width, $height, $crop=0)
	{	
		if(!list($w, $h) = getimagesize($src)) return "Unsupported picture type!";
		
		$type = strtolower(substr(strrchr($src,"."),1));
		if($type == 'jpeg') $type = 'jpg';
		switch($type){
		    case 'bmp': $img = imagecreatefromwbmp($src); break;
		    case 'gif': $img = imagecreatefromgif($src); break;
		    case 'jpg': $img = imagecreatefromjpeg($src); break;
		    case 'png': $img = imagecreatefrompng($src); break;
		    default : return "Unsupported picture type!";
		}
		
				
		// resize
		if($crop)
		{
		    if($w < $width or $h < $height) return "Picture is too small!";
		    $ratio = max($width/$w, $height/$h);
		    $h = $height / $ratio;
		    $x = ($w - $width / $ratio) / 2;
		    $w = $width / $ratio;
		}
		else
		{
		    if($w < $width and $h < $height) return "Picture is too small!";
		    $ratio = min($width/$w, $height/$h);
		    $width = $w * $ratio;
		    $height = $h * $ratio;
		    $x = 0;
		}	
		
		$new = imagecreatetruecolor($width, $height);
		
		// preserve transparency
		if($type == "gif" or $type == "png"){
		    imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
		    imagealphablending($new, false);
		    imagesavealpha($new, true);
		}
		
		//die(" SRC-H: {$h}/SRC-W: {$w}.....DEST-W: {$width}/DEST-H{$height}\n");
		//
		//
		//fix uploaded image orientation
		$exif = exif_read_data($src);
	    if(!empty($exif) && isset($exif['Orientation']))
	    {
		    switch ($exif['Orientation']) 
		    {
	            case 3:
	                $img = imagerotate($img, 180, 0);
	                break;
	
	            case 6:
	                $img = imagerotate($img, -90, 0);
	                break;
	
	            case 8:
	                $img = imagerotate($img, 90, 0);
	                break;
	        }
	        imagecopyresampled($new, $img, 0, 0, $x-45, 45, $width, $height, $w-90, $h);
		}		
		//end fix orientation
		//
		//
		else
		{			
			imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);
		}
		
		
		
		
		
		switch($type){
		    case 'bmp': imagewbmp($new, $dst); break;
		    case 'gif': imagegif($new, $dst); break;
		    case 'jpg': imagejpeg($new, $dst); break;
		    case 'png': imagepng($new, $dst); break;
		}
		return true;
	}
	
		
		
		
		
		
	
	
		
	public function fplogin(Request $request)
	{
		/**
		$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://10.10.10.25:9810/api/FingerPrint/PostFingerPrint",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_TIMEOUT => 30000,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET")
);
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
		**/
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://10.10.10.25:9810/api/FingerPrint");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ['fingerprint' => $request->fingerprint]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close ($ch);	
			
		print $response;
		echo "<pre>".print_r(base64_decode($request->fingerprint),1)."</pre>";
		die();
		
		
		//echo "<pre>".print_r($request->fingerprint,1)."</pre>";
		//die();
		//$fp = explode(",", $request->fingerprint);		
		$substr = substr($request->fingerprint, 0, 1000);
	    $guardians = Guardian::where('fingerprint_png', 'LIKE',  '%'.$substr.'%')->get();
	    //$guardian = Guardian::findOrFail(2);
	    //return new GuardianResource($guardian);
	    if(isset($guardians[0])){
		    return new GuardianResource($guardians[0]);
	    }	    
	}
	
}
