<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 15:19
 */

class VisitTypesTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('visit_types')->delete();

        \Reflex\Models\VisitType::create(array('code' => 'PR', 'name' => 'Programada'));
        \Reflex\Models\VisitType::create(array('code' => 'AD', 'name' => 'Adicional'));
        \Reflex\Models\VisitType::create(array('code' => 'RE', 'name' => 'Reemplazo'));




    }

}