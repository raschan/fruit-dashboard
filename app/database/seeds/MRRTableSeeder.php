<?php

class MrrTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('mrr')->delete();

        $currentDay = time();
        $currentDay = $currentDay - 395*24*60*60;
        $previousValue = 13456;

        for ($i = 0; $i < 415; $i++) { 
            
            $date = date('Y-m-d', $currentDay + $i*24*60*60);

            $value = $previousValue * ((100 - rand(-15,10)) / 100);
            $value = $value < 0 ? 0 : $value;
            $previousValue = $value;

            DB::table('mrr')->insert(
                array(
                    'value' => round($value),
                    'user' => 1,
                    'date' => $date,
                    'provider' => 'stripe'
                )
            );
        }


        //gyt data 
        DB::table('mrr')->insert(
array(
'value' => 0,
'user' => 4,
'date' => '2015-01-01'
)
);

DB::table('mrr')->insert(
array(
'value' => 135916,
'user' => 4,
'date' => '2015-01-02'
)
);

DB::table('mrr')->insert(
array(
'value' => 169247,
'user' => 4,
'date' => '2015-01-03'
)
);

DB::table('mrr')->insert(
array(
'value' => 142168,
'user' => 4,
'date' => '2015-01-04'
)
);

DB::table('mrr')->insert(
array(
'value' => 187865,
'user' => 4,
'date' => '2015-01-05'
)
);

DB::table('mrr')->insert(
array(
'value' => 492189,
'user' => 4,
'date' => '2015-01-06'
)
);

DB::table('mrr')->insert(
array(
'value' => 287224,
'user' => 4,
'date' => '2015-01-07'
)
);

DB::table('mrr')->insert(
array(
'value' => 452446,
'user' => 4,
'date' => '2015-01-08'
)
);

DB::table('mrr')->insert(
array(
'value' => 350130,
'user' => 4,
'date' => '2015-01-09'
)
);

DB::table('mrr')->insert(
array(
'value' => 442315,
'user' => 4,
'date' => '2015-01-10'
)
);

DB::table('mrr')->insert(
array(
'value' => 495393,
'user' => 4,
'date' => '2015-01-11'
)
);

DB::table('mrr')->insert(
array(
'value' => 490970,
'user' => 4,
'date' => '2015-01-12'
)
);

DB::table('mrr')->insert(
array(
'value' => 844211,
'user' => 4,
'date' => '2015-01-13'
)
);

DB::table('mrr')->insert(
array(
'value' => 758497,
'user' => 4,
'date' => '2015-01-14'
)
);

DB::table('mrr')->insert(
array(
'value' => 2058759,
'user' => 4,
'date' => '2015-01-15'
)
);

DB::table('mrr')->insert(
array(
'value' => 769282,
'user' => 4,
'date' => '2015-01-16'
)
);

DB::table('mrr')->insert(
array(
'value' => 704329,
'user' => 4,
'date' => '2015-01-17'
)
);

DB::table('mrr')->insert(
array(
'value' => 788848,
'user' => 4,
'date' => '2015-01-18'
)
);

DB::table('mrr')->insert(
array(
'value' => 577550,
'user' => 4,
'date' => '2015-01-19'
)
);

DB::table('mrr')->insert(
array(
'value' => 1204510,
'user' => 4,
'date' => '2015-01-20'
)
);

DB::table('mrr')->insert(
array(
'value' => 1271598,
'user' => 4,
'date' => '2015-01-21'
)
);

DB::table('mrr')->insert(
array(
'value' => 879000,
'user' => 4,
'date' => '2015-01-22'
)
);

DB::table('mrr')->insert(
array(
'value' => 1278599,
'user' => 4,
'date' => '2015-01-23'
)
);

DB::table('mrr')->insert(
array(
'value' => 674437,
'user' => 4,
'date' => '2015-01-24'
)
);

DB::table('mrr')->insert(
array(
'value' => 640715,
'user' => 4,
'date' => '2015-01-25'
)
);

DB::table('mrr')->insert(
array(
'value' => 627227,
'user' => 4,
'date' => '2015-01-26'
)
);

DB::table('mrr')->insert(
array(
'value' => 1727689,
'user' => 4,
'date' => '2015-01-27'
)
);

DB::table('mrr')->insert(
array(
'value' => 1983290,
'user' => 4,
'date' => '2015-01-28'
)
);

DB::table('mrr')->insert(
array(
'value' => 1217421,
'user' => 4,
'date' => '2015-01-29'
)
);

DB::table('mrr')->insert(
array(
'value' => 1203434,
'user' => 4,
'date' => '2015-01-30'
)
);

DB::table('mrr')->insert(
array(
'value' => 1074134,
'user' => 4,
'date' => '2015-01-31'
)
);

DB::table('mrr')->insert(
array(
'value' => 955979,
'user' => 4,
'date' => '2015-02-01'
)
);

DB::table('mrr')->insert(
array(
'value' => 1009686,
'user' => 4,
'date' => '2015-02-02'
)
);

DB::table('mrr')->insert(
array(
'value' => 2154959,
'user' => 4,
'date' => '2015-02-03'
)
);

DB::table('mrr')->insert(
array(
'value' => 2136653,
'user' => 4,
'date' => '2015-02-04'
)
);

DB::table('mrr')->insert(
array(
'value' => 1326151,
'user' => 4,
'date' => '2015-02-05'
)
);

DB::table('mrr')->insert(
array(
'value' => 748694,
'user' => 4,
'date' => '2015-02-06'
)
);

DB::table('mrr')->insert(
array(
'value' => 1670501,
'user' => 4,
'date' => '2015-02-07'
)
);

DB::table('mrr')->insert(
array(
'value' => 1703911,
'user' => 4,
'date' => '2015-02-08'
)
);

DB::table('mrr')->insert(
array(
'value' => 1687206,
'user' => 4,
'date' => '2015-02-09'
)
);

DB::table('mrr')->insert(
array(
'value' => 3086301,
'user' => 4,
'date' => '2015-02-10'
)
);

