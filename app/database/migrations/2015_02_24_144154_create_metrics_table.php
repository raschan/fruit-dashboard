<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetricsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('metrics', function($table)
		{
			// identification of row
			$table->increments('id');
			$talbe->integer('user');
			$table->foreign('user')->references('id')->on('users')->onDelete('cascade');

			$table->date('date');

			$table->timestamps();

			// metric values
			$table->bigInteger('mrr')->unsigned();			// monthly recurring revenue
			$table->integer('au')->unsigned();				// active users
			$table->bigInteger('arr')->unsigned();			// annual recurring revenue
			$table->bigInteger('arpu')->unsigned();			// average recurring revenue per active user
			$table->integer('cancellations')->unsigned();	// cancellations
			$table->integer('cumulativeCanc')->unsigned();	// cumulative cancellations (sum of last 30 days)
			$table->decimal('uc', 5, 2);					// user churn

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('metrics');
	}

}
