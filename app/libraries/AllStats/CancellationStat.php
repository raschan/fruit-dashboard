<?php


class CancellationStat extends BaseStat {


	public static function showCancellation($fullDataNeeded = false)
	{
		// defaults
		self::$statID = 'cancellations';
		self::$statName = 'Cancellations';

		$cancellationData = array();

    	$cancellationData = self::showSimpleStat();

    	return $cancellationData;
	}
}
