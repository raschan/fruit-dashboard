<?php

use Abf\Event;      // needed because of conflicts with Laravel and Stripe

class Calculator
{

    /** 
    * daily metric calculator - called from cron script
    * @param $user
    * 
    * @return null
    */

    public static function calculateMetrics($user, $time) {

        // get needed time vars
        if ($time){
            $timestamp = $time;
        }
        else {
            $timestamp = time();
        }
        $today = date('Y-m-d', $timestamp);
        $yesterday = date('Y-m-d', $timestamp - 86400);

        // get today's metrics

        $metrics = Metric::firstOrNew(
            array(
                    'user'  => $user->id,
                    'date'  => $today
                    )
            );

        // get yesterday's metrics
        // this should never return an empty array

        $yesterdayMetric = Metric::where('user', $user->id)
                        ->where('date', $yesterday)
                        ->first();

        if(!$yesterdayMetric)
        {
            Calculator::calculateMetrics($user, $timestamp-86400);
            $yesterdayMetric = Metric::where('user', $user->id)
                    ->where('date', $yesterday)
                    ->first();            
        }
        // get today's events
        $events = Event::where('user', $user->id)
                    ->where('date', $today)
                    ->get();
        // events have a provider, needs merging
        // FIXME!!!!
        
        // calculate all the metrics

        // monthly recurring revenue
            // return int
        $metrics->mrr = MrrStat::calculate($yesterdayMetric->mrr, $events);

        // active users
            // return int
        $metrics->au = AUStat::calculate($yesterdayMetric->au, $events);   
        
        // annual recurring revenue
            // return int
        $metrics->arr = ArrStat::calculate($metrics->mrr);

        // average recurring revenue per active user
            // return int
        $metrics->arpu = ArpuStat::calculate($metrics->mrr, $metrics->au);
        
        // daily and monthly cancellations
            // return array
        list($daily, $monthly) = CancellationStat::calculate($events,$user);
        $metrics->cancellations = $daily;
        $metrics->monthlyCancellations = $monthly;

        // user churn
            // return float
        $metrics->uc = UserChurnStat::calculate($metrics->monthlyCancellations,$user,$timestamp);
        
        // save everything
        $metrics->save();
    }


    /** 
    * first time metric calculator - called on connect
    * calculates metrics in the past
    * can be a long running method
    * @param $user
    * 
    * @return null
    */

    public static function calculateMetricsOnConnect($user) 
    {
        $timestamp = time();
        $todayDate = date('Y-m-d', $timestamp);    

        // request and save events
        self::saveEvents($user);
        // get first event date
        $firstDate = Event::where('user', $user->id)
                        ->orderBy('date','asc')
                        ->first()
                        ->date;
        // request plans and subscription infos (alternativly, customers)
        $customers = TailoredData::getCustomers($user);
        // calculate starter mrr and au
        $starterAU = count($customers);
        $starterMRR = MrrStat::calculateFirstTime($customers);
        
        // reverse calculate from events
        $historyMRR = MrrStat::calculateHistory($timestamp,$user,$firstDate,$starterMRR);
        $historyAU = AUStat::calculateHistory($timestamp,$user,$firstDate,$starterAU);
        $historyCancellation = CancellationStat::calculateHistory($timestamp,$user,$firstDate);
        // calculate arr, arpu, uc
        $historyUC = UserChurnStat::calculateHistory($historyCancellation['monthly'], $historyAU);
        $historyARR = ArrStat::calculateHistory($historyMRR);
        $historyARPU = ArpuStat::calculateHistory($historyMRR, $historyAU);

        // save all the data
        foreach ($historyAU as $date => $au) 
        {
            $metrics = Metric::firstOrNew(
                array(
                        'date'      => $date,
                        'user'      => $user->id
                    )
                );
            $metrics->user = $user->id;
            $metrics->date = $date;

            $metrics->mrr = $historyMRR[$date];
            $metrics->au = $au;
            $metrics->arr = $historyARR[$date];
            $metrics->arpu = $historyARPU[$date];
            $metrics->uc = array_key_exists($date, $historyUC) ? $historyUC[$date] : null;

            $metrics->cancellations = array_key_exists($date, $historyCancellation['daily']) 
                                                ? $historyCancellation['daily'][$date]
                                                : 0 ;
            $metrics->monthlyCancellations = array_key_exists($date, $historyCancellation['monthly']) 
                                                ? $historyCancellation['monthly'][$date]
                                                : 0 ;

            $metrics->save();
        }
    }

    /**
    * save every event we don't have already
    *
    * @param user
    *
    * @return null
    */

    public static function saveEvents($user)
    {
        $eventsToSave = TailoredData::getEvents($user);

        if($eventsToSave)
        {
            foreach ($eventsToSave as $id => $event) {
                // check, if we already saved this event
                $newEvent = Event::firstOrNew(
                    array(
                        'date'      => date('Y-m-d', $event['created']),
                        'eventID'   => $id
                    )
                );
                $newEvent->date                 = date('Y-m-d', $event['created']);
                $newEvent->eventID              = $id;
                $newEvent->user                 = $user->id;
                $newEvent->created              = date('Y-m-d H:i:s', $event['created']);
                $newEvent->provider             = $event['provider'];
                $newEvent->type                 = $event['type'];
                $newEvent->object               = json_encode($event['data']['object']);
                $newEvent->previousAttributes   = isset($event['data']['previous_attributes'])
                                                    ? json_encode($event['data']['previous_attributes'])
                                                    : null;
                $newEvent->save();
            }
        }
    }

