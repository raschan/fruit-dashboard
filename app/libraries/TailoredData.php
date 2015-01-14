<?php


class TailoredData
{
	/**
	* Unify customer objects from PayPal and Stripe
	* 
	* @param Stripe key
	* @param PayPal key
	*
	* @return array of all customers
	*/
	public static function getCustomers($stripeKey, $paypalKey)
	{
		// return array
		$allCustomers = array();

		// get customers from Stripe
		$stripeCustomers = StripeHelper::getCustomers($stripeKey);

		// get customers from Paypal
		$paypalCustomers = PayPalHelper::getCustomers($paypalKey);

		// merge the 2 arrays
		$allCustomers = array_merge($stripeCustomers,$paypalCustomers);

		return $allCustomers;
	}
}