<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    
	    $this->call(StatesTableSeeder::class);
    	$this->call(CarriersTableSeeder::class);
    	
        $this->call(FacilityTableSeeder::class);
        $this->call(RoleTableSeeder::class);
    	$this->call(UserTableSeeder::class);
    	$this->call(ClassroomTableSeeder::class);
    	$this->call(GuardianTableSeeder::class);
    	$this->call(StudentTableSeeder::class);   	

		$this->call(TimecardTableSeeder::class);
    }
}
