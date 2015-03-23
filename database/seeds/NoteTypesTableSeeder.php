<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 16:54
 */

class NoteTypesTableSeeder extends Seeder {

    public function run(){

        DB::table('note_types')->delete();

        \Reflex\Models\Role::create(array('code' => 'AD', 'name' => 'Administrador'));
        \Reflex\Models\Role::create(array('code' => 'LU', 'name' => 'Lufthansa'));
        \Reflex\Models\Role::create(array('code' => 'GG', 'name' => 'Gerente General'));
        \Reflex\Models\Role::create(array('code' => 'GD', 'name' => 'Gerente División'));
        \Reflex\Models\Role::create(array('code' => 'JP', 'name' => 'Product Manager'));
        \Reflex\Models\Role::create(array('code' => 'SU', 'name' => 'Supervisor'));
        \Reflex\Models\Role::create(array('code' => 'CO', 'name' => 'Consultor'));


    }
}