<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Student;
use App\Facility;
use App\Classroom;
use App\Guardian;
//use App\Carrier;

use App\Http\Resources\Student as StudentResource;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $students = Student::orderBy('classroom_id')
	    				->orderBy('primary_guardian_id')
	    				->paginate(10);
        $students->load('guardians')
        		->load('primary_guardian')
	        	->load('classroom')
	        	->load('facility');
	     
	     /*
	     $students->map(function($s){
		     $s->guardians->map(function($g){
			     $g->user;
			     $g->user->map(function($u){
				     $u->
			     });
		     });
	     });   	
	    */
        
        return StudentResource::collection($students);
    }
    
    //get all students - used mainly by admin for search feature
    public function options()
    {
	    $students = Student::orderBy('lastname')->get();	    
        return StudentResource::collection($students);
    }
    

           
    //Get all students by classroom using $classroom_id
	public function classroom($classroom_id)
	{
		$students = Student::where('classroom_id', $classroom_id)
						->orderBy('firstname')->get();
						//->paginate(30);
		$students->load('guardians')
				->load('primary_guardian')
				->load('classroom')
				->load('facility');
        return StudentResource::collection($students);
	}

	public function facility($facility_id)
	{
		$students = Student::where('facility_id', $facility_id)
						->orderBy('firstname')
						->paginate(10);
		$students->load('guardians')
				->load('primary_guardian')
				->load('classroom')
				->load('facility');
        return StudentResource::collection($students);
	}

/*
	public function carrier_options()
	{
		$carriers = Carrier::all();
		return StudentResource::collection($carriers);
	}
*/

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
        //VALIDATE
        $validations = [
	        'primary_guardian_id' => 'required',
            'facility_id' => 'required',
            'classroom_id' => 'required',
            'lastname' => 'required|string|max:255',
            'mi' => 'sometimes|nullable|string|max:1',           
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|min:4|max:6'
	    ];
	    
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
        
               
        //SAVE
        $student = $request->isMethod('put') ? Student::findOrFail($request->student_id) : new Student;
        
        if($request->isMethod('put'))
        {
	        //$student = Student::findOrFail($request->student_id);
	        $student->id = $request->input('student_id');
	        $student->firstname = $request->input('firstname');
			$student->lastname = $request->input('lastname');
			$student->mi = $request->input('mi');				
			$student->suffix = $request->input('suffix');
			$student->date_of_birth = $request->input('date_of_birth');
			$student->gender = $request->input('gender');			
			$student->allergies = $request->input('allergies');
			$student->special_needs = $request->input('special_needs');
			$student->special_code = $request->input('special_code');
			
			$student->primary_guardian()->dissociate();
			$guardian = Guardian::findOrFail($request->primary_guardian_id);
			$student->primary_guardian()->associate($guardian);
			
			$student->facility()->dissociate();
			$facility = Facility::findOrFail($request->facility_id);
			$student->facility()->associate($facility);
			
			$student->classroom()->dissociate();
			$classroom = Classroom::findOrFail($request->classroom_id);
			$student->classroom()->associate($classroom);
        }
        
        if($request->isMethod('post'))
        {	        
	        //$student = new Student;
	        $student->firstname = $request->input('firstname');
			$student->lastname = $request->input('lastname');
			$student->mi = $request->input('mi');				
			$student->suffix = $request->input('suffix');
			$student->date_of_birth = $request->input('date_of_birth');
			$student->gender = $request->input('gender');			
			$student->allergies = $request->input('allergies');
			$student->special_needs = $request->input('special_needs');
			$student->special_code = $request->input('special_code');
			$student->status ='active';
			
			$guardian = Guardian::findOrFail($request->primary_guardian_id);
			$student->primary_guardian()->associate($guardian);
			
			$facility = Facility::findOrFail($request->facility_id);
			$student->facility()->associate($facility);
			
			$classroom = Classroom::findOrFail($request->classroom_id);
			$student->classroom()->associate($classroom);		    
        }
        
        
        
        
        
        //associate all guardian.is_admin=1 guardians with the selected guardians
        $adguards = Guardian::select('id','user_id')->where('is_admin','1')->get();
		$allguards = $request->guardians;
		foreach($adguards as $g)
		{
			array_push($allguards, $g->id);
		}
        $request->guardians = $allguards;
        
        
		if($student->save())
		{
			//Uncomment to generate and save static images of qrcode - currently dynamically generated:
			// 162.243.170.129/qrcode/{guardian_id}/{student_id}/{size} 
			//$this->generate_qrcodes($student->id, $request->guardians);
			
			$student->guardians()->sync($request->guardians);	//organize guardians, include id and relationship			
			return new StudentResource($student);
		}
		
    }





