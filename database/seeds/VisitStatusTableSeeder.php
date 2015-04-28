<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 15:19
 */

class VisitStatusTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('visit_status')->delete();

        \Reflex\Models\VisitStatus::create(array('code' => 'PE', 'name' => 'Pendiente'));
        \Reflex\Models\VisitStatus::create(array('code' => 'VI', 'name' => 'Visitado'));
        \Reflex\Models\VisitStatus::create(array('code' => 'AU', 'name' => 'Ausente'));


    }

}