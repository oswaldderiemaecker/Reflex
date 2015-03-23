<?php

use Reflex\Models\Country;
class CountriesTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('countries')->delete();

        Country::create(array('code' => 'PE','name' => 'Perú', 'language' => 'ES','currency' => 'PEN'));
        Country::create(array('code' => 'CL','name' => 'Chile', 'language' => 'ES','currency' => 'CLP'));
        Country::create(array('code' => 'PY','name' => 'Paraguay', 'language' => 'ES','currency' => 'PYG'));
        Country::create(array('code' => 'AR','name' => 'Argentina', 'language' => 'ES','currency' => 'ARS'));
        Country::create(array('code' => 'BO','name' => 'Bolivia', 'language' => 'ES','currency' => 'BOB'));
        Country::create(array('code' => 'CO','name' => 'Colombia', 'language' => 'ES','currency' => 'COP'));
        Country::create(array('code' => 'VE','name' => 'Venezuela', 'language' => 'ES','currency' => 'VEF'));
        Country::create(array('code' => 'BR','name' => 'Brasil', 'language' => 'ES','currency' => 'BRL'));


    }

}