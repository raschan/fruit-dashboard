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
        //TEMPORARY SOLUTION!!!!
        Counter::saveMRR(Auth::user());

        setlocale(LC_MONETARY,"en_US");

        return View::make(
            'dev.stripe'
        );
    }

    /*
    |====================================================
    | <GET> | showGYT: imports xls to database
    |====================================================
    */
    public function showGYT()
    {
        return View::make('dev.gyt');
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
    |====================================================
    | <GET> | showRashan: renders the testing page
    |====================================================
    */
    public function showRashan()
    {
        Counter::saveCancellations(Auth::user());

        $timeItStarts = time();
        $savedObjects = Counter::saveEvents(Auth::user());
        $timeItFinishes = time();

        return View::make('dev.rashan',array(
                'name' => 'Rashan',
                'count' => $savedObjects,
                'timeItTakes' => $timeItFinishes - $timeItStarts
            )
        );
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
