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
            $sub_business_unit_id = rand(1,20);

            $sub = \Reflex\Models\SubBusinessUnit::where('id','=',$sub_business_unit_id)->first()->business_unit_id;

            \Reflex\Models\Zone::create([
                'company_id' => 1,
                'business_unit_id' => $sub,
                'sub_business_unit_id' => $sub_business_unit_id,
                'code' => str_pad($index, 10, "0", STR_PAD_LEFT),
                'name' => $faker->firstName.' '.$faker->lastName
            ]);
        }
    }
}