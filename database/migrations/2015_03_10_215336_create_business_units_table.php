<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessUnitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
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
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('business_units');
	}

}
