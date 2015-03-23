<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 17:17
 */

class CategoriesTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('categories')->delete();

        \Reflex\Models\Category::create(array(
            'company_id' =>  \Reflex\Models\Company::where('code','=', 'FJ')->first()->id,
            'code' => 'V',
            'name' => 'VIP',
            'qty_visits' => 2 ));

        \Reflex\Models\Category::create(array(
            'company_id' =>  \Reflex\Models\Company::where('code','=', 'FJ')->first()->id,
            'code' => 'A',
            'name' => 'A',
            'qty_visits' => 1));

        \Reflex\Models\Category::create(array(
            'company_id' =>  \Reflex\Models\Company::where('code','=', 'FJ')->first()->id,
            'code' => 'B',
            'name' => 'B',
            'qty_visits' => 1));

        \Reflex\Models\Category::create(array(
            'company_id' =>  \Reflex\Models\Company::where('code','=', 'FJ')->first()->id,
            'code' => 'C',
            'name' => 'C',
            'qty_visits' => 0));

    }

}