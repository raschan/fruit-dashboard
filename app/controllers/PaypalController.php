<?php
use PayPal\Rest\ApiContext;

use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\OpenIdUserinfo;
use PayPal\Api\OpenIdTokeninfo;

use PayPal\Api\Plan;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Currency;


use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\ShippingAddress;
use PayPal\Api\PayerInfo;
use PayPal\Api\ChargeModel;
use PayPal\Api\FundingInstrument;


use PayPal\Api\PatchRequest;
use PayPal\Api\Patch;
use PayPal\Common\PayPalModel;


use PayPal\Api\Payment;

use PayPal\Api\Invoice;

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
            $accessToken = OpenIdTokeninfo::createFromAuthorizationCode(array('code' => $code), null, null, $this->apiContext);
        } catch (PayPalConnectionException $ex) {
            echo '<pre>';print_r(json_decode($ex->getData()));
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

    //I-9XA8BL6KSYAT
    /*
    |====================================================
    | <GET> | showCreatePlan: renders create plan page
    |====================================================
    */
    public function showCreatePlan()
    {
        // setting api context
        $api_context = PayPalHelper::getApiContext();
        
        // [I-F231FUFEPYG8, I-9XA8BL6KSYAT, I-WFTN8BULD984, I-YSRV6BDEPBLG]
        // $agreement = new Agreement();
        // $agreement->execute("EC-08Y71958XX624761D", $api_context);
        // $agreement = Agreement::get("I-F231FUFEPYG8", $api_context);
        $params = array('count' => 10, 'start_index' => 5);
        
        $output = Payment::all($params, $api_context);
        
        /*
        echo "<pre>";
        print_r(var_dump($output));
        exit(1);*/
        //echo '<pre>';print_r(var_dump($output));
        //exit(1);
        
        try {

            $params = array('count' => 10, 'start_index' => 5);
        
            //$payments = Payment::all($params, $api_context);            
            //echo '<pre>';echo var_dump($payments);
            //exit(1);
            
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo '<pre>';print_r(json_decode($ex->getData()));
            exit(1);
        }
        
        // getting the list of plans
        $plans = PayPalHelper::getPlans($api_context);

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
                $user = OpenIdUserinfo::getUserinfo($params, $api_context);
            } catch (PayPal\Exception\PPConnectionException $ex) {
                echo '<pre>';print_r(json_decode($ex->getData()));
                exit(1);
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


            try {
                $patch = new Patch();
            
                $value = new PayPalModel('{
            	       "state":"ACTIVE"
            	     }');
            
                $patch->setOp('replace')
                    ->setPath('/')
                    ->setValue($value);
                $patchRequest = new PatchRequest();
                $patchRequest->addPatch($patch);
            
                $plan->update($patchRequest, $api_context);
            
                $updated_plan = Plan::get($plan->getId(), $api_context);
            
            } catch (PayPal\Exception\PPConnectionException $ex) {
                echo '<pre>';print_r(json_decode($ex->getData()));
                exit(1);
            }
            

            $agreement = new Agreement();
            
            $agreement->setName('Base Agreement')
                ->setDescription('Basic Agreement')
                ->setStartDate('2015-01-15T15:10:04Z');
            
            // Add Plan ID
            // Please note that the plan Id should be only set in this case.
            $new_plan = new Plan();
            $new_plan->setId($updated_plan->getId());
            $agreement->setPlan($new_plan);
            
            // Add Payer
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $agreement->setPayer($payer);
            
            // Add Shipping Address
            $shippingAddress = new ShippingAddress();
            $shippingAddress->setLine1('111 First Street')
                ->setCity('Saratoga')
                ->setState('CA')
                ->setPostalCode('95070')
                ->setCountryCode('US');
                
            $agreement->setShippingAddress($shippingAddress);            

            // ### Create Agreement
            try {
                // Please note that as the agreement has not yet activated, we wont be receiving the ID just yet.
                $agreement = $agreement->create($api_context);
            
            } catch (PayPal\Exception\PPConnectionException $ex) {
                echo '<pre>';print_r(json_decode($ex->getData()));
                exit(1);
            }
            echo $agreement->getId();
            echo "<br><pre>"; echo var_dump($agreement);
            exit(1);
            

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
