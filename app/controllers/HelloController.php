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
        //$account_info = json_decode(Stripe_Account::retrieve(), true);
        //Log::info(Stripe_Balance::retrieve());
        //Log::info(Stripe_Account::retrieve());
        Stripe::setApiKey(Auth::user()->stripe_key);

        Log::info(Stripe_Charge::all());

        # trying to acquire Stripe
        return View::make(
            'dev.stripe',
            array('balance' => Auth::user()->balance)
        );
    }
}
