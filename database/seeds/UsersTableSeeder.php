<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 18:11
 */
use Faker\Factory as Faker;

class UsersTableSeeder extends \Illuminate\Database\Seeder {

    public function run(){

        DB::table('users')->delete();
        $business_unit_id = \Reflex\Models\BusinessUnit::where('code','=', 'NES')->first()->id;
        $sub_business_unit_id = \Reflex\Models\SubBusinessUnit::where('code','=', 'NEA')->first()->id;
        $company_id = \Reflex\Models\Company::where('code','=', 'FJ')->first()->id;
        $role_id = \Reflex\Models\Role::where('code','=', 'SU')->first()->id;

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
        $role_id = \Reflex\Models\Role::where('code','=', 'SU')->first()->id;


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

        $role_id = \Reflex\Models\Role::where('code','=', 'CO')->first()->id;


        \Reflex\User::create(array(
            'role_id' => $role_id,
            'company_id' => $company_id,
            'business_unit_id' => $business_unit_id,
            'sub_business_unit_id' => $sub_business_unit_id,
            'supervisor_id' => $supervisor_id,
            'firstname' => 'Nelly',
            'lastname' => 'Valencia',
            'closeup_name' => 'NELLY VALENCIO',
            'email' => 'nelly.pvg@gmail.com',
            'username' => 'nelly',
            'imei' => '356878052040481',
            'password' => Hash::make('1234')
        ));

        $faker = Faker::create();

        foreach (range(1, 400) as $index)
        {
            $firstname = $faker->firstName;
            $lastname = $faker->lastName;

            $sub_business_unit_id = rand(1,20);

            $sub_business_unit = \Reflex\Models\SubBusinessUnit::find($sub_business_unit_id);

            \Reflex\User::create([
                'role_id' => $role_id,
                'company_id' => 1,
                'business_unit_id' => $sub_business_unit->business_unit_id,
                'sub_business_unit_id' => $sub_business_unit_id,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'closeup_name' => $firstname.' '.$lastname,
                'email' => $faker->email,
                'username' => $faker->unique()->userName,
                'password' => Hash::make('1234')
            ]);
        }




    }
}