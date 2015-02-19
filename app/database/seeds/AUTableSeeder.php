<?php

class AUTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('au')->delete();    

        $currentDay = time();
        $currentDay = $currentDay - 395*24*60*60;
        $previousValue = 3;

        for ($i = 0; $i < 415; $i++) { 
            
            $date = date('Y-m-d', $currentDay + $i*24*60*60);

            $value = $previousValue + rand(-2,3);
            $value = $value < 0 ? 0 : $value;
            $previousValue = $value;

            DB::table('au')->insert(
                array(
                    'value' => $value,
                    'user' => 1,
                    'date' => $date,
                    'provider' => 'stripe'
                )
            );
        }

        //gyt data
        
        DB::table('au')->insert(
        array(
            'value' => 0,
            'user' => 4,
            'date' => '2015-01-01'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 0,
            'user' => 4,
            'date' => '2015-01-02'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 6,
            'user' => 4,
            'date' => '2015-01-03'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 6,
            'user' => 4,
            'date' => '2015-01-04'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 6,
            'user' => 4,
            'date' => '2015-01-05'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 14,
            'user' => 4,
            'date' => '2015-01-06'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 15,
            'user' => 4,
            'date' => '2015-01-07'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 15,
            'user' => 4,
            'date' => '2015-01-08'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 16,
            'user' => 4,
            'date' => '2015-01-09'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 18,
            'user' => 4,
            'date' => '2015-01-10'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 18,
            'user' => 4,
            'date' => '2015-01-11'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 18,
            'user' => 4,
            'date' => '2015-01-12'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 28,
            'user' => 4,
            'date' => '2015-01-13'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 28,
            'user' => 4,
            'date' => '2015-01-14'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 34,
            'user' => 4,
            'date' => '2015-01-15'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 36,
            'user' => 4,
            'date' => '2015-01-16'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 39,
            'user' => 4,
            'date' => '2015-01-17'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 39,
            'user' => 4,
            'date' => '2015-01-18'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 39,
            'user' => 4,
            'date' => '2015-01-19'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 42,
            'user' => 4,
            'date' => '2015-01-20'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 45,
            'user' => 4,
            'date' => '2015-01-21'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 45,
            'user' => 4,
            'date' => '2015-01-22'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 46,
            'user' => 4,
            'date' => '2015-01-23'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 47,
            'user' => 4,
            'date' => '2015-01-24'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 47,
            'user' => 4,
            'date' => '2015-01-25'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 47,
            'user' => 4,
            'date' => '2015-01-26'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 49,
            'user' => 4,
            'date' => '2015-01-27'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 50,
            'user' => 4,
            'date' => '2015-01-28'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 50,
            'user' => 4,
            'date' => '2015-01-29'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 51,
            'user' => 4,
            'date' => '2015-01-30'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 57,
            'user' => 4,
            'date' => '2015-01-31'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 57,
            'user' => 4,
            'date' => '2015-02-01'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 57,
            'user' => 4,
            'date' => '2015-02-02'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 60,
            'user' => 4,
            'date' => '2015-02-03'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 61,
            'user' => 4,
            'date' => '2015-02-04'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 72,
            'user' => 4,
            'date' => '2015-02-05'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 73,
            'user' => 4,
            'date' => '2015-02-06'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 74,
            'user' => 4,
            'date' => '2015-02-07'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 74,
            'user' => 4,
            'date' => '2015-02-08'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 74,
            'user' => 4,
            'date' => '2015-02-09'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 78,
            'user' => 4,
            'date' => '2015-02-10'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 82,
            'user' => 4,
            'date' => '2015-02-11'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 88,
            'user' => 4,
            'date' => '2015-02-12'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 88,
            'user' => 4,
            'date' => '2015-02-13'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 88,
            'user' => 4,
            'date' => '2015-02-14'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 88,
            'user' => 4,
            'date' => '2015-02-15'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 88,
            'user' => 4,
            'date' => '2015-02-16'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 93,
            'user' => 4,
            'date' => '2015-02-17'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 95,
            'user' => 4,
            'date' => '2015-02-18'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 95,
            'user' => 4,
            'date' => '2015-02-19'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 98,
            'user' => 4,
            'date' => '2015-02-20'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 98,
            'user' => 4,
            'date' => '2015-02-21'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 98,
            'user' => 4,
            'date' => '2015-02-22'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 98,
            'user' => 4,
            'date' => '2015-02-23'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 105,
            'user' => 4,
            'date' => '2015-02-24'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 107,
            'user' => 4,
            'date' => '2015-02-25'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 110,
            'user' => 4,
            'date' => '2015-02-26'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 110,
            'user' => 4,
            'date' => '2015-02-27'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 114,
            'user' => 4,
            'date' => '2015-02-28'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 114,
            'user' => 4,
            'date' => '2015-03-01'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 114,
            'user' => 4,
            'date' => '2015-03-02'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 115,
            'user' => 4,
            'date' => '2015-03-03'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 118,
            'user' => 4,
            'date' => '2015-03-04'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 126,
            'user' => 4,
            'date' => '2015-03-05'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 127,
            'user' => 4,
            'date' => '2015-03-06'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 129,
            'user' => 4,
            'date' => '2015-03-07'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 129,
            'user' => 4,
            'date' => '2015-03-08'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 129,
            'user' => 4,
            'date' => '2015-03-09'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 132,
            'user' => 4,
            'date' => '2015-03-10'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 133,
            'user' => 4,
            'date' => '2015-03-11'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 142,
            'user' => 4,
            'date' => '2015-03-12'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 142,
            'user' => 4,
            'date' => '2015-03-13'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 144,
            'user' => 4,
            'date' => '2015-03-14'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 144,
            'user' => 4,
            'date' => '2015-03-15'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 144,
            'user' => 4,
            'date' => '2015-03-16'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 146,
            'user' => 4,
            'date' => '2015-03-17'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 155,
            'user' => 4,
            'date' => '2015-03-18'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 155,
            'user' => 4,
            'date' => '2015-03-19'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 159,
            'user' => 4,
            'date' => '2015-03-20'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 159,
            'user' => 4,
            'date' => '2015-03-21'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 159,
            'user' => 4,
            'date' => '2015-03-22'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 159,
            'user' => 4,
            'date' => '2015-03-23'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 163,
            'user' => 4,
            'date' => '2015-03-24'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 164,
            'user' => 4,
            'date' => '2015-03-25'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 164,
            'user' => 4,
            'date' => '2015-03-26'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 164,
            'user' => 4,
            'date' => '2015-03-27'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 175,
            'user' => 4,
            'date' => '2015-03-28'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 175,
            'user' => 4,
            'date' => '2015-03-29'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 175,
            'user' => 4,
            'date' => '2015-03-30'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 177,
            'user' => 4,
            'date' => '2015-03-31'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 179,
            'user' => 4,
            'date' => '2015-04-01'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 179,
            'user' => 4,
            'date' => '2015-04-02'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 181,
            'user' => 4,
            'date' => '2015-04-03'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 188,
            'user' => 4,
            'date' => '2015-04-04'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 188,
            'user' => 4,
            'date' => '2015-04-05'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 188,
            'user' => 4,
            'date' => '2015-04-06'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 195,
            'user' => 4,
            'date' => '2015-04-07'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 195,
            'user' => 4,
            'date' => '2015-04-08'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 198,
            'user' => 4,
            'date' => '2015-04-09'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 199,
            'user' => 4,
            'date' => '2015-04-10'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 208,
            'user' => 4,
            'date' => '2015-04-11'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 208,
            'user' => 4,
            'date' => '2015-04-12'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 208,
            'user' => 4,
            'date' => '2015-04-13'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 210,
            'user' => 4,
            'date' => '2015-04-14'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 211,
            'user' => 4,
            'date' => '2015-04-15'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 211,
            'user' => 4,
            'date' => '2015-04-16'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 214,
            'user' => 4,
            'date' => '2015-04-17'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 216,
            'user' => 4,
            'date' => '2015-04-18'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 216,
            'user' => 4,
            'date' => '2015-04-19'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 216,
            'user' => 4,
            'date' => '2015-04-20'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 216,
            'user' => 4,
            'date' => '2015-04-21'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 218,
            'user' => 4,
            'date' => '2015-04-22'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 222,
            'user' => 4,
            'date' => '2015-04-23'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 225,
            'user' => 4,
            'date' => '2015-04-24'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 225,
            'user' => 4,
            'date' => '2015-04-25'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 225,
            'user' => 4,
            'date' => '2015-04-26'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 225,
            'user' => 4,
            'date' => '2015-04-27'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 229,
            'user' => 4,
            'date' => '2015-04-28'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 229,
            'user' => 4,
            'date' => '2015-04-29'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 233,
            'user' => 4,
            'date' => '2015-04-30'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 233,
            'user' => 4,
            'date' => '2015-05-01'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 233,
            'user' => 4,
            'date' => '2015-05-02'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 233,
            'user' => 4,
            'date' => '2015-05-03'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 233,
            'user' => 4,
            'date' => '2015-05-04'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 247,
            'user' => 4,
            'date' => '2015-05-05'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 247,
            'user' => 4,
            'date' => '2015-05-06'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 250,
            'user' => 4,
            'date' => '2015-05-07'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 251,
            'user' => 4,
            'date' => '2015-05-08'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 253,
            'user' => 4,
            'date' => '2015-05-09'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 254,
            'user' => 4,
            'date' => '2015-05-10'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 254,
            'user' => 4,
            'date' => '2015-05-11'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 264,
            'user' => 4,
            'date' => '2015-05-12'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 265,
            'user' => 4,
            'date' => '2015-05-13'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 267,
            'user' => 4,
            'date' => '2015-05-14'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 267,
            'user' => 4,
            'date' => '2015-05-15'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 267,
            'user' => 4,
            'date' => '2015-05-16'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 267,
            'user' => 4,
            'date' => '2015-05-17'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 267,
            'user' => 4,
            'date' => '2015-05-18'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 279,
            'user' => 4,
            'date' => '2015-05-19'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 279,
            'user' => 4,
            'date' => '2015-05-20'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 282,
            'user' => 4,
            'date' => '2015-05-21'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 282,
            'user' => 4,
            'date' => '2015-05-22'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 283,
            'user' => 4,
            'date' => '2015-05-23'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 283,
            'user' => 4,
            'date' => '2015-05-24'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 283,
            'user' => 4,
            'date' => '2015-05-25'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 289,
            'user' => 4,
            'date' => '2015-05-26'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 291,
            'user' => 4,
            'date' => '2015-05-27'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 296,
            'user' => 4,
            'date' => '2015-05-28'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 298,
            'user' => 4,
            'date' => '2015-05-29'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 300,
            'user' => 4,
            'date' => '2015-05-30'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 300,
            'user' => 4,
            'date' => '2015-05-31'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 300,
            'user' => 4,
            'date' => '2015-06-01'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 304,
            'user' => 4,
            'date' => '2015-06-02'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 307,
            'user' => 4,
            'date' => '2015-06-03'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 309,
            'user' => 4,
            'date' => '2015-06-04'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 320,
            'user' => 4,
            'date' => '2015-06-05'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 320,
            'user' => 4,
            'date' => '2015-06-06'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 320,
            'user' => 4,
            'date' => '2015-06-07'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 320,
            'user' => 4,
            'date' => '2015-06-08'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 320,
            'user' => 4,
            'date' => '2015-06-09'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 324,
            'user' => 4,
            'date' => '2015-06-10'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 325,
            'user' => 4,
            'date' => '2015-06-11'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 332,
            'user' => 4,
            'date' => '2015-06-12'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 333,
            'user' => 4,
            'date' => '2015-06-13'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 333,
            'user' => 4,
            'date' => '2015-06-14'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 333,
            'user' => 4,
            'date' => '2015-06-15'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 338,
            'user' => 4,
            'date' => '2015-06-16'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 341,
            'user' => 4,
            'date' => '2015-06-17'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 341,
            'user' => 4,
            'date' => '2015-06-18'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 342,
            'user' => 4,
            'date' => '2015-06-19'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 342,
            'user' => 4,
            'date' => '2015-06-20'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 342,
            'user' => 4,
            'date' => '2015-06-21'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 342,
            'user' => 4,
            'date' => '2015-06-22'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 342,
            'user' => 4,
            'date' => '2015-06-23'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 345,
            'user' => 4,
            'date' => '2015-06-24'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 346,
            'user' => 4,
            'date' => '2015-06-25'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 346,
            'user' => 4,
            'date' => '2015-06-26'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 346,
            'user' => 4,
            'date' => '2015-06-27'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 346,
            'user' => 4,
            'date' => '2015-06-28'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 346,
            'user' => 4,
            'date' => '2015-06-29'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 355,
            'user' => 4,
            'date' => '2015-06-30'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 356,
            'user' => 4,
            'date' => '2015-07-01'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 357,
            'user' => 4,
            'date' => '2015-07-02'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 359,
            'user' => 4,
            'date' => '2015-07-03'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 367,
            'user' => 4,
            'date' => '2015-07-04'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 367,
            'user' => 4,
            'date' => '2015-07-05'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 367,
            'user' => 4,
            'date' => '2015-07-06'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 370,
            'user' => 4,
            'date' => '2015-07-07'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 373,
            'user' => 4,
            'date' => '2015-07-08'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 373,
            'user' => 4,
            'date' => '2015-07-09'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 374,
            'user' => 4,
            'date' => '2015-07-10'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 375,
            'user' => 4,
            'date' => '2015-07-11'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 375,
            'user' => 4,
            'date' => '2015-07-12'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 375,
            'user' => 4,
            'date' => '2015-07-13'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 386,
            'user' => 4,
            'date' => '2015-07-14'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 389,
            'user' => 4,
            'date' => '2015-07-15'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 392,
            'user' => 4,
            'date' => '2015-07-16'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 394,
            'user' => 4,
            'date' => '2015-07-17'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 396,
            'user' => 4,
            'date' => '2015-07-18'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 396,
            'user' => 4,
            'date' => '2015-07-19'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 396,
            'user' => 4,
            'date' => '2015-07-20'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 399,
            'user' => 4,
            'date' => '2015-07-21'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 399,
            'user' => 4,
            'date' => '2015-07-22'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 400,
            'user' => 4,
            'date' => '2015-07-23'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 401,
            'user' => 4,
            'date' => '2015-07-24'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 402,
            'user' => 4,
            'date' => '2015-07-25'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 402,
            'user' => 4,
            'date' => '2015-07-26'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 402,
            'user' => 4,
            'date' => '2015-07-27'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 410,
            'user' => 4,
            'date' => '2015-07-28'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 410,
            'user' => 4,
            'date' => '2015-07-29'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 410,
            'user' => 4,
            'date' => '2015-07-30'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 413,
            'user' => 4,
            'date' => '2015-07-31'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 413,
            'user' => 4,
            'date' => '2015-08-01'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 413,
            'user' => 4,
            'date' => '2015-08-02'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 413,
            'user' => 4,
            'date' => '2015-08-03'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 421,
            'user' => 4,
            'date' => '2015-08-04'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 431,
            'user' => 4,
            'date' => '2015-08-05'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 431,
            'user' => 4,
            'date' => '2015-08-06'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 431,
            'user' => 4,
            'date' => '2015-08-07'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 431,
            'user' => 4,
            'date' => '2015-08-08'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 431,
            'user' => 4,
            'date' => '2015-08-09'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 431,
            'user' => 4,
            'date' => '2015-08-10'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 447,
            'user' => 4,
            'date' => '2015-08-11'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 449,
            'user' => 4,
            'date' => '2015-08-12'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 449,
            'user' => 4,
            'date' => '2015-08-13'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 449,
            'user' => 4,
            'date' => '2015-08-14'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 449,
            'user' => 4,
            'date' => '2015-08-15'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 449,
            'user' => 4,
            'date' => '2015-08-16'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 449,
            'user' => 4,
            'date' => '2015-08-17'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 453,
            'user' => 4,
            'date' => '2015-08-18'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 453,
            'user' => 4,
            'date' => '2015-08-19'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 453,
            'user' => 4,
            'date' => '2015-08-20'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 453,
            'user' => 4,
            'date' => '2015-08-21'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 454,
            'user' => 4,
            'date' => '2015-08-22'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 454,
            'user' => 4,
            'date' => '2015-08-23'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 454,
            'user' => 4,
            'date' => '2015-08-24'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 458,
            'user' => 4,
            'date' => '2015-08-25'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 458,
            'user' => 4,
            'date' => '2015-08-26'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 458,
            'user' => 4,
            'date' => '2015-08-27'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 460,
            'user' => 4,
            'date' => '2015-08-28'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 464,
            'user' => 4,
            'date' => '2015-08-29'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 464,
            'user' => 4,
            'date' => '2015-08-30'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 464,
            'user' => 4,
            'date' => '2015-08-31'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 466,
            'user' => 4,
            'date' => '2015-09-01'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 469,
            'user' => 4,
            'date' => '2015-09-02'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 470,
            'user' => 4,
            'date' => '2015-09-03'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 470,
            'user' => 4,
            'date' => '2015-09-04'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 479,
            'user' => 4,
            'date' => '2015-09-05'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 479,
            'user' => 4,
            'date' => '2015-09-06'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 479,
            'user' => 4,
            'date' => '2015-09-07'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 481,
            'user' => 4,
            'date' => '2015-09-08'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 484,
            'user' => 4,
            'date' => '2015-09-09'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 485,
            'user' => 4,
            'date' => '2015-09-10'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 487,
            'user' => 4,
            'date' => '2015-09-11'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 494,
            'user' => 4,
            'date' => '2015-09-12'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 494,
            'user' => 4,
            'date' => '2015-09-13'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 494,
            'user' => 4,
            'date' => '2015-09-14'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 494,
            'user' => 4,
            'date' => '2015-09-15'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 494,
            'user' => 4,
            'date' => '2015-09-16'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 496,
            'user' => 4,
            'date' => '2015-09-17'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 497,
            'user' => 4,
            'date' => '2015-09-18'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 497,
            'user' => 4,
            'date' => '2015-09-19'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 497,
            'user' => 4,
            'date' => '2015-09-20'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 497,
            'user' => 4,
            'date' => '2015-09-21'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 500,
            'user' => 4,
            'date' => '2015-09-22'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 500,
            'user' => 4,
            'date' => '2015-09-23'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 501,
            'user' => 4,
            'date' => '2015-09-24'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 503,
            'user' => 4,
            'date' => '2015-09-25'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 503,
            'user' => 4,
            'date' => '2015-09-26'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 503,
            'user' => 4,
            'date' => '2015-09-27'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 503,
            'user' => 4,
            'date' => '2015-09-28'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 505,
            'user' => 4,
            'date' => '2015-09-29'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 514,
            'user' => 4,
            'date' => '2015-09-30'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 515,
            'user' => 4,
            'date' => '2015-10-01'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 517,
            'user' => 4,
            'date' => '2015-10-02'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 518,
            'user' => 4,
            'date' => '2015-10-03'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 518,
            'user' => 4,
            'date' => '2015-10-04'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 518,
            'user' => 4,
            'date' => '2015-10-05'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 526,
            'user' => 4,
            'date' => '2015-10-06'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 526,
            'user' => 4,
            'date' => '2015-10-07'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 527,
            'user' => 4,
            'date' => '2015-10-08'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 527,
            'user' => 4,
            'date' => '2015-10-09'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 530,
            'user' => 4,
            'date' => '2015-10-10'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 530,
            'user' => 4,
            'date' => '2015-10-11'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 530,
            'user' => 4,
            'date' => '2015-10-12'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 531,
            'user' => 4,
            'date' => '2015-10-13'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 539,
            'user' => 4,
            'date' => '2015-10-14'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 539,
            'user' => 4,
            'date' => '2015-10-15'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 544,
            'user' => 4,
            'date' => '2015-10-16'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 545,
            'user' => 4,
            'date' => '2015-10-17'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 545,
            'user' => 4,
            'date' => '2015-10-18'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 545,
            'user' => 4,
            'date' => '2015-10-19'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 546,
            'user' => 4,
            'date' => '2015-10-20'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 549,
            'user' => 4,
            'date' => '2015-10-21'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 550,
            'user' => 4,
            'date' => '2015-10-22'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 550,
            'user' => 4,
            'date' => '2015-10-23'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 550,
            'user' => 4,
            'date' => '2015-10-24'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 550,
            'user' => 4,
            'date' => '2015-10-25'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 550,
            'user' => 4,
            'date' => '2015-10-26'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 556,
            'user' => 4,
            'date' => '2015-10-27'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 556,
            'user' => 4,
            'date' => '2015-10-28'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 556,
            'user' => 4,
            'date' => '2015-10-29'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 557,
            'user' => 4,
            'date' => '2015-10-30'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 562,
            'user' => 4,
            'date' => '2015-10-31'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 562,
            'user' => 4,
            'date' => '2015-11-01'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 562,
            'user' => 4,
            'date' => '2015-11-02'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 562,
            'user' => 4,
            'date' => '2015-11-03'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 566,
            'user' => 4,
            'date' => '2015-11-04'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 571,
            'user' => 4,
            'date' => '2015-11-05'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 571,
            'user' => 4,
            'date' => '2015-11-06'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 573,
            'user' => 4,
            'date' => '2015-11-07'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 573,
            'user' => 4,
            'date' => '2015-11-08'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 573,
            'user' => 4,
            'date' => '2015-11-09'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 574,
            'user' => 4,
            'date' => '2015-11-10'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 583,
            'user' => 4,
            'date' => '2015-11-11'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 583,
            'user' => 4,
            'date' => '2015-11-12'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 586,
            'user' => 4,
            'date' => '2015-11-13'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 587,
            'user' => 4,
            'date' => '2015-11-14'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 587,
            'user' => 4,
            'date' => '2015-11-15'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 587,
            'user' => 4,
            'date' => '2015-11-16'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 588,
            'user' => 4,
            'date' => '2015-11-17'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 589,
            'user' => 4,
            'date' => '2015-11-18'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 590,
            'user' => 4,
            'date' => '2015-11-19'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 590,
            'user' => 4,
            'date' => '2015-11-20'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 590,
            'user' => 4,
            'date' => '2015-11-21'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 590,
            'user' => 4,
            'date' => '2015-11-22'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 590,
            'user' => 4,
            'date' => '2015-11-23'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 595,
            'user' => 4,
            'date' => '2015-11-24'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 595,
            'user' => 4,
            'date' => '2015-11-25'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-11-26'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-11-27'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-11-28'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-11-29'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-11-30'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-01'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-02'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-03'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-04'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-05'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-06'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-07'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-08'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-09'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-10'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-11'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-12'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-13'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-14'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-15'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-16'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-17'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-18'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-19'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-20'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-21'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-22'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-23'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-24'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-25'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-26'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-27'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-28'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-29'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-30'
            )
        );

        DB::table('au')->insert(
        array(
            'value' => 596,
            'user' => 4,
            'date' => '2015-12-31'
            )
        );
    }
}
        /*
        DB::table('au')->delete();
        DB::table('au')->insert(
            array(
                'value' => 5,
                'user'  => 1,
                'date'  => '2014-12-27'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 5,
                'user'  => 1,
                'date'  => '2014-12-28'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 5,
                'user'  => 1,
                'date'  => '2014-12-29'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 5,
                'user'  => 1,
                'date'  => '2014-12-30'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 5,
                'user'  => 1,
                'date'  => '2014-12-31'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 5,
                'user'  => 1,
                'date'  => '2015-01-01'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 10,
                'user'  => 1,
                'date'  => '2015-01-02'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 15,
                'user'  => 1,
                'date'  => '2015-01-03'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 20,
                'user'  => 1,
                'date'  => '2015-01-04'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 25,
                'user'  => 1,
                'date'  => '2015-01-05'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 30,
                'user'  => 1,
                'date'  => '2015-01-06'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 35,
                'user'  => 1,
                'date'  => '2015-01-07'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 40,
                'user'  => 1,
                'date'  => '2015-01-08'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 45,
                'user'  => 1,
                'date'  => '2015-01-09'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 50,
                'user'  => 1,
                'date'  => '2015-01-10'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 60,
                'user'  => 1,
                'date'  => '2015-01-11'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 80,
                'user'  => 1,
                'date'  => '2015-01-12'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 100,
                'user'  => 1,
                'date'  => '2015-01-13'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 105,
                'user'  => 1,
                'date'  => '2015-01-14'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 255,
                'user'  => 1,
                'date'  => '2015-01-15'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 155,
                'user'  => 1,
                'date'  => '2015-01-16'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 165,
                'user'  => 1,
                'date'  => '2015-01-17'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 200,
                'user'  => 1,
                'date'  => '2015-01-18'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 215,
                'user'  => 1,
                'date'  => '2015-01-19'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 230,
                'user'  => 1,
                'date'  => '2015-01-20'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 250,
                'user'  => 1,
                'date'  => '2015-01-21'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 250,
                'user'  => 1,
                'date'  => '2015-01-22'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 250,
                'user'  => 1,
                'date'  => '2015-01-23'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 250,
                'user'  => 1,
                'date'  => '2015-01-24'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 250,
                'user'  => 1,
                'date'  => '2015-01-25'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 250,
                'user'  => 1,
                'date'  => '2015-01-26'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 250,
                'user'  => 1,
                'date'  => '2015-01-27'
            )
        );
        DB::table('au')->insert(
            array(
                'value' => 250,
                'user'  => 1,
                'date'  => '2015-01-28'
            )
        );
        */