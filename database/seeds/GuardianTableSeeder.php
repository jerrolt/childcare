<?php

use Illuminate\Database\Seeder;
use App\Guardian;
use App\User;
use App\Carrier;
class GuardianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    //user_id, carrier_id foreign keys
	    $carrier = Carrier::findOrFail(4);	    
	    $user = User::where('lastname','Morrison')->first();	    
	    $guardian = new Guardian();
        $guardian->firstname = $user->firstname;
		$guardian->lastname = $user->lastname;
		$guardian->mi = $user->mi;
		$guardian->suffix = '';
		$guardian->address = $user->address;
        $guardian->city = $user->city;
        $guardian->state = $user->state;
        $guardian->zipcode = $user->zipcode;
        $guardian->phone = $user->phone;       
        $guardian->is_admin = 0;
        $guardian->image = "1543440643.jpg";
        //foreign_keys
        $guardian->carrier()->associate($carrier);
        $guardian->user()->associate($user);
        $guardian->save();
        
        
        //user_id, carrier_id foreign keys
        $carrier = Carrier::findOrFail(57);
        $user = User::where('lastname','Parsons')->first();
        $guardian = new Guardian();
        $guardian->firstname = $user->firstname;
		$guardian->lastname = $user->lastname;
		$guardian->mi = $user->mi;
		$guardian->suffix = '';
		$guardian->address = $user->address;
        $guardian->city = $user->city;
        $guardian->state = $user->state;
        $guardian->zipcode = $user->zipcode;
        $guardian->phone = $user->phone;
        $guardian->is_admin = 0;
        $guardian->image = "1543440655.jpg";
        //foreign_keys
        $guardian->carrier()->associate($carrier);
        $guardian->user()->associate($user);
        $guardian->save();
        
        
        //user_id, carrier_id foreign keys
        $carrier = Carrier::findOrFail(47);
        $user = User::where('lastname','Henderson')->first();
        $guardian = new Guardian();
        $guardian->firstname = $user->firstname;
		$guardian->lastname = $user->lastname;
		$guardian->mi = $user->mi;
		$guardian->suffix = '';
		$guardian->address = $user->address;
        $guardian->city = $user->city;
        $guardian->state = $user->state;
        $guardian->zipcode = $user->zipcode;
        $guardian->phone = $user->phone;
        $guardian->is_admin = 0;
        $guardian->image = "1543440622.jpg";
        //foreign_keys
        $guardian->carrier()->associate($carrier);
        $guardian->user()->associate($user);
        $guardian->save();
        
        
        //user_id, carrier_id foreign keys
        $carrier = Carrier::findOrFail(30);
        $user = User::where('lastname','Quinn')->first();
        $guardian = new Guardian();
        $guardian->firstname = $user->firstname;
		$guardian->lastname = $user->lastname;
		$guardian->mi = $user->mi;
		$guardian->suffix = '';
		$guardian->address = $user->address;
        $guardian->city = $user->city;
        $guardian->state = $user->state;
        $guardian->zipcode = $user->zipcode;
        $guardian->phone = $user->phone;
        $guardian->is_admin = 0;
        $guardian->image = "1543440675.jpeg";
        //foreign_keys
        $guardian->carrier()->associate($carrier);
        $guardian->user()->associate($user);
        $guardian->save();
        
        
        //user_id, carrier_id foreign keys
        $carrier = Carrier::findOrFail(18);
		$user = User::where('lastname','Simpson')->first();
        $guardian = new Guardian();
        $guardian->firstname = $user->firstname;
		$guardian->lastname = $user->lastname;
		$guardian->mi = $user->mi;
		$guardian->suffix = '';
		$guardian->address = $user->address;
        $guardian->city = $user->city;
        $guardian->state = $user->state;
        $guardian->zipcode = $user->zipcode;
        $guardian->phone = $user->phone;
        $guardian->is_admin = 0;
        $guardian->image = "1543440690.jpeg";
        //fkeys
        $guardian->carrier()->associate($carrier);
        $guardian->user()->associate($user);
        $guardian->save();
    }
}
