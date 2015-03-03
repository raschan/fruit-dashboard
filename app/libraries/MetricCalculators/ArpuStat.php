<?php


class ArpuStat extends BaseStat {

    /**
    * calculate today's ARPU from today's MRR and AU
    *
    * @param today's MRR
    * @param today's AU
    *
    * @return int
    */

    public static function calculate($mrr, $au)
    {
        $arpu = $au != 0 ? round($mrr / $au) : null;
        return $arpu;
    }

    /**
    * calculate past ARPU from past MRR and AU
    *
    * @param array of MRR
    * @param array of AU
    *
    * @return array
    */

    public static function calculateHistory($arrayMRR, $arrayAU)
    {
        $historyARPU = array();

        foreach ($arrayMRR as $date => $mrr) 
        {
            $historyARPU[$date] = self::calculate($mrr,$arrayAU[$date]);
        }

        return $historyARPU;
    }

    /**
    * Prepare ARPU for statistics
    *
    * @param boolean
    *
    * @return array
    */

    public static function show($fullDataNeeded = false)
    {
        // defaults
        self::$statName = 'Average Revenue Per User';
        self::$statID = 'arpu';

    	$arpuData = array();


        if ($fullDataNeeded){

            $arpuData = self::showFullStat();

            foreach($arpuData['fullHistory'] as $date => $value)
            {   
                if ($value) {
                    $arpuData['fullHistory'][$date] = $value / 100;
                }
            }
        } else {
        	$arpuData = self::showSimpleStat();
        }

        foreach($arpuData['history'] as $date => $value)
        {   
            if ($value) {
                $arpuData['history'][$date] = $value / 100;
            }
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
            return round($mrrOnDay[0]->value / $auOnDay[0]->value);
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

        if ($firstDay){
            return strtotime($firstDay->date);
        }
        else {
            // needs review, so it can handle null with new users too
            return date('Y-m-d', '2013-12-31');
        }
    }

}
