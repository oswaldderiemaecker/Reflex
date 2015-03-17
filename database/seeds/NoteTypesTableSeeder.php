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

        \Reflex\Role::create(array('code' => 'AD', 'name' => 'Administrador'));
        \Reflex\Role::create(array('code' => 'LU', 'name' => 'Lufthansa'));
        \Reflex\Role::create(array('code' => 'GG', 'name' => 'Gerente General'));
        \Reflex\Role::create(array('code' => 'GD', 'name' => 'Gerente División'));
        \Reflex\Role::create(array('code' => 'JP', 'name' => 'Product Manager'));
        \Reflex\Role::create(array('code' => 'SU', 'name' => 'Supervisor'));
        \Reflex\Role::create(array('code' => 'CO', 'name' => 'Consultor'));


    }
}