<?php
/*
A Controller for testing stuff
*/

class HelloController extends BaseController
{
    public function showHello ()
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
    public function showStripe ()
    {
        // this means we have valid balance
        Log::info(json_decode(strstr($balance,'{'), true));
        //$account_info = json_decode(Stripe_Account::retrieve(), true);
        //Log::info(Stripe_Balance::retrieve());
        //Log::info(Stripe_Account::retrieve());
        # trying to acquire Stripe
        return View::make('dev.stripe');
    }
}
