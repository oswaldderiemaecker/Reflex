<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 15:19
 */

class UniversitiesTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('universities')->delete();

        Excel::load('/database/seeds/data/universities.csv', function($reader) {

            $results = $reader->get();

            foreach($results as $result)
            {
                    \Reflex\University::create(array('country_id' => $result->country_id,
                    'code' => $result->code,
                    'name' => $result->name
                    ));
            }
        });
    }

}