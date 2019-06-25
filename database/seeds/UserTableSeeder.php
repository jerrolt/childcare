<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Role;
use App\Guardian;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Admin
		$admin_role = Role::where('name', 'admin')->first();
        $user = new User();
        $guardian = new Guardian();
		$guardian->firstname = $user->firstname = 'Application';
		$guardian->lastname = $user->lastname = 'Admin';
		$guardian->mi = $user->mi = '';
		$user->email = 'gene0904@gmail.com';
		$user->password = bcrypt('password');
		$user->account_number = rand(1000000000, 9999999999);		
        $guardian->address = $user->address = $user->address = "2746 Andell Rd.";
        $guardian->city = $user->city = ucfirst(strtolower("Goodlettsville"));
        $guardian->state = $user->state = "TN";
        $guardian->zipcode = $user->zipcode = "37072";
        $guardian->phone = $user->phone = "615-681-7207";
        $guardian->is_admin = 1;
        $user->status = 'active';
		$user->save();
		$user->roles()->attach($admin_role);
		$guardian->carrier_id = 4;		
        $guardian->user()->associate($user);
        $guardian->save();



		//Teacher
		$employee_role = Role::where('name', 'employee')->first();
		$user = new User();
		$user->firstname = 'Rodrigez';
		$user->lastname = 'Admin';
		$user->mi = '';
		$user->email = 'gene0904@yahoo.com';
		$user->password = bcrypt('password');		
		$user->account_number = rand(100000000, 999999999);
        $user->address = "4240 Rose St.";
        $user->city = ucfirst(strtolower("ANTIOCH"));
        $user->state = "TN";
        $user->zipcode = "37011";
        $user->phone = "615-485-1478";
        $user->status = 'active';			
		$user->save();	    
		$user->roles()->attach($employee_role);

		
		
		
		
		
		
		
		/** 
		 *	Guardian Users
		 **/
		 
		//1 - Sarah	Morrison
		$guardian_role = Role::where('name', 'guardian')->first();
		$user = new User();
		$user->firstname = 'Sarah';
		$user->lastname = 'Morrison';
		$user->mi = 'G';
		$user->email = 'Sarah.Morrison@yahoo.com';
		$user->password = bcrypt('password');		
		$user->account_number = rand(1000000000, 9999999999);
        $user->address = "201 N Ridge Dr";
        $user->city = ucfirst(strtolower("MADISON"));
        $user->state = "TN";
        $user->zipcode = "37116";
        $user->phone = "(423) 404-9362";	
        $user->status = 'active';	
		$user->save();	    
		$user->roles()->attach($guardian_role);
						
		//2 - Donna	Parsons
		$guardian_role = Role::where('name', 'guardian')->first();
		$user = new User();
		$user->firstname = 'Donna';
		$user->lastname = 'Parsons';
		$user->mi = 'C';
		$user->email = 'Donna.Parsons@yahoo.com';		
		$user->password = bcrypt('password');		
		$user->account_number = rand(1000000000, 9999999999);
        $user->address = "4879 Cottonwood Ln.";
        $user->city = ucfirst(strtolower("Nashville"));
        $user->state = "TN";
        $user->zipcode = "37203";
        $user->phone = "615-939-7997";
        $user->status = 'active';		
		$user->save();	    
		$user->roles()->attach($guardian_role);
								
		//3 - Ella Henderson
		$guardian_role = Role::where('name', 'guardian')->first();
		$user = new User();
		$user->firstname = 'Ella';
		$user->lastname = 'Henderson';
		$user->mi = '';
		$user->email = 'Ella.Henderson@yahoo.com';		
		$user->password = bcrypt('password');		
		$user->account_number = rand(1000000000, 9999999999);
        $user->address = "4752 Green St";
        $user->city = ucfirst(strtolower("Nashville"));
        $user->state = "TN";
        $user->zipcode = "37207";
        $user->phone = "615-626-0897";	
        $user->status = 'pending';	
		$user->save();	    
		$user->roles()->attach($guardian_role);
						
		//4 - Rachel Quinn
		$guardian_role = Role::where('name', 'guardian')->first();
		$user = new User();
		$user->firstname = 'Rachel';
		$user->lastname = 'Quinn';
		$user->mi = 'J';
		$user->email = 'Rachel.Quinn@yahoo.com';
		$user->password = bcrypt('password');		
		$user->account_number = rand(1000000000, 9999999999);
        $user->address = "2478 Green St";
        $user->city = ucfirst(strtolower("Nashville"));
        $user->state = "TN";
        $user->zipcode = "37214";
        $user->phone = "(615) 432-2338";		
        $user->status = 'pending';
		$user->save();	    
		$user->roles()->attach($guardian_role);
				
		//5 - Heather Simpson
		$guardian_role = Role::where('name', 'guardian')->first();
		$user = new User();
		$user->firstname = 'Heather';
		$user->lastname = 'Simpson';
		$user->mi = '';
		$user->email = 'Heather.Simpson@yahoo.com';
		$user->password = bcrypt('password');		
		$user->account_number = rand(1000000000, 9999999999);
        $user->address = "1244 Bombardier Way";
        $user->city = ucfirst(strtolower("Nashville"));
        $user->state = "TN";
        $user->zipcode = "37242";
        $user->phone = "(615) 364-0987";		
        $user->status = 'disabled';
		$user->save();	    
		$user->roles()->attach($guardian_role);
    }
}
