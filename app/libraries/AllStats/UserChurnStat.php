<?php

class UserChurnStat extends BaseStat {

	public static function showUserChurn ($fullDataNeeded = false)
	{
		self::$statID = 'uc';
		self::$statName = 'User Churn';

		$userChurnData = array();

		if($fullDataNeeded)
		{
			$userChurnData = self::showFullStat();
			$userChurnData['detailData'] = Counter::getSubscriptionDetails(Auth::user());
		} else {
			$userChurnData = self::showSimpleStat();
		}

		$userChurnData = self::toMoneyFormat($userChurnData, $fullDataNeeded);

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
        $day = date('Y-m-d', $timestamp);
        $lastMonthDay = date('Y-m-d', $timestamp - 30*24*60*60);

        $cancellations = DB::table('cancellations')
            ->where('date',$day)
            ->where('user', Auth::user()->id)
            ->get();
        $activeUsers = DB::table('au')
        	->where('date',$lastMonthDay)
        	->where('user', Auth::user()->id)
        	->get();

        if($cancellations && $activeUsers){
            $cancellationValue = 0;
            foreach ($cancellations as $data) {
                $cancellationValue += $data->value;
            }

            $activeUserValue = 0;
            foreach ($activeUsers as $data) {
            	$activeUserValue += $data->value;
            }
            return round($cancellationValue / $activeUserValue * 100,1);
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