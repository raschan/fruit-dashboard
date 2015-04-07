<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExpandUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
        {
             // adding title
            $table->string('stripeUserId')->nullable();
            $table->string('stripeRefreshToken')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table)
        {
            // dropping column
            $table->dropColumn('stripeUserId');
            $table->dropColumn('stripeRefreshToken');
        });
	}
}