    /**
    * helper function for calculationg MRR
    * @param plan array
    *
    * @return int, contribution to MRR
    */

    public static function getMRRContribution($plan)
    {
        // check all possible intervals, and return the correct amount

        switch ($plan['interval']) {

            case 'day':
                return $plan['amount'] * 30;        // average days in a month

            case 'week':
                return $plan['amount'] * 4;         // average weeks in a month
            
            case 'month':
                return $plan['amount'];             // basic amount

            case 'year':
                return round($plan['amount'] / 12); // rebased for a month

            default:
                return null;                        // should never ever return this, its a major fault at provider
        }
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


    public static function formatEvents($user)
    {
        $eventArray = array();      // return array
        $tempArray = array();       // helper
        $prevTempArray = array();   // previous values

        // last X events from database
        // select only those event types, which we show on dashboard
        $events = Event::where('user', $user->id)
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
        
        foreach ($events as $event)
        {
            // if stripe event
            if ($event->provider == 'stripe')
            {
                // decoding object

                $tempArray = json_decode(strstr($event->object, '{'), true);
                $prevTempArray = !is_null($event->previousAttributes)
                                    ? json_decode(strstr($event->previousAttributes , '{'), true)
                                    : null;

                // formatting and creating data for return array
                // type eg. 'charge.succeeded'
                $eventArray[$i]['type'] = $event->type;
                // provider eg. 'stripe'
                $eventArray[$i]['provider'] = $event->provider;
                // date eg. '02-11 20:44'
                $eventArray[$i]['date'] = date('m-d H:i', strtotime($event->created));

                // name eg. 'chris'
                if (array_key_exists('card', $tempArray)){
                    if(array_key_exists('name', $tempArray['card'])){
                        if($tempArray['card']['name']){
                            $eventArray[$i]['name'] = $tempArray['card']['name'];
                        }
                        else {
                            $eventArray[$i]['name'] = 'Someone1';
                        }
                    }
                    else {
                        $eventArray[$i]['name'] = 'Someone2';
                    }
                }
                else {
                    $eventArray[$i]['name'] = 'Someone3';
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
                if (array_key_exists('plan', $tempArray))
                {
                switch ($tempArray['plan']['interval']) 
                    {
                        case 'day':
                            $eventArray[$i]['plan_interval'] = 'daily';
                            break;
                        case 'week':
                            $eventArray[$i]['plan_interval'] = 'weekly';
                            break;
                        case 'month':
                            $eventArray[$i]['plan_interval'] = 'daily';
                            break;
                        case 'year':
                            $eventArray[$i]['plan_interval'] = 'yearly';
                            break;
                        default:
                            // don't do anything
                    }
                }
                // previous plan ID, name, interval and amount
                if (!is_null($prevTempArray))
                {
                    if (array_key_exists('plan', $prevTempArray))
                    {
                        $eventArray[$i]['prevPlanID'] = $prevTempArray['plan']['id'];
                        $eventArray[$i]['prevPlanName'] = $prevTempArray['plan']['name'];
                        $eventArray[$i]['prevPlanAmount'] = $prevTempArray['plan']['amount'];
    
                        switch ($prevTempArray['plan']['interval']) 
                        {
                            case 'day':
                                $eventArray[$i]['prevPlanInterval'] = 'daily';
                                break;
                            case 'week':
                                $eventArray[$i]['prevPlanInterval'] = 'weekly';
                                break;
                            case 'month':
                                $eventArray[$i]['prevPlanInterval'] = 'daily';
                                break;
                            case 'year':
                                $eventArray[$i]['prevPlanInterval'] = 'yearly';
                                break;
                            default:
                                // don't do anything
                        }
                    }
                }

                // if the event is a coupon event

                if (isset($tempArray['coupon']))
                {
                    $eventArray[$i]['newCoupon'] = $tempArray['coupon']['id'];
    
                    if (!is_null($prevTempArray)) 
                    {
                        $eventArray[$i]['prevCoupon'] = $prevTempArray['coupon']['id'];
                    }
                }
            } // end if stripe event
            $i++;
        }// end foreach
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
    	$events = Event::where('user', $user->id)
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

    /** 
    * Stores all the metrics we currently calculate
    *
    * @return assoc array of metric Classnames and column headers
    */

    public static function currentMetrics()
    {
        return array(
            'mrr'               => array('metricClass'  => 'MrrStat'
                                        ,'metricName'   => 'Monthly Recurring Revenue')
            ,'au'               => array('metricClass'  => 'AUStat'
                                        ,'metricName'   => 'Active Users')
            ,'arr'              => array('metricClass'  => 'ArrStat'
                                        ,'metricName'   => 'Annual Recurring Revenue')
            ,'arpu'             => array('metricClass'  => 'ArpuStat'
                                        ,'metricName'   => 'Average Revenue Per User')
            ,'cancellations'    => array('metricClass'  => 'CancellationStat'
                                        ,'metricName'   => 'Cancellations')
            ,'uc'               => array('metricClass'  => 'UserChurnStat'
                                        ,'metricName'   => 'User Churn')           
        );
    }
}
