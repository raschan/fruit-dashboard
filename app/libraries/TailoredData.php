<?php


class TailoredData
{
	/**
	* Unify customer objects from PayPal and Stripe
	*
	* @return array of all customers
	*/
	public static function getCustomers()
	{
		// getting api context for PP
		$apiContext = PayPalHelper::getApiContext();

		// return array
		$allCustomers = array();

		$stripeCustomers = array();
		$paypalCustomers = array();

		// get customers from Stripe if connected
		if (Auth::user()->isStripeConnected())
		{
			$stripeCustomers = StripeHelper::getCustomers(Auth::user()->stripe_key);
		}

		// get customers from Paypal if connected
		if (Auth::user()->isPayPalConnected())
		{
			$paypalCustomers = PayPalHelper::getCustomers($apiContext);
		}

		// merge the 2 arrays
		$allCustomers = array_merge($stripeCustomers, $paypalCustomers);

		return $allCustomers;
	}


	/**
	* Unify plan objects from PayPal and Stripe
	*
	* @return array of plans
	*/

	public static function getPlans()
	{
		// getting api context for PP
		$apiContext = PayPalHelper::getApiContext();

		// return array
		$allPlans = array();

		$stripePlans = array();
		$paypalPlans = array();

		// get plans from Stripe if connected
		if (Auth::user()->isStripeConnected())
		{
			$stripePlans = StripeHelper::getPlans(Auth::user()->stripe_key);
		}

		// get plans from Paypal if connected
		if (Auth::user()->isPayPalConnected())
		{
			$paypalPlans = PayPalHelper::getPlans($apiContext);
		}

		// merge the 2 arrays
		$allPlans = array_merge($stripePlans, $paypalPlans);

		return $allPlans;
	}
}