DB::table('mrr')->insert(
array(
'value' => 2854309,
'user' => 4,
'date' => '2015-02-11'
)
);

DB::table('mrr')->insert(
array(
'value' => 3036009,
'user' => 4,
'date' => '2015-02-12'
)
);

DB::table('mrr')->insert(
array(
'value' => 2831752,
'user' => 4,
'date' => '2015-02-13'
)
);

DB::table('mrr')->insert(
array(
'value' => 1874679,
'user' => 4,
'date' => '2015-02-14'
)
);

DB::table('mrr')->insert(
array(
'value' => 1724704,
'user' => 4,
'date' => '2015-02-15'
)
);

DB::table('mrr')->insert(
array(
'value' => 1537237,
'user' => 4,
'date' => '2015-02-16'
)
);

DB::table('mrr')->insert(
array(
'value' => 3323893,
'user' => 4,
'date' => '2015-02-17'
)
);

DB::table('mrr')->insert(
array(
'value' => 3448522,
'user' => 4,
'date' => '2015-02-18'
)
);

DB::table('mrr')->insert(
array(
'value' => 2822133,
'user' => 4,
'date' => '2015-02-19'
)
);

DB::table('mrr')->insert(
array(
'value' => 3527324,
'user' => 4,
'date' => '2015-02-20'
)
);

DB::table('mrr')->insert(
array(
'value' => 1197454,
'user' => 4,
'date' => '2015-02-21'
)
);

DB::table('mrr')->insert(
array(
'value' => 1377072,
'user' => 4,
'date' => '2015-02-22'
)
);

DB::table('mrr')->insert(
array(
'value' => 1053759,
'user' => 4,
'date' => '2015-02-23'
)
);

DB::table('mrr')->insert(
array(
'value' => 2841510,
'user' => 4,
'date' => '2015-02-24'
)
);

DB::table('mrr')->insert(
array(
'value' => 1757654,
'user' => 4,
'date' => '2015-02-25'
)
);

DB::table('mrr')->insert(
array(
'value' => 3111648,
'user' => 4,
'date' => '2015-02-26'
)
);

DB::table('mrr')->insert(
array(
'value' => 1732463,
'user' => 4,
'date' => '2015-02-27'
)
);

DB::table('mrr')->insert(
array(
'value' => 1529473,
'user' => 4,
'date' => '2015-02-28'
)
);

DB::table('mrr')->insert(
array(
'value' => 1498884,
'user' => 4,
'date' => '2015-03-01'
)
);

DB::table('mrr')->insert(
array(
'value' => 1284758,
'user' => 4,
'date' => '2015-03-02'
)
);

DB::table('mrr')->insert(
array(
'value' => 5899771,
'user' => 4,
'date' => '2015-03-03'
)
);

DB::table('mrr')->insert(
array(
'value' => 3422896,
'user' => 4,
'date' => '2015-03-04'
)
);

DB::table('mrr')->insert(
array(
'value' => 2795627,
'user' => 4,
'date' => '2015-03-05'
)
);

DB::table('mrr')->insert(
array(
'value' => 2792355,
'user' => 4,
'date' => '2015-03-06'
)
);

DB::table('mrr')->insert(
array(
'value' => 3431528,
'user' => 4,
'date' => '2015-03-07'
)
);

DB::table('mrr')->insert(
array(
'value' => 2985429,
'user' => 4,
'date' => '2015-03-08'
)
);

DB::table('mrr')->insert(
array(
'value' => 3877627,
'user' => 4,
'date' => '2015-03-09'
)
);

DB::table('mrr')->insert(
array(
'value' => 4190757,
'user' => 4,
'date' => '2015-03-10'
)
);

DB::table('mrr')->insert(
array(
'value' => 5242259,
'user' => 4,
'date' => '2015-03-11'
)
);

DB::table('mrr')->insert(
array(
'value' => 3812580,
'user' => 4,
'date' => '2015-03-12'
)
);

DB::table('mrr')->insert(
array(
'value' => 1954701,
'user' => 4,
'date' => '2015-03-13'
)
);

DB::table('mrr')->insert(
array(
'value' => 5141700,
'user' => 4,
'date' => '2015-03-14'
)
);

DB::table('mrr')->insert(
array(
'value' => 4216194,
'user' => 4,
'date' => '2015-03-15'
)
);

DB::table('mrr')->insert(
array(
'value' => 4164777,
'user' => 4,
'date' => '2015-03-16'
)
);

DB::table('mrr')->insert(
array(
'value' => 5177371,
'user' => 4,
'date' => '2015-03-17'
)
);

DB::table('mrr')->insert(
array(
'value' => 3715955,
'user' => 4,
'date' => '2015-03-18'
)
);

DB::table('mrr')->insert(
array(
'value' => 1529488,
'user' => 4,
'date' => '2015-03-19'
)
);

DB::table('mrr')->insert(
array(
'value' => 3262052,
'user' => 4,
'date' => '2015-03-20'
)
);

DB::table('mrr')->insert(
array(
'value' => 5587075,
'user' => 4,
'date' => '2015-03-21'
)
);

DB::table('mrr')->insert(
array(
'value' => 5419462,
'user' => 4,
'date' => '2015-03-22'
)
);

DB::table('mrr')->insert(
array(
'value' => 5307721,
'user' => 4,
'date' => '2015-03-23'
)
);

DB::table('mrr')->insert(
array(
'value' => 5256800,
'user' => 4,
'date' => '2015-03-24'
)
);

DB::table('mrr')->insert(
array(
'value' => 5805269,
'user' => 4,
'date' => '2015-03-25'
)
);

DB::table('mrr')->insert(
array(
'value' => 2256394,
'user' => 4,
'date' => '2015-03-26'
)
);

DB::table('mrr')->insert(
array(
'value' => 2282948,
'user' => 4,
'date' => '2015-03-27'
)
);

DB::table('mrr')->insert(
array(
'value' => 5466545,
'user' => 4,
'date' => '2015-03-28'
)
);

