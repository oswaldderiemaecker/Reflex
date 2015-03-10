<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCountry extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
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
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('countries');

	}

}
