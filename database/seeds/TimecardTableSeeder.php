<?php

use Illuminate\Database\Seeder;
use App\Timecard;

class TimecardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    //G-2 S-1
		// 11/19
        $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-19 08:30:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin = '1';
		$tc->is_checkout = '0';		
		$tc->notes = '';
		$tc->save();

		$tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-19 13:30:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = '';
		$tc->save();
        
        $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-19 14:30:01';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin = '1';
		$tc->is_checkout = '0';		
		$tc->notes = '';
		$tc->save();

		$tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-19 23:59:59';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = 'AUTO CHECKOUT: 2018-11-19 23:59:59';
		$tc->save();
		
	    // 11/20
        $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-20 09:30:01';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin = '1';
		$tc->is_checkout = '0';		
		$tc->notes = '';
		$tc->save();
		
		$tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-20 15:45:59';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = '';
		$tc->save();
		
        $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-20 17:30:01';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin = '1';
		$tc->is_checkout = '0';		
		$tc->notes = '';
		$tc->save();
		
		$tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-20 23:59:59';
		$tc->confirmed_by = '1'; //admin		
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = 'AUTO CHECKOUT: 2018-11-20 23:59:59';
		$tc->save();
		
        // 11/21
        $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-21 7:30:01';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin = '1';
		$tc->is_checkout = '0';		
		$tc->notes = '';
		$tc->save();

		$tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-21 14:27:52';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = '';
		$tc->save();
		
		// 11/22
        $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-22 9:30:01';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin = '1';
		$tc->is_checkout = '0';		
		$tc->notes = '';
		$tc->save();

		$tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-22 11:59:59';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = '';
		$tc->save();
		
        $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-22 13:30:01';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin = '1';
		$tc->is_checkout = '0';		
		$tc->notes = '';
		$tc->save();

		$tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-22 23:59:59';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = 'AUTO CHECKOUT: 2018-11-24 23:59:59';
		$tc->save();
				
		// 11/23
		$tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-23 13:05:46';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '1';
		$tc->is_checkout = '0';		
		$tc->notes       = '';
		$tc->save();
		
        $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-23 13:06:17';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = '';
		$tc->save();
	        
        // 11/26
        $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-26 08:30:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin = '1';
		$tc->is_checkout = '0';		
		$tc->notes = '';
		$tc->save();

		$tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-26 17:20:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = '';
		$tc->save();
		     
        // 11/27
        $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-27 08:00:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin = '1';
		$tc->is_checkout = '0';		
		$tc->notes = '';
		$tc->save();

		$tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '1';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-27 12:00:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = '';
		$tc->save();			
			
			
			
			
		
		//G-2 S-2 
		// 11/20
		$tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '2';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-20 16:15:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '1';
		$tc->is_checkout = '0';			
		$tc->notes       = '';
		$tc->save();
			
        $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '2';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-20 23:59:59';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = 'AUTO CHECKOUT: 2018-11-20 23:59:59';
		$tc->save();
		
		// 11/21	
		$tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '2';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-21 07:00:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '1';
		$tc->is_checkout = '0';		
		$tc->notes       = '';
		$tc->save();	
		
	    $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '2';				
		$tc->facility_id = '1';	
		$tc->confirmed_at = $tc->action_at = '2018-11-21 16:45:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = '';
		$tc->save();
			
        $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '2';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-21 18:30:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '1';
		$tc->is_checkout = '0';		
		$tc->notes       = '';
		$tc->save();	
		
	    $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '2';				
		$tc->facility_id = '1';	
		$tc->confirmed_at = $tc->action_at = '2018-11-21 23:59:59';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = 'AUTO CHECKOUT: 2018-11-21 23:59:59';
		$tc->save();
		
		// 11/22	
		$tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '2';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-22 09:45:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '1';
		$tc->is_checkout = '0';		
		$tc->notes       = '';
		$tc->save();	
		
	    $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '2';				
		$tc->facility_id = '1';	
		$tc->confirmed_at = $tc->action_at = '2018-11-22 17:45:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = '';
		$tc->save();		

		// 11/23	
		$tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '2';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-23 11:35:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '1';
		$tc->is_checkout = '0';		
		$tc->notes       = '';
		$tc->save();	
		
	    $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '2';				
		$tc->facility_id = '1';	
		$tc->confirmed_at = $tc->action_at = '2018-11-23 18:35:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = '';
		$tc->save();
	
		// 11/26
        $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '2';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-26 09:22:27';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '1';
		$tc->is_checkout = '0';			
		$tc->notes       = '';
		$tc->save();
			
        $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '2';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-26 23:59:59';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = 'AUTO CHECKOUT: 2018-11-26 23:59:59';
		$tc->save();
		
		// 11/27
		$tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '2';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-27 09:45:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '1';
		$tc->is_checkout = '0';			
		$tc->notes       = '';
		$tc->save();
			
        $tc = new Timecard();
		$tc->guardian_id = '2';		
		$tc->student_id  = '2';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-27 23:59:59';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = 'AUTO CHECKOUT: 2018-11-25 23:59:59';
		$tc->save();		
		




		// G-3 S-3 
		// 11/19
		$tc = new Timecard();
		$tc->guardian_id = '3';		
		$tc->student_id  = '3';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-19 08:45:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '1';
		$tc->is_checkout = '0';			
		$tc->notes       = '';
		$tc->save();
			
        $tc = new Timecard();
		$tc->guardian_id = '3';		
		$tc->student_id  = '3';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-19 23:59:59';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = 'AUTO CHECKOUT: 2018-11-19 23:59:59';
		$tc->save();
				
		// 11/20
		$tc = new Timecard();
		$tc->guardian_id = '3';		
		$tc->student_id  = '3';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-20 12:58:27';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '1';
		$tc->is_checkout = '0';			
		$tc->notes       = '';
		$tc->save();
			
        $tc = new Timecard();
		$tc->guardian_id = '3';		
		$tc->student_id  = '3';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-20 18:59:59';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = 'AUTO CHECKOUT: 2018-11-20 23:59:59';
		$tc->save();
		
		// 11/21
		$tc = new Timecard();
		$tc->guardian_id = '3';		
		$tc->student_id  = '3';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at = '2018-11-21 07:00:00';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '1';
		$tc->is_checkout = '0';		
		$tc->notes       = '';
		$tc->save();	
						
        $tc = new Timecard();
		$tc->guardian_id = '3';		
		$tc->student_id  = '3';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at   = '2018-11-21 13:06:17';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';			
		$tc->notes       = '';
		$tc->save();
		
		$tc = new Timecard();
		$tc->guardian_id = '3';		
		$tc->student_id  = '3';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at   = '2018-11-21 14:45:59';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '1';
		$tc->is_checkout = '0';		
		$tc->notes       = '';
		$tc->save();	
						
        $tc = new Timecard();
		$tc->guardian_id = '3';		
		$tc->student_id  = '3';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at   = '2018-11-21 23:59:59';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';			
		$tc->notes       = 'AUTO CHECKOUT: 2018-11-21 23:59:59';
		$tc->save();
								
		// 11/26
	    $tc = new Timecard();
		$tc->guardian_id = '3';		
		$tc->student_id  = '3';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at   = '2018-11-26 14:39:56';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '1';
		$tc->is_checkout = '0';		
		$tc->notes       = '';
		$tc->save();
		
		$tc = new Timecard();
		$tc->guardian_id = '3';		
		$tc->student_id  = '3';				
		$tc->facility_id = '1';	
		$tc->confirmed_at = $tc->action_at   = '2018-11-26 22:18:53';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = '';
		$tc->save();
		
		// 11/27
		$tc->save();				
	    $tc = new Timecard();
		$tc->guardian_id = '3';		
		$tc->student_id  = '3';				
		$tc->facility_id = '1';		
		$tc->confirmed_at = $tc->action_at   = '2018-11-27 09:39:56';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '1';
		$tc->is_checkout = '0';		
		$tc->notes       = '';
		$tc->save();
		
		$tc = new Timecard();
		$tc->guardian_id = '3';		
		$tc->student_id  = '3';				
		$tc->facility_id = '1';	
		$tc->confirmed_at = $tc->action_at   = '2018-11-27 19:18:53';
		$tc->confirmed_by = '1'; //admin
		$tc->is_checkin  = '0';
		$tc->is_checkout = '1';		
		$tc->notes       = '';
		$tc->save();
    }
}
