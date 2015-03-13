<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 17:24
 */

class SubBusinessUnitsTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('sub_business_units')->delete();

        $id = \Reflex\BusinessUnit::where('code','=', 'NES')->first()->id;

        \Reflex\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'NEA',
            'name' => 'NEURO A'));

        \Reflex\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'NEB',
            'name' => 'NEURO B'));

        \Reflex\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'NEC',
            'name' => 'NEURO C'));

        $id = \Reflex\BusinessUnit::where('code','=', 'NEM')->first()->id;

        \Reflex\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'NMA',
            'name' => 'NEUMO A'));

        \Reflex\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'NMB',
            'name' => 'NEUMO B'));

        \Reflex\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'NMC',
            'name' => 'NEUMO C'));


        $id = \Reflex\BusinessUnit::where('code','=', 'CAF')->first()->id;

        \Reflex\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'CAA',
            'name' => 'CARDIO A'));

        \Reflex\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'CAB',
            'name' => 'CARDIO B'));

        \Reflex\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'CAC',
            'name' => 'CARDIO C'));

        $id = \Reflex\BusinessUnit::where('code','=', 'DEF')->first()->id;

        \Reflex\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'DEA',
            'name' => 'DERMA A'));

        \Reflex\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'DEB',
            'name' => 'DERMA B'));

        \Reflex\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'DEC',
            'name' => 'DERMA C'));

        $id = \Reflex\BusinessUnit::where('code','=', 'GIF')->first()->id;

        \Reflex\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'GIA',
            'name' => 'GINO A'));

        \Reflex\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'GIB',
            'name' => 'GINO B'));

        \Reflex\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'GIC',
            'name' => 'GINO C'));
    }


}