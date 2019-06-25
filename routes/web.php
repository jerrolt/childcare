<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//TEST Mailer
Route::get('/mailable', function () {
	$timecard = App\Timecard::findOrFail(20);
    return new App\Mail\StudentDropoff($timecard);
});



Route::get('/qrcode/{guardian_id}/{student_id}/{px}', function ($guardian_id, $student_id, $px) {
	
	/*
		1.  check that a guardian_student pivot table record exists
		2.  check that $px isset and is_numeric
		3.  set default QrCode::color(32,32,32) black
		4.  set default QrCode::backgroundColor(255,255,255) white
		5.  if record doesnt exist, merge STOP PNG into QRCODE
	 */
	 
	 
	//$valid = DB::table('guardian_student')->where('guardian_id', $guardian_id)->where('student_id',$student_id)->exists();
	

		$qrcode = QrCode::format('png')
				->size($px)
				->margin(0)
				->backgroundColor(255,255,255)
				->color(0, 0, 0) //(96,96,96)(64,64,64)(32,32,32)
				->generate("g{$guardian_id}_s{$student_id}");	 

		/*  USE THIS FOR INVALID CODES
		$qrcode = QrCode::format('png')
				->size(100)
				->margin(0)
				->merge('https://www.highschooldriver.com/assets/image/compressed/road-signs/regulatory-signs/stop-sign-regulatory-sign.png', 1.0, true)
				->backgroundColor(255,255,255)
				->color(0, 0, 0)
				->generate("invalid qrcode");
		*/
	
	return response()->make(
		$qrcode, 
		200, 
		array('Content-Type' => 'image/png', 'Cache-Control'=>'max-age=0, public')
	);
});


Route::get('/guardian/tmp/{guardian_id}', 'GuardianController@tmp');


Route::get('/guardian/scan/{guardian_id}', 'GuardianController@scan')->name('guardian-scan');  //loads in iframe

Route::get('/guardian/checkin/{guardian_id}', 'GuardianController@checkin')->name('guardian-checkin'); //base64_encode/decode guardian id




Route::get('/facilities', 'FacilityController@index')->name('facilities');
Route::get('/admin/facilities', 'FacilityController@admin')->name('admin-facilities');


Route::get('/admin/classrooms', 'ClassroomController@index');
Route::get('/admin/classrooms/{facility_id}', 'ClassroomController@facility');


//all students of a school
Route::get('/admin/students', 'StudentController@admin')->name('student-admin'); 
//only students by guardian
Route::get('/admin/students/guardian/{guardian_id}', 'StudentController@guardian')->name('student-guardian-admin');
Route::get('/admin/students/classroom/{classroom_id}', 'StudentController@classroom')->name('student-classroom-admin');


Route::get('/admin/guardians', 'GuardianController@admin')->name('guardian-admin');


//Student Activity Reports
Route::get('/attendance-records', 'StudentController@activity')->name('attendance-records');
Route::get('/admin/attendance-records', 'StudentController@activity_admin')->name('admin-attendance-records'); 

//PDF Report
Route::get('/summary-pdf/{student_id}/{from}/{to}','StudentController@summary_pdf');
Route::get('/absentee-pdf/{date}','StudentController@absentee_pdf');
Route::get('/attendance-pdf/{date}','StudentController@attendance_pdf');

//PDF Student Badge
Route::get('/student-badge-pdf/{student_id}','StudentController@badge');




Route::get('/get-attendance-pdf-count/{from}/{to}','StudentController@get_attendance_pdf_timecard_count');










//AUTHENTICATION ROUTES
//Auth::routes(); //delete all auth routes below and use this if not custom auth

//NEW checkin-login
$this->get('checkin-login', 'Auth\LoginController@showCheckinLoginForm')->name('check-login');
$this->post('checkin-login', 'Auth\LoginController@login')->name('check-login');

$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//$this->get('register', 'Auth\RegisterController@guardianForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');
// END OF AUTHENTICATION ROUTES




//NEW
Route::get('/identify', 'GuardianController@identify')->name('indentify');


//old fingerprint login
Route::get('/guardian/fingerprint-login', 'GuardianController@fplogin')->name('fingerprint-login');
//New for Guardian Students page
Route::get('/guardian/students', 'GuardianController@students')->name('guardian-students');








Route::get('/home', 'HomeController@index')->name('home');
