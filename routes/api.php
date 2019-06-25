<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('guardian/fingerprint-login', 'Api\GuardianController@fplogin');






Route::get('facilities/options', 'Api\FacilityController@options'); //get full list for dropdown
Route::get('facilities', 'Api\FacilityController@index');
Route::get('facility/{id}', 'Api\FacilityController@show');
Route::put('facility', 'Api\FacilityController@store'); //update existing facility
Route::post('facility', 'Api\FacilityController@store'); //create new facility
Route::delete('facility/{id}', 'Api\FacilityController@destroy');

//get classrooms by facility_id or get all classrooms with facility_id=0
Route::get('classrooms/{facility_id}', 'Api\ClassroomController@index');
Route::get('classrooms/options/{facility_id}', 'Api\ClassroomController@options');
Route::get('classroom/{id}', 'Api\ClassroomController@show');
Route::put('classroom', 'Api\ClassroomController@store');
Route::post('classroom', 'Api\ClassroomController@store');
Route::delete('classroom/{id}', 'Api\ClassroomController@destroy');


Route::get('students', 'Api\StudentController@index');
Route::get('student/options', 'Api\StudentController@options');

Route::put('student/status','Api\StudentController@status');
Route::get('student/{student_id}', 'Api\StudentController@show');
Route::get('students/classroom/{classroom_id}', 'Api\StudentController@classroom');
Route::get('students/facility/{facility_id}', 'Api\StudentController@facility');
Route::put('student', 'Api\StudentController@store'); //update existing student
Route::post('student', 'Api\StudentController@store'); //create new student
Route::post('student/upload', 'Api\StudentController@upload'); //upload selfie
Route::delete('student/{id}', 'Api\StudentController@destroy');
//Route::get('carriers/options', 'Api\StudentController@carrier_options');
Route::get('options/carriers', 'Api\OptionsController@carriers');
Route::get('options/states', 'Api\OptionsController@states');


Route::put('guardian/status','Api\GuardianController@status');
Route::get('guardians', 'Api\GuardianController@index');
Route::get('guardians/options', 'Api\GuardianController@options');
Route::get('guardian/{id}', 'Api\GuardianController@show');
Route::put('guardian', 'Api\GuardianController@store'); //update guardian
Route::post('guardian', 'Api\GuardianController@store'); //create guardian w/ user acct
Route::post('guardian/upload', 'Api\GuardianController@upload');




Route::post('guardian/fingerprint','Api\GuardianController@fingerprint');
//Route::get('guardian/students_activities/{id}/{date}', 'Api\GuardianController@students_activities');
Route::put('guardian/save-fingerprint','Api\GuardianController@saveFingerprint');
Route::get('guardians/load-fingerprints','Api\GuardianController@loadFingerprints');




//
Route::get('timecard/edit/{id}', 'Api\TimecardController@edit');

Route::get('timecard/sync/{guardian_id}', 'Api\TimecardController@sync');
Route::get('timecard/sync-all', 'Api\TimecardController@sync_all');

Route::put('timecard', 'Api\TimecardController@save'); //updater for /admin/student-activity (reports)
Route::post('timecard', 'Api\TimecardController@store');


Route::get('timecard/current-status','Api\TimecardController@current_status');
Route::get('timecard/guardian-summary/{guardian_id}','Api\TimecardController@guardian_summary');


//searches using form parameter (uses POST request to execute the search - change back to GET request)
Route::post('timecards/report', 'Api\TimecardController@report');
Route::post('timecards/block_report', 'Api\TimecardController@block_report');
//Route::get('timecard/period_summary/{from}/{to}/{students}', 'Api\TimecardController@period_summary'); //NEW TESTING
//Route::get('student/absentee_data/{from}/{to}', 'Api\StudentController@absentee_data');
Route::get('student/get_days_included/{from}/{to}', 'Api\StudentController@get_days_included');


//TESTING
//Route::get('guardian/totals/{id}/{date}','Api\GuardianController@daily_activity_totals');

Route::get('guardian/student_options/{guardian_id}', 'Api\GuardianController@student_options');
