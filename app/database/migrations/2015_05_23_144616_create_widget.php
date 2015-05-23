<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWidget extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('widgets', function($t)
		{
			$t->increments('wid_id');
			$t->text('wid_name');
			$t->text('wid_type'); # f.e. google-spreadsheet-linear
			$t->longText('wid_source'); # JSON
			$t->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('widgets');
	}

}