DB::table('mrr')->insert(
array(
'value' => 5302548,
'user' => 4,
'date' => '2015-03-29'
)
);

DB::table('mrr')->insert(
array(
'value' => 4755894,
'user' => 4,
'date' => '2015-03-30'
)
);

DB::table('mrr')->insert(
array(
'value' => 5223414,
'user' => 4,
'date' => '2015-03-31'
)
);

DB::table('mrr')->insert(
array(
'value' => 4086282,
'user' => 4,
'date' => '2015-04-01'
)
);

DB::table('mrr')->insert(
array(
'value' => 4747662,
'user' => 4,
'date' => '2015-04-02'
)
);

DB::table('mrr')->insert(
array(
'value' => 6552578,
'user' => 4,
'date' => '2015-04-03'
)
);

DB::table('mrr')->insert(
array(
'value' => 3610052,
'user' => 4,
'date' => '2015-04-04'
)
);

DB::table('mrr')->insert(
array(
'value' => 3321248,
'user' => 4,
'date' => '2015-04-05'
)
);

DB::table('mrr')->insert(
array(
'value' => 3862755,
'user' => 4,
'date' => '2015-04-06'
)
);

DB::table('mrr')->insert(
array(
'value' => 4601027,
'user' => 4,
'date' => '2015-04-07'
)
);

DB::table('mrr')->insert(
array(
'value' => 5480118,
'user' => 4,
'date' => '2015-04-08'
)
);

DB::table('mrr')->insert(
array(
'value' => 4873013,
'user' => 4,
'date' => '2015-04-09'
)
);

DB::table('mrr')->insert(
array(
'value' => 2675508,
'user' => 4,
'date' => '2015-04-10'
)
);

DB::table('mrr')->insert(
array(
'value' => 3414119,
'user' => 4,
'date' => '2015-04-11'
)
);

DB::table('mrr')->insert(
array(
'value' => 3926237,
'user' => 4,
'date' => '2015-04-12'
)
);

DB::table('mrr')->insert(
array(
'value' => 3618966,
'user' => 4,
'date' => '2015-04-13'
)
);

DB::table('mrr')->insert(
array(
'value' => 7859163,
'user' => 4,
'date' => '2015-04-14'
)
);

DB::table('mrr')->insert(
array(
'value' => 6674238,
'user' => 4,
'date' => '2015-04-15'
)
);

DB::table('mrr')->insert(
array(
'value' => 7518897,
'user' => 4,
'date' => '2015-04-16'
)
);

DB::table('mrr')->insert(
array(
'value' => 3980320,
'user' => 4,
'date' => '2015-04-17'
)
);

DB::table('mrr')->insert(
array(
'value' => 4957269,
'user' => 4,
'date' => '2015-04-18'
)
);

DB::table('mrr')->insert(
array(
'value' => 4758978,
'user' => 4,
'date' => '2015-04-19'
)
);

DB::table('mrr')->insert(
array(
'value' => 5849577,
'user' => 4,
'date' => '2015-04-20'
)
);

DB::table('mrr')->insert(
array(
'value' => 5948722,
'user' => 4,
'date' => '2015-04-21'
)
);

DB::table('mrr')->insert(
array(
'value' => 7824838,
'user' => 4,
'date' => '2015-04-22'
)
);

DB::table('mrr')->insert(
array(
'value' => 5658557,
'user' => 4,
'date' => '2015-04-23'
)
);

DB::table('mrr')->insert(
array(
'value' => 5131495,
'user' => 4,
'date' => '2015-04-24'
)
);

DB::table('mrr')->insert(
array(
'value' => 4353563,
'user' => 4,
'date' => '2015-04-25'
)
);

DB::table('mrr')->insert(
array(
'value' => 3526386,
'user' => 4,
'date' => '2015-04-26'
)
);

DB::table('mrr')->insert(
array(
'value' => 3831135,
'user' => 4,
'date' => '2015-04-27'
)
);

DB::table('mrr')->insert(
array(
'value' => 5895453,
'user' => 4,
'date' => '2015-04-28'
)
);

DB::table('mrr')->insert(
array(
'value' => 6171455,
'user' => 4,
'date' => '2015-04-29'
)
);

DB::table('mrr')->insert(
array(
'value' => 8004122,
'user' => 4,
'date' => '2015-04-30'
)
);

DB::table('mrr')->insert(
array(
'value' => 9364823,
'user' => 4,
'date' => '2015-05-01'
)
);

DB::table('mrr')->insert(
array(
'value' => 6963586,
'user' => 4,
'date' => '2015-05-02'
)
);

DB::table('mrr')->insert(
array(
'value' => 8964617,
'user' => 4,
'date' => '2015-05-03'
)
);

DB::table('mrr')->insert(
array(
'value' => 6403298,
'user' => 4,
'date' => '2015-05-04'
)
);

DB::table('mrr')->insert(
array(
'value' => 10189220,
'user' => 4,
'date' => '2015-05-05'
)
);

DB::table('mrr')->insert(
array(
'value' => 8084989,
'user' => 4,
'date' => '2015-05-06'
)
);

DB::table('mrr')->insert(
array(
'value' => 5982141,
'user' => 4,
'date' => '2015-05-07'
)
);

DB::table('mrr')->insert(
array(
'value' => 4601181,
'user' => 4,
'date' => '2015-05-08'
)
);

DB::table('mrr')->insert(
array(
'value' => 6039149,
'user' => 4,
'date' => '2015-05-09'
)
);

DB::table('mrr')->insert(
array(
'value' => 1026737,
'user' => 4,
'date' => '2015-05-10'
)
);

DB::table('mrr')->insert(
array(
'value' => 1026737,
'user' => 4,
'date' => '2015-05-11'
)
);

DB::table('mrr')->insert(
array(
'value' => 8934195,
'user' => 4,
'date' => '2015-05-12'
)
);

DB::table('mrr')->insert(
array(
'value' => 6177654,
'user' => 4,
'date' => '2015-05-13'
)
);

DB::table('mrr')->insert(
array(
'value' => 7929591,
'user' => 4,
'date' => '2015-05-14'
)
);

