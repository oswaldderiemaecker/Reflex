<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
		Schema::dropIfExist('users');
        Schema::dropIfExist('roles');
        Schema::dropIfExist('sub_business_units');
        Schema::dropIfExist('business_units');
        Schema::dropIfExist('countries');
        Schema::dropIfExist('companies');

	}

}
