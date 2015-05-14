<?php
use PayPal\Api\OpenIdSession;
use PayPal\Rest\ApiContext;

use PayPal\Api\OpenIdTokeninfo;
use PayPal\Exception\ConnectionException;
use PayPal\Api\OpenIdUserinfo;
use PayPal\Api\Plan;

use PayPal\Api\PaymentDefinition;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Currency;
use PayPal\Api\ChargeModel;


/*
A Controller for testing stuff
*/

class DevController extends BaseController
{
    public function show()
    {
        $transaction = Braintree_Transaction::find('k2f3hj');

        var_dump($transaction->billing['firstName']);
        exit();
    }
    /*
    |====================================================
    | <GET> | showUsers: showing the current users
    |====================================================
    */
    public function showUsers()
    {
        // returning the current users
        return View::make(
            'dev.users',
            array(
                'users' => User::all()
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
            $user = OpenIdUserinfo::getUserinfo($params, $api_context);
        } catch (Exception $ex) {
            print "no pp key";
        }
        /*
        // Create a new instance of Plan object
        $plan = new Plan();

        // # Basic Information
        // Fill up the basic information that is required for the plan
        $plan->setName('Welltakeyourmoney')
            ->setDescription('If you register we can take all your money.')
            ->setType('fixed');

        $paymentDefinition = new PaymentDefinition();

        // The possible values for such setters are mentioned in the setter method documentation.
        // Just open the class file. e.g. lib/PayPal/Api/PaymentDefinition.php and look for setFrequency method.
        // You should be able to see the acceptable values in the comments.
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval("5")
            ->setCycles("12")
            ->setAmount(new Currency(array('value' => 999, 'currency' => 'USD')));
        // ### Create Plan
        $merchantPreferences = new MerchantPreferences();

        $merchantPreferences->setReturnUrl(route('auth.dashboard'))
            ->setCancelUrl(route('auth.dashboard'))
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => 9999, 'currency' => 'USD')));

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        $request = clone $plan;

        try {
            $output = $plan->create($api_context);
        } catch (PayPal\Exception\PPConnectionException $ex) {
            echo '<pre>';print_r(json_decode($ex->getData()));
            exit(1);
        }
        */

        try {
            $params = array('page_size' => '20');
            $planList = Plan::all($params, $api_context);
        } catch (PayPal\Exception\ConnectionException $ex) {
            echo '<pre>';print_r(json_decode($ex->getData()));
            exit(1);
        }
        Log::info($planList);

        try {
            $plan = Plan::get("P-0TA38541GG196850X3XYQ2KI", $api_context);
        } catch (PayPal\Exception\ConnectionException $ex) {
            echo '<pre>';print_r(json_decode($ex->getData()));
            exit(1);
        }

        return View::make(
            'dev.paypal',
            array('output' => $plan)
        );

    }

    

    public function showBraintree()
    {

        /* 
        notification samples
        Braintree_WebhookNotification::SUBSCRIPTION_CANCELED
        Braintree_WebhookNotification::SUBSCRIPTION_CHARGED_SUCCESSFULLY
        Braintree_WebhookNotification::SUBSCRIPTION_CHARGED_UNSUCCESSFULLY
        Braintree_WebhookNotification::SUBSCRIPTION_EXPIRED
        Braintree_WebhookNotification::SUBSCRIPTION_TRIAL_ENDED
        Braintree_WebhookNotification::SUBSCRIPTION_WENT_ACTIVE
        Braintree_WebhookNotification::SUBSCRIPTION_WENT_PAST_DUE
        Braintree_WebhookNotification::SUB_MERCHANT_ACCOUNT_APPROVED
        Braintree_WebhookNotification::SUB_MERCHANT_ACCOUNT_DECLINED
        Braintree_WebhookNotification::TRANSACTION_DISBURSED
        Braintree_WebhookNotification::DISPUTE_OPENED
        Braintree_WebhookNotification::DISPUTE_LOST
        Braintree_WebhookNotification::DISPUTE_WON
        */

        $sampleNotification = Braintree_WebhookTesting::sampleNotification(
            Braintree_WebhookNotification::TRANSACTION_DISBURSED,
            'my_id'
        );

        $webhookNotification = Braintree_WebhookNotification::parse(
            $sampleNotification['bt_signature'],
            $sampleNotification['bt_payload']
        );

        var_dump($webhookNotification->kind);
        var_dump($webhookNotification->subject);
        foreach ($webhookNotification->subject as $key => $value) 
        {
            var_dump($webhookNotification->$key);
        }
        exit();
    }

    public function doBraintreePayment()
    {
        if(Input::get('payment_method_nonce'))
        {
            $result = Braintree_Transaction::sale(array(
                'amount' => '10.00',
                'paymentMethodNonce' => Input::get('payment_method_nonce'))
            );

            return View::make('dev.braintree',array(
                'result' => $result
            ));
        }
    }
}
