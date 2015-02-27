<?php

use Abf\Event;      // needed because of conflicts with Laravel and Stripe


class CancellationStat extends BaseStat {

    /**
    * calculate today's Cancellations from today's changes
    * relevant changes:
    *   - customer deleted
    *
    * @param today's changes
    * @param user for monthly value
    *
    * @return int
    */

    public static function calculate($events,$user)
    {
        // return values
        $dailyValue = 0;
        $monthlyValue = 0;

        // lets get the daily cancellations
        // for every event
        foreach ($events as $event) {

            // if its a subscription cancellation event, count it
            if($event->type == 'customer.subscription.deleted')
            {
                $dailyValue++;
            }
        }
        // lets count the previous 30 days cancellations
        $metrics = Metric::where('user', $user->id)
                            ->orderBy('date', 'desc')
                            ->take(29);
        // lets count them
        foreach ($metrics as $metric) 
        {
            $monthlyValue += $metric->dailyCancellations;
        }

        // add todays value
        $monthlyValue += $dailyValue;

        // return the values
        return array($dailyValue,$monthlyValue);
    }


    /**
    * calculates daily cancellations history after connection
    * 
    * @param current day's timestamp
    * @param user
    * @param date of first event
    *
    * @return array of int
    */

    public static function calculateHistory($timestamp, $user, $firstDate)
    {
        // return array
        $historyCanc = array();

        $events = Event::where('user', $user->id)
                    ->get();
        // save the first one
        foreach ($events as $event) 
        {
            if(!isset($historyCanc['daily'][$event->date]))
            {
                // we have no data on this date yet,
                // initialize it
                $historyCanc['daily'][$event->date] = 0;
            }
            // if its a subscription cancellation event, count it
            if($event->type == 'customer.subscription.deleted')
            {
                $historyCanc['daily'][$event->date]++;
            }
        }

        $historyCanc['monthly'] = self::monthlyCancellations($historyCanc['daily']);

        return $historyCanc;
    }

    /** calculates monthly cancellation history
    * @param daily cancellations array
    *
    * @return array
    */

    private static function monthlyCancellations($dailyCancellations)
    {
        $monthlyCancellations = array();

        // making sure the array is in order (newest first)
        krsort($dailyCancellations);

        $offset = 0;

        foreach ($dailyCancellations as $date => $value) 
        {
            set_time_limit(20);
            //get the last max 30 days
            $last30days = array_slice($dailyCancellations, $offset, 30);
            
            // initialize the monthly data
            $monthlyCancellations[$date] = 0;
            foreach ($last30days as $cancellations) 
            {
                $monthlyCancellations[$date] += $cancellations;
            }

            $offset++;
        }

        return $monthlyCancellations;
    }


	public static function showCancellation($fullDataNeeded = false)
	{
		// defaults
		self::$statID = 'cancellations';
		self::$statName = 'Cancellations';

		$cancellationData = array();

    	if ($fullDataNeeded){

            $cancellationData = self::showFullStat();

            // data for single stat table
            $cancellationData['detailData'] = Calculator::getSubscriptionDetails(Auth::user());

        } else {
        	$cancellationData = self::showSimpleStat();
        }

        // positiveIsGood, for front end colors
        $cancellationData['positiveIsGood'] = false;

    	return $cancellationData;
	}

