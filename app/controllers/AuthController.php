<?php

/*
|--------------------------------------------------------------------------
| AuthController: Handles the authentication related sites
|--------------------------------------------------------------------------
*/
class AuthController extends BaseController
{

    /*
    |===================================================
    | <GET> | showSignin: renders the signin page
    |===================================================
    */
    public function showSignin()
    {
        if (Auth::check()) {
            return Redirect::route('hello');
        } else {
            return View::make('auth.signin');
        }
    }

    /*
    |===================================================
    | <POST> | doSignin: signs in the user
    |===================================================
    */
    public function doSignin()
    {
        // Validation
        $rules = array(
            'email'    => 'required|email',
            'password' => 'required'
        );

        // run the validation rules on the inputs
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            // validation error -> redirect
            return Redirect::route('auth.signin')
                ->withErrors($validator) // send back errors
                ->withInput(Input::except('password')); // sending back data
        } else {
            // validator success -> signin
            $credentials = Input::only('email', 'password');

            // attempt to do the login
            if (Auth::attempt($credentials)) {
                // auth successful!
                // check for homecoming action

                // please note: the user will never see this action
                // since it will be triggered automatically right after login


                return Redirect::route('auth.addkey')->with('success', 'You have been signed in.');
            } else {
                // auth unsuccessful -> redirect to login
                return Redirect::route('auth.signin')
                    ->withInput(Input::except('password'))
                    ->with('error', 'Signin failed.');
            }
        }
    }

    /*
    |===================================================
    | <GET> | showSignup: renders the signup page
    |===================================================
    */
    public function showSignup()
    {
        if (Auth::check()) {
            return Redirect::route('hello');
        } else {
            return View::make('auth.signup');
        }
    }

    /*
    |===================================================
    | <POST> | doSignin: signs up the user
    |===================================================
    */
    public function doSignup()
    {
        // Validation rules
        $rules = array(
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
        );

        // run the validation rules on the inputs
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            // validation error -> redirect
            return Redirect::route('auth.signup')
                ->withErrors($validator) // send back errors
                ->withInput(); // sending back data
        } else {
            // validator success -> signup

            // create user
            $user = new User;
            // set auth info
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->save();
            // signing the user in and redirect to dashboard
            Auth::login($user);
            return Redirect::route('auth.signup')->with('success', 'Signup was successful.');
        }
    }

    /*
    |===================================================
    | <ANY> | doSignout: signs out the user
    |===================================================
    */
    public function doSignout()
    {
        Auth::logout();
        return Redirect::route('auth.signin');
    }

    /*
    |=====================================================
    | <GET> | addKey: renders the signup page or redirects
    |=====================================================
    */
    public function showAddKey()
    {
        // checking if we have key
        Auth::user()->stripe_key;
        //return Redirect::route('dev.stripe');
        return View::make('auth.addkey');

    }

}
