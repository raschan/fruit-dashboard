<?php

class MrrTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('mrr')->delete();
        DB::table('mrr')->insert(
            array(
                'value' => 10323,
                'user'  => 1,
                'date'  => '2013-01-01',
                'provider' => 'stripe'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 10343,
                'user'  => 1,
                'date'  => '2015-01-01',
                'provider' => 'stripe'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 11032,
                'user'  => 1,
                'date'  => '2015-01-02',
                'provider' => 'stripe'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 12345,
                'user'  => 1,
                'date'  => '2015-01-03',
                'provider' => 'stripe'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 11234,
                'user'  => 1,
                'date'  => '2015-01-04',
                'provider' => 'stripe'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 11000,
                'user'  => 1,
                'date'  => '2015-01-05',
                'provider' => 'stripe'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 12643,
                'user'  => 1,
                'date'  => '2015-01-06',
                'provider' => 'paypal'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 14540,
                'user'  => 1,
                'date'  => '2015-01-07',
                'provider' => 'paypal'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 14233,
                'user'  => 1,
                'date'  => '2015-01-08',
                'provider' => 'paypal'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 15324,
                'user'  => 1,
                'date'  => '2015-01-09',
                'provider' => 'paypal'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 15123,
                'user'  => 1,
                'date'  => '2015-01-10',
                'provider' => 'paypal'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 15123,
                'user'  => 1,
                'date'  => '2015-01-11',
                'provider' => 'paypal'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 15534,
                'user'  => 1,
                'date'  => '2015-01-12',
                'provider' => 'stripe'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 15234,
                'user'  => 1,
                'date'  => '2015-01-13',
                'provider' => 'paypal'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 16843,
                'user'  => 1,
                'date'  => '2015-01-14',
                'provider' => 'paypal'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 16545,
                'user'  => 1,
                'date'  => '2015-01-15',
                'provider' => 'paypal'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 17435,
                'user'  => 1,
                'date'  => '2015-01-16',
                'provider' => 'paypal'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 16994,
                'user'  => 1,
                'date'  => '2015-01-17',
                'provider' => 'paypal'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 18432,
                'user'  => 1,
                'date'  => '2015-01-18',
                'provider' => 'stripe'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 19324,
                'user'  => 1,
                'date'  => '2015-01-19',
                'provider' => 'stripe'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 20435,
                'user'  => 1,
                'date'  => '2015-01-20',
                'provider' => 'stripe'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 21435,
                'user'  => 1,
                'date'  => '2015-01-21',
                'provider' => 'stripe'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 21435,
                'user'  => 1,
                'date'  => '2015-02-02',
                'provider' => 'stripe'
            )
        );
        DB::table('mrr')->insert(
            array(
                'value' => 21435,
                'user'  => 1,
                'date'  => '2015-02-02',
                'provider' => 'paypal'
            )
        );
    }

}
