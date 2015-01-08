<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface
{
    use UserTrait;

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
     * Testing if the user has connected at least one account
     *
     * @return boolean
    */
    public function isConnected()
    {
        if ($this->isStripeConnected() ||
            $this->isPayPalConnected()) {
            // connected
            return True;
        }
        // not connected
        return False;
    }

    /**
     * Getting all the charges for the user
     *
     * @return an array with the charges
    */
    public function getCharges()
    {
        $out_charges = array();


        // paypal/stripe decision

        if ($this->stripe_key) {

            // stripe

            // telling stripe who we are
            Stripe::setApiKey($this->stripe_key);

            // getting the charges
            // https://stripe.com/docs/api/php#charges
            $returned_object = Stripe_Charge::all();

            // extractin json (this is not the best approach)
            $charges = json_decode(strstr($returned_object, '{'), true);

            // getting relevant fields
            foreach ($charges['data'] as $charge) {
                // updating array

                /*
                id                      - string
                created                 - timestamp
                amount                  - non negative integer
                currency                - string, 3 letter ISO currency code
                paid                    - boolean
                captured                - boolean
                description             - string
                statement_description   - string
                failure_code            - string (see https://stripe.com/docs/api#errors for a list of codes)
                */

                $out_charges[$charge['id']] =
                    array(
                        'created'               => $charge['created'],
                        'amount'                => $charge['amount'],
                        'currency'              => $charge['currency'],
                        'paid'                  => $charge['paid'],
                        'captured'              => $charge['captured'],
                        'description'           => $charge['description'],
                        'statement_description' => $charge['statement_description'],
                        'failure_code'          => $charge['failure_code']
                    );
            }
        } else {
            // paypal
        }
        // returning object
        return $out_charges;
    }

    /**
     * Getting specific events for the user (null = all)
     *
     * @return an array with the charges
    */
    public function getEvents()
    {
        $out_evnets = array();

        // paypal/stripe decision

        if ($this->stripe_key) {

            // stripe

            // initializing variables
            $has_more = true;
            $last_obj = null;
            $count = 0;

            while ($has_more) {
                // trying to avoid overflow
                $previous_last_obj = $last_obj;

                // telling stripe who we are
                Stripe::setApiKey($this->stripe_key);

                // getting the events
                // https://stripe.com/docs/api/php#events
                // pagination....
                if ($last_obj) {
                    // we have last obj -> starting from there
                    $returned_object = Stripe_Event::all(
                        array(
                            'limit'          => 100,
                            'starting_after' => $last_obj
                        )
                    );
                } else {
                    // starting from zero
                    $returned_object = Stripe_Event::all(
                        array(
                            'limit' => 100
                            )
                    );
                }

                // extractin json (this is not the best approach)
                $events = json_decode(strstr($returned_object, '{'), true);

                // getting relevant fields
                foreach ($events['data'] as $event) {

                    // updating array

                    /*
                    created     - timestamp
                    type        - string, see https://stripe.com/docs/api/php#event_types
                    object      - hash map (assoc array)
                    */
                    
                    if (isset($event['data']['object']['id'])) {
                        $out_events[$event['id']] =
                            array(
                                'created'  => $event['created'],
                                'type'     => $event['type'],
                                'object' => $event['data']['object']
                            );
                        $last_obj = $event['id'];
                    }
                }// foreach
                // updating has_more
                $has_more = $events['has_more'];
                $count += 1;
                // avoiding infinite loop
                if ((($previous_last_obj == $last_obj) and $has_more) or $count > 100) {
                    // we should never get here
                    // this is too bad system failure :(
                    $has_more = false;
                }
            } // while
        } else {
            // paypal
        }
        // returning object
        return $out_events;
    }
    /**
     * Getting all the plans for the user
     *
     * @return an array with the plans
    */
    public function getPlans()
    {
        $out_plans = array();
        // paypal/stripe decision

        if ($this->stripe_key) {

            // stripe

            // telling stripe who we are
            Stripe::setApiKey($this->stripe_key);

            // getting the charges
            $returned_object = Stripe_Plan::all();

            // extractin json (this is not the best approach)
            $plans = json_decode(strstr($returned_object, '{'), true);

            // getting relevant fields
            foreach ($plans['data'] as $plan) {
                // updating array

                /*
                interval        - string, one of 'day', 'week', 'month' or 'year'. 
                                    The frequency with which a subscription should be billed.
                name            - name of the plan
                interval_count  - pos int, with the property 'interval' specifies how frequent is the billing,
                                    ex: interval = 'month', interval_count = 3 => billing every 3 month
                amount          - pos int, the price of plan, in cents
                currency        - currency in which the plan is charged (e.g "usd")
                created         - timestamp
                name            - name of plan
                */

                $out_plans[$plan['id']] =
                    array(
                        'interval'       => $plan['interval'],
                        'name'           => $plan['name'],
                        'created'        => $plan['created'],
                        'amount'         => $plan['amount'],
                        'currency'       => $plan['currency'],
                        'interval_count' => $plan['interval_count']
                    );
            }
        } else {
            // paypal
        }
        // returning object
        return $out_plans;
    }

    /**
     * Getting all the customers for the user
     *
     * @return an array with the subscriptions
    */
    public function getCustomers()
    {
        // init out array
        $out_customers = array();

        if ($this->stripe_key) {

            // stripe

            // setting stripe key
            Stripe::setApiKey($this->stripe_key);

            // getting the customers
            $returned_object = Stripe_Customer::all();

            // extracting data
            $customers = json_decode(strstr($returned_object, '{'), true);

            // setting the data to our own format
            foreach ($customers['data'] as $customer) {
                // updating array

                /*
                livemode        - valid customer
                subscriptions   - all the subscription a user has
                */

                $out_customers[$customer['id']] =
                    array(
                        'zombie'        => $customer['livemode'],
                        'email'         => $customer['email'],
                        'subscriptions' => $customer['subscriptions']
                    );
            }
        } else {
            // paypal
        }

        // return with the customers
        return $out_customers;
    }

    /**
     * Getting all the subscriptions. PROBLEM WITH HISTORY!
     *
     * @return an array with the subscriptions
    */
    public function getCurrentSubscriptions()
    {
        // intializing out array
        $active_subscriptions = array();

        // getting the customers
        $customers = $this->getCustomers();

        if ($this->stripe_key) {

            // stripe

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

        }
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
        $plans = $this->getPlans();

        // getting current subscriptions
        $current_subscriptions = $this->getCurrentSubscriptions();

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
     * Getting the MRR for a timestamp (must be within 30 days in the past)
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
     * @return a bigint with the MRR in it
    */
    public function buildMRR()
    {
        // getting the events
        $events = $this->getEvents();

        $current_time = time();
        // building mrr array
        for ($i = $current_time-30*86400; $i < $current_time; $i+=86400) {
            $this->buildMRROnDay($i, $events);
        }


    }
}
