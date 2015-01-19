<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTable extends Migration
{

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
            $table->string('name', 128)->nullable();
            $table->string('language', 8)->nullable();
            $table->string('phone_number', 32)->nullable();
            $table->string('locale', 8)->nullable();
            $table->string('zoneinfo', 128)->nullable();
            $table->string('gender', 8)->nullable();
            $table->date('birthday')->nullable();
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
            $table->dropColumn('name');
            $table->dropColumn('language');
            $table->dropColumn('phone_number');
            $table->dropColumn('locale');
            $table->dropColumn('zoneinfo');
            $table->dropColumn('gender');
            $table->dropColumn('birthday');
        });
    }

}
