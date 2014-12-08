<?php
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
        # trying to acquire Stripe
        return View::make(
            'dev.stripe',
            array(
                'balance' => Auth::user()->balance,
                'charges' => Auth::user()->getCharges(),
                'mrr' => Auth::user()->getMrr(),
                'events' => Auth::user()->getEvents(),
            )
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
