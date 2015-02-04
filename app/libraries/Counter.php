<?php



class Counter
{

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
	* Format events for dashboard transactions live feed
	*
	* @return array
	*/


	/**
	* Retreive data relevant to MRR and calculate the current value
	*
	* @return array (provider => mrr)
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
        $mrr = array();

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
        	if (isset($mrr[$plans[$plan_id]['provider']])){
        		// we already met this provider
   	        	$mrr[$plans[$plan_id]['provider']] += $plans[$plan_id]['amount'] * $count;
   	        } else {
   	        	// this is a new provider
   	        	$mrr[$plans[$plan_id]['provider']] = $plans[$plan_id]['amount'] * $count;
   	        }
        }

        // returning int
        return $mrr;
    }

    /**
    * Save the daily MRR in database
    */

    public static function saveMRR()
    {
    	$currentDay = date('Y-m-d', time());

        // checking if we already have data
        $currentDayMRR = DB::table('mrr')
            ->where('date', $currentDay)
            ->where('user', Auth::user()->id)
            ->get();

        if (!$currentDayMRR) {
        	// no previous data
    		$mrrValue = self::retreiveAndCalculateMRR();

    		foreach ($mrrValue as $provider => $value) {
	    		DB::table('mrr')->insert(
	                array(
	                	'provider' 	=> $provider,
	                    'value' 	=> $value,
	                    'user'  	=> Auth::user()->id,
	                    'date'  	=> $currentDay
	                )
	            );
    		}
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

	public static function getActiveCustomers()
	{
		// get all the customers
		$allCustomers = TailoredData::getCustomers();

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
    * Save the daily Active Users number in database
    */

    public static function saveAU()
    {
    	$currentDay = date('Y-m-d', time());

        // checking if we already have data
        $currentDayAU = DB::table('au')
            ->where('date', $currentDay)
            ->where('user', Auth::user()->id)
            ->get();

        if (!$currentDayAU) {
        	// no previous data
    		$AUValue = self::getActiveCustomers();

    		DB::table('AU')->insert(
                array(
                    'value' => $AUValue,
                    'user'  => Auth::user()->id,
                    'date'  => $currentDay
                )
            );
    	}
    }



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
    * Get Active User details
    *
    * 
    * @return array
    */

    private static function getAUDetails()
    {
    	$day = date('Y-m-d', $timestamp);

    	$au = DB::table('au')
    		->where('date',$day)
    		->where('user', Auth::user()->id)
    		->get();

    	if($au){
    		return $au[0]->value;
    	} else {
			return null;
    	}
    }

	/**
    * Get Active Users on given day
    *
    * @param timestamp, current day timestamp
    * 
    * @return int (cents) or null if data not exist
    */

    private static function getAUOnDay($timestamp)
    {
    	$day = date('Y-m-d', $timestamp);

    	$au = DB::table('au')
    		->where('date',$day)
    		->where('user', Auth::user()->id)
    		->get();

    	if($au){
    		return $au[0]->value;
    	} else {
			return null;
    	}
    }

	/**
    * Get MRR on given day
    *
    * @param timestamp, current day timestamp
    * 
    * @return int (cents) or null if data not exist
    */

    private static function getMRROnDay($timestamp)
    {
    	$day = date('Y-m-d', $timestamp);

    	$mrr = DB::table('mrr')
    		->where('date',$day)
    		->where('user', Auth::user()->id)
    		->get();

    	if($mrr){
    		return $mrr[0]->value;
    	} else {
			return null;
    	}
    }

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
        $customers = TailoredData::getCustomers();

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
	                            'plan_id'  => $subscription['plan']['id']
	                        );
	                }
                } // foreach subscriptions
            } // if subscriptions
        } // foreach customer

        return $active_subscriptions;
    }

    public static function getSubscriptionDetails()
    {
    	// get all active subscriptions
    	$currentSubscriptions = self::getCurrentSubscriptions();

    	// get all plans
    	$plans = TailoredData::getPlans();

    	// we'll store the details here
        $planDetails = array();

        // getting plan details
        foreach ($plans as $id => $plan) {
        	$planDetails[$id] = array(
        		'name' => $plan['name'],
        		'price' => $plan['amount'],
        		'currency' => $plan['currency'],
        		'interval' => $plan['interval'],
        		'count' => 0,
        		'mrr' => 0
        	);
        }
        // getting each plan's count and mrr contribution
        foreach ($currentSubscriptions as $subscription) {
        	$planDetail = $planDetails[$subscription['plan_id']];
            $planDetail['count']++;
            $planDetail['mrr'] = $planDetail['price'] * $planDetail['count'];
            $planDetails[$subscription['plan_id']] = $planDetail;
        }

	    // returning int
        return $planDetails;
    }

    public static function saveEvents()
    {
    	$eventsToSave = TailoredData::getEvents();
    	foreach ($eventsToSave as $id => $event) {
    		$hasEvent = DB::table('events')
    		->where('eventID',$id)
    		->where('user', Auth::user()->id)
    		->get();

    		// if we dont already have that event
    		if(!$hasEvent)
    		{    		
	    		DB::table('events')->insert(
	                array(
	                    'created' 	=> date('Y-m-d', $event['created']),
	                    'user'  	=> Auth::user()->id,
	                    'provider' 	=> $event['provider'],
	                    'eventID'	=> $id,
	                    'object'	=> json_encode($event['object'])
	                )
	            );
	    	}
		}

    } 

    public static function getEvents()
    {

    	$events = DB::table('events')
    		->where('user', Auth::user()->id)
    		->orderBy('created', 'desc')
    		->take(50)
    		->get();

    	if($events){
    		return $events;
    	} else {
			return null;
    	}
    }
    	
}