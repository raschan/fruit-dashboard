<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCreatedColumnInEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('events', function($table)
		{
		    $table->dropColumn('created');
		});

		Schema::table('events', function($table)
		{
			$table->timestamp('created');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('events', function($table)
		{
		    $table->dropColumn('created');
	    });

		Schema::table('events', function($table)
		{
			$table->date('created');
		});
	}

}
