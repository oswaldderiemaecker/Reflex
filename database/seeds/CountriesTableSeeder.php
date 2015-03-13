<?php

class CountriesTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('countries')->delete();

        \Reflex\Country::create(array('code' => 'PE','name' => 'Perú', 'language' => 'ES','currency' => 'PEN'));
        \Reflex\Country::create(array('code' => 'CL','name' => 'Chile', 'language' => 'ES','currency' => 'CLP'));
        \Reflex\Country::create(array('code' => 'PY','name' => 'Paraguay', 'language' => 'ES','currency' => 'PYG'));
        \Reflex\Country::create(array('code' => 'AR','name' => 'Argentina', 'language' => 'ES','currency' => 'ARS'));
        \Reflex\Country::create(array('code' => 'BO','name' => 'Bolivia', 'language' => 'ES','currency' => 'BOB'));
        \Reflex\Country::create(array('code' => 'CO','name' => 'Colombia', 'language' => 'ES','currency' => 'COP'));
        \Reflex\Country::create(array('code' => 'VE','name' => 'Venezuela', 'language' => 'ES','currency' => 'VEF'));
        \Reflex\Country::create(array('code' => 'BR','name' => 'Brasil', 'language' => 'ES','currency' => 'BRL'));


    }

}