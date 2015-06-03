<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveWidgetPositionToWidgetFromDashboards extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasColumn('dashboards','widgetPosition'))
        {
            Schema::table('dashboards', function($table)
            {
                // dropping column
                $table->dropColumn('widgetPosition');
            });
        }

        Schema::table('widgets', function($table)
        {
        	$table->string('position')->default('{"size_x":1,"size_y":1,"col":1,"row":1}');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasColumn('widgets', 'position'))
		{
			Schema::table('widgets', function($table)
			{
				$table->dropColumn('position');
			});
		}
	}

}
