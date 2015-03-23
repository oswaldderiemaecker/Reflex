<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 16:49
 */

class PlacesTableSeeder extends \Illuminate\Database\Seeder {

    public function run()
    {
        DB::table('places')->delete();


        $id = \Reflex\Models\Company::where('code','=', 'FJ')->first()->id;
        \Reflex\Models\Place::create(array('company_id' => $id,'code' => 'CO','name' => 'Consulta'));
        \Reflex\Models\Place::create(array('company_id' => $id,'code' => 'AM','name' => 'Hospital'));

    }

}