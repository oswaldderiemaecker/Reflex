<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubBusinessUnitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
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
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sub_business_units');
	}

}
