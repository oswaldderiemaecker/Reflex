<?php
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(\Reflex\User::class, function ($faker) {
    return [
        'password' => str_random(10),
        'remember_token' => str_random(10),
        'role_id' => 1,
        'company_id' => 1,
        'business_unit_id' => 1,
        'sub_business_unit_id' => 1,
        'supervisor_id' => 1,
        'code' => str_random(10),
        'firstname' => $faker->firstname,
        'lastname' => $faker->firstname,
        'closeup_name' => $faker->firstname,
        'email' => $faker->email,
        'username' => str_random(10),
        'photo' => str_random(10),
        'imei' => str_random(10),
        'facebook_token' => str_random(10),
        'google_token' => str_random(10)
    ];
});