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

    public static function show($metrics, $fullDataNeeded = false)
    {
        // defaults
        self::$statName = 'Average Revenue Per User';
        self::$statID = 'arpu';

    	$data = array();


        if ($fullDataNeeded){

            $data = self::showFullStat($metrics);

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

        //converting to money format
        $data = self::toMoneyFormat($data, $fullDataNeeded);

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

        $stats = Metric::where('date',$day)
            ->where('user', Auth::user()->id)
            ->first();

        if($stats){
            $statValue = $stats->{self::$statID};
            return $statValue;
        } else {
            return null;
        }
    }
}
