<?php

use Faker\Generator as Faker;

$factory->define(App\Facility::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'state' => $faker->stateAbbr,
        'zipcode' => $faker->postcode,
        'phone' => $faker->phoneNumber,
        'carrier_id' => 4
    ];
});
