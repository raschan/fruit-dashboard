<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedWidgetPositionToDashboards extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_dashboards', function($table)
        {
             // adding title
            $table->longtext('widgetPosition')->default('');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasColumn('users','widgetPosition'))
        {
            Schema::table('users', function($table)
            {
                // dropping column
                $table->dropColumn('widgetPosition');
            });
        }
	}
}