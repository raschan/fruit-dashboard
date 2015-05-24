<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersDashboardsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_dashboards', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('usr_id');
			$table->integer('das_id');
			$table->string('udc_role'); # reader / editor / owner
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users_dashboards');
	}

}
