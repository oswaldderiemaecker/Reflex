desc routes<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVisitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('routes', function(Blueprint $table)
        {
            $table->string('uuid',36)->primary();
            $table->integer('assignment_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('zone_id')->unsigned();
            $table->integer('campaign_id')->unsigned();
            $table->integer('target_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->text('description')->nullable();
            $table->boolean('point_of_contact')->default(true);
            $table->boolean('is_from_mobile')->default(true);
            $table->boolean('active')->default(true);
            $table->boolean('synchro')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('zone_id')->references('id')->on('zones');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->foreign('target_id')->references('id')->on('targets');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('assignment_id')->references('id')->on('assignments');
        });

        Schema::create('visit_status', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code',10)->nullable();
            $table->string('name',100)->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('visit_types', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code',10)->nullable();
            $table->string('name',100)->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('reasons', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code',10)->nullable();
            $table->string('name',100)->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('visits', function(Blueprint $table)
        {
            $table->string('uuid',36)->primary();
            $table->string('route_uuid',36)->nullable();
            $table->integer('visit_type_id')->unsigned();
            $table->integer('visit_status_id')->unsigned();
            $table->integer('reason_id',false, true)->nullable();
            $table->integer('assignment_id')->unsigned();
            $table->integer('zone_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('campaign_id')->unsigned();
            $table->integer('target_id')->unsigned();
            $table->integer('specialty_id',false,true)->nullable();
            $table->integer('client_id')->unsigned();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->string('supervisor',50)->nullable(); //array('Vacio', 'Supervisor','Product Manager','Gerente de División'));
            $table->text('description',500)->nullable();
            $table->string('cmp',10)->nullable();
            $table->string('firstname',100)->nullable();
            $table->string('lastname',100)->nullable();
            $table->boolean('is_supervised')->default(false);
            $table->boolean('is_from_mobile')->default(false);
            $table->boolean('active')->default(true);
            $table->boolean('synchro')->default(false);
            $table->decimal('longitude',10,8)->nullable();
            $table->decimal('latitude',10,8)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('start');
            $table->index('end');
            $table->index('cmp');

            $table->foreign('route_uuid')->references('uuid')->on('routes');
            $table->foreign('visit_type_id')->references('id')->on('visit_types');
            $table->foreign('visit_status_id')->references('id')->on('visit_status');
            $table->foreign('reason_id')->references('id')->on('reasons');
            $table->foreign('zone_id')->references('id')->on('zones');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->foreign('target_id')->references('id')->on('targets');
            $table->foreign('specialty_id')->references('id')->on('specialties');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('assignment_id')->references('id')->on('assignments');

        });

        Schema::create('note_types', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code',10)->nullable();
            $table->string('name',100)->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('notes', function(Blueprint $table)
        {
            $table->string('uuid',36)->primary();
            $table->integer('note_type_id')->unsigned()->nullable();
            $table->integer('assignment_id')->unsigned();
            $table->integer('zone_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('campaign_id')->unsigned();
            $table->integer('target_id',false,true)->nullable();
            $table->integer('client_id',false,true)->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('title',200)->nullable();
            $table->string('description',500)->nullable();
            $table->boolean('is_completed')->default(false);
            $table->boolean('is_from_mobile')->default(true);
            $table->boolean('active')->default(true);
            $table->boolean('synchro')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('note_type_id')->references('id')->on('note_types');
            $table->foreign('zone_id')->references('id')->on('zones');
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->foreign('target_id')->references('id')->on('targets');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('assignment_id')->references('id')->on('assignments');

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
