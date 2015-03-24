<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

        ini_set('memory_limit','10024M');

		Model::unguard();

        $this->call('RolesTableSeeder');

        $this->command->info('Roles Table Seeded!');

        $this->call('CountriesTableSeeder');

        $this->command->info('Countries Table Seeded!');

        $this->call('CompaniesTableSeeder');

        $this->command->info('Companies Table Seeded!');

        $this->call('PlacesTableSeeder');

        $this->command->info('Places Table Seeded!');

        $this->call('ReasonsTableSeeder');

        $this->command->info('Reasons Table Seeded!');

        $this->call('CategoriesTableSeeder');

        $this->command->info('Categories Table Seeded!');

        $this->call('BusinessUnitsTableSeeder');

        $this->command->info('Business Units Table Seeded!');

        $this->call('SubBusinessUnitsTableSeeder');

        $this->command->info('Sub Business Units Table Seeded!');

        $this->call('UsersTableSeeder');

        $this->command->info('Users Table Seeded!');

        $this->call('RegionsTableSeeder');

        $this->command->info('Regions Table Seeded!');

        $this->call('LocationsTableSeeder');

        $this->command->info('Locations Table Seeded!');

        $this->call('VisitTypesTableSeeder');

        $this->command->info('Visit Types Table Seeded!');

        $this->call('VisitStatusTableSeeder');

        $this->command->info('Visit Status Table Seeded!');

        $this->call('ClientTypesTableSeeder');

        $this->command->info('Client Types Table Seeded!');

        $this->call('HobbiesTableSeeder');

        $this->command->info('Hobbies Table Seeded!');

        $this->call('UniversitiesTableSeeder');

        $this->command->info('Universities Table Seeded!');

        $this->call('SpecialtiesTableSeeder');

        $this->command->info('Specialties Table Seeded!');

        $this->call('CampaignsTableSeeder');

        $this->command->info('Campaigns Table Seeded!');

        $this->call('ZonesTableSeeder');

        $this->command->info('Zones Table Seeded!');

        $this->call('ClientsTableSeeder');

        $this->command->info('Clients Table Seeded!');

        $this->call('NoteTypesTableSeeder');

        $this->command->info('Note Types Table Seeded!');

	}

}
