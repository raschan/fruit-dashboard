<?php

class MrrStat extends BaseStat {

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
			$mrrData['detailData'] = Counter::getSubscriptionDetails(Auth::user());
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
