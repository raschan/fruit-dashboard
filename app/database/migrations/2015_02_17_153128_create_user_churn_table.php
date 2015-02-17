<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserChurnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('uc',function($table)
		{
			// value
			// 5 significant digits and 1 digit after decimal point
            $table->decimal('value',5,1)->unsigned()->nullable();
            // user id
            $table->integer('user')->unsigned();
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
            // when
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
		Schema::dropIfExist('uc');
	}

}
