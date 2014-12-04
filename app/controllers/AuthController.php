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
            return Redirect::route('auth.addkey');
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


                return Redirect::route('auth.dashboard')->with('success', 'You have been signed in.');
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
            return Redirect::route('auth.addkey');
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
        // if we have valid key redirect
        if (strlen(Auth::user()->stripe_key) > 16) { //this is not enough
            // valid key -> redirect
            return Redirect::route('dev.stripe');
        } else {
            return View::make('auth.addkey');
        }

    }

    /*
    |=====================================================
    | <POST> | addKey: validates and updates api key
    |=====================================================
    */
    public function doAddKey()
    {
        // Validation
        $rules = array(
            'api_key' => 'required|min:16|max:64',
        );

        // run the validation rules on the inputs
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            // validation error -> sending back
            return Redirect::back()
                ->withErrors($validator) // send back errors
                ->withInput(); // sending back data
        } else {
            // validator success
            try {
                // trying to login with this key
                Stripe::setApiKey(Input::get('api_key'));
                $returned_object = Stripe_Balance::retrieve(); // catchable line
                // success
                // warning the next line is hacked!
                $balance = json_decode(strstr($returned_object, '{'), true);
                Log::info($balance);
                // updating the user

                $user = Auth::user();
                $user->stripe_key = Input::get('api_key');
                $user->balance = $balance['available'][0]['amount'];

                // saving user
                $user->save();

            } catch(Stripe_AuthenticationError $e) {
                // code was invalid
                return Redirect::back()->withErrors(
                    array('api_key' => "This key does not seem to be valid!")
                );
            } catch (Stripe_ApiConnectionError $e) {
                return Redirect::back()->withErrors(
                    array('api_key' => "Hmm... that's strange looks like Stripe is down.!")
                );

            }

            // redirect to stripe page
            return Redirect::route('dev.stripe');

        }
    }

    /*
    |===================================================
    | <GET> | showDashboard: renders the dashboard page
    |===================================================
    */
    public function showDashboard()
    {
        return View::make('auth.dashboard');  
    }
}
