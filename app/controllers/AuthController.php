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
        // if we have valid key redirect
        if (strlen(Auth::user()->stripe_key) > 16) {
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
                $balance = Stripe_Balance::retrieve(); // catchable line
                // success
                $returned_object = json_decode(strstr($balance, '{'), true);

                // updating the user
                $user = Auth::user();

                $user->stripe_key = Input::get('api_key');
                $user->balance = $returned_object['available'][0]['amount'];

                // saving user
                $user->save();

            } catch(Stripe_AuthenticationError $e) {
                // code was invalid
                return Redirect::back()->withErrors(
                    array('api_key' => "Authentication unsuccessful!")
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

    /*
    |===================================================
    | <GET> | showSettings: renders the settings page
    |===================================================
    */
    public function showSettings()
    {
        return View::make('auth.settings');  
    }


    /*
    |===================================================
    | <POST> | doSettings: updates user data
    |===================================================
    */
    public function doSettings()
    {
        Log::info(Input::all());
        // Validation rules
        $rules = array(
            'email' => 'email'
        );
        // run the validation rules on the inputs
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            // validation error -> redirect
            return Redirect::route('site.settings')
                ->withErrors($validator) // send back errors
                ->withInput(); // sending back data
        } else {
            // Log::info($validator);
            // validator success -> edit_profile
            // selecting logged in user
            $user = Auth::user();
            // checking actions and updating data
            // checking if submitted email has registered user
            $user_to_check = User::where('email', '=', Input::get('email'))->get()->first();
            // if email is not registered
            if (is_null($user_to_check)) {
                // we have valid email
                $user->email = Input::get('email');
            } else {
                // if email is registered and changed
                if ($user->email != Input::get('email')) {
                    return Redirect::route('site.settings')
                        ->withErrors('email', 'This email is already registered.') // send back errors
                        ->withInput(); // sending back data
                }
            }

    
            $user->save();
            // setting data
            return Redirect::route('site.settings')
                ->with('success', 'Edit was successful.');
        }
    }
}
