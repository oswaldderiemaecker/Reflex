<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 15:19
 */

class ClientsTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        ini_set('memory_limit','10024M');
        Eloquent::unguard();

        DB::disableQueryLog();
        DB::table('clients')->delete();

        Excel::batch('/database/seeds/data/clients', function($rows, $file) {

            // Explain the reader how it should interpret each row,
            // for every file inside the batch
            $rows->each(function($result) {

                \Reflex\Client::create(array(
                    'client_type_id' => $result->client_type_id,
                    'company_id' => $result->company_id,
                    'zone_id' => $result->zone_id,
                    'category_id' => $result->category_id,
                    'place_id' => $result->place_id,
                    'specialty_base_id' => $result->specialty_base_id,
                    'specialty_target_id' => $result->specialty_target_id,
                    'location_id' => $result->location_id,
                    'code' => $result->code,
                    'firstname' => $result->firstname,
                    'lastname' => $result->lastname,
                    'closeup_name' => $result->closeup_name,
                    'address' => ($result->address == '')?'S/D':$result->address
                ));
            });
        });
    }

}