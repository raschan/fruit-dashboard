<?php

class BaseStat
{
    // later rewrite to be protected
    public static $statName;
    public static $statID;

    /**
    * Prepare data for simple statistics (for dashboard)
    *
    * @return array
    */

    public static function showSimpleStat()
    {
        // helpers
        $currentDay = time();
        $lastMonthTime = $currentDay - 30*24*60*60;

        // return array
        $data = array();

        // simple data
        // basics, what we are
        $data['id'] = self::$statID;
        $data['statName'] = self::$statName;

        // building history array for dashboard
        for ($i = $currentDay-30*86400; $i < $currentDay; $i+=86400) {
            $date = date('Y-m-d',$i);
            $data['history'][$date] = static::getStatOnDay($i);
        }

        // current value, formatted for money
        $data['currentValue'] = static::getStatOnDay($currentDay);

        // change in timeframe
        $lastMonthValue = static::getStatOnDay($lastMonthTime);
        // check if data is available, so we don't divide by null
        if ($lastMonthValue) {
            $changeInPercent = (static::getStatOnDay($currentDay) / $lastMonthValue * 100) - 100;
            $data['oneMonthChange'] = round($changeInPercent) . '%';
        } else {
            $data['oneMonthChange'] = null;
        }

        return $data;

    }
	
    /**
    * Prepare data for full statistics (for single_stat)
    *
    * @return array
    */

    public static function showFullStat()
    {
        // helpers
        $currentDay = time();
        $lastMonthTime = $currentDay - 30*24*60*60;
        $twoMonthTime = $currentDay - 2*30*24*60*60;
        $threeMonthTime = $currentDay - 3*30*24*60*60;
        $sixMonthTime = $currentDay - 6*30*24*60*60;
        $nineMonthTime = $currentDay - 9*30*24*60*60;
        $lastYearTime = $currentDay - 365*24*60*60;

        // return array
        $data = array();

        $data = self::showSimpleStat();

        // building full mrr history
        $firstDay = static::getFirstDay();
        $data['firstDay'] = date('d-m-Y',$firstDay);
        

        for ($i = $firstDay; $i < $currentDay; $i+=86400) {
            $date = date('Y-m-d',$i);
            $data['fullHistory'][$date] = static::getStatOnDay($i);
        }

        // past values (null if not available)
        $lastMonthValue = static::getStatOnDay($lastMonthTime);          
        $twoMonthValue = static::getStatOnDay($twoMonthTime);
        $threeMonthValue = static::getStatOnDay($threeMonthTime);
        $sixMonthValue = static::getStatOnDay($sixMonthTime);
        $nineMonthValue = static::getStatOnDay($nineMonthTime);
        $oneYearValue = static::getStatOnDay($lastYearTime);

        // 30 days ago
        $data['oneMonth'] = $lastMonthValue;
        // 6 months ago
        $data['sixMonth'] = $sixMonthValue; 
        // 1 year ago
        $data['oneYear'] = $oneYearValue;

        // check if data is available, so we don't divide by null
        // we have 30 days change
        
        if ($twoMonthValue) {
            $changeInPercent = (static::getStatOnDay($currentDay) / $twoMonthValue * 100) - 100;
            $data['twoMonthChange'] = round($changeInPercent) . '%';
        } else {
            $data['twoMonthChange'] = null; 
        }

        if ($threeMonthValue) {
            $changeInPercent = (static::getStatOnDay($currentDay) / $threeMonthValue * 100) - 100;
            $data['threeMonthChange'] = round($changeInPercent) . '%';
        } else {
            $data['threeMonthChange'] = null; 
        }

        if ($sixMonthValue) {
            $changeInPercent = (static::getStatOnDay($currentDay) / $sixMonthValue * 100) - 100;
            $data['sixMonthChange'] = round($changeInPercent) . '%';
        } else {
            $data['sixMonthChange'] = null; 
        }

        if ($nineMonthValue) {
            $changeInPercent = (static::getStatOnDay($currentDay) / $nineMonthValue * 100) - 100;
            $data['nineMonthChange'] = round($changeInPercent) . '%';
        } else {
            $data['nineMonthChange'] = null; 
        }

        if ($oneYearValue) {
            $changeInPercent = (static::getStatOnDay($currentDay) / $oneYearValue * 100) - 100;
            $data['oneYearChange'] = round($changeInPercent) . '%';
        } else {
            $data['oneYearChange'] = null; 
        }

        // time interval for shown statistics
        // right now, only last 30 days
        $startDate = date('d-m-Y',$lastMonthTime);
        $stopDate = date('d-m-Y',$currentDay);

        $data['dateInterval'] = array(
            'startDate' => $startDate,
            'stopDate' => $stopDate
        );

        return $data;

    }  

    

    /**
    * Convert data to money format 
    *
    * @param array
    *
    * @return array
    */

    public static function toMoneyFormat($data, $fullDataNeeded){
        setlocale(LC_MONETARY,"en_US");
        $data['currentValue'] = money_format('%n',$data['currentValue']);

        if ($fullDataNeeded){
            // 30 days ago
            $data['oneMonth'] = $data['oneMonth'] ? money_format('%n', $data['oneMonth']) : null;
            // 6 months ago
            $data['sixMonth'] = $data['sixMonth'] ? money_format('%n', $data['sixMonth']) : null; 
            // 1 year ago
            $data['oneYear'] = $data['oneYear'] ? money_format('%n', $data['oneYear']) : null;
        }

        return $data;
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

    	$stat = DB::table(self::$statID)
    		->where('date',$day)
    		->where('user', Auth::user()->id)
    		->get();

    	if($stat){
    		return $stat[0]->value;
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

        $firstDay = DB::table(self::$statID)->where('user', Auth::user()->id)->orderBy('date', 'asc')->first();
        $firstDay = strtotime($firstDay->date);

        if ($firstDay){
            return $firstDay;
        }
        else {
            return null;
        }
    }

}
