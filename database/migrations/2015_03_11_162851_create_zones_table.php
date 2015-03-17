<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('campaigns', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('code',10);
            $table->string('name',100);
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('close_date')->nullable();
            $table->date('finish_date')->nullable();
            $table->integer('qty_days')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
        });

        Schema::create('regions', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('country_id')->unsigned();
            $table->string('code',10)->unique();
            $table->string('name',100);
            $table->string('description')->nullable();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->timestamps();
        });

		Schema::create('zones', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
			$table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('business_unit_id', false, true)->nullable();
            $table->string('code',10);
            $table->string('name',100);
            $table->string('hidden_name',100)->nullable();
            $table->string('description')->nullable();
            $table->integer('qty_doctors')->nullable();
            $table->integer('qty_contacts_am')->nullable();
            $table->integer('qty_contacts_pm')->nullable();
            $table->integer('qty_contacts_vip')->nullable();
            $table->integer('qty_available_days')->nullable();
            $table->string('zone_type',10)->nullable();
            $table->boolean('vacancy')->default(false);
            $table->boolean('active')->default(true);
			$table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('business_unit_id')->references('id')->on('business_units');
		});

        Schema::create('locations', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('country_id',false,true)->nullable();
            $table->integer('region_id',false,true)->nullable();
            $table->string('code',10)->unique();
            $table->string('name',100);
            $table->string('department',100)->nullable();
            $table->string('province',100)->nullable();
            $table->string('district',100)->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('region_id')->references('id')->on('regions');
        });


        Schema::create('region_zone', function(Blueprint $table)
        {
           // $table->engine = 'InnoDB';
           // $table->increments('id');
            $table->integer('zone_id')->unsigned();
            $table->integer('region_id')->unsigned();
            //$table->timestamps();

            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
        });

        Schema::create('location_zone', function(Blueprint $table)
        {
           // $table->engine = 'InnoDB';
          //  $table->increments('id');
            $table->integer('zone_id')->unsigned();
            $table->integer('location_id')->unsigned();
           // $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
        });

        Schema::create('user_zone', function(Blueprint $table)
        {
           // $table->engine = 'InnoDB';
          //  $table->increments('id');
            $table->integer('zone_id')->unsigned();
            $table->integer('user_id')->unsigned();
          //  $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
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
