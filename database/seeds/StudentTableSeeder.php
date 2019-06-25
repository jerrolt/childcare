<?php

use Illuminate\Database\Seeder;

use App\Guardian;
use App\Student;
use App\Classroom;
use App\Facility;
class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $adminGuardian = Guardian::findOrFail(1); //make admin users a guardian to all students(not primary)
	    
	    $classroom = Classroom::findOrFail(1);
	    $facility = Facility::findOrFail($classroom->facility_id);
	    
        $guardian = Guardian::findOrFail(2); //user.id==1 is admin so seed with id==2
	    $student = new Student();
	    $student->status = 'active';
        $student->firstname = 'Neil';
		$student->lastname = 'Morrison';
		$student->mi = '';
		$student->suffix = '';
		$student->date_of_birth = "2014-08-17";
        $student->gender = "male";
        $student->special_needs = "none";
        $student->allergies = "none";
        $student->image = "1543440791.jpg";
        $student->primary_guardian()->associate($guardian);
        $student->classroom()->associate($classroom);
        $student->facility()->associate($facility);
        $student->save();
        $student->guardians()->attach($guardian);
        $student->guardians()->attach($adminGuardian);
        
		$guardian = Guardian::findOrFail(2);
	    $student = new Student();
	    $student->status = 'active';
        $student->firstname = 'Caroline';
		$student->lastname = 'Morrison';
		$student->mi = '';
		$student->suffix = '';
		$student->date_of_birth = "2012-06-07";
        $student->gender = "female";
        $student->special_needs = "autism";
        $student->special_code = "RX56V7U";
        $student->allergies = "none";
        $student->image = "1543440805.jpg";
        $student->primary_guardian()->associate($guardian);
        $student->classroom()->associate($classroom);
        $student->facility()->associate($facility);
        $student->save();
        $student->guardians()->attach($guardian);
        $student->guardians()->attach($adminGuardian);
        
        
        
        
        $guardian = Guardian::findOrFail(3);
	    $student = new Student();
	    $student->status = 'active';
        $student->firstname = 'Ian';
		$student->lastname = 'Parsons';
		$student->mi = 'L';
		$student->suffix = 'Jr.';
		$student->date_of_birth = "2014-03-10";
        $student->gender = "male";
        $student->special_needs = "asthma";
        $student->allergies = "peanuts, orange juice";
        $student->image = "1543440856.jpg";
        $student->primary_guardian()->associate($guardian);
        $student->classroom()->associate($classroom);
        $student->facility()->associate($facility);
        $student->save();
        $student->guardians()->attach($guardian);
        $student->guardians()->attach($adminGuardian);
        
		$guardian = Guardian::findOrFail(4);
	    $student = new Student();
	    $student->status = 'active';
        $student->firstname = 'Amy';
		$student->lastname = 'Henderson';
		$student->mi = '';
		$student->suffix = '';
		$student->date_of_birth = "2013-12-08";
        $student->gender = "female";
        $student->special_needs = "none";
        $student->allergies = "none";
        $student->image = "1543441872.jpg";
        $student->primary_guardian()->associate($guardian);
        $student->classroom()->associate($classroom);
        $student->facility()->associate($facility);
        $student->save();
        $student->guardians()->attach($guardian);
        $student->guardians()->attach($adminGuardian);
        
		$guardianA = Guardian::findOrFail(5);
		$guardianB = Guardian::findOrFail(6);
	    $student = new Student();
	    $student->status = 'active';
        $student->firstname = 'Amanda';
		$student->lastname = 'Quinn';
		$student->mi = '';
		$student->suffix = '';
		$student->date_of_birth = "2013-05-08";
        $student->gender = "female";
        $student->special_needs = "none";
        $student->allergies = "none";
        $student->image = "1543441857.jpeg";
        $student->primary_guardian()->associate($guardianA);
        $student->classroom()->associate($classroom);
        $student->facility()->associate($facility);
        $student->save();
        $student->guardians()->attach($guardianA);
        $student->guardians()->attach($guardianB);
        $student->guardians()->attach($adminGuardian);
    }
}
