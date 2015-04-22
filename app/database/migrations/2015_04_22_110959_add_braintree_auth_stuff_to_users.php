<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBraintreeAuthStuffToUsers extends Migration {

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
            $table->string('btEnvironment')->nullable();
            $table->string('btPublicKey')->nullable();
            $table->string('btPrivateKey')->nullable();
            $table->string('btMerchantId')->nullable();
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
            $table->dropColumn('btEnvironment');
            $table->dropColumn('btPublicKey');
            $table->dropColumn('btPrivateKey');
            $table->dropColumn('btMerchantId');
        });
	}

}
