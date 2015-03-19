<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 15:19
 */

class CompaniesTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('companies')->delete();

        \Reflex\Company::create(array(
            'country_id' =>  \Reflex\Country::where('code','=', 'PE')->first()->id,
            'code' => 'FJ',
            'name' => 'FARMA JASMINE'));

     /*   \Reflex\Company::create(array(
            'country_id' =>  \Reflex\Country::where('code','=', 'CL')->first()->id,
            'code' => 'FD',
            'name' => 'FARMA DAV'));



        \Reflex\Company::create(array(
            'country_id' =>  \Reflex\Country::where('code','=', 'PE')->first()->id,
            'code' => 'FL',
            'name' => 'FARMA LUX'));

        \Reflex\Company::create(array(
            'country_id' =>  \Reflex\Country::where('code','=', 'PE')->first()->id,
            'code' => 'MF',
            'name' => 'MARY FARMA'));*/

    }

}