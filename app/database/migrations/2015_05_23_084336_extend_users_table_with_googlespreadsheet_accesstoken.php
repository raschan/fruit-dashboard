<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendUsersTableWithGooglespreadsheetAccesstoken extends Migration {

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
            $table->longText('googleSpreadsheetAccessToken')->nullable();
            $table->string('googleSpreadsheetEmail')->nullable();
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
            $table->dropColumn('googleSpreadsheetAccessToken');
            $table->dropColumn('googleSpreadsheetEmail')->nullable();
        });
	}

}
