<?php

class UserChurnStat extends BaseStat {

    /**
    * calculate today's UC from today's monthly cancellations, and 30 days ago AU
    *
    * @param today's montly cancellations
    * @param user
    * @param today's timestamp
    *
    * @return floar
    */

    public static function calculate($mC,$user,$timestamp)
    {
        // return value
        $returnValue = 0;

        // get AU 30 days ago
        $metrics = Metric::where('user', $user->id)
                    ->where('date', date('Y-m-d', $timestamp - 30 * 86400))
                    ->get();

        // calculate UC
        $returnValue = ($metrics && $metrics[0]->au != 0) 
                        ? $mC / $metrics[0]->au * 100 
                        : null;

        return $returnValue;
    }

    /**
    * calculates UC history after connection
    * 
    * @param monthly cancellations array
    * @param active users array
    *
    * @return array of int
    */

    public static function calculateHistory($mC, $au)
    {
        // return array
        $historyUC = array();

        foreach ($mC as $date => $cancellations) 
        {
            $date30DaysAgo = date('Y-m-d', strtotime($date) - 30 * 86400);
            $historyUC[$date] = (isset($au[$date30DaysAgo]) && $au[$date30DaysAgo] != 0) 
                                    ? $cancellations / $au[$date30DaysAgo]
                                    : null;
        }

        return $historyUC;
    }


	public static function showUserChurn ($fullDataNeeded = false)
	{
		self::$statID = 'uc';
		self::$statName = 'User Churn';

		$userChurnData = array();

		if($fullDataNeeded)
		{
			$userChurnData = self::showFullStat();
			$userChurnData['detailData'] = Calculator::getSubscriptionDetails(Auth::user());
		} else {
			$userChurnData = self::showSimpleStat();
		}

		$userChurnData = self::toMoneyFormat($userChurnData, $fullDataNeeded);

        // positiveIsGood, for front end colors
        $userChurnData['positiveIsGood'] = false;

		return $userChurnData;
	}


	/**
	* Override parent function to show
	* % instead of money
	*
	*@param full data set
	*@param boolean if full data is needed
	*
	*@return value in percent string
	*/
	public static function toMoneyFormat($data, $fullDataNeeded){
        
        $data['currentValue'] = $data['currentValue'] ? $data['currentValue'].'%' : null;

        if ($fullDataNeeded){
            // 30 days ago
            $data['oneMonth'] = $data['oneMonth'] ? $data['oneMonth'].'%' : null;
            // 6 months ago
            $data['sixMonth'] = $data['sixMonth'] ? $data['sixMonth'].'%' : null;
            // 1 year ago
            $data['oneYear'] = $data['oneYear'] ? $data['oneYear'].'%' : null;
        }

        return $data;
    }
        /**
    * Get stat on given day, overriding parent function
    *
    * @param timestamp, current day timestamp
    *
    * @return float (percent) or null if data not exist
    */

    public static function getStatOnDay($timestamp)
    {
        $lastMonthDay = date('Y-m-d', $timestamp - 30*24*60*60);

        $cancellations = CancellationStat::getIndicatorStatOnDay($timestamp);
     
        $activeUsers = DB::table('au')
        	->where('date',$lastMonthDay)
        	->where('user', Auth::user()->id)
        	->get();

        if($cancellations && $activeUsers){
            $activeUserValue = 0;
            foreach ($activeUsers as $data) {
            	$activeUserValue += $data->value;
            }
            return round($cancellations / $activeUserValue * 100,1);
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

        $firstDay = DB::table('au')
            ->where('user', Auth::user()->id)
            ->orderBy('date', 'asc')
            ->first();
        $firstDay = strtotime($firstDay->date);

        return $firstDay;
    }
}