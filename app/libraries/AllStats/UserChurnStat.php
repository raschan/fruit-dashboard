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
		return $userChurnData;
	}
}