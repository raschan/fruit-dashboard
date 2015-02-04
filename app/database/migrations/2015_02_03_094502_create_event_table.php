<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events',function($newTable)
		{
			$newTable->increments('id');
			$newTable->integer('user')->unsigned();
			$newTable->foreign('user')->references('id')->on('users')->onDelete('cascade');
			
			$newTable->date('created');
			$newTable->string('eventID');
			$newTable->string('object', 2048);
			$newTable->string('type');

			$newTable->string('provider');
			$newTable->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('events');
	}

}
