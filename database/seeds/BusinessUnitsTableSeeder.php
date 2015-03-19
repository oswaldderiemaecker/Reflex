<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 17:24
 */

class BusinessUnitsTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('business_units')->delete();

        $id = \Reflex\Company::where('code','=', 'FJ')->first()->id;

        \Reflex\BusinessUnit::create(array(
            'company_id' =>  $id,
            'code' => 'NES',
            'name' => 'NEURO SCIENCE'));

        \Reflex\BusinessUnit::create(array(
            'company_id' =>  $id,
            'code' => 'NEM',
            'name' => 'NEUMO FLEX'));

        \Reflex\BusinessUnit::create(array(
            'company_id' =>  $id,
            'code' => 'CAF',
            'name' => 'CARDIO FLEX'));

        \Reflex\BusinessUnit::create(array(
            'company_id' =>  $id,
            'code' => 'DEF',
            'name' => 'DERMA FLEX'));

        \Reflex\BusinessUnit::create(array(
            'company_id' =>  $id,
            'code' => 'GIF',
            'name' => 'GINO FLEX'));




    }

}