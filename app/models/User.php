<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface
{
    use UserTrait;

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
            $returned_object = Stripe_Charge::all();

            // extractin json (this is not the best approach)
            $charges = json_decode(strstr($returned_object, '{'), true);

            // getting relevant fields
            foreach ($charges['data'] as $charge) {
                // updating array
                $out_charges[$charge['id']] =
                    array(
                        'created' => $charge['created'],
                        'amount' => $charge['amount'],
                        'currency' => $charge['currency'],
                        'paid' => $charge['paid'],
                        'captured' => $charge['captured'],
                        'description' => $charge['description'],
                        'statement_description' => $charge['statement_description'],
                        'failure_code' => $charge['failure_code']
                    );
            }
        } else {
            // paypal
        }
        // returning object
        return $out_charges;
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
                $out_plans[$plan['id']] =
                    array(
                        'interval' => $plan['interval'],
                        'name' => $plan['name'],
                        'created' => $plan['created'],
                        'amount' => $plan['amount'],
                        'currency' => $plan['currency'],
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
                $out_customers[$customer['id']] =
                    array(
                        'zombie' => $customer['livemode'],
                        'email' => $customer['email'],
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

            // getting the active subsciprionts for a customer
            foreach ($customers as $customer) {
                // going through each subscription if any
                if ($customer['subscriptions']['total_count'] > 0) {
                    // there are some subs
                    foreach ($customer['subscriptions']['data'] as
                             $subscription) {
                        // updating array
                        $active_subscriptions[$subscription['id']] =
                            array(
                                'plan_id' => $subscription['plan']['id'],
                                'start' => $subscription['start'],
                                'status' => $subscription['status'],
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
            $plan_subscriptions[$subscription['plan_id']] += 1;

            $mrr += $plans[$subscription['plan_id']]['amount'];

        }

        // returning object
        return $mrr;
    }
}
