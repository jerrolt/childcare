<?php

use Illuminate\Database\Seeder;
use App\Facility;

class FacilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Facility::class, 15)->create();
    }
}
