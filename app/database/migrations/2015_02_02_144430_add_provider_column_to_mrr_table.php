<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProviderColumnToMrrTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mrr', function($table)
        {
            // adding title
            $table->string('provider', 64);

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('mrr', function($table)
        {
            // dropping column
            $table->dropColumn('provider');
        });
	}

}
