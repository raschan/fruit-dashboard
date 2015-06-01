<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			$table->boolean('isBackgroundOn')->default(true);

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
		Schema::drop('users_settings');
	}

}
