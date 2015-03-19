<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 18:11
 */

use Faker\Factory as Faker;

class ZonesTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('zones')->delete();

        DB::disableQueryLog();

        $faker = Faker::create();

        foreach (range(1, 400) as $index)
        {
            $business_unit_id = rand(1,5);

            $firstname = $faker->firstName;
            $lastname = $faker->lastName;

            \Reflex\Zone::create([
                'company_id' => 1,
                'business_unit_id' => $business_unit_id,
                'code' => $faker->postcode,
                'name' => $firstname.' '.$lastname
            ]);
        }
    }
}