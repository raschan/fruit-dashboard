<?php
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\OpenIdTokeninfo;

use PayPal\Api\Plan;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Currency;


class PayPalHelper {

    /**
     * Getting the API context for the application
     * change the clientID and clientSecret accordingly
     *
     * @return boolean
    */
    public static function getApiContext() {
        // setting api codes
        $client_id = "AY1PlRC0yK6SExlx8aRDW-hF2REkl90Qmza0Ak5LUacd-LFAczGmXfanQYK-";
        $client_secret = "EBXUZxD6PobEUtc-WldtZgbG8eUzl4IkOFAeMxpAGhNDt-mESoj3a3QRRIGw";


        // getting the ApiContext from oauth
        $api_context = new ApiContext(
            new OAuthTokenCredential(
                $client_id,
                $client_secret
            )
        );

        // setting api context
        $api_context->setConfig(
            array(
                'mode'                   => 'sandbox',
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled'         => true,
                'log.FileName'           => '../PayPal.log',
                'log.LogLevel'           => 'FINE',
                'validation.level'       => 'log',
                'cache.enabled'          => 'true'
            )
        );

        // returning api context
        return $api_context;
    }

    /**
     * Generating an access token for the user
     * from the previously stored refresh token
     * false on no token
     *
     * @return String/boolean
    */
    public static function generateAccessTokenFromRefreshToken($refresh_token)
    {
        $api_context = PayPalHelper::getApiContext();
        
        try {
            // getting token info
            $token_info = new OpenIdTokeninfo();
            $token_info = $token_info->createFromRefreshToken(array('refresh_token' => $refresh_token), $api_context);
            
        } catch (Exception $ex) {
            // something went wrong
            echo '<pre>';print_r(json_decode($ex->getData()));
            exit(1);
        }

        // everything's fine, returning accessToken
        return $token_info->getAccessToken();
    }

    /**
     * Getting all the charges for the user
     * @param paypal key
     * 
     * @return an array with the charges
    */

    public static function getCharges($key)
    {
        $out_charges = array();
        
        // tell paypal who we are
        // get the charges from paypal
        // build return array
        
        // return the object
        return $out_charges;
    }

    /**
     * Getting specific events for the user
     * @param paypal key
     *
     * @return an array with the charges
    */

    public static function getEvents($key)
    {
        $out_events = array();
        
        // tell paypal who we are
        // get the events from paypal
        // build return array

        // return the object
        return $out_events;
    }

    /**
     * Getting all the plans for the user
     * @param paypal key
     *
     * @return an array with the plans
    */

    public static function getPlans($api_context)
    {
        // initializing output array
        $out_plans = array();

        try {
            // getting the list of plans
            $params = array('page_size' => '20', 'status' => 'ACTIVE'); // needs paging !!!!
            $planlist = Plan::all($params, $api_context);

        } catch (PayPal\Exception\PPConnectionException $ex) {
            
            // error handling
            echo '<pre>';print_r(json_decode($ex->getData()));
            exit(1);
            
        }
        
        // building up the output array
        foreach ($planlist->getPlans() as $raw_plan) {
            // getting the plan 
            $plan = Plan::get($raw_plan->getId(), $api_context);
            
            // decoding data
            $json_plan = json_decode($plan->toJSON(), true);
            
            // initializing array to add
            $plan_instance = array();
            
            // extracting data
            $plan_instance['id'] = $json_plan['id'];
            $plan_instance['name'] = $json_plan['name'];
            $plan_instance['interval'] = $json_plan['payment_definitions'][0]['frequency'];
            $plan_instance['interval_count'] = $json_plan['payment_definitions'][0]['frequency_interval'];
            $plan_instance['currency'] = $json_plan['payment_definitions'][0]['amount']['currency'];
            $plan_instance['amount'] = $json_plan['payment_definitions'][0]['amount']['value'];

            // adding to array
            array_push($out_plans, $plan_instance);
        }

        // returning object
        return $out_plans;
    }

     /**
     * Getting all the customers for the user
     * @param stripe key
     *
     * @return an array with the subscriptions
    */
    
    public static function getCustomers($key)
    {
        $out_customers = array();

        // tell paypal who we are
        // get the customers from paypal
        // build return array

        // returning object
        return $out_customers;
    }
}
