<?php

use Illuminate\Database\Seeder;

use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        //admin role
		$role = new Role();
		$role->name = 'admin';
		$role->description = 'Application administrator.';
		$role->priority = 10000;
		$role->save();
		
		
		//employee
		$role = new Role();
		$role->name = 'employee';
		$role->description = 'An employee';
		$role->priority = 50000;
		$role->save();
		
		//guardian role
		$role = new Role();
		$role->name = 'guardian';
		$role->description = 'A resident guardian.';
		$role->priority = 100000;
		$role->save();
    }
}
