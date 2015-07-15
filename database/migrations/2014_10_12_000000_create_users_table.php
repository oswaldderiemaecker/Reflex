<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('roles', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code',10)->unique();
            $table->string('name',100);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('countries', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code',10)->unique();
            $table->string('name',100);
            $table->string('currency',10)->nullable();
            $table->string('language',10)->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('companies', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('country_id')->unsigned();
            $table->string('code',20)->unique();
            $table->string('name',100);
            $table->string('description')->nullable();
            $table->timestamps();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->softDeletes();
        });

        Schema::create('business_units', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('code',20)->nullable();
            $table->string('name',100);
            $table->string('description')->nullable();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->softDeletes();
        });

        Schema::create('sub_business_units', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('business_unit_id')->unsigned();
            $table->string('code',20)->nullable();
            $table->string('name',100);
            $table->string('description')->nullable();
            $table->timestamps();
            $table->foreign('business_unit_id')->references('id')->on('business_units');
            $table->softDeletes();
        });

		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('role_id',false, true)->nullable();
            $table->integer('company_id',false, true)->nullable();
            $table->integer('business_unit_id',false, true)->nullable();
            $table->integer('sub_business_unit_id',false, true)->nullable();
            $table->integer('supervisor_id',false, true)->nullable();
            $table->string('code',100)->nullable();
			$table->string('firstname',100);
            $table->string('lastname',100);
            $table->string('closeup_name',200);
			$table->string('email',100)->unique();
            $table->string('username',50)->unique();
			$table->string('password', 255);
            $table->string('photo')->nullable();
            $table->string('imei', '100')->nullable();
            $table->string('facebook_token','500')->nullable();
            $table->string('google_token','500')->nullable();
			$table->rememberToken();
			$table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('business_unit_id')->references('id')->on('business_units');
            $table->foreign('sub_business_unit_id')->references('id')->on('sub_business_units');
            $table->foreign('supervisor_id')->references('id')->on('users');

		});






	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('notes');
        Schema::dropIfExists('note_types');
        Schema::dropIfExists('visits');
        Schema::dropIfExists('reasons');
        Schema::dropIfExists('visit_status');
        Schema::dropIfExists('visit_types');
        Schema::dropIfExists('routes');

        Schema::dropIfExists('targets');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('client_types');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('places');
        Schema::dropIfExists('universities');
        Schema::dropIfExists('specialties');
        Schema::dropIfExists('hobbies');

        Schema::dropIfExists('zone_users');
        Schema::dropIfExists('zone_regions');
        Schema::dropIfExists('zone_locations');
        Schema::dropIfExists('user_zones');
        Schema::dropIfExists('user_zone');
        Schema::dropIfExists('region_zone');
        Schema::dropIfExists('location_zone');
        Schema::dropIfExists('specialty_zone');
        Schema::dropIfExists('specialty_sub_business_unit');

        Schema::dropIfExists('zones');

        Schema::dropIfExists('locations');

        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');

        Schema::dropIfExists('sub_business_units');
        Schema::dropIfExists('business_units');

        Schema::dropIfExists('companies');
        Schema::dropIfExists('countries');

        Schema::dropIfExists('regions');
        Schema::dropIfExists('campaigns');


	}

}
