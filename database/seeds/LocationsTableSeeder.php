<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 15:19
 */

class LocationsTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){


        DB::disableQueryLog();
        DB::table('locations')->delete();

        Excel::load('/database/seeds/data/locations.csv', function($reader) {

            $results = $reader->get();

            foreach($results as $result)
            {
                \Reflex\Location::create(array(
                    'country_id' => $result->country_id,
                    'region_id' => $result->region_id,
                    'code' => $result->code,
                    'name' => $result->name,
                    'department' => $result->department,
                    'province' => $result->province,
                    'district' => $result->district,
                ));
            }
        });
    }

}