<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 18:11
 */

class UsersTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('users')->delete();
        $business_unit_id = \Reflex\BusinessUnit::where('code','=', 'NES')->first()->id;
        $sub_business_unit_id = \Reflex\SubBusinessUnit::where('code','=', 'NEA')->first()->id;
        $company_id = \Reflex\Company::where('code','=', 'FJ')->first()->id;
        $role_id = \Reflex\Role::where('code','=', 'SU')->first()->id;

        \Reflex\User::create(array(
            'role_id' => $role_id,
            'company_id' => $company_id,
            'business_unit_id' => $business_unit_id,
            'sub_business_unit_id' => $sub_business_unit_id,
            'firstname' => 'David Joan',
            'lastname' => 'Tataje Mendoza',
            'closeup_name' => 'DAVID TATAJE',
            'email' => 'davidtataje@gmail.com',
            'username' => 'davidjoan',
            'password' => Hash::make('1234')
        ));

        $supervisor_id = \Reflex\User::where('username','=', 'davidjoan')->first()->id;
        $role_id = \Reflex\Role::where('code','=', 'SU')->first()->id;




        \Reflex\User::create(array(
            'role_id' => $role_id,
            'company_id' => $company_id,
            'business_unit_id' => $business_unit_id,
            'sub_business_unit_id' => $sub_business_unit_id,
            'supervisor_id' => $supervisor_id,
            'firstname' => 'Daniel',
            'lastname' => 'Saavedra',
            'closeup_name' => 'DANIEL SAAVEDRA',
            'email' => 'dasaaved1981@gmail.com',
            'username' => 'daniel',
            'password' => Hash::make('1234')
        ));



    }
}