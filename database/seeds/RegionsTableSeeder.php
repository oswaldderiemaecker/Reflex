<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 15:19
 */

class RegionsTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){


        DB::disableQueryLog();
        DB::table('regions')->delete();


        Excel::load('/database/seeds/data/regions.csv', function($reader) {

            $results = $reader->get();

            foreach($results as $result)
            {
                \Reflex\Models\Region::create(array(
                    'country_id' => $result->country_id,
                    'code' => $result->code,
                    'name' => $result->name
                    ));
            }
        });
    }

}