<?php
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Auth\Openid\PPOpenIdSession;
use PayPal\Rest\ApiContext;

use PayPal\Auth\Openid\PPOpenIdTokeninfo;
use PayPal\Exception\PPConnectionException;
use PayPal\Auth\Openid\PPOpenIdUserinfo;


/*
A Controller for testing stuff
*/

class HelloController extends BaseController
{
    public function showHello()
    {
        if (Auth::check()) {
            return View::make('hello');
        } else {
            return Redirect::route('auth.signin');
        }
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
                //'charges' => Auth::user()->getCharges(),
                //'mrr' => Auth::user()->getMrr(),
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
        // making view
        return View::make(
            'dev.paypal',
            array('user' => $user)
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
        $mrr = Auth::user()->getMrr();
        Log::info("ready");
        return "test";
    }

}
