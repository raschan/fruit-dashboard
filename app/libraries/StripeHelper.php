<?php

use Stripe\Event;
use Stripe\Stripe;
use Stripe\Customer;

class StripeHelper
{



	/**
	 * Getting all the charges for the user
	 * @param stripe key
	 *
	 * @return an array with the charges
	*/

	public static function getCharges($key)
    {
        $out_charges = array();

        // telling stripe who we are
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

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
        } //foreach

        // returning object
        return $out_charges;
    }


	/**
	 * Getting specific events for the user (null = all)
	 * @param stripe key
	 * 
	 * @return an array with the events
	*/

    public static function getEvents($user)
    {
        $out_events = array();
        // initializing variables
        $has_more = true;
        $foundLatestEvent = false;

        $latestEvent = Abf\Event::where('user', $user->id)
                        ->where('provider', 'stripe')
                        ->orderBy('created','desc')
                        ->first();
        
        $last_obj = null;

        // continue request as long as there is more AND we don't already have it
        while ($has_more && !$foundLatestEvent) {
            // trying to avoid overflow
            $previous_last_obj = $last_obj;

            // telling stripe who we are
            if (strlen($user->stripe_key) > 2)
            {
                Stripe::setApiKey($user->stripe_key);
                if ($last_obj) {

                    // we have last obj -> starting from there
                    $returned_object = Event::all(
                        array(
                            'limit'          => 20,
                            'starting_after' => $last_obj
                        )
                    );

                } else {

                    // starting from zero
                    $returned_object = Event::all(
                        array(
                            'limit' => 100
                            )
                    );
                }
            } else {
                Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
                if ($last_obj) {

                    // we have last obj -> starting from there
                    $returned_object = Event::all(
                        array(
                            'limit'          => 20,
                            'starting_after' => $last_obj
                        ),
                        array('stripe_account' => $user->stripeUserId)
                    );

                } else {

                    // starting from zero
                    $returned_object = Event::all(
                        array(
                            'limit' => 100
                            ),
                        array('stripe_account' => $user->stripeUserId)
                    );
                }
            }

            // getting the events
            // https://stripe.com/docs/api/php#events
            // pagination....

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

                if (isset($event['data']['object'])) {
                    if ($latestEvent) {
                        if ($event['id'] == $latestEvent->eventID)
                        {
                            $foundLatestEvent = true;
                        }
                    }
                    $out_events[$event['id']] =
                        array(
                            'created'   => $event['created'],
                            'type'      => $event['type'],
                            'data'      => $event['data'],
                            'provider'  => 'stripe'
                        );
                    $last_obj = $event['id'];
                }
            }// foreach
            // updating has_more
            $has_more = $events['has_more'];
            // avoiding infinite loop
            if (($previous_last_obj == $last_obj) and $has_more) {
                // we should never get here
                // this is too bad system failure :(
                $has_more = false;
            }
        } // while

        // returning object
        return $out_events;
    }


	/**
	 * Getting all the plans for the user
	 * @param stripe key
	 *
	 * @return an array with the plans
	*/

    public static function getPlans($key)
    {
        $out_plans = array();

        // telling stripe who we are
        Stripe::setApiKey($key);

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
                    'interval_count' => $plan['interval_count'],
                    'provider'       => 'stripe'
                );
        } //foreach

        // returning object
        return $out_plans;
    }

    /**
     * Getting all the customers for the user
     * @param stripe key
     *
     * @return an array with the customers
    */

    public static function getCustomers($user)
    {
        // init out array
        $out_customers = array();

        // setting stripe key
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        // getting the customers
        $returned_object = Customer::all(array(('stripe_account' => $user->stripeUserId));

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
                    'subscriptions' => $customer['subscriptions']['data']
                );
        } //foreach

        // return with the customers
        return $out_customers;
    }
}
