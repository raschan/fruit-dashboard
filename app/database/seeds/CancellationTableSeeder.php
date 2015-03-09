<?php

class CancellationTableSeeder extends Seeder
{
    public function run()
    {
    	   DB::table('metrics')->insert(
                array(
                    'value' => 1,
                    'user' => 1,
                    'date' => 2014-03-02,
                    'provider' => 'stripe'
                )
            );
            DB::table('metrics')->insert(
                array(
                    'value' => 1,
                    'user' => 1,
                    'date' => 2014-03-03,
                    'provider' => 'stripe'
                )
            );
            DB::table('metrics')->insert(
                array(
                    'value' => 1,
                    'user' => 1,
                    'date' => 2014-03-04,
                    'provider' => 'stripe'
                )
            );
    }
}