<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 15:19
 */

class ClientTypesTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('client_types')->delete();

        \Reflex\Models\ClientType::create(array('code' => 'DO', 'name' => 'Doctor'));
        \Reflex\Models\ClientType::create(array('code' => 'FA', 'name' => 'Farmacia'));
        \Reflex\Models\ClientType::create(array('code' => 'CL', 'name' => 'Clínica'));
        \Reflex\Models\ClientType::create(array('code' => 'HO', 'name' => 'Hospital'));

    }

}