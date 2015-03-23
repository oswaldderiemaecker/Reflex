<?php

use \Reflex\Models\Reason;

class ReasonsTableSeeder extends \Illuminate\Database\Seeder {

    public function run()
    {
        DB::table('reasons')->delete();

        Reason::create(array('code' => 'MNR','name' => 'MEDICO NO RECIBE'));
        Reason::create(array('code' => 'MDM','name' => 'MEDICO CON DESCANSO MEDICO'));
        Reason::create(array('code' => 'DNE','name' => 'DIRECCION NO ENCONTRADA'));
        Reason::create(array('code' => 'MFA','name' => 'MEDICO FALLECIDO'));
        Reason::create(array('code' => 'DNA','name' => 'DESASTRE NATURAL'));
        Reason::create(array('code' => 'MCZ','name' => 'MEDICO CAMBIO DE ZONA'));
        Reason::create(array('code' => 'PIN','name' => 'PROHIBIDO INGRESO'));
        Reason::create(array('code' => 'NSV','name' => 'NO SE VIAJO'));
        Reason::create(array('code' => 'MDV','name' => 'MEDICO DE VACACIONES'));
        Reason::create(array('code' => 'OTR','name' => 'OTROS'));


    }

}