    public static function getIndicatorStatOnDay($timestamp)
    {
        $beforeValues = array();

        $day = date('Y-m-d', $timestamp);        

        $returnValue = DB::table('cancellations')
            ->where('date', $day)
            ->where('user', Auth::user()->id)
            ->get();

        if ($returnValue)
        {
            // we have data for that day
            // FIX IT FOR MULTIPLE PROVIDERS
            if ($returnValue[0]->cumulativeValue)
            {
                // we have a cumulative value
                // FIX IT FOR MULTIPLE PROVIDERS
                $returnValue = $returnValue[0]->cumulativeValue;
            } else {
                // we don't have the cumulative value, lets compute it
                for ($i=0; $i < 30 ; $i++) { 
                    $day = date('Y-m-d', $timestamp - $i * 24*60*60);

                    $stats = DB::table('cancellations')
                        ->where('date',$day)
                        ->where('user', Auth::user()->id)
                        ->get();

                    if($stats){
                        $statValue = 0;
                        foreach ($stats as $stat) {
                            $statValue += $stat->value;
                        }
                        $beforeValues[$day] = $statValue;
                    } else {
                        $beforeValues[$day] = null;
                    }
                }

                $returnValue = null;
                foreach ($beforeValues as $value) {
                    if($value)
                    {
                        if($returnValue)
                        {
                            $returnValue += $value;
                        } else {
                            $returnValue = $value;
                        }
                    }
                }
                // save the cumulative value
                // FIX IT FOR MULTIPLE PROVIDERS
                $day = date('Y-m-d', $timestamp);
                DB::table('cancellations')
                    ->where('user', Auth::user()->id)
                    ->where('date', $day)
                    ->where('provider', 'stripe')
                    ->update(array('cumulativeValue' => $returnValue));
            }
        }
        return $returnValue;
    }


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
        $data['currentValue'] = static::getIndicatorStatOnDay($currentDay);

        // change in timeframe
        $lastMonthValue = static::getIndicatorStatOnDay($lastMonthTime);
        // check if data is available, so we don't divide by null
        if ($lastMonthValue) {
            $changeInPercent = ($data['currentValue'] / $lastMonthValue * 100) - 100;
            $data['oneMonthChange'] = round($changeInPercent) . '%';
        } else {
            $data['oneMonthChange'] = null;
        }

        // positiveIsGood, for front end colors
        $data['positiveIsGood'] = false;

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
        $data['firstDay'] = date('d-m-Y', $firstDay);


        for ($i = $firstDay; $i < $currentDay; $i+=86400) {
            $date = date('Y-m-d',$i);
            $data['fullHistory'][$date] = static::getStatOnDay($i);
        }
        

        // past values (null if not available)
        $lastMonthValue = static::getIndicatorStatOnDay($lastMonthTime);
        $twoMonthValue = static::getIndicatorStatOnDay($twoMonthTime);
        $threeMonthValue = static::getIndicatorStatOnDay($threeMonthTime);
        $sixMonthValue = static::getIndicatorStatOnDay($sixMonthTime);
        $nineMonthValue = static::getIndicatorStatOnDay($nineMonthTime);
        $oneYearValue = static::getIndicatorStatOnDay($lastYearTime);

        // 30 days ago
        $data['oneMonth'] = $lastMonthValue;
        // 6 months ago
        $data['sixMonth'] = $sixMonthValue;
        // 1 year ago
        $data['oneYear'] = $oneYearValue;

        // check if data is available, so we don't divide by null
        // we have 30 days change

        if ($twoMonthValue) {
            $changeInPercent = ($data['currentValue'] / $twoMonthValue * 100) - 100;
            $data['twoMonthChange'] = round($changeInPercent) . '%';
        } else {
            $data['twoMonthChange'] = null;
        }

        if ($threeMonthValue) {
            $changeInPercent = ($data['currentValue'] / $threeMonthValue * 100) - 100;
            $data['threeMonthChange'] = round($changeInPercent) . '%';
        } else {
            $data['threeMonthChange'] = null;
        }

        if ($sixMonthValue) {
            $changeInPercent = ($data['currentValue'] / $sixMonthValue * 100) - 100;
            $data['sixMonthChange'] = round($changeInPercent) . '%';
        } else {
            $data['sixMonthChange'] = null;
        }

        if ($nineMonthValue) {
            $changeInPercent = ($data['currentValue'] / $nineMonthValue * 100) - 100;
            $data['nineMonthChange'] = round($changeInPercent) . '%';
        } else {
            $data['nineMonthChange'] = null;
        }

        if ($oneYearValue) {
            $changeInPercent = ($data['currentValue'] / $oneYearValue * 100) - 100;
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

        // positiveIsGood, for front end colors
        $data['positiveIsGood'] = false;

        return $data;
    }

}
