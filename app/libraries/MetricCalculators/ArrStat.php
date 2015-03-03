<?php

class ArrStat extends BaseStat {
    
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

    public static function show($fullDataNeeded = false) {
    	// defaults
        self::$statName = 'Annual Run Rate';
        self::$statID = 'arr';

        // return array
        $arrData = array();

        // full ARR data
        if ($fullDataNeeded){

            $arrData = self::showFullStat();

            // correction of the money to dollars from cents
            foreach($arrData['fullHistory'] as $date => $value)
            {   
                if ($value) {
                    $arrData['fullHistory'][$date] = $value / 100;
                }
            }
        } else {
            $arrData = self::showSimpleStat();
        }
        // converting to money format
        $arrData = self::toMoneyFormat($arrData, $fullDataNeeded);

        foreach($arrData['history'] as $date => $value)
        {   
            if ($value) {
                $arrData['history'][$date] = $value / 100;
            }
        }

        return $arrData;
    }

    /**
    * Get stat on given day, overriding parent function
    *
    * @param timestamp, current day timestamp
    *
    * @return int (cents) or null if data not exist
    */

    public static function getStatOnDay($timeStamp)
    {
        $day = date('Y-m-d', $timeStamp);

        $stats = DB::table('mrr')
            ->where('date',$day)
            ->where('user', Auth::user()->id)
            ->get();

        if($stats){
            $statValue = 0;
            foreach ($stats as $stat) {
                $statValue += $stat->value;
            }
            return $statValue * 12;
        } else {
            return null;
        }
    }

    /**
    * Get day of first recorded data
    *
    * @return string with date
    */

    public static function getFirstDay(){

        $firstDay = DB::table('mrr')
            ->where('user', Auth::user()->id)
            ->orderBy('date', 'asc')
            ->first();
        $firstDay = strtotime($firstDay->date);

        return $firstDay;
    }

}
