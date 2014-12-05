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
                array_push(
                    $out_charges,
                    array(
                        'id' => $charge['id'],
                        'created' => $charge['created'],
                        'amount' => $charge['amount'],
                        'currency' => $charge['currency'],
                        'paid' => $charge['paid'],
                        'captured' => $charge['captured'],
                        'description' => $charge['description'],
                        'statement_description' => $charge['statement_description'],
                        'failure_code' => $charge['failure_code']
                    )
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
                array_push(
                    $out_plans,
                    array(
                        'interval' => $plan['interval'],
                        'name' => $plan['name'],
                        'created' => $plan['created'],
                        'amount' => $plan['amount'],
                        'currency' => $plan['currency'],
                        'interval_count' => $plan['interval_count']
                    )
                );
            }
        } else {
            // paypal
        }
        // returning object
        return $out_plans;
    }

    /**
     * Getting the MRR based on the plans
     *
     * @return a bigint with the MRR in it
    */
    public function getMRR()
    {
        $mrr = 54327890534;
        // getting the plans
        $plans = $this->getPlans();

        // going through them
        foreach ($plans as $plan) {
            // getting subscriptions

        }
        // returning object
        return $mrr;
    }
}
