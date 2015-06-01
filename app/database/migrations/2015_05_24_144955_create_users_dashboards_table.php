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

			$table->integer('user_id');
			// $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			$table->integer('dashboard_id');
			// $table->foreign('dashboard_id')->references('id')->on('dashboards')->onDelete('cascade');

			$table->string('role'); # reader / editor / owner

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
