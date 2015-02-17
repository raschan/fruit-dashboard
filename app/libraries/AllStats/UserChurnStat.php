<?php

class UserChurnStat extends BaseStat {

	public static function showUserChurn ($fullDataNeeded = false)
	{
		self::$statID = 'uc';
		self::$statName = 'User Churn';

		$userChurnData = array();
		$userChurnData = self::showSimpleStat();

		return $userChurnData;
	}
}