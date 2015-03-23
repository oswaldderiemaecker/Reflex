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

        \Reflex\Models\VisitStatus::create(array('code' => 'PL', 'name' => 'Plan'));
        \Reflex\Models\VisitStatus::create(array('code' => 'VI', 'name' => 'Visita'));
        \Reflex\Models\VisitStatus::create(array('code' => 'AU', 'name' => 'Ausencia'));


    }

}