<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeReadyColumnType extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
		    $table->dropColumn('ready');
		});

		Schema::table('users', function($table)
		{
			$table->string('ready');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table)
		{
		    $table->dropColumn('ready');
	    });

		Schema::table('users', function($table)
		{
			$table->boolean('ready')->nullable();
		});
	}

}
