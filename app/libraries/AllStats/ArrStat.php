<?php 

	/**
    * Prepare ARR for statistics
    *
    * @return array
    */

class ArrStat extends BaseStat {

	/**
    * Prepare ARR for statistics
    *
    * @param boolean 
    * 
    * @return array
    */

    public static function showARR($fullDataNeeded = false) {
    	// defaults
        self::$statName = 'Annual Run Rate';
        self::$statID = 'arr';

        // return array
        $arrData = array();
        $arrData = self::showSimpleStat();
   

            // full ARR data
            if ($fullDataNeeded){

                $arrData = self::showFullStat();
                // data for single stat table
                $arrData['detailData'] = Counter::getSubscriptionDetails();

            }
        // converting to money format
        $arrData = self::toMoneyFormat($arrData, $fullDataNeeded);

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

        $stat = DB::table('mrr')
            ->where('date',$day)
            ->where('user', Auth::user()->id)
            ->get();

        if($stat){
            return $stat[0]->value * 12;
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

        $firstDay = DB::table('mrr')->where('user', Auth::user()->id)->orderBy('date', 'asc')->first();
        $firstDay = strtotime($firstDay->date);

        return $firstDay;
    }

}