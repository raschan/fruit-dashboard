<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

use StripeHelper;

class User extends Eloquent implements UserInterface
{
    use UserTrait;
    /**
     * Testing if the user has connected a stripe account
     *
     * @return boolean
    */
    public function isStripeConnected()
    {
        // at this point validation like this is all right
        if (strlen($this->stripe_key) > 16) {
            // long enough key
            return True;
        }
        // no key is given
        return False;
    }

     /**
     * Testing if the user has connected a paypal account
     *
     * @return boolean
    */
    public function isPayPalConnected()
    {
        // at this point validation like this is all right
        if (strlen($this->paypal_key) > 16) {
            // refreshtoken is longer longer than 16
            return True;
        }
        // no valid refreshtoken is stored
        return False;
    }

    /**
     * Testing if the user has connected at least one account
     *
     * @return boolean
    */
    public function isConnected()
    {
        if ($this->isStripeConnected() 
            || $this->isPayPalConnected()) 
        {
            // connected
            return True;
        }
        // not connected
        return False;
    }

    /**
     * Getting all the subscriptions. PROBLEM WITH HISTORY!
     * @param stripe key
     * @param paypal key
     *
     * @return an array with the subscriptions
    */
    public function getCurrentSubscriptions($stripe_key, $paypal_key)
    {
        // intializing out array
        $active_subscriptions = array();

        // getting the customers
            // add stripe customers
        $customers = StripeHelper::getCustomers($stripe_key);
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

                    $active_subscriptions[$subscription['id']] =
                        array(
                            'plan_id'  => $subscription['plan']['id'],
                            'start'    => $subscription['start'],
                            'status'   => $subscription['status'],
                            'quantity' => $subscription['quantity']
                        );
                } // foreach suibscriptions
            } // if subscriptions
        } // foreach customer

        return $active_subscriptions;
    }

    /**
     * Getting the MRR based on the plans. High lvl function!
     * Don't use paypal/stripe specific methods here
     *
     * @return a bigint with the MRR in it
    */
    public function getMRR()
    {
        // getting the plans
        $plans = StripeHelper::getPlans($this->stripe_key);

        // getting current subscriptions
        $current_subscriptions = $this->getCurrentSubscriptions($this->stripe_key, $this->paypal_key);

        // we'll store the relations here
        $plan_subscriptions = array();

        // dividing subscriptions among the plans and summing the mrr
        $mrr = 0;

        foreach ($current_subscriptions as $subscription) {
            // getting the plan

            // checking for previous
            if (isset($plan_subscriptions[$subscription['plan_id']])) {
                // has previous data
                $plan_subscriptions[$subscription['plan_id']] += 1;
            } else {
                // initializing data
                $plan_subscriptions[$subscription['plan_id']] = 1;
            }
        }

        // counting the mrr
        foreach ($plan_subscriptions as $plan_id => $count) {
            // now this is obviously not enough

            // checking interval
            // checking now - trial_end
            // canceled_at

            $mrr += $plans[$plan_id]['amount']*$count;
        }

        // returning object
        return $mrr;
    }

    /**
     * Getting the ARR based on MRR. High lvl function!
     * Don't use paypal/stripe specific methods here
     *
     * @return a bigint with the ARR in it
    */
    public function getARR()
    {
        $mrr = $this->getMRR();

        return $mrr*12;
    }

    /**
     * Adding event to MRR
     * Description: checks the day before and the events during the day
     * !!!NOT YET GENERALIZED!!!
     * @return int
    */
    private function addToMRR($mrr, $event)
    {
        // initializing new mrr
        $new_mrr = $mrr;

        // we only care about subscriptions here
        if (strstr($event['type'], 'subscription')) {
            // three possible events
            if (strstr($event['type'], 'create')) {
                // create :)

                // adding to mrr
                $new_mrr += $event['object']['plan']['amount'];

            } else if (strstr($event['type'], 'update')) {
                // update :|

            } else if (strstr($event['type'], 'delete')) {
                // delete :(

                // removing from mrr
                $new_mrr -= $event['object']['plan']['amount'];
            }

        }

        // returning new mrr
        return $new_mrr;
    }

    /**
     * Saving the MRR for a timestamp (must be within 30 days in the past)
     * Description: checks the day before and the events during the day
     *
     * @return void
    */
    private function buildMRROnDay($timestamp, $events)
    {
        // building up yesterday date
        $yesterday_ts = $timestamp - 86400;
        $yesterday = date('Y-m-d', $yesterday_ts);

        $current_day = date('Y-m-d', $timestamp);

        // checking if we already have data
        $current_day_mrr = DB::table('mrr')
            ->where('date', $current_day)
            ->where('user', Auth::user()->id)
            ->get();

        if (!$current_day_mrr) {
            // no previous reco

            // selecting mrr for the user on yesterday
            $yesterday_mrr = DB::table('mrr')
                ->where('date', $yesterday)
                ->where('user', Auth::user()->id)
                ->get();

            // making sure we are not trying to add NULL to database
            if (!$yesterday_mrr) {
                $mrr = 0;
            } else {
                $mrr = $yesterday_mrr[0]->value;
            }

            // building up the range
            $range_start = strtotime($current_day);
            $range_stop = $range_start + 86400;


            // building the mrr

            // selecting the relevant events
            foreach ($events as $event) {
                // checking if created is in the range
                if ($event['created'] > $range_start and
                    $event['created'] < $range_stop) {

                    $mrr = $this->addToMRR($mrr, $event);
                }
            }
            // saving mrr to db if we don't have previous data
            DB::table('mrr')->insert(
                array(
                    'value' => $mrr,
                    'user'  => Auth::user()->id,
                    'date'  => $current_day
                )
            );
        }
    }

    /**
     * Building up the mrr histogram for the last 30 days
     * Stripe only!
     *
     * @return void
    */
    public function buildMRR()
    {
        // getting the events
        $events = StripeHelper::getEvents($this->stripe_key);

        $current_time = time();
        // building mrr array
        for ($i = $current_time-30*86400; $i < $current_time; $i+=86400) {
            $this->buildMRROnDay($i, $events);
        }
    }

    /**
     * Getting the MRR for a timestamp (must be within 30 days in the past)
     * Description: checks the day before and the events during the day
     *
     * @param timestamp
     * 
     * @return int or NULL if not available
     */

    private function getMRROnDay($timestamp)
    {
        $current_day = date('Y-m-d', $timestamp);

        // checking if we have data
        $current_day_mrr = DB::table('mrr')
            ->where('date', $current_day)
            ->where('user', Auth::user()->id)
            ->get();

        if ($current_day_mrr) {
            return $current_day_mrr;
        } else {
            return NULL;
        }
    }

    /**
    * Building the ARR histogram for the last 30 days,
    * from the MRR (ARR = MRR*12)
    * 
    * @return array of ints or NULLs
    */
    public function buildARR()
    {
        // return array
        $arr = array();

        $current_time = time();

        $index = 0;
        for ($i = $current_time-30*86400; $i < $current_time; $i+=86400) {
           $arr[$index] = $this->getMRROnDay($i)*12;
           $index++;
        }
        return $arr;
    }
}
