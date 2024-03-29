<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 15:19
 */

class CampaignsTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('campaigns')->delete();

        \Reflex\Models\Campaign::create(array(
            'company_id' =>  1,
            'code' => '201503',
            'name' => 'Ciclo Marzo',
            'start_date' => date('2015-03-01'),
            'close_date' => date('2015-03-20'),
            'finish_date' => date('2015-03-29'),
            'qty_days' => '21'

            ));

        \Reflex\Models\Campaign::create(array(
            'company_id' =>  1,
            'code' => '201504',
            'name' => 'Ciclo Abril',
            'start_date' => date('2015-04-01'),
            'close_date' => date('2015-04-20'),
            'finish_date' => date('2015-04-29'),
            'qty_days' => '21'
        ));

        \Reflex\Models\Campaign::create(array(
            'company_id' =>  1,
            'code' => '201505',
            'name' => 'Ciclo Mayo',
            'start_date' => '2015-05-01',
            'close_date' => '2015-05-20',
            'finish_date' => '2015-05-30',
            'qty_days' => '21'
        ));

        \Reflex\Models\Campaign::create(array(
            'company_id' =>  1,
            'code' => '201506',
            'name' => 'Ciclo Junio',
            'start_date' => '2015-06-01',
            'close_date' => '2015-06-20',
            'finish_date' => '2015-06-30',
            'qty_days' => '21'
        ));

        \Reflex\Models\Campaign::create(array(
            'company_id' =>  1,
            'code' => '201507',
            'name' => 'Ciclo Julio',
            'start_date' => '2015-07-01',
            'close_date' => '2015-07-20',
            'finish_date' => '2015-07-30',
            'qty_days' => '21',
            'active' => '1'
        ));


        \Reflex\Models\Campaign::create(array(
            'company_id' => 1,
            'code' => '201508',
            'name' => 'Ciclo Agosto',
            'start_date' => '2015-07-01',
            'close_date' => '2015-07-20',
            'finish_date' => '2015-07-30',
            'qty_days' => '21'
        ));

        \Reflex\Models\Campaign::create(array(
            'company_id' => 1,
            'code' => '201509',
            'name' => 'Ciclo Septiembre',
            'start_date' => '2015-07-01',
            'close_date' => '2015-07-20',
            'finish_date' => '2015-07-30',
            'qty_days' => '21'
        ));

        \Reflex\Models\Campaign::create(array(
            'company_id' => 1,
            'code' => '201510',
            'name' => 'Ciclo Octubre',
            'start_date' => '2015-07-01',
            'close_date' => '2015-07-20',
            'finish_date' => '2015-07-30',
            'qty_days' => '21'
        ));

        \Reflex\Models\Campaign::create(array(
            'company_id' => 1,
            'code' => '201511',
            'name' => 'Ciclo Noviembre',
            'start_date' => '2015-07-01',
            'close_date' => '2015-07-20',
            'finish_date' => '2015-07-30',
            'qty_days' => '21'
        ));




    }

}