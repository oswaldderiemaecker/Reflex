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

        Schema::create('client_types', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code',10)->nullable();
            $table->string('name',100)->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('address_types', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code',10)->nullable();
            $table->string('name',100)->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('clients', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('client_type_id', false, true);
            $table->integer('company_id', false, true);
            $table->integer('zone_id', false, true);
            $table->integer('category_id', false, true)->nullable();
            $table->integer('place_id', false, true)->nullable();
            $table->integer('hobby_id', false, true)->nullable();
            $table->integer('specialty_base_id', false, true)->nullable();
            $table->integer('specialty_target_id', false, true)->nullable();
            $table->integer('university_id', false, true)->nullable();
            $table->integer('location_id', false, true)->nullable();
            $table->integer('address_type_id', false, true)->nullable();
            $table->integer('parent_id', false, true)->nullable();
            $table->string('cmp',50)->nullable(); //CMP
            $table->string('code',50)->nullable(); //refers to DNI in peru and cedula in chile or RUC
            $table->string('name',200)->nullable(); //Only For Pharmacy or Institutions
            $table->string('firstname',100)->nullable();
            $table->string('lastname', 100)->nullable();
            $table->string('closeup_name', 200)->nullable();
            $table->string('photo',255)->nullable(); //doctor photo or image of pharmacy
            $table->string('email',100)->nullable();
            $table->date('date_of_birth')->nullable();//date fundation or date of birth
            $table->string('gender',1)->nullable();
            $table->integer('qty_visits')->default(1)->nullable(); // Per Cycle
            $table->string('marital_status',1)->nullable();
            $table->string('institution',500)->nullable();
            $table->string('address',500);
            $table->string('address_number',10)->nullable();
            $table->string('address_interior',20)->nullable();
            $table->string('reference',500)->nullable();
            $table->string('phone','100')->nullable();
            $table->string('mobile','100')->nullable();
            $table->integer('qty_patiences')->default(0)->nullable();
            $table->decimal('price_inquiry',12,2)->default(0.0)->nullable();
            $table->string('social_level_patients',1)->default('C'); //A ->ALTO B->MEDIO C->BAJO
            $table->boolean('attends_child')->default(false);
            $table->boolean('attends_teen')->default(false);
            $table->boolean('attends_adult')->default(false);
            $table->boolean('attends_old')->default(false);
            $table->boolean('is_alive')->default(true); //is active
            $table->decimal('longitude',10,8)->nullable();
            $table->decimal('latitude',10,8)->nullable();
            $table->boolean('active')->default(true); //was deleted
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
            $table->foreign('address_type_id')->references('id')->on('address_types');
            $table->foreign('parent_id')->references('id')->on('clients');

        });

        Schema::create('schedules', function(Blueprint $table)
        {
            $table->string('uuid',36)->primary();
            $table->integer('zone_id', false, true)->nullable();
            $table->integer('client_id', false, true)->nullable();
            $table->string('day',1)->nullable();
            $table->time('start_time')->nullable();
            $table->time('finish_time')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('zone_id')->references('id')->on('zones');
            $table->foreign('client_id')->references('id')->on('clients');
        });

        Schema::create('targets', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('campaign_id')->unsigned();
            $table->integer('zone_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('client_id')->unsigned();
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
            $table->foreign('client_id')->references('id')->on('clients');
        });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{



	}

}
