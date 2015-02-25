<?php

class MrrStat extends BaseStat {

    /**
    * calculate today's MRR from yesterday value and changes
    * relevant changes:
    *   - subscription created
    *   - subscription cancelled
    *   - subscription updated
    *
    * @param yesterday's value
    * @param today's changes
    *
    * @return int
    */

    public static function calculate($yesterdayMRR, $events)
    {
        // return var
        $todayMRR = $yesterdayMRR;
        // for every event
        foreach ($events as $event) {
            // check, if event is relevant for the value 
            switch ($event->type) {
                case 'customer.subsription.created':
                    // subscription created, increase MRR
                    $tempArray = json_decode(strstr($event->object, '{'), true);

                    $changeValue = Calculator::getMRRContribution($tempArray['plan']);

                    // check if there is a problem
                    if (!is_null($changeValue))
                    {
                        // no problems here, add the contribution to yesterdayMRR

                        $todayMRR += $changeValue;
                    } else {
                        // do some error handling here
                    }
                    break;
                
                case 'customer.subscription.deleted':
                    // subscription deleted, decrease MRR
                    $tempArray = json_decode(strstr($event->object, '{'), true);

                    $changeValue = Calculator::getMRRContribution($tempArray['plan']);

                    // check if there is a problem
                    if (!is_null($changeValue))
                    {
                        // no problems here, add the contribution to yesterdayMRR
                        $todayMRR -= $changeValue;
                    } else {
                        // do some error handling here
                    }
                    break;

                case 'customer.subscription.updated':
                    // subscription changed
                    $newValues = json_decode(strstr($event->object, '{'), true);
                    $previousValues = json_decode(strstr($event->previousAttributes, '{'), true);

                    // decrease MRR with previous amount
                    $changeValue = Calculator::getMRRContribution($previousValues['plan']);
                    // check if there is a problem
                    if (!is_null($changeValue))
                    {
                        // no problems here, decrease MRR with previous value
                        $todayMRR -= $changeValue;
                    } else {
                        // do some error handling here
                    }

                    // increase MRR with new amount
                    $changeValue = Calculator::getMRRContribution($newValues['plan']);
                    // check if there is a problem
                    if (!is_null($changeValue))
                    {
                        // no problems here, increase MRR with new value
                        $todayMRR += $changeValue;
                    } else {
                        // do some error handling here
                    }
                    break;

                default:
                    // do nothing
            } // end switch
        } // end foreach

        return $todayMRR;
    }



    /**
    * Prepare MRR for statistics
    *
    * @param boolean
    *
    * @return array
    */

    public static function showMRR($fullDataNeeded = false)
    {
        // defaults
        self::$statName = 'Monthly Recurring Revenue';
        self::$statID = 'mrr';


    	$mrrData = array();

        // full MRR data
    	if ($fullDataNeeded){

    		$mrrData = self::showFullStat();

            // correction of the money to dollars from cents
            foreach($mrrData['fullHistory'] as $date => $value)
            {   
                if ($value) {
                    $mrrData['fullHistory'][$date] = $value / 100;
                }
            }

            // data for single stat table
			// get all the plan details
			$mrrData['detailData'] = Calculator::getSubscriptionDetails(Auth::user());
            setlocale(LC_MONETARY,"en_US");
			//converting price and mrr to money format
        	foreach ($mrrData['detailData'] as $id => $planDetail) {
	        	$mrrData['detailData'][$id]['price'] = money_format('%n', $planDetail['price'] / 100);
	            $mrrData['detailData'][$id]['mrr'] = money_format('%n', $planDetail['mrr'] / 100);
        	}
    	} else {
            $mrrData = self::showSimpleStat();
        }
        // converting to money format
        $mrrData = self::toMoneyFormat($mrrData, $fullDataNeeded);

        foreach($mrrData['history'] as $date => $value)
        {   
            if ($value) {
                $mrrData['history'][$date] = $value / 100;
            }
        }

    	return $mrrData;
    }

}
