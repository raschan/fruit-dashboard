<?php

class MetricsTableSeeder extends Seeder
{

    public function run()
    {

            DB::table('metrics')->insert(
                array(
                    'mrr' => 1,
                    'user' => 1,
                    'au' => 1,
                    'arr' => 1,
                    'arpu' => 1,
                    'uc' => 1,
                    'cancellations' => 1,
                    'monthlyCancellations' => 1,
                    'date' => '2014-03-13'
                )
            );


            DB::table('metrics')->insert(
                array(
                    'mrr' => 1,
                    'user' => 1,
                    'au' => 1,
                    'arr' => 1,
                    'arpu' => 1,
                    'uc' => 1,
                    'cancellations' => 1,
                    'monthlyCancellations' => 1,
                    'date' => '2014-03-14'
                )
            );


            DB::table('metrics')->insert(
                array(
                    'mrr' => 1,
                    'user' => 1,
                    'au' => 1,
                    'arr' => 1,
                    'arpu' => 1,
                    'uc' => 1,
                    'cancellations' => 1,
                    'monthlyCancellations' => 1,
                    'date' => '2014-03-15'
                )
            );


    }

}