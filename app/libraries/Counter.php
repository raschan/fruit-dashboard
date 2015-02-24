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
    *   - plan details
    *       - subscription count
    *       - plan cost
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

    public static function retreiveAndCalculateMRR($user)
    {
        // getting the plans
        $plans = TailoredData::getPlans($user);

        // getting current subscriptions (only active subscriptions)
        $current_subscriptions = self::getCurrentSubscriptions($user);

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

    public static function saveMRR($user)
    {
        $currentDay = date('Y-m-d', time());

        // checking if we already have data
        $currentDayMRR = DB::table('mrr')
            ->where('date', $currentDay)
            ->where('user', $user->id)
            ->get();

        if (!$currentDayMRR) {
            // no previous data
            $mrrValue = self::retreiveAndCalculateMRR($user);

            foreach ($mrrValue as $provider => $value) {
                DB::table('mrr')->insert(
                    array(
                        'provider'  => $provider,
                        'value'     => $value,
                        'user'      => $user->id,
                        'date'      => $currentDay
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
    *   - charge events
    *
    * @return int (cents)
    */


    /**
    * Refunds
    * refunds on any made charge
    *
    * Required events/data:
    *   - refund events
    *
    * @return int (cents)
    */


    /**
    * AU - Active Users
    * every user, who has atleast one live subscription
    *
    * Required events/data:
    *   - user/customer details
    *       - subscription data
    *
    * @return pos. int (heads)
    */

    public static function getActiveCustomers($user)
    {
        // get all the customers
        $allCustomers = TailoredData::getCustomers($user);

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

    public static function saveAU($user)
    {
        $currentDay = date('Y-m-d', time());

        // checking if we already have data
        $currentDayAU = DB::table('au')
            ->where('date', $currentDay)
            ->where('user', $user->id)
            ->get();

        if (!$currentDayAU) {
            // no previous data
            $AUValue = self::getActiveCustomers($user);

            DB::table('AU')->insert(
                array(
                    'value' => $AUValue,
                    'user'  => $user->id,
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
    *   - all events regarding spending money
    *
    * @return int (cents)
    */


    /**
    * Cancellations
    * count of cancelled subscriptions
    *
    * Required events/data:
    *   - cancellation events
    *
    * Must save also:
    *   - the price difference
    *
    * @return int (pieces)
    */

    public static function saveCancellations($user) 
    {
    	$currentDay = date('Y-m-d',time());

    	$currentDayCancellations = DB::table('cancellations')
    		->where('date',$currentDay)
    		->where('user', $user->id)
            ->get();

        if (!$currentDayCancellations)
        {
        	$cancellationValue = self::getCancellations($user);

            DB::table('cancellations')->insert(
                array(
                    'value' => $cancellationValue,
                    'user'  => $user->id,
                    'date'  => $currentDay,
                    'provider' => 'stripe',
                    'cumulativeValue' => CancellationStat::getIndicatorStatOnDay(time())
                )
            );
        }
    }

    /**
    * Downgrade
    * changing to a smaller plan
    *
    * Required events/data:
    *   - update events, where plan cost went down
    *
    * Must save also:
    *   - the price difference
    *
    * @return int (pieces)
    */


    /**
    * Upgrades
    * changing to a bigger plan
    *
    * Required events/data:
    *   - update events, where plan cost went up
    *
    * @return int (pieces)
    */


    /**
    * CR - Coupons Redeemed
    * income loss due to redeemed coupons
    *
    * Required events/data
    *   - Coupon/Disount data
    *
    * @return int (cents)
    */


    /**
    * FC - Failed Charges
    *
    * Required events/data
    *   - charge events, which failed to be paid
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
    *   -
    *   - MRR
    *   - Refunds
    * ORR
    * @return int (cents)
    */


    /**
    * ARR - Annual run rate
    * MRR * 12
    *
    * Required functions:
    *   - MRR
    *
    * @return int (cents)
    */


    /**
    * ARPU - Average Revenue Per active Users
    * MRR / active users
    *
    * Required functions:
    *   - MRR
    *   - AU
    *
    * @return int (cents)
    */


    /**
    * UC - User Churn
    * Cancellations / (Last month Active Users) * 100
    *
    * Required functions:
    *   - Cancellations
    *   - AU 30 days before
    *
    * @return int (percent)
    */
    

    /**
    * LV - Lifetime Value
    * the average 'usefullness' of users
    * (Average Revenue Per User) / (User Churn)
    *
    * Required functions:
    *   - ARPU
    *   - UC
    *
    * @return int (cents/percent)
    */


    /**
    * RC - Revenue Churn
    * (MRR loss due to cancellations and downgrades) / (last month MRR) * 100
    *
    * Required functions:
    *   - MRR (30 days before)
    *   - price difference of cancellations
    *   - price difference of downgrades
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

    private static function getAUDetails($user)
    {
        $day = date('Y-m-d', $timestamp);

        $au = DB::table('au')
            ->where('date',$day)
            ->where('user', $user->id)
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

    

    /**
     * Getting all the subscriptions.
     *
     * @return an array with the active subscriptions
    */
    private static function getCurrentSubscriptions($user)
    {
        // intializing out array
        $active_subscriptions = array();

        // getting the customers
        $customers = TailoredData::getCustomers($user);

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

    public static function getSubscriptionDetails($user)
    {
        // get all active subscriptions
        $currentSubscriptions = self::getCurrentSubscriptions($user);

        // get all plans
        $plans = TailoredData::getPlans($user);

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

    public static function saveEvents($user)
    {
        $savedObjects = 0;
        $eventsToSave = TailoredData::getEvents($user);

        if(!$eventsToSave)
        {
            return $savedObjects;
        } else {

            foreach ($eventsToSave as $id => $event) {

                // check, if we already saved this event
                $hasEvent = DB::table('events')
                ->where('eventID',$id)
                ->where('user', $user->id)
                ->get();

                // if we dont already have that event
                if(!$hasEvent)
                {
                    $savedObjects++;
                    DB::table('events')->insert(
                        array(
                            'created'   => date('Y-m-d H:i:s',$event['created']),
                            'user'      => $user->id,
                            'provider'  => $event['provider'],
                            'eventID'   => $id,
                            'type'      => $event['type'],
                            'object'    => json_encode($event['object'])
                        )
                    );
                }
            }
        }
        return $savedObjects;
    }

    public static function formatEvents($user)
    {
        // helpers
        $eventArray = array();
        $tempArray = array();

        // last X events from database
        // select only those event types, which we show on dashboard
        $events = DB::table('events')
            ->where('user', $user->id)
            ->whereIn('type', ['charge.succeeded'
                                ,'charge.failed'
                                ,'charge.captured'
                                ,'charge.refunded'
                                ,'customer.created'
                                ,'customer.deleted'
                                ,'customer.subscription.created'
                                ,'customer.subscription.updated'
                                ,'customer.subscription.deleted'
                                ,'customer.discount.created'
                                ,'customer.discount.updated'
                                ,'customer.discount.deleted'])
            ->orderBy('created', 'desc')
            //->take(20)
            ->get();


        $i = 0;
        
        foreach ($events as $event){
            // if stripe event
            if ($event->provider == 'stripe'){
                // decoding object
                $tempArray = json_decode(strstr($event->object, '{'), true);

                // formatting and creating data for return array
                // type eg. 'charge.succeeded'
                $eventArray[$i]['type'] = $event->type;
                // provider eg. 'stripe'
                $eventArray[$i]['provider'] = $event->provider;
                // date eg. '02-11 20:44'
                if (array_key_exists('created', $tempArray)){
                    $eventArray[$i]['date'] = date('m-d H:i', $tempArray['created']);
                }
                elseif(array_key_exists('plan', $tempArray) && array_key_exists('created', $tempArray['plan'])){
                    $eventArray[$i]['date'] = date('m-d H:i', $tempArray['plan']['created']);
                }
                else {
                    $eventArray[$i]['date'] = null;
                }
                // name eg. 'chris'
                if (array_key_exists('card', $tempArray)){
                    if(array_key_exists('name', $tempArray['card'])){
                        if($tempArray['card']['name']){
                            $eventArray[$i]['name'] = $tempArray['card']['name'];
                        }
                        else {
                            $eventArray[$i]['name'] = 'Someone';
                        }
                    }
                    else {
                        $eventArray[$i]['name'] = 'Someone';
                    }
                }
                else {
                    $eventArray[$i]['name'] = 'Someone';
                }
                // currency
                if (array_key_exists('currency', $tempArray)){
                    $eventArray[$i]['currency'] = $tempArray['currency'];
                }
                elseif (array_key_exists('plan', $tempArray)){
                    if (array_key_exists('currency', $tempArray['plan'])){
                        $eventArray[$i]['currency'] = $tempArray['plan']['currency'];
                    }
                }
                else {
                    $eventArray[$i]['currency'] = null;
                }
                
                // amount paid
                if(array_key_exists('amount', $tempArray)){
                    $eventArray[$i]['amount'] = $tempArray['amount'];
                }
                elseif (array_key_exists('amount_due', $tempArray)){
                    $eventArray[$i]['amount'] = $tempArray['amount_due'];
                }
                elseif (array_key_exists('plan', $tempArray)){
                    if (array_key_exists('amount', $tempArray['plan'])){
                        $eventArray[$i]['amount'] = $tempArray['plan']['amount'];
                    }
                }
                elseif (array_key_exists('amount_refunded', $tempArray)){
                    $eventArray[$i]['amount'] = $tempArray['amount_refunded'];
                }
                else {
                    $eventArray[$i]['amount'] = null;
                }
                // plan name
                if (array_key_exists('plan', $tempArray)){
                    if (array_key_exists('name', $tempArray['plan'])){
                        $eventArray[$i]['plan_name'] = $tempArray['plan']['name'];
                    }
                }
                // plan interval
                if (array_key_exists('plan', $tempArray)){
                        if ($tempArray['plan']['interval'] == 'day'){
                            $eventArray[$i]['plan_interval'] = 'daily';
                        }
                        elseif ($tempArray['plan']['interval'] == 'month'){
                            $eventArray[$i]['plan_interval'] = 'monthly';
                        }
                        elseif ($tempArray['plan']['interval'] == 'year'){
                            $eventArray[$i]['plan_interval'] = 'yearly';
                        }
                        else {
                            $eventArray[$i]['plan_interval'] = $tempArray['plan']['interval'];
                        }

                }

            }
            elseif ($event->provider == 'paypal'){
                // paypal formatter
            }
            $i++;
        }

            return $eventArray;
    }

    private static function getCancellations($user)
    {	
    	// return value
    	$cancellations = 0;

   		// check if we reached the day before yesterday
    	$reachedEndOfDay = false;

    	$currentDay = time();
    	$yesterDay = $currentDay - 24*60*60;

    	// get all the evens saying customer cancelled
    	$events = DB::table('events')
            ->where('user', $user->id)
            ->whereIn('type', ['customer.subscription.deleted'])
            ->orderBy('created', 'desc')
            ->get();

        $i = 0;

        // go through all the returned events and check for dates
        while (!$reachedEndOfDay)
        {
        	if (strtotime($events[$i]->created) < $yesterDay) {
        		$reachedEndOfDay = true;
        	} else {
        		$cancellations++;
        	}
        	$i++;
        	if (!isset($events[$i]))
        	{
        		$reachedEndOfDay = true;
        	}
        }

    	return $cancellations;
    }
}