DB::table('mrr')->insert(
array(
'value' => 5108845,
'user' => 4,
'date' => '2015-05-15'
)
);

DB::table('mrr')->insert(
array(
'value' => 6548887,
'user' => 4,
'date' => '2015-05-16'
)
);

DB::table('mrr')->insert(
array(
'value' => 7400242,
'user' => 4,
'date' => '2015-05-17'
)
);

DB::table('mrr')->insert(
array(
'value' => 6745354,
'user' => 4,
'date' => '2015-05-18'
)
);

DB::table('mrr')->insert(
array(
'value' => 9839808,
'user' => 4,
'date' => '2015-05-19'
)
);

DB::table('mrr')->insert(
array(
'value' => 5536476,
'user' => 4,
'date' => '2015-05-20'
)
);

DB::table('mrr')->insert(
array(
'value' => 4660662,
'user' => 4,
'date' => '2015-05-21'
)
);

DB::table('mrr')->insert(
array(
'value' => 6611161,
'user' => 4,
'date' => '2015-05-22'
)
);

DB::table('mrr')->insert(
array(
'value' => 6894521,
'user' => 4,
'date' => '2015-05-23'
)
);

DB::table('mrr')->insert(
array(
'value' => 6136124,
'user' => 4,
'date' => '2015-05-24'
)
);

DB::table('mrr')->insert(
array(
'value' => 6549795,
'user' => 4,
'date' => '2015-05-25'
)
);

DB::table('mrr')->insert(
array(
'value' => 7261275,
'user' => 4,
'date' => '2015-05-26'
)
);

DB::table('mrr')->insert(
array(
'value' => 5195518,
'user' => 4,
'date' => '2015-05-27'
)
);

DB::table('mrr')->insert(
array(
'value' => 5658260,
'user' => 4,
'date' => '2015-05-28'
)
);

DB::table('mrr')->insert(
array(
'value' => 5672455,
'user' => 4,
'date' => '2015-05-29'
)
);

DB::table('mrr')->insert(
array(
'value' => 6483346,
'user' => 4,
'date' => '2015-05-30'
)
);

DB::table('mrr')->insert(
array(
'value' => 7066847,
'user' => 4,
'date' => '2015-05-31'
)
);

DB::table('mrr')->insert(
array(
'value' => 6483346,
'user' => 4,
'date' => '2015-06-01'
)
);

DB::table('mrr')->insert(
array(
'value' => 4886283,
'user' => 4,
'date' => '2015-06-02'
)
);

DB::table('mrr')->insert(
array(
'value' => 3668311,
'user' => 4,
'date' => '2015-06-03'
)
);

DB::table('mrr')->insert(
array(
'value' => 12123506,
'user' => 4,
'date' => '2015-06-04'
)
);

DB::table('mrr')->insert(
array(
'value' => 9385054,
'user' => 4,
'date' => '2015-06-05'
)
);

DB::table('mrr')->insert(
array(
'value' => 8130987,
'user' => 4,
'date' => '2015-06-06'
)
);

DB::table('mrr')->insert(
array(
'value' => 6830029,
'user' => 4,
'date' => '2015-06-07'
)
);

DB::table('mrr')->insert(
array(
'value' => 7724437,
'user' => 4,
'date' => '2015-06-08'
)
);

DB::table('mrr')->insert(
array(
'value' => 8374916,
'user' => 4,
'date' => '2015-06-09'
)
);

DB::table('mrr')->insert(
array(
'value' => 9705206,
'user' => 4,
'date' => '2015-06-10'
)
);

DB::table('mrr')->insert(
array(
'value' => 15188418,
'user' => 4,
'date' => '2015-06-11'
)
);

DB::table('mrr')->insert(
array(
'value' => 4514454,
'user' => 4,
'date' => '2015-06-12'
)
);

DB::table('mrr')->insert(
array(
'value' => 8598855,
'user' => 4,
'date' => '2015-06-13'
)
);

DB::table('mrr')->insert(
array(
'value' => 9802695,
'user' => 4,
'date' => '2015-06-14'
)
);

DB::table('mrr')->insert(
array(
'value' => 7824958,
'user' => 4,
'date' => '2015-06-15'
)
);

DB::table('mrr')->insert(
array(
'value' => 6536894,
'user' => 4,
'date' => '2015-06-16'
)
);

DB::table('mrr')->insert(
array(
'value' => 7818859,
'user' => 4,
'date' => '2015-06-17'
)
);

DB::table('mrr')->insert(
array(
'value' => 6226688,
'user' => 4,
'date' => '2015-06-18'
)
);

DB::table('mrr')->insert(
array(
'value' => 4389086,
'user' => 4,
'date' => '2015-06-19'
)
);

DB::table('mrr')->insert(
array(
'value' => 8229233,
'user' => 4,
'date' => '2015-06-20'
)
);

DB::table('mrr')->insert(
array(
'value' => 8887571,
'user' => 4,
'date' => '2015-06-21'
)
);

DB::table('mrr')->insert(
array(
'value' => 7982356,
'user' => 4,
'date' => '2015-06-22'
)
);

DB::table('mrr')->insert(
array(
'value' => 10087832,
'user' => 4,
'date' => '2015-06-23'
)
);

DB::table('mrr')->insert(
array(
'value' => 8516164,
'user' => 4,
'date' => '2015-06-24'
)
);

DB::table('mrr')->insert(
array(
'value' => 6535254,
'user' => 4,
'date' => '2015-06-25'
)
);

DB::table('mrr')->insert(
array(
'value' => 3108810,
'user' => 4,
'date' => '2015-06-26'
)
);

DB::table('mrr')->insert(
array(
'value' => 4080897,
'user' => 4,
'date' => '2015-06-27'
)
);

DB::table('mrr')->insert(
array(
'value' => 4121706,
'user' => 4,
'date' => '2015-06-28'
)
);

DB::table('mrr')->insert(
array(
'value' => 4203324,
'user' => 4,
'date' => '2015-06-29'
)
);

