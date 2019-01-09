<?php

use Faker\Generator as Faker;

$factory->define(App\Customer::class, function (Faker $faker) {
    return [
        'cust_name' => $faker->name,
        'address' => $faker->address,
        'main_phone' => $faker->phonenumber,
    ];
});