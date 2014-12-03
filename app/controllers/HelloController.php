<?php
/*
A Controller for testing stuff
*/

class HelloController extends BaseController
{
    public function showHello ()
    {
        
        return View::make('hello');
    }

    /*
    |====================================================
    | <GET> | showStripe: renders the stripe testing page
    |====================================================
    */
    public function showStripe ()
    {
        Stripe::setApiKey("sk_test_YOhLG7AgROpHWUyr62TlGXmg");
        $account_info = json_decode(Stripe_Account::retrieve(), true);
        //Log::info(Stripe_Balance::retrieve());
        Log::info(Stripe_Account::retrieve());
        # trying to acquire Stripe
        return View::make(
            'dev.stripe',
            array(
                'account_info' => $account_info,
            )
        );
    }
}
