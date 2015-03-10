<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
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
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('companies');
	}

}
