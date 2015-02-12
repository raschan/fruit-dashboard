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

    	$mrrData = self::showSimpleStat();

        // full MRR data
    	if ($fullDataNeeded){

    		$mrrData = self::showFullStat();

            // data for single stat table
			// get all the plan details
			$mrrData['detailData'] = Counter::getSubscriptionDetails(Auth::user());

			//converting price and mrr to money format
        	foreach ($mrrData['detailData'] as $id => $planDetail) {
	        	$mrrData['detailData'][$id]['price'] = money_format('%n', $planDetail['price'] / 100);
	            $mrrData['detailData'][$id]['mrr'] = money_format('%n', $planDetail['mrr'] / 100);
        	}
    	}
        // converting to money format
        $mrrData = self::toMoneyFormat($mrrData, $fullDataNeeded);

    	return $mrrData;
    }

}
