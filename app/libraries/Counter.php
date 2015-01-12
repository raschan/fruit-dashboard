<?php

use TailoredData;

class Counter
{
	/**
	* Gets the active customers from all the customers
	*
	* @param Stripe key
	* @param PayPal key
	*
	* @return int - active customers
	*/

	public static function getActiveCustomers($stripeKey, $paypalKey)
	{
		// get all the customers
		$allCustomers = TailoredData::getCustomers($stripeKey, $paypalKey);

		// return int
		$activeCustomers = 0;

		// count all, that have at least one subscription
		foreach ($allCustomers as $customer) {
			if ($customer['subscriptions']['total_count'] > 0){
				$activeCustomers++;
			}
		}

		return $activeCustomers;
	}

	/**
	* Gets the Average revenue per active users
	*
	* @param Stripe key
	* @param PayPal key
	*
	* @return int
	*/
	public static function getARPU($stripeKey, $paypalKey)
	{
		// get active customer count
		$activeCustomers = self::getActiveCustomers($stripeKey, $paypalKey);

		// get MRR - TEMPORARY SOLUTION!!!
		$mrr = Auth::user()->getMRR();

		// count and return the ARPU
		$arpu = $mrr / $activeCustomers;
		return $arpu;
	}
}