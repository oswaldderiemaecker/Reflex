<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 15:19
 */

class HobbiesTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('hobbies')->delete();

        Excel::load('/database/seeds/data/hobbies.csv', function($reader) {

            $results = $reader->get();

            foreach($results as $result)
            {
                \Reflex\Hobby::create(array(
                    'code' => $result->code,
                    'name' => $result->name
                    ));
            }
        });
    }

}