<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPreviousAttributesColumnToEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('events', function($table)
		{
			$table->longText('previousAttributes')->nullable();
			$table->date('date');
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
			if (Schema::hasColumn('events', 'previousAttributes'))
			{
				$table->dropColumn('previousAttributes');
			}
			if (Schema::hasColumn('events', 'date'))
			{
				$table->dropColumn('date');
			}
		});
	}

}
