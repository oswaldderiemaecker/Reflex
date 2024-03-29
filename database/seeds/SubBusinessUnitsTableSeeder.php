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

        $id = \Reflex\Models\BusinessUnit::where('code','=', 'NES')->first()->id;

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'NEA',
            'name' => 'NEURO A'));

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'NEB',
            'name' => 'NEURO B'));

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'NEC',
            'name' => 'NEURO C'));

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'NED',
            'name' => 'NEURO D'));

        $id = \Reflex\Models\BusinessUnit::where('code','=', 'NEM')->first()->id;

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'NMA',
            'name' => 'NEUMO A'));

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'NMB',
            'name' => 'NEUMO B'));

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'NMC',
            'name' => 'NEUMO C'));

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'NMD',
            'name' => 'NEUMO D'));

        $id = \Reflex\Models\BusinessUnit::where('code','=', 'CAF')->first()->id;

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'CAA',
            'name' => 'CARDIO A'));

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'CAB',
            'name' => 'CARDIO B'));

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'CAC',
            'name' => 'CARDIO C'));

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'CAD',
            'name' => 'CARDIO D'));
        $id = \Reflex\Models\BusinessUnit::where('code','=', 'DEF')->first()->id;

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'DEA',
            'name' => 'DERMA A'));

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'DEB',
            'name' => 'DERMA B'));

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'DEC',
            'name' => 'DERMA C'));

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'DED',
            'name' => 'DERMA D'));
        $id = \Reflex\Models\BusinessUnit::where('code','=', 'GIF')->first()->id;

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'GIA',
            'name' => 'GINO A'));

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'GIB',
            'name' => 'GINO B'));

        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'GIC',
            'name' => 'GINO C'));


        \Reflex\Models\SubBusinessUnit::create(array(
            'business_unit_id' =>  $id,
            'code' => 'GID',
            'name' => 'GINO D'));
    }


}