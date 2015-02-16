<?php
//file : app/config/constants.php

return [
    /* --------------- CURRENCY FONT/TEXT--------------- */
    // stripe uses iso 4217 codes, http://www.xe.com/symbols.php
    'usd' => '$',
    'aud' => '$',
    'cny' => '¥',
    'huf' => 'Ft',
    'cad' => '$',
    'chf' => 'CHF',
    'jpy' => '¥',
    'gbp' => '£',
    'eur' => '€',
    /* --------------- COUNTRY CODE --------------- */
    // stripe uses iso 3166-1 alpha-2 codes, php here: http://stackoverflow.com/questions/3191664/list-of-all-locales-and-their-short-codes
    'US' => 'en_US',
];
