<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 15:19
 */

class SpecialtiesTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::disableQueryLog();

        DB::table('specialties')->delete();

        Excel::load('/database/seeds/data/specialties.csv', function($reader) {

            $results = $reader->get();

            foreach($results as $result)
            {
                \Reflex\Specialty::create(array(
                    'code' => $result->code,
                    'name' => $result->name
                    ));
            }
        });
    }

}