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
        # trying to acquire Stripe
        return View::make(
            'dev.stripe',
            array(
                'balance' => Auth::user()->balance,
                'charges' => Auth::user()->getCharges()
            )
        );
    }
}
