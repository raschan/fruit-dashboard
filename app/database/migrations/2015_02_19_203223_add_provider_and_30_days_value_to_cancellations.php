<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProviderAnd30DaysValueToCancellations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cancellations', function($table)
		{
			$table->string('provider');
			$table->integer('cumulativeValue')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cancellations', function($table)
		{
			$table->dropColumn('provider');
			$table->dropColumn('cumulativeValue');
		});
	}

}