DB::table('mrr')->insert(
array(
'value' => 7894836,
'user' => 4,
'date' => '2015-06-30'
)
);

DB::table('mrr')->insert(
array(
'value' => 8671732,
'user' => 4,
'date' => '2015-07-01'
)
);

DB::table('mrr')->insert(
array(
'value' => 5579736,
'user' => 4,
'date' => '2015-07-02'
)
);

DB::table('mrr')->insert(
array(
'value' => 9465389,
'user' => 4,
'date' => '2015-07-03'
)
);

DB::table('mrr')->insert(
array(
'value' => 6387541,
'user' => 4,
'date' => '2015-07-04'
)
);

DB::table('mrr')->insert(
array(
'value' => 6962420,
'user' => 4,
'date' => '2015-07-05'
)
);

DB::table('mrr')->insert(
array(
'value' => 7154046,
'user' => 4,
'date' => '2015-07-06'
)
);

DB::table('mrr')->insert(
array(
'value' => 9655520,
'user' => 4,
'date' => '2015-07-07'
)
);

DB::table('mrr')->insert(
array(
'value' => 6004396,
'user' => 4,
'date' => '2015-07-08'
)
);

DB::table('mrr')->insert(
array(
'value' => 10570696,
'user' => 4,
'date' => '2015-07-09'
)
);

DB::table('mrr')->insert(
array(
'value' => 7293866,
'user' => 4,
'date' => '2015-07-10'
)
);

DB::table('mrr')->insert(
array(
'value' => 6479394,
'user' => 4,
'date' => '2015-07-11'
)
);

DB::table('mrr')->insert(
array(
'value' => 5442691,
'user' => 4,
'date' => '2015-07-12'
)
);

DB::table('mrr')->insert(
array(
'value' => 5831455,
'user' => 4,
'date' => '2015-07-13'
)
);

DB::table('mrr')->insert(
array(
'value' => 16523029,
'user' => 4,
'date' => '2015-07-14'
)
);

DB::table('mrr')->insert(
array(
'value' => 5472644,
'user' => 4,
'date' => '2015-07-15'
)
);

DB::table('mrr')->insert(
array(
'value' => 2958572,
'user' => 4,
'date' => '2015-07-16'
)
);

DB::table('mrr')->insert(
array(
'value' => 7029783,
'user' => 4,
'date' => '2015-07-17'
)
);

DB::table('mrr')->insert(
array(
'value' => 7751032,
'user' => 4,
'date' => '2015-07-18'
)
);

DB::table('mrr')->insert(
array(
'value' => 9223728,
'user' => 4,
'date' => '2015-07-19'
)
);

DB::table('mrr')->insert(
array(
'value' => 6200825,
'user' => 4,
'date' => '2015-07-20'
)
);

DB::table('mrr')->insert(
array(
'value' => 8365692,
'user' => 4,
'date' => '2015-07-21'
)
);

DB::table('mrr')->insert(
array(
'value' => 6367342,
'user' => 4,
'date' => '2015-07-22'
)
);

DB::table('mrr')->insert(
array(
'value' => 8293248,
'user' => 4,
'date' => '2015-07-23'
)
);

DB::table('mrr')->insert(
array(
'value' => 7103800,
'user' => 4,
'date' => '2015-07-24'
)
);

DB::table('mrr')->insert(
array(
'value' => 6340846,
'user' => 4,
'date' => '2015-07-25'
)
);

DB::table('mrr')->insert(
array(
'value' => 7418790,
'user' => 4,
'date' => '2015-07-26'
)
);

DB::table('mrr')->insert(
array(
'value' => 5262902,
'user' => 4,
'date' => '2015-07-27'
)
);

DB::table('mrr')->insert(
array(
'value' => 5583970,
'user' => 4,
'date' => '2015-07-28'
)
);

DB::table('mrr')->insert(
array(
'value' => 8423792,
'user' => 4,
'date' => '2015-07-29'
)
);

DB::table('mrr')->insert(
array(
'value' => 8626776,
'user' => 4,
'date' => '2015-07-30'
)
);

DB::table('mrr')->insert(
array(
'value' => 9295947,
'user' => 4,
'date' => '2015-07-31'
)
);

DB::table('mrr')->insert(
array(
'value' => 4323525,
'user' => 4,
'date' => '2015-08-01'
)
);

DB::table('mrr')->insert(
array(
'value' => 4366760,
'user' => 4,
'date' => '2015-08-02'
)
);

DB::table('mrr')->insert(
array(
'value' => 4150584,
'user' => 4,
'date' => '2015-08-03'
)
);

DB::table('mrr')->insert(
array(
'value' => 12409999,
'user' => 4,
'date' => '2015-08-04'
)
);

DB::table('mrr')->insert(
array(
'value' => 10842065,
'user' => 4,
'date' => '2015-08-05'
)
);

DB::table('mrr')->insert(
array(
'value' => 4531247,
'user' => 4,
'date' => '2015-08-06'
)
);

DB::table('mrr')->insert(
array(
'value' => 11261779,
'user' => 4,
'date' => '2015-08-07'
)
);

DB::table('mrr')->insert(
array(
'value' => 6172100,
'user' => 4,
'date' => '2015-08-08'
)
);

DB::table('mrr')->insert(
array(
'value' => 5986937,
'user' => 4,
'date' => '2015-08-09'
)
);

DB::table('mrr')->insert(
array(
'value' => 6418984,
'user' => 4,
'date' => '2015-08-10'
)
);

DB::table('mrr')->insert(
array(
'value' => 13854713,
'user' => 4,
'date' => '2015-08-11'
)
);

DB::table('mrr')->insert(
array(
'value' => 7279470,
'user' => 4,
'date' => '2015-08-12'
)
);

DB::table('mrr')->insert(
array(
'value' => 7405731,
'user' => 4,
'date' => '2015-08-13'
)
);

DB::table('mrr')->insert(
array(
'value' => 5857804,
'user' => 4,
'date' => '2015-08-14'
)
);

