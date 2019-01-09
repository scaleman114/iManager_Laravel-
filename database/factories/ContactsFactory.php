<?php

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {
    return [
        'contact_name' => $faker->name,
        'email' => $faker->email,
        'customer_id' => factory('App\Customer')->create()->id,
    ];
});