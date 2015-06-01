<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('connections', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('user_id');
			// $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			$table->longText('connection_object'); # JSON
			$table->string('connection_type'); # provider

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
		Schema::drop('connections');
	}

}