DB::table('mrr')->insert(
array(
'value' => 7791235,
'user' => 4,
'date' => '2015-08-15'
)
);

DB::table('mrr')->insert(
array(
'value' => 9271570,
'user' => 4,
'date' => '2015-08-16'
)
);

DB::table('mrr')->insert(
array(
'value' => 7323761,
'user' => 4,
'date' => '2015-08-17'
)
);

DB::table('mrr')->insert(
array(
'value' => 12141813,
'user' => 4,
'date' => '2015-08-18'
)
);

DB::table('mrr')->insert(
array(
'value' => 7193187,
'user' => 4,
'date' => '2015-08-19'
)
);

DB::table('mrr')->insert(
array(
'value' => 7840574,
'user' => 4,
'date' => '2015-08-20'
)
);

DB::table('mrr')->insert(
array(
'value' => 12955762,
'user' => 4,
'date' => '2015-08-21'
)
);

DB::table('mrr')->insert(
array(
'value' => 6475510,
'user' => 4,
'date' => '2015-08-22'
)
);

DB::table('mrr')->insert(
array(
'value' => 7058306,
'user' => 4,
'date' => '2015-08-23'
)
);

DB::table('mrr')->insert(
array(
'value' => 5504184,
'user' => 4,
'date' => '2015-08-24'
)
);

DB::table('mrr')->insert(
array(
'value' => 14673912,
'user' => 4,
'date' => '2015-08-25'
)
);

DB::table('mrr')->insert(
array(
'value' => 10753268,
'user' => 4,
'date' => '2015-08-26'
)
);

DB::table('mrr')->insert(
array(
'value' => 6945494,
'user' => 4,
'date' => '2015-08-27'
)
);

DB::table('mrr')->insert(
array(
'value' => 7412469,
'user' => 4,
'date' => '2015-08-28'
)
);

DB::table('mrr')->insert(
array(
'value' => 8743776,
'user' => 4,
'date' => '2015-08-29'
)
);

DB::table('mrr')->insert(
array(
'value' => 8656338,
'user' => 4,
'date' => '2015-08-30'
)
);

DB::table('mrr')->insert(
array(
'value' => 8044273,
'user' => 4,
'date' => '2015-08-31'
)
);

DB::table('mrr')->insert(
array(
'value' => 10733258,
'user' => 4,
'date' => '2015-09-01'
)
);

DB::table('mrr')->insert(
array(
'value' => 9735348,
'user' => 4,
'date' => '2015-09-02'
)
);

DB::table('mrr')->insert(
array(
'value' => 5056250,
'user' => 4,
'date' => '2015-09-03'
)
);

DB::table('mrr')->insert(
array(
'value' => 9663983,
'user' => 4,
'date' => '2015-09-04'
)
);

DB::table('mrr')->insert(
array(
'value' => 11749551,
'user' => 4,
'date' => '2015-09-05'
)
);

DB::table('mrr')->insert(
array(
'value' => 12924506,
'user' => 4,
'date' => '2015-09-06'
)
);

DB::table('mrr')->insert(
array(
'value' => 11162073,
'user' => 4,
'date' => '2015-09-07'
)
);

DB::table('mrr')->insert(
array(
'value' => 12532394,
'user' => 4,
'date' => '2015-09-08'
)
);

DB::table('mrr')->insert(
array(
'value' => 9625262,
'user' => 4,
'date' => '2015-09-09'
)
);

DB::table('mrr')->insert(
array(
'value' => 17502368,
'user' => 4,
'date' => '2015-09-10'
)
);

DB::table('mrr')->insert(
array(
'value' => 10396177,
'user' => 4,
'date' => '2015-09-11'
)
);

DB::table('mrr')->insert(
array(
'value' => 11423967,
'user' => 4,
'date' => '2015-09-12'
)
);

DB::table('mrr')->insert(
array(
'value' => 12909082,
'user' => 4,
'date' => '2015-09-13'
)
);

DB::table('mrr')->insert(
array(
'value' => 11995165,
'user' => 4,
'date' => '2015-09-14'
)
);

DB::table('mrr')->insert(
array(
'value' => 15703107,
'user' => 4,
'date' => '2015-09-15'
)
);

DB::table('mrr')->insert(
array(
'value' => 14298624,
'user' => 4,
'date' => '2015-09-16'
)
);

DB::table('mrr')->insert(
array(
'value' => 5027069,
'user' => 4,
'date' => '2015-09-17'
)
);

DB::table('mrr')->insert(
array(
'value' => 5134118,
'user' => 4,
'date' => '2015-09-18'
)
);

DB::table('mrr')->insert(
array(
'value' => 12191369,
'user' => 4,
'date' => '2015-09-19'
)
);

DB::table('mrr')->insert(
array(
'value' => 10118836,
'user' => 4,
'date' => '2015-09-20'
)
);

DB::table('mrr')->insert(
array(
'value' => 12922851,
'user' => 4,
'date' => '2015-09-21'
)
);

DB::table('mrr')->insert(
array(
'value' => 8065507,
'user' => 4,
'date' => '2015-09-22'
)
);

DB::table('mrr')->insert(
array(
'value' => 8721542,
'user' => 4,
'date' => '2015-09-23'
)
);

DB::table('mrr')->insert(
array(
'value' => 6545579,
'user' => 4,
'date' => '2015-09-24'
)
);

DB::table('mrr')->insert(
array(
'value' => 11033649,
'user' => 4,
'date' => '2015-09-25'
)
);

DB::table('mrr')->insert(
array(
'value' => 7660271,
'user' => 4,
'date' => '2015-09-26'
)
);

DB::table('mrr')->insert(
array(
'value' => 7966682,
'user' => 4,
'date' => '2015-09-27'
)
);

DB::table('mrr')->insert(
array(
'value' => 7507065,
'user' => 4,
'date' => '2015-09-28'
)
);

DB::table('mrr')->insert(
array(
'value' => 15725490,
'user' => 4,
'date' => '2015-09-29'
)
);

