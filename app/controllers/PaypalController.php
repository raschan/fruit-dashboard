<?php
use PayPal\Rest\ApiContext;

use PayPal\Exception\PPConnectionException;
use PayPal\Auth\Openid\PPOpenIdUserinfo;
use PayPal\Auth\Openid\PPOpenIdTokeninfo;

use PayPal\Api\Plan;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Currency;

class PaypalController extends BaseController
{
    /**
     * we will need the context in almost all functions
     *
     * @var apiContext
    */
    var $apiContext = null;


    /**
     * in the construct we set the context up
     *
     * @return null
    */
   function __construct() {
        // getting api context
       $this->apiContext = PayPalHelper::getApiContext();
   }


    /*
    |====================================================
    | <GET> | createRefreshTokenfromAuthToken: renders the paypal testing page
    |====================================================
    */
    public function createRefreshToken()
    {
        // checking if we have code
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
        } else {
            return "error";
            exit(1);

        }

        try {
            // Obtain Authorization Code from Code, Client ID and Client Secret
            $accessToken = PPOpenIdTokeninfo::createFromAuthorizationCode(array('code' => $code), null, null, $this->apiContext);
        } catch (PPConnectionException $ex) {
            return "error";
            exit(1);
        }

        // updating the user
        $user = Auth::user();
    
        Log::info(strlen($accessToken->getRefreshToken()));
        //saving refresh token
        $user->paypal_key = $accessToken->getRefreshToken();

        Log::info(strlen($user->paypal_key));
        // saving user
        $user->save();

        // redirect
        return Redirect::route('auth.dashboard');
   }

    
    /*
    |====================================================
    | <GET> | showCreatePlan: renders create plan page
    |====================================================
    */
    public function showCreatePlan()
    {
        // setting api context
        $api_context = PayPalHelper::getApiContext();
        
        /*
        try {
            $params = array('access_token' => PayPalHelper::generateAccessTokenFromRefreshToken(Auth::user()->paypal_key));
            $user = PPOpenIdUserinfo::getUserinfo($params, $api_context);
        } catch (Exception $ex) {
            print "no pp key";
        }*/

        // getting plans
        try {
            $params = array('page_size' => '20');
            $raw_planlist = Plan::all($params, $api_context);
        } catch (PayPal\Exception\PPConnectionException $ex) {
            echo '<pre>';print_r(json_decode($ex->getData()));
            exit(1);
        }
        
        // building up the output array
        $plans = array();
        foreach ($raw_planlist->getPlans() as $raw_plan) {
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
            array_push($plans, $plan_instance);
        }

        // returning view
        return View::make(
            'dev.paypal_create_plan',
            array('plans' => $plans)
        );
        
    }    
    /*
    |===================================================
    | <POST> | doCreatePlan: Creates a PP plan for a user
    |===================================================
    */
    public function doCreatePlan()
    {
        // Validation
        $rules = array(
            'interval' => 'required',
            'interval_count' => 'numeric',
            'name' => 'required',
            'amount' => 'required',
            'currency' => 'required'
        );

        // run the validation rules on the inputs
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            // validation error -> redirect
            return Redirect::route('paypal.createPlan')
                ->withErrors($validator) // send back errors
                ->withInput(); // sending back data
        } else {
            // valid data
            // uploading to PP
            $api_context = PayPalHelper::getApiContext();
            try {
                $params = array('access_token' => PayPalHelper::generateAccessTokenFromRefreshToken(Auth::user()->paypal_key));
                $user = PPOpenIdUserinfo::getUserinfo($params, $api_context);
            } catch (Exception $ex) {
                print "no pp key";
            }
    
            // Create a new instance of Plan object
            $plan = new Plan();
            
            // # Basic Information
            // Fill up the basic information that is required for the plan
            $plan->setName(Input::get('name'))
                ->setDescription('not yet implemented')
                ->setType('fixed'); // <-- what's this ?? 
    
            // Create a new instance of PaymentDefinition
            $paymentDefinition = new PaymentDefinition();
            
            // You should be able to see the acceptable values in the comments.
            $paymentDefinition->setName('Regular Payments')
                ->setType('REGULAR')
                ->setFrequency(Input::get('interval'))
                ->setFrequencyInterval(Input::get('interval_count'))
                ->setCycles("12")
                ->setAmount(new Currency(array('value' => Input::get('amount'), 'currency' => Input::get('currency'))));

            $merchantPreferences = new MerchantPreferences();
    
            $merchantPreferences->setReturnUrl(route('auth.dashboard'))
                ->setCancelUrl(route('auth.dashboard'))
                ->setAutoBillAmount("yes")
                ->setInitialFailAmountAction("CONTINUE")
                ->setMaxFailAttempts("5");

            // adding PaymentDefinition, MerchantPreferences to Plan
            $plan->setPaymentDefinitions(array($paymentDefinition));
            $plan->setMerchantPreferences($merchantPreferences);

            try {
                $output = $plan->create($api_context);
            } catch (PayPal\Exception\PPConnectionException $ex) {
                echo '<pre>';print_r(json_decode($ex->getData()));
                exit(1);
            }
            
            return Redirect::route('paypal.createPlan');
        }
    }    
    
    /*
    |===================================================
    | <GET> | doDeletePlan: Deletes a PP plan
    |===================================================
    */
    public function doDeletePlan($id)
    {
        // setting API context
        $api_context = PayPalHelper::getApiContext();
        
        // trying to delete the plan
        try {
            
            // getting the plan by ID
            $plan = Plan::get($id, $api_context);
            
            // delete the plan 
            $result = $plan->delete($api_context);
            
            
        } catch (PayPal\Exception\PPConnectionException $ex) {
            // catching errors
            echo '<pre>';print_r(json_decode($ex->getData()));
            exit(1);
        }
        
        // returning to createPlan
        return Redirect::route('paypal.createPlan');
    }
    
}
