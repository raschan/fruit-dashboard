<?php

class MrrTableSeeder extends Seeder
{

    public function run()
    {

            DB::table('mrr')->insert(
                array(
                    'value' => 1,
                    'user' => 1,
                    'date' => 2014-03-01,
                    'provider' => 'stripe'
                )
            );

            DB::table('mrr')->insert(
                array(
                    'value' => 1,
                    'user' => 1,
                    'date' => 2014-03-02,
                    'provider' => 'stripe'
                )
            );
            DB::table('mrr')->insert(
                array(
                    'value' => 1,
                    'user' => 1,
                    'date' => 2014-03-03,
                    'provider' => 'stripe'
                )
            );
            DB::table('mrr')->insert(
                array(
                    'value' => 1,
                    'user' => 1,
                    'date' => 2014-03-04,
                    'provider' => 'stripe'
                )
            );
    

    }
}
