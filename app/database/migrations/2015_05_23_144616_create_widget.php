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
			$t->increments('id');
			$t->text('widget_name');
			$t->text('widget_type'); # f.e. google-spreadsheet-linear
			$t->longText('widget_source'); # JSON

			$t->integer('dashboard_id'); # connection to dashboard
			// $t->foreign('dashboard_id')->references('id')->on('dashboards')->onDelete('cascade');

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
