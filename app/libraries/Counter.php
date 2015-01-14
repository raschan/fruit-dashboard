<?php


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
	* Gets the Average Revenue Per active Users
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


	/*
	|--------------------------------------------------------------
	| Base functions (depend only on data from Stripe/Paypal/Other)
	|--------------------------------------------------------------
	*/
	

	/**
	* MRR - Monthly Recurring Revenue
	* all recurring revenues, per month 
	* (e.g a yearly plan is divided by 12)
	* 
	* Required events/data: 
	* 	- plan details
	* 		- subscription count
	*		- plan cost
	*
	* @return int (cents)
	*/


	/**
	* OR - Other Revenues
	* every revenue, which not connected to recurring revenues
	* 
	* Required events/data:
	* 	- charge events
	*
	* @return int (cents)
	*/
	

	/**
	* Refunds
	* refunds on any made charge
	*
	* Required events/data:
	*	- refund events
	*
	* @return int (cents)
	*/


	/**
	* AU - Active Users
	* every user, who has atleast one live subscription
	*
	* Required events/data:
	*	- user/customer details
	*		- subscription data
	*
	* @return pos. int (heads)
	*/


	/**
	* Fees
	* all payed fees
	*
	* Required events/data:
	* 	- all events regarding spending money
	*
	* @return int (cents)
	*/


	/**
	* Cancellations
	* count of cancelled subscriptions 
	*
	* Required events/data:
	*	- cancellation events
	*
	* Must save also:
	* 	- the price difference
	*
	* @return int (pieces)
	*/


	/**
	* Downgrade
	* changing to a smaller plan
	*
	* Required events/data:
	* 	- update events, where plan cost went down
	*
	* Must save also:
	* 	- the price difference
	*
	* @return int (pieces)
	*/

	
	/**
	* Upgrades
	* changing to a bigger plan
	*
	* Required events/data:
	*	- update events, where plan cost went up
	*
	* @return int (pieces)
	*/


	/**
	* CR - Coupons Redeemed
	* income loss due to redeemed coupons
	*
	* Required events/data
	*	- Coupon/Disount data
	*
	* @return int (cents)
	*/ 


	/**
	* FC - Failed Charges
	*
	* Required events/data
	*	- charge events, which failed to be paid
	*
	* @return int (cents)
	*/

	/*
	|--------------------------------------------------------------
	| Derived functions (have dependecies on base functions)
	|--------------------------------------------------------------
	*/


	/**
	* NR - net revenue
	* MRR + OR - refunds
	* 
	* Required functions:
	*	-
	*	- MRR
	*	- Refunds
	* ORR
	* @return int (cents)
	*/


	/**
	* ARR - Annual run rate
	* MRR * 12
	*	
	* Required functions:
	* 	- MRR
	*
	* @return int (cents)
	*/


	/**
	* ARPU - Average Revenue Per active Users
	* MRR / active users
	*
	* Required functions:
	*	- MRR
	*	- AU
	*
	* @return int (cents)
	*/


	/**
	* UC - User Churn
	* Cancellations / (Last month Active Users) * 100
	*
	* Required functions:
	*	- Cancellations
	* 	- AU 30 days before
	*
	* @return int (percent)
	*/


	/** 
	* LV - Lifetime Value
	* the average 'usefullness' of users
	* (Average Revenue Per User) / (User Churn)
	*
	* Required functions:
	*	- ARPU
	*	- UC
	*
	* @return int (cents/percent) 
	*/


	/** 
	* RC - Revenue Churn
	* (MRR loss due to cancellations and downgrades) / (last month MRR) * 100
	*
	* Required functions:
	* 	- MRR (30 days before)
	*	- price difference of cancellations
	*	- price difference of downgrades
	*
	* @return int (percent)
	*/
}