<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('hobbies', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code',10)->nullable();
            $table->string('name',100)->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('specialties', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code',10)->nullable();
            $table->string('name',100)->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('universities', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('country_id')->unsigned();
            $table->string('code',10)->nullable();
            $table->string('name',100)->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->foreign('country_id')->references('id')->on('countries');
            $table->timestamps();
        });

        Schema::create('categories', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('code',10)->nullable();
            $table->string('name',100)->nullable();
            $table->integer('qty_visits')->default(1)->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
        });

        Schema::create('places', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('code',10)->nullable();
            $table->string('name',100)->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
        });

        Schema::create('doctors', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('zone_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('place_id')->unsigned();
            $table->integer('hobby_id')->unsigned()->nullable();
            $table->integer('specialty_base_id')->unsigned()->nullable();
            $table->integer('specialty_target_id')->unsigned();
            $table->integer('university_id')->unsigned()->nullable();
            $table->integer('location_id')->unsigned();
            $table->string('cmp',50)->nullable();
            $table->string('code',50)->nullable(); //refers to DNI in peru and cedula in chile
            $table->string('firstname',100);
            $table->string('lastname', 100);
            $table->string('closeup_name', 500)->nullable();
            $table->string('photo',255)->nullable();
            $table->string('email',100)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender',1)->nullable();
            $table->integer('qty_visits')->default(1)->nullable();
            $table->string('marital_status',1)->nullable();
            $table->string('institution',500)->nullable();
            $table->string('address',500);
            $table->string('phone','100')->nullable();
            $table->string('mobile','100')->nullable();
            $table->integer('qty_patiences')->default(0);
            $table->decimal('price_inquiry',12,2)->default(0.0);
            $table->string('social_level_patients',1)->default('C'); //A ->ALTO B->MEDIO C->BAJO
            $table->boolean('attends_child')->default(false);
            $table->boolean('attends_teen')->default(false);
            $table->boolean('attends_adult')->default(false);
            $table->boolean('attends_old')->default(false);
            $table->boolean('is_alive')->default(true);
            $table->decimal('longitude',10,8)->nullable();
            $table->decimal('latitude',10,8)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('cmp');
            //$table->index('closeup_name');
            //$table->index('institution');
            //$table->index('address');
            //$table->index('email');

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('zone_id')->references('id')->on('zones');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('place_id')->references('id')->on('places');
            $table->foreign('hobby_id')->references('id')->on('hobbies');
            $table->foreign('specialty_base_id')->references('id')->on('specialties');
            $table->foreign('specialty_target_id')->references('id')->on('specialties');
            $table->foreign('university_id')->references('id')->on('universities');
            $table->foreign('location_id')->references('id')->on('locations');

        });

        Schema::create('schedules', function(Blueprint $table)
        {
            $table->string('uuid',36)->primary();
            $table->integer('zone_id')->unsigned()->nullable();
            $table->integer('doctor_id')->unsigned()->nullable();
            $table->string('day',1)->nullable();
            $table->time('start_time')->nullable();
            $table->time('finish_time')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('zone_id')->references('id')->on('zones');
            $table->foreign('doctor_id')->references('id')->on('doctors');
        });

        Schema::create('targets', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('campaign_id')->unsigned();
            $table->integer('zone_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('doctor_id')->unsigned();
            $table->integer('qty_visits')->default(0);
            $table->integer('visits_reg')->default(0);
            $table->integer('routes_reg')->default(0);
            $table->boolean('synchro')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->foreign('zone_id')->references('id')->on('zones');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('doctor_id')->references('id')->on('doctors');
        });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('targets');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('places');
        Schema::dropIfExists('universities');
        Schema::dropIfExists('specialties');
        Schema::dropIfExists('hobbies');
	}

}
