<?php

class ArrStat extends BaseStat {
    
    const POSITIVE_IS_GOOD = true;

    /**
    * calculate current ARR from current MRR
    *
    * @param current MRR
    *
    * @return int
    */

    public static function calculate($mrr)
    {
        return $mrr * 12;
    }

    /**
    * calculate past ARR from past MRR
    *
    * @param array of MRR
    *
    * @return array
    */

    public static function calculateHistory($mrrArray)
    {
        $historyARR = array();

        foreach ($mrrArray as $date => $mrr) 
        {
            $historyARR[$date] = self::calculate($mrr);
        }

        return $historyARR;
    }



    /**
    * Prepare ARR for statistics
    *
    * @param boolean
    *
    * @return array
    */

    public static function show($metrics, $fullDataNeeded = false) {
    	// defaults
        self::$statName = 'Annual Run Rate';
        self::$statID = 'arr';

        // return array
        $data = array();

        // full ARR data
        if ($fullDataNeeded){

            $data = self::showFullStat($metrics);

            // correction of the money to dollars from cents
            foreach($data['fullHistory'] as $date => $value)
            {   
                if ($value) {
                    $data['fullHistory'][$date] = $value / 100;
                }
            }
        } else {
            $data = self::showSimpleStat($metrics);
        }

        if (isset($data['history']))
        {
            foreach($data['history'] as $date => $value)
            {   
                if ($value) {
                    $data['history'][$date] = $value / 100;
                }
            }
        } else {
            $data['history'] = array();
        }

        // converting to money format
        $data = self::toMoneyFormat($data, $fullDataNeeded);
        return $data;
    }
}