DB::table('mrr')->insert(
array(
'value' => 6287507,
'user' => 4,
'date' => '2015-09-30'
)
);

DB::table('mrr')->insert(
array(
'value' => 9778106,
'user' => 4,
'date' => '2015-10-01'
)
);

DB::table('mrr')->insert(
array(
'value' => 11256953,
'user' => 4,
'date' => '2015-10-02'
)
);

DB::table('mrr')->insert(
array(
'value' => 10425564,
'user' => 4,
'date' => '2015-10-03'
)
);

DB::table('mrr')->insert(
array(
'value' => 10425564,
'user' => 4,
'date' => '2015-10-04'
)
);

DB::table('mrr')->insert(
array(
'value' => 9695774,
'user' => 4,
'date' => '2015-10-05'
)
);

DB::table('mrr')->insert(
array(
'value' => 15292486,
'user' => 4,
'date' => '2015-10-06'
)
);

DB::table('mrr')->insert(
array(
'value' => 11019525,
'user' => 4,
'date' => '2015-10-07'
)
);

DB::table('mrr')->insert(
array(
'value' => 18633068,
'user' => 4,
'date' => '2015-10-08'
)
);

DB::table('mrr')->insert(
array(
'value' => 14217011,
'user' => 4,
'date' => '2015-10-09'
)
);

DB::table('mrr')->insert(
array(
'value' => 9005299,
'user' => 4,
'date' => '2015-10-10'
)
);

DB::table('mrr')->insert(
array(
'value' => 7384345,
'user' => 4,
'date' => '2015-10-11'
)
);

DB::table('mrr')->insert(
array(
'value' => 8825193,
'user' => 4,
'date' => '2015-10-12'
)
);

DB::table('mrr')->insert(
array(
'value' => 15076271,
'user' => 4,
'date' => '2015-10-13'
)
);

DB::table('mrr')->insert(
array(
'value' => 13309317,
'user' => 4,
'date' => '2015-10-14'
)
);

DB::table('mrr')->insert(
array(
'value' => 12348670,
'user' => 4,
'date' => '2015-10-15'
)
);

DB::table('mrr')->insert(
array(
'value' => 7524570,
'user' => 4,
'date' => '2015-10-16'
)
);

DB::table('mrr')->insert(
array(
'value' => 6685515,
'user' => 4,
'date' => '2015-10-17'
)
);

DB::table('mrr')->insert(
array(
'value' => 2131768,
'user' => 4,
'date' => '2015-10-18'
)
);

DB::table('mrr')->insert(
array(
'value' => 2451533,
'user' => 4,
'date' => '2015-10-19'
)
);

DB::table('mrr')->insert(
array(
'value' => 17956164,
'user' => 4,
'date' => '2015-10-20'
)
);

DB::table('mrr')->insert(
array(
'value' => 8111162,
'user' => 4,
'date' => '2015-10-21'
)
);

DB::table('mrr')->insert(
array(
'value' => 8030269,
'user' => 4,
'date' => '2015-10-22'
)
);

DB::table('mrr')->insert(
array(
'value' => 7869663,
'user' => 4,
'date' => '2015-10-23'
)
);

DB::table('mrr')->insert(
array(
'value' => 7789361,
'user' => 4,
'date' => '2015-10-24'
)
);

DB::table('mrr')->insert(
array(
'value' => 6424215,
'user' => 4,
'date' => '2015-10-25'
)
);

DB::table('mrr')->insert(
array(
'value' => 8110571,
'user' => 4,
'date' => '2015-10-26'
)
);

DB::table('mrr')->insert(
array(
'value' => 28333717,
'user' => 4,
'date' => '2015-10-27'
)
);

DB::table('mrr')->insert(
array(
'value' => 14146401,
'user' => 4,
'date' => '2015-10-28'
)
);

DB::table('mrr')->insert(
array(
'value' => 7465273,
'user' => 4,
'date' => '2015-10-29'
)
);

DB::table('mrr')->insert(
array(
'value' => 11390401,
'user' => 4,
'date' => '2015-10-30'
)
);

DB::table('mrr')->insert(
array(
'value' => 7208084,
'user' => 4,
'date' => '2015-10-31'
)
);

DB::table('mrr')->insert(
array(
'value' => 8145135,
'user' => 4,
'date' => '2015-11-01'
)
);

DB::table('mrr')->insert(
array(
'value' => 7352245,
'user' => 4,
'date' => '2015-11-02'
)
);

DB::table('mrr')->insert(
array(
'value' => 19378088,
'user' => 4,
'date' => '2015-11-03'
)
);

DB::table('mrr')->insert(
array(
'value' => 13743961,
'user' => 4,
'date' => '2015-11-04'
)
);

DB::table('mrr')->insert(
array(
'value' => 10880310,
'user' => 4,
'date' => '2015-11-05'
)
);

DB::table('mrr')->insert(
array(
'value' => 16215829,
'user' => 4,
'date' => '2015-11-06'
)
);

DB::table('mrr')->insert(
array(
'value' => 23871321,
'user' => 4,
'date' => '2015-11-07'
)
);

DB::table('mrr')->insert(
array(
'value' => 19335770,
'user' => 4,
'date' => '2015-11-08'
)
);

DB::table('mrr')->insert(
array(
'value' => 20290623,
'user' => 4,
'date' => '2015-11-09'
)
);

DB::table('mrr')->insert(
array(
'value' => 19522266,
'user' => 4,
'date' => '2015-11-10'
)
);

DB::table('mrr')->insert(
array(
'value' => 9984430,
'user' => 4,
'date' => '2015-11-11'
)
);

DB::table('mrr')->insert(
array(
'value' => 15755429,
'user' => 4,
'date' => '2015-11-12'
)
);

DB::table('mrr')->insert(
array(
'value' => 21459761,
'user' => 4,
'date' => '2015-11-13'
)
);

DB::table('mrr')->insert(
array(
'value' => 13190196,
'user' => 4,
'date' => '2015-11-14'
)
);

DB::table('mrr')->insert(
array(
'value' => 11343569,
'user' => 4,
'date' => '2015-11-15'
)
);

