<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedStripeKeyToUser extends Migration
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
            $table->string('stripe_key', 64)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users','stripe_key'))
        {
            Schema::table('users', function($table)
            {
                // dropping column
                $table->dropColumn('stripe_key');
            });
        }
    }

}
