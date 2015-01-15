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
		$mrr = self::getMRR();

		// count and return the ARPU
		$arpu = round($mrr / $activeCustomers);
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
	* Retreive data relevant to MRR and calculate the current value
	*
	* @return int (cents)
	*/

	public static function retreiveAndCalculateMRR()
    {
        // getting the plans
        $plans = TailoredData::getPlans();

        // getting current subscriptions (only active subscriptions)
        $current_subscriptions = self::getCurrentSubscriptions();

        // we'll store the relations here
        $plan_subscriptions = array();

        // dividing subscriptions among the plans and summing the mrr
        $mrr = 0;

        // getting each plan's count
        foreach ($current_subscriptions as $subscription) {
            // checking for previous data
            if (isset($plan_subscriptions[$subscription['plan_id']])) {
                // has previous data
                $plan_subscriptions[$subscription['plan_id']]++;
            } else {
                // initializing data
                $plan_subscriptions[$subscription['plan_id']] = 1;
            }
        }

        // counting the mrr
        foreach ($plan_subscriptions as $plan_id => $count) {
            $mrr += $plans[$plan_id]['amount'] * $count;
        }

        // returning int
        return $mrr;
    }

    /**
    * Save the daily MRR in database
    */

    public static function saveMRR()
    {
    	$current_day = date('Y-m-d', time());

        // checking if we already have data
        $current_day_mrr = DB::table('mrr')
            ->where('date', $current_day)
            ->where('user', Auth::user()->id)
            ->get();

        if (!$current_day_mrr) {
        	// no previous data
    		$mrrValue = self::retreiveAndCalculateMRR();

    		DB::table('mrr')->insert(
                array(
                    'value' => $mrrValue,
                    'user'  => Auth::user()->id,
                    'date'  => $current_day
                )
            );
    	}
    }

    /**
    * Get MRR on given day
    *
    * @param timestamp, current day timestamp
    * 
    * @return int (cents) or 0 if data not exist
    */

    public static function getMRROnDay($timestamp)
    {
    	$day = date('Y-m-d', $timestamp);

    	$mrr = DB::table('mrr')
    		->where('date',$day)
    		->where('user', Auth::user()->id)
    		->get();

    	if($mrr){
    		return $mrr[0]->value;
    	} else {
			return 0;
    	}
    }


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


	/*
	|------------------------------------------------------------
	| Other helper functions
	|------------------------------------------------------------
	*/


	/**
     * Getting all the subscriptions.
     *
     * @return an array with the active subscriptions
    */
    private static function getCurrentSubscriptions()
    {
        // intializing out array
        $active_subscriptions = array();

        // getting the customers
            // add stripe customers
        $customers = TailoredData::getCustomers();
            // add paypal customers

        // getting the active subscriptions for a customer
        foreach ($customers as $customer) {

            // going through each subscription if any
            if ($customer['subscriptions']['total_count'] > 0) {
                // there are some subs
                foreach ($customer['subscriptions']['data'] as
                         $subscription) {
                    // updating array

                    /*
                    plan
                        id - string
                    start       - timestamp, subscription start date
                    status      - string, possible values are: 
                                    'trialing'
                                    'active'
                                    'past_due'
                                    'canceled'
                                    'unpaid'
                    quantity    - int
                    */

                    // only count subscriptions, that are active
                    if ($subscription['status'] == 'active')
                    {
	                    $active_subscriptions[$subscription['id']] =
	                        array(
	                            'plan_id'  => $subscription['plan']['id'],
	                            'start'    => $subscription['start'],
	                            'quantity' => $subscription['quantity']
	                        );
	                }
                } // foreach suibscriptions
            } // if subscriptions
        } // foreach customer

        return $active_subscriptions;
    }
}