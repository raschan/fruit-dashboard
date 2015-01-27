<?php

class MrrTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('mrr')->delete();
        DB::table('mrr')->insert(
            array(
                'value' => 10343,
                'user'  => 1,
                'date'  => '2015-01-01'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 11032,
                'user'  => 1,
                'date'  => '2015-01-02'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 12345,
                'user'  => 1,
                'date'  => '2015-01-03'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 11234,
                'user'  => 1,
                'date'  => '2015-01-04'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 11000,
                'user'  => 1,
                'date'  => '2015-01-05'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 12643,
                'user'  => 1,
                'date'  => '2015-01-06'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 14540,
                'user'  => 1,
                'date'  => '2015-01-07'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 14233,
                'user'  => 1,
                'date'  => '2015-01-08'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 15324,
                'user'  => 1,
                'date'  => '2015-01-09'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 15123,
                'user'  => 1,
                'date'  => '2015-01-10'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 15123,
                'user'  => 1,
                'date'  => '2015-01-11'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 15534,
                'user'  => 1,
                'date'  => '2015-01-12'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 15234,
                'user'  => 1,
                'date'  => '2015-01-13'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 16843,
                'user'  => 1,
                'date'  => '2015-01-14'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 16545,
                'user'  => 1,
                'date'  => '2015-01-15'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 17435,
                'user'  => 1,
                'date'  => '2015-01-16'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 16994,
                'user'  => 1,
                'date'  => '2015-01-17'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 18432,
                'user'  => 1,
                'date'  => '2015-01-18'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 19324,
                'user'  => 1,
                'date'  => '2015-01-19'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 20435,
                'user'  => 1,
                'date'  => '2015-01-20'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 21435,
                'user'  => 1,
                'date'  => '2015-01-21'
            )
        );
    }

}
