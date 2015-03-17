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
            'name' => 'Ciclo Test',
            'start_date' => '2015-01-01',
            'close_date' => '2015-12-12',
            'finish_date' => '2015-12-12',
            'qty_days' => '21'
            ));



    }

}