DB::table('mrr')->insert(
array(
'value' => 13981608,
'user' => 4,
'date' => '2015-11-16'
)
);

DB::table('mrr')->insert(
array(
'value' => 19646844,
'user' => 4,
'date' => '2015-11-17'
)
);

DB::table('mrr')->insert(
array(
'value' => 12627251,
'user' => 4,
'date' => '2015-11-18'
)
);

DB::table('mrr')->insert(
array(
'value' => 12199708,
'user' => 4,
'date' => '2015-11-19'
)
);

DB::table('mrr')->insert(
array(
'value' => 10250070,
'user' => 4,
'date' => '2015-11-20'
)
);

DB::table('mrr')->insert(
array(
'value' => 315617108,
'user' => 4,
'date' => '2015-11-21'
)
);

DB::table('mrr')->insert(
array(
'value' => 261962199,
'user' => 4,
'date' => '2015-11-22'
)
);

DB::table('mrr')->insert(
array(
'value' => 255649857,
'user' => 4,
'date' => '2015-11-23'
)
);

DB::table('mrr')->insert(
array(
'value' => 17397921,
'user' => 4,
'date' => '2015-11-24'
)
);

DB::table('mrr')->insert(
array(
'value' => 14751240,
'user' => 4,
'date' => '2015-11-25'
)
);

DB::table('mrr')->insert(
array(
'value' => 13148211,
'user' => 4,
'date' => '2015-11-26'
)
);

DB::table('mrr')->insert(
array(
'value' => 14385404,
'user' => 4,
'date' => '2015-11-27'
)
);

DB::table('mrr')->insert(
array(
'value' => 16000613,
'user' => 4,
'date' => '2015-11-28'
)
);

DB::table('mrr')->insert(
array(
'value' => 16960650,
'user' => 4,
'date' => '2015-11-29'
)
);

DB::table('mrr')->insert(
array(
'value' => 18720718,
'user' => 4,
'date' => '2015-11-30'
)
);

DB::table('mrr')->insert(
array(
'value' => 17327458,
'user' => 4,
'date' => '2015-12-01'
)
);

DB::table('mrr')->insert(
array(
'value' => 23944052,
'user' => 4,
'date' => '2015-12-02'
)
);

DB::table('mrr')->insert(
array(
'value' => 17302377,
'user' => 4,
'date' => '2015-12-03'
)
);

DB::table('mrr')->insert(
array(
'value' => 13146022,
'user' => 4,
'date' => '2015-12-04'
)
);

DB::table('mrr')->insert(
array(
'value' => 16762997,
'user' => 4,
'date' => '2015-12-05'
)
);

DB::table('mrr')->insert(
array(
'value' => 13578027,
'user' => 4,
'date' => '2015-12-06'
)
);

DB::table('mrr')->insert(
array(
'value' => 16930627,
'user' => 4,
'date' => '2015-12-07'
)
);

DB::table('mrr')->insert(
array(
'value' => 31446351,
'user' => 4,
'date' => '2015-12-08'
)
);

DB::table('mrr')->insert(
array(
'value' => 11655972,
'user' => 4,
'date' => '2015-12-09'
)
);

DB::table('mrr')->insert(
array(
'value' => 9996559,
'user' => 4,
'date' => '2015-12-10'
)
);

DB::table('mrr')->insert(
array(
'value' => 13801274,
'user' => 4,
'date' => '2015-12-11'
)
);

DB::table('mrr')->insert(
array(
'value' => 12832575,
'user' => 4,
'date' => '2015-12-12'
)
);

DB::table('mrr')->insert(
array(
'value' => 10271166,
'user' => 4,
'date' => '2015-12-13'
)
);

DB::table('mrr')->insert(
array(
'value' => 10990148,
'user' => 4,
'date' => '2015-12-14'
)
);

DB::table('mrr')->insert(
array(
'value' => 11089871,
'user' => 4,
'date' => '2015-12-15'
)
);

DB::table('mrr')->insert(
array(
'value' => 14847850,
'user' => 4,
'date' => '2015-12-16'
)
);

DB::table('mrr')->insert(
array(
'value' => 11903858,
'user' => 4,
'date' => '2015-12-17'
)
);

DB::table('mrr')->insert(
array(
'value' => 10275785,
'user' => 4,
'date' => '2015-12-18'
)
);

DB::table('mrr')->insert(
array(
'value' => 13936318,
'user' => 4,
'date' => '2015-12-19'
)
);

DB::table('mrr')->insert(
array(
'value' => 11427780,
'user' => 4,
'date' => '2015-12-20'
)
);

DB::table('mrr')->insert(
array(
'value' => 13378865,
'user' => 4,
'date' => '2015-12-21'
)
);

DB::table('mrr')->insert(
array(
'value' => 14367275,
'user' => 4,
'date' => '2015-12-22'
)
);

DB::table('mrr')->insert(
array(
'value' => 12540734,
'user' => 4,
'date' => '2015-12-23'
)
);

DB::table('mrr')->insert(
array(
'value' => 819351,
'user' => 4,
'date' => '2015-12-24'
)
);

DB::table('mrr')->insert(
array(
'value' => 811157,
'user' => 4,
'date' => '2015-12-25'
)
);

DB::table('mrr')->insert(
array(
'value' => 827545,
'user' => 4,
'date' => '2015-12-26'
)
);

DB::table('mrr')->insert(
array(
'value' => 925867,
'user' => 4,
'date' => '2015-12-27'
)
);

DB::table('mrr')->insert(
array(
'value' => 712835,
'user' => 4,
'date' => '2015-12-28'
)
);

DB::table('mrr')->insert(
array(
'value' => 20039805,
'user' => 4,
'date' => '2015-12-29'
)
);

DB::table('mrr')->insert(
array(
'value' => 9429117,
'user' => 4,
'date' => '2015-12-30'
)
);

DB::table('mrr')->insert(
array(
'value' => 8354728,
'user' => 4,
'date' => '2015-12-31'
)
);

}

}
