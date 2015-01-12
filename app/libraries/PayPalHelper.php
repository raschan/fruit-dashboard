<?php
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Auth\Openid\PPOpenIdTokeninfo;

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
            $token_info = new PPOpenIdTokeninfo();
            $token_info = $token_info->createFromRefreshToken(array('refresh_token' => $refresh_token), $api_context);
            
        } catch (Exception $ex) {
            Log::info($ex);
            // something went wrong
            // redirect to 500
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

    public static function getPlans($key)
    {
        $out_plans = array();

        // tell paypal who we are
        // get the plans from paypal
        // build return array

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
