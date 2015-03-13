<?php

class ReasonsTableSeeder extends \Illuminate\Database\Seeder {

    public function run()
    {
        DB::table('reasons')->delete();

        \Reflex\Reason::create(array('code' => 'MNR','name' => 'MEDICO NO RECIBE'));
        \Reflex\Reason::create(array('code' => 'MDM','name' => 'MEDICO CON DESCANSO MEDICO'));
        \Reflex\Reason::create(array('code' => 'DNE','name' => 'DIRECCION NO ENCONTRADA'));
        \Reflex\Reason::create(array('code' => 'MFA','name' => 'MEDICO FALLECIDO'));
        \Reflex\Reason::create(array('code' => 'DNA','name' => 'DESASTRE NATURAL'));
        \Reflex\Reason::create(array('code' => 'MCZ','name' => 'MEDICO CAMBIO DE ZONA'));
        \Reflex\Reason::create(array('code' => 'PIN','name' => 'PROHIBIDO INGRESO'));
        \Reflex\Reason::create(array('code' => 'NSV','name' => 'NO SE VIAJO'));
        \Reflex\Reason::create(array('code' => 'MDV','name' => 'MEDICO DE VACACIONES'));
        \Reflex\Reason::create(array('code' => 'OTR','name' => 'OTROS'));


    }

}