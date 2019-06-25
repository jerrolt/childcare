<?php

use Illuminate\Database\Seeder;

use App\Facility;
use App\Classroom;

class ClassroomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $facility=Facility::findOrFail(1);
	    
		$classroom = new Classroom();
        $classroom->name = $facility->name.' - Classroom 1';
        $classroom->facility_id = $facility->id;
		$classroom->save();
		
		$classroom = new Classroom();
        $classroom->name = $facility->name.' - Classroom 2';
        $classroom->facility_id = $facility->id;
		$classroom->save();
		
		$classroom = new Classroom();
        $classroom->name = $facility->name.' - Classroom 3';
        $classroom->facility_id = $facility->id;
		$classroom->save();
		
		$classroom = new Classroom();
        $classroom->name = $facility->name.' - Classroom 4';
        $classroom->facility_id = $facility->id;
		$classroom->save();		

		$classroom = new Classroom();
        $classroom->name = $facility->name.' - Classroom 5';
        $classroom->facility_id = $facility->id;
		$classroom->save();
		
		
		$facility=Facility::findOrFail(2);
		
		$classroom = new Classroom();
        $classroom->name = $facility->name.' - Classroom A';
        $classroom->facility_id = $facility->id;
		$classroom->save();
		
		$classroom = new Classroom();
        $classroom->name = $facility->name.' - Classroom B';
        $classroom->facility_id = $facility->id;
		$classroom->save();
		
		$classroom = new Classroom();
        $classroom->name = $facility->name.' - Classroom C';
        $classroom->facility_id = $facility->id;
		$classroom->save();
		
		$classroom = new Classroom();
        $classroom->name = $facility->name.' - Classroom D';
        $classroom->facility_id = $facility->id;
		$classroom->save();		

		$classroom = new Classroom();
        $classroom->name = $facility->name.' - Classroom E';
        $classroom->facility_id = $facility->id;
		$classroom->save();	
    }
}
