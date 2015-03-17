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

        \Reflex\VisitStatus::create(array('code' => 'PL', 'name' => 'Plan'));
        \Reflex\VisitStatus::create(array('code' => 'VI', 'name' => 'Visita'));
        \Reflex\VisitStatus::create(array('code' => 'AU', 'name' => 'Ausencia'));


    }

}