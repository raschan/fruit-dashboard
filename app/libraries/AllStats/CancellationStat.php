<?php


class CancellationStat extends BaseStat {


	public static function showCancellation($fullDataNeeded = false)
	{
		// defaults
		self::$statID = 'cancellations';
		self::$statName = 'Cancellations';

		$cancellationData = array();

    	if ($fullDataNeeded){

            $cancellationData = self::showFullStat();

            // data for single stat table
            $cancellationData['detailData'] = Counter::getSubscriptionDetails(Auth::user());

        } else {
        	$cancellationData = self::showSimpleStat();
        }

    	return $cancellationData;
	}
}
