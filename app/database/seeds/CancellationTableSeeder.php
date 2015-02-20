<?php

class CancellationTableSeeder extends Seeder
{
    public function run()
    {
    	DB::table('cancellations')->delete();    

        $currentDay = time();
        $currentDay = $currentDay - 395*24*60*60;

        for ($i = 0; $i < 415; $i++) { 
            
            $date = date('Y-m-d', $currentDay + $i*24*60*60);
            $value = rand(0,2);

            DB::table('cancellations')->insert(
                array(
                    'value' => $value,
                    'user' => 1,
                    'date' => $date,
                    'provider' => 'stripe'
                )
            );
        }
    }
}