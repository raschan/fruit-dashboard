<?php

class QuoteTableSeeder extends Seeder
{

    public function run()
    {

            DB::table('quotes')->insert(
                array(
                    'quote' => 'If one does not know to which port one is sailing, no wind is favorable.',
                    'author' => 'Lucius Annaeus Seneca',
                    'type' => 'quote-inspirational',
                    'language' => 'english'
                )
            );

            DB::table('quotes')->insert(
                array(
                    'quote' => 'Always remember that you are absolutely unique. Just like everyone else.',
                    'author' => 'Margaret Mead',
                    'type' => 'quote-funny',
                    'language' => 'english'
                )
            );

            DB::table('quotes')->insert(
                array(
                    'quote' => 'Happy families are all alike; every unhappy family is unhappy in its own way.',
                    'author' => 'Leo Tolstoy, Anna Karenina',
                    'type' => 'quote-first-line',
                    'language' => 'english'
                )
            );
    }

}