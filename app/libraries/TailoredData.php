<?php


class TailoredData
{
    /**
    * Unify customer objects from PayPal and Stripe
    *
    * @return array of all customers
    */
    public static function getCustomers($user)
    {
        // return array
        $allCustomers = array();

        $stripeCustomers = array();
        $paypalCustomers = array();

        // get customers from Stripe if connected
        if ($user->isStripeConnected())
        {
            $stripeCustomers = StripeHelper::getCustomers($user);
        }

        // get customers from Paypal if connected
        if ($user->isPayPalConnected())
        {
            // getting api context
            $apiContext = PayPalHelper::getApiContext();

            $paypalCustomers = PayPalHelper::getCustomers($apiContext);

            // TODO
            // tailor it to look like Stripe data
        }

        // merge the 2 arrays
        $allCustomers = array_merge($stripeCustomers, $paypalCustomers);

        return $allCustomers;
    }


    /**
    * Unify plan objects from PayPal and Stripe
    *
    * @return array of plans
    */

    public static function getPlans($user)
    {
        // return array
        $allPlans = array();

        $stripePlans = array();
        $paypalPlans = array();

        // get plans from Stripe if connected
        if ($user->isStripeConnected())
        {
            $stripePlans = StripeHelper::getPlans($user->stripe_key);
        }

        // get plans from Paypal if connected
        if ($user->isPayPalConnected())
        {
            // getting api context
            $apiContext = PayPalHelper::getApiContext();

            $paypalPlans = PayPalHelper::getPlans($apiContext);
        }

        // merge the 2 arrays
        $allPlans = array_merge($stripePlans, $paypalPlans);

        return $allPlans;
    }

    /**
    * Unify charges from PayPal and Stripe
    *
    * @return array of all customers
    */

    public static function getEvents($user){
        // return array
        $allEvents = array();
        $stripeEvents = array();
        $paypalEvents = array();

        // get charges from Stripe if connected
        if ($user->isStripeConnected())
        {
            $stripeEvents = StripeHelper::getEvents($user);
        }


        // get plans from Paypal if connected
        if ($user->isPayPalConnected())
        {
            // getting api context
            $apiContext = PayPalHelper::getApiContext();

            $paypalPlans = PayPalHelper::getEvents($apiContext);
        }

        // merge the 2 arrays
        $allEvents = array_merge($stripeEvents, $paypalEvents);

        return $allEvents;
    }
}
