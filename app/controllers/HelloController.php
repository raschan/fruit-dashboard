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
        # trying to acquire Stripe
        return View::make(
            'dev.stripe',
            array(
                'balance' => Auth::user()->balance,
                'charges' => Auth::user()->getCharges(),
                'plans' => Auth::user()->getMRR()
            )
        );
    }
}
