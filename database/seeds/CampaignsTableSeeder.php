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

        \Reflex\Campaign::create(array(
            'company_id' =>  1,
            'code' => '201503',
            'name' => 'Ciclo Marzo',
            'start_date' => '2015-03-01',
            'close_date' => '2015-03-20',
            'finish_date' => '2015-03-30',
            'qty_days' => '21',
            'active' => '1'
            ));

        \Reflex\Campaign::create(array(
            'company_id' =>  1,
            'code' => '201504',
            'name' => 'Ciclo Abril',
            'start_date' => '2015-04-01',
            'close_date' => '2015-04-20',
            'finish_date' => '2015-04-30',
            'qty_days' => '21'
        ));

        \Reflex\Campaign::create(array(
            'company_id' =>  1,
            'code' => '201505',
            'name' => 'Ciclo Mayo',
            'start_date' => '2015-05-01',
            'close_date' => '2015-15-20',
            'finish_date' => '2015-05-30',
            'qty_days' => '21'
        ));

        \Reflex\Campaign::create(array(
            'company_id' =>  1,
            'code' => '201506',
            'name' => 'Ciclo Junio',
            'start_date' => '2015-06-01',
            'close_date' => '2015-06-20',
            'finish_date' => '2015-06-30',
            'qty_days' => '21'
        ));

        \Reflex\Campaign::create(array(
            'company_id' =>  1,
            'code' => '201507',
            'name' => 'Ciclo Agosto',
            'start_date' => '2015-07-01',
            'close_date' => '2015-07-20',
            'finish_date' => '2015-07-30',
            'qty_days' => '21'
        ));



    }

}