public function status(Request $request)
{
	//$student = Student::findOrFail($request->student_id);
        
    if($request->isMethod('put'))
    {
        $student = Student::findOrFail($request->student_id);
        //$student->id = $request->student_id;
        $student->status = $request->status;
		if($student->save())
		{
			return new StudentResource($student);
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
        $student = Student::findOrFail($id);
        $student->load('guardians');
        $student->load('primary_guardian');
        /*
    	$student->guardians->map(function($g){
	    	$g->user;
        });		
        */      
        return new StudentResource($student);
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

     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */    
    public function upload(Request $request){
	    
	    
	    //return response()->json($_POST);
	    
	    
	    $validator = \Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'student_id' => 'required|numeric'     
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
        
        
        //$request->image=$_FILES['image'];

	    list($w,$h,$t)=getimagesize(request()->image);
	    //list($w,$h,$t)=getimagesize($_FILES['image']['name']);
	            
        $original = time().'_o.'.request()->image->getClientOriginalExtension();
               
        request()->image->move(public_path('images/students'), $original);

		$imageName = time().'.'.request()->image->getClientOriginalExtension();
          
        //resample image 400w or smaller and create a 50x50 thumbnail       
        if($w > 400 || $h > 400)
        {
			$this->image_resize(public_path('images/students')."/".$original, public_path('images/students')."/".$imageName, 400, 400, 1);
		}
		else
		{
			$this->image_resize(public_path('images/students')."/".$original, public_path('images/students')."/".$imageName, $w, $h, 1);	
		}
        
        $this->image_resize(public_path('images/students')."/".$original, public_path('images/students')."/thumb_".$imageName, 50, 50, 1);
        
        
        
        $student = Student::findOrFail($request->student_id);
             
        
        //remove the original
        if(file_exists(public_path('images/students')."/".$original))
        	unlink(public_path('images/students')."/".$original); 
        
        //remove the old thumb and fullsize
        if($student->image)
        {
	        if(file_exists(public_path('images/students')."/thumb_".$student->image))
	        	unlink(public_path('images/students')."/thumb_".$student->image);
	        	
	        if(file_exists(public_path('images/students')."/".$student->image))
				unlink(public_path('images/students')."/".$student->image);
        }       
        
        //set and save the new image
        $student->image = $imageName; 
        if($student->save())
		{
			return new StudentResource($student);
		}
	}
	
	

	
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
		if($type == "jpg")
		{
			
		
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
		
		
		
		}
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
    
    
    
    
    
    
    
    /**
	 *   Generate a QR_Code PNG for each Guardian a Student is linked to
	 *
	 */
    protected function generate_qrcodes($student_id, $guardians)
    {
	    //  QrCode::format('png')->size(100)->margin(0)
		// 	->merge('https://www.w3.org/Graphics/PNG/alphatest.png', 0.3, true)
		// 	->generate("g{$gid}_s{$sid}_xs","g{$gid}_s{$sid}_xs.png")
	    //
		// Display like this in a blade template
	    // <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(50)->margin(0)->generate('qrcoder2')) !!}">
	    //
	    foreach($guardians as $gid)
	    {
		    //PATH: /pubic/images/qrcode/
		    $content  =  "g{$gid}_s{$student_id}";
		    
		    $filename = public_path('images/qrcode')."/{$content}.png";
		    if(!file_exists($filename))
		    {
				\QrCode::format('png')->margin(0)->generate($content, $filename);   
		    }
		    		    
		    $filename = public_path('images/qrcode')."/{$content}_50.png";
		    if(!file_exists($filename))
		    {
		    	\QrCode::format('png')->size(50)->margin(0)->generate($content, $filename);
		    }
		    
		    $filename = public_path('images/qrcode')."/{$content}_75.png";
		    if(!file_exists($filename))
		    {
		    	\QrCode::format('png')->size(75)->margin(0)->generate($content, $filename);
		    }
		    
		    $filename = public_path('images/qrcode')."/{$content}_100.png";
		    if(!file_exists($filename))
		    {
		    	\QrCode::format('png')->size(100)->margin(0)->generate($content, $filename);
		    }
		}
    }
    
    
    
    
    
    
    public function get_days_included($from, $to)
    {
	    $num_days = $this->getWorkingDays($from,$to); //no weekends
	    //echo $num_days."\r\n";
	    $date = $from;
	    $days = [$from];
	    
	    for($x=0;$x<=$num_days;$x++)
	    {
		    $date = strtotime("+1 day", strtotime($date));						
			$jd=gregoriantojd( date('m',$date), date('d',$date), date('Y',$date));
			$date = date('Y-m-d',$date);
			if( jddayofweek($jd,0) != 0 && jddayofweek($jd,0) != 6 )
			{
				$days[] = $date;
			}
			//echo strtotime($to)." - date: ".$date."\r\n";
			if(strtotime($date) == strtotime($to)) 
			{
				//echo "im here\r\n";
				break;
			}				
	    }
	    
		return response()->json(['days'=>$days]);
    }
        /*
    public function absentee_data($from, $to)
    {
	    $num_days = $this->getWorkingDays($from,$to); //no weekends
	    $date = $from;
	    $days = [$from];
	    
	    for($x=0;$x<=$num_days;$x++)
	    {
		    $date = strtotime("+1 day", strtotime($date));						
			$jd=gregoriantojd( date('m',$date), date('d',$date), date('Y',$date));
			$date = date('Y-m-d',$date);
			if( jddayofweek($jd,0) != 0 && jddayofweek($jd,0) != 6 )
			{
				$days[] = $date;
			}
			
			if(strtotime($date) == strtotime($to)) 
				break;
	    }
	    
		return response()->json(['days'=>$days]);
    }
    */
    protected function getWorkingDays($startDate,$endDate)
    {	
	  $days = false;
	  //echo "start: ".$startDate."\r\n";
	  $startDate = strtotime($startDate." 00:00:00");
	  
	  
	  //echo $endDate." 23:59:59";
	  
	  
	  $endDate = strtotime($endDate." 23:59:59");
	
	  if($startDate <= $endDate)
	  {
	    $datediff = $endDate - $startDate;
	    //echo "datediff: {$datediff}\r\n";
	    //echo "1 day: ".(60 * 60 * 24)."\r\n";
	    //echo "num days: ".floor($datediff / (60 * 60 * 24))."\r\n";
	    $days = floor($datediff / (60 * 60 * 24)); // Total Nos Of Days
	$days++;
	    $sundays = intval($days / 7) + (date('N', $startDate) + $days % 7 >= 7); // Total Nos Of Sundays Between Start Date & End Date
	    $saturdays = intval($days / 7) + (date('N', $startDate) + $days % 6 >= 6); // Total Nos Of Saturdays Between Start Date & End Date
	
	    $days = $days - ($sundays + $saturdays); // Total Nos Of Days Excluding Weekends
	  }
	  return $days;
	}
	
	
    
}
