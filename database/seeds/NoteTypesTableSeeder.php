<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 16:54
 */

class NoteTypesTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('note_types')->delete();

        \Reflex\Models\NoteType::create(array('code' => 'AAC', 'name' => 'Alerta Activa'));
        \Reflex\Models\NoteType::create(array('code' => 'INF', 'name' => 'Información'));
        \Reflex\Models\NoteType::create(array('code' => 'NOT', 'name' => 'Notificación'));
        \Reflex\Models\NoteType::create(array('code' => 'OBJ', 'name' => 'Objetivo '));
    }
}