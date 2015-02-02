<?php


class ArpuStat extends BaseStat {

    /**
    * Prepare ARPU for statistics
    *
    * @param boolean 
    * 
    * @return array
    */

    public static function showARPU($fullDataNeeded = false)
    {
        // defaults
        self::$statName = 'Average Revenue Per User';
        self::$statID = 'arpu';
    	
    	$arpuData = array();

    	$arpuData = self::showSimpleStat();

    	if ($fullDataNeeded){
    		
    		$arpuData = self::showFullStat();

			// get all the plans details
			$arpuData['detailData'] = Counter::getSubscriptionDetails();


    	}

        //converting to money format
        $arpuData = self::toMoneyFormat($arpuData, $fullDataNeeded);

    	return $arpuData;
    }

    /**
    * Get stat on given day
    *
    * @param timestamp, current day timestamp
    *
    * @return int (cents) or null if data not exist
    */

    public static function getStatOnDay($timeStamp)
    {
        $day = date('Y-m-d', $timeStamp);

        $mrrOnDay = DB::table('mrr')
            ->where('date',$day)
            ->where('user', Auth::user()->id)
            ->get();

        $auOnDay = DB::table('au')
            ->where('date',$day)
            ->where('user', Auth::user()->id)
            ->get();

        if($mrrOnDay && $auOnDay){
            return $mrrOnDay[0]->value / $auOnDay[0]->value;
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

        $firstDay = DB::table('mArr')->where('user', Auth::user()->id)->orderBy('date', 'asc')->first();
        $firstDay = strtotime($firstDay->date);

        return $firstDay;
    }

}