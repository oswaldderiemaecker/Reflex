<?php

use Illuminate\Database\Migrations\Migration;

class FixAssignment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assignments', function($table)
        {
            $table->dropUnique('"assignments_user_id_unique"');
            $table->unique(array('user_id','campaign_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
