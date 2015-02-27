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
			$table->integer('user')->unsigned();
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');

			$table->date('date');

			$table->timestamps();

			// metric values
			$table->bigInteger('mrr')->unsigned();					// monthly recurring revenue
			$table->integer('au')->unsigned();						// active users
			$table->bigInteger('arr')->unsigned();					// annual recurring revenue
			$table->bigInteger('arpu')->unsigned()->nullable();		// average recurring revenue per active user
			$table->integer('dailyCancellations')->unsigned();		// cancellations
			$table->integer('monthlyCancellations')					// cumulative cancellations (sum of last 30 days)
				->unsigned()
				->nullable();										
			$table->decimal('uc', 5, 1)->nullable();				// user churn

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
