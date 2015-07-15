<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 18:11
 */

use Faker\Factory as Faker;

class AssignmentsTableSeeder extends \Illuminate\Database\Seeder
{

    public function run()
    {

        DB::table('assignments')->delete();

        DB::disableQueryLog();

        $faker = Faker::create();


        $campaign = \Reflex\Models\Campaign::where('active', '=', '1')->first();


        foreach (range(1, 400) as $index) {

            \Reflex\Models\Assignment::create([
                'campaign_id' => $campaign->id,
                'user_id' => $index,
                'zone_id' => $index,
                'description' => $faker->sentence(6)
            ]);
        }
    }
}