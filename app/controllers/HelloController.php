<?php
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Auth\Openid\PPOpenIdSession;
use PayPal\Rest\ApiContext;

use PayPal\Auth\Openid\PPOpenIdTokeninfo;
use PayPal\Exception\PPConnectionException;
use PayPal\Auth\Openid\PPOpenIdUserinfo;
use PayPal\Api\Plan;

use PayPal\Api\PaymentDefinition;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Currency;
use PayPal\Api\ChargeModel;

use StripeHelper;
/*
A Controller for testing stuff
*/

class HelloController extends BaseController
{
    public function showHello()
    {
        
    }

    /*
    |====================================================
    | <GET> | showStripe: renders the stripe testing page
    |====================================================
    */
    public function showStripe()
    {
        Auth::user()->buildMrr();
        // trying to acquire Stripe
        return View::make(
            'dev.stripe',
            array(
                //'balance' => Auth::user()->balance,
                'charges' => StripeHelper::getCharges(Auth::user()->stripe_key),
                'mrr' => Auth::user()->getMrr(),
                //'events' => Auth::user()->getEvents(),
            )
        );
    }

    /*
    |====================================================
    | <GET> | showPaypal: renders the paypal testing page
    |====================================================
    */
    public function showPaypal()
    {
        $api_context = PayPalHelper::getApiContext();
        try {
            $params = array('access_token' => PayPalHelper::generateAccessTokenFromRefreshToken(Auth::user()->paypal_key));
            $user = PPOpenIdUserinfo::getUserinfo($params, $api_context);
        } catch (Exception $ex) {
            print "no pp key";
        }

        /*
        // Create a new instance of Plan object
        $plan = new Plan();
        
        // # Basic Information
        // Fill up the basic information that is required for the plan
        $plan->setName('H13 water service')
            ->setDescription('Providing fresh cold water every day.')
            ->setType('fixed');
        
        // # Payment definitions for this billing plan.
        $paymentDefinition = new PaymentDefinition();
        
        // The possible values for such setters are mentioned in the setter method documentation.
        // Just open the class file. e.g. lib/PayPal/Api/PaymentDefinition.php and look for setFrequency method.
        // You should be able to see the acceptable values in the comments.
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval("1")
            ->setCycles("12")
            ->setAmount(new Currency(array('value' => 1290, 'currency' => 'USD')));
        /*
        // Charge Models    
        $chargeModel = new ChargeModel();
        $chargeModel->setType('SHIPPING')
            ->setAmount(new Currency(array('value' => 50, 'currency' => 'USD')));
        
        $paymentDefinition->setChargeModels(array($chargeModel));
        $merchantPreferences = new MerchantPreferences();

        $merchantPreferences->setReturnUrl(route('auth.dashboard'))
            ->setCancelUrl(route('auth.dashboard'))
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'USD')));
        
        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        // For Sample Purposes Only.
        $request = clone $plan;
        
        // ### Create Plan
        try {
            $output = $plan->create($api_context);
        } catch (Exception $ex) {
            Log::info($ex);
            exit(1);
        }

        try {
            $params = array('page_size' => '2');
            $planList = Plan::all($params, $api_context);
        } catch (Exception $ex) {
            Log::info($ex);
            exit(1);
        }
        */
        // Create a new instance of Plan object
        $plan = new Plan();
        
        // # Basic Information
        // Fill up the basic information that is required for the plan
        $plan->setName('T-Shirt of the Month Club Plan')
            ->setDescription('Template creation.')
            ->setType('fixed');
        
        // # Payment definitions for this billing plan.
        $paymentDefinition = new PaymentDefinition();
        
        // The possible values for such setters are mentioned in the setter method documentation.
        // Just open the class file. e.g. lib/PayPal/Api/PaymentDefinition.php and look for setFrequency method.
        // You should be able to see the acceptable values in the comments.
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval("2")
            ->setCycles("12")
            ->setAmount(new Currency(array('value' => 100, 'currency' => 'USD')));
        
        // Charge Models
        $chargeModel = new ChargeModel();
        $chargeModel->setType('SHIPPING')
            ->setAmount(new Currency(array('value' => 10, 'currency' => 'USD')));
        
        $paymentDefinition->setChargeModels(array($chargeModel));
        
        $merchantPreferences = new MerchantPreferences();
        // ReturnURL and CancelURL are not required and used when creating billing agreement with payment_method as "credit_card".
        // However, it is generally a good idea to set these values, in case you plan to create billing agreements which accepts "paypal" as payment_method.
        // This will keep your plan compatible with both the possible scenarios on how it is being used in agreement.
        $merchantPreferences->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'USD')));
        
        
        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);
        
        // For Sample Purposes Only.
        $request = clone $plan;
        
        // ### Create Plan
        try {
            $output = $plan->create($api_context);
        } catch (Exception $ex) {
            Log::info($ex);
            exit(1);
        }
        
        //Log::info($ex);
        
        return View::make(
            'dev.paypal',
            array('plans' => $output)
        );
        
    }


    /*
    |====================================================
    | <GET> | showStripe: renders the stripe testing page
    |====================================================
    */
    public function doStripe()
    {

        //check if its our form
        if (Session::token() !== Input::get('_token')) {
            return Response::json(array(
                'msg' => 'Unauthorized attempt to create setting'
            ));
        }
        $charges = Auth::user()->getCharges();

        return Response::json($charges);
    }
    /*
    |========================================================
    | <AJAX/POST> | ajaxGetMrr: gets the logged in user's mrr
    |========================================================
    */
    public function ajaxGetMrr()
    {
        $mrr = Auth::user()->getMRR();
        Log::info("ready");
        return "test";
    }

}
