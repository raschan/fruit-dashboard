<?php
use PayPal\Auth\Openid\PPOpenIdSession;

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
            return Redirect::route('auth.connect');
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
    |===================================================
    | <GET> | showDashboard: renders the dashboard page
    |===================================================
    */
    public function showDashboard()
    {
        // getting mrr history
        $mrr_history = DB::table('mrr')
            ->where('user', Auth::user()->id)
            ->get();

        // initializing array
        $mrr_data = array();
        foreach ($mrr_history as $mrr_element) {
            array_push($mrr_data, $mrr_element->value);
        }
        Log::info($mrr_data);
        return View::make(
            'auth.dashboard',
            array(
                'mrr_history' => $mrr_data
            )
        );
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
            return Redirect::route('auth.settings')
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
                    return Redirect::route('auth.settings')
                        ->withErrors('email', 'This email is already registered.') // send back errors
                        ->withInput(); // sending back data
                }
            }


            $user->save();
            // setting data
            return Redirect::route('auth.settings')
                ->with('success', 'Edit was successful.');
        }
    }

    /*
    |===================================================
    | <GET> | showConnect: renders the connect page
    |===================================================
    */
    public function showConnect()
    {
        // getting paypal api context

        $apiContext = PayPalHelper::getApiContext();

        // building up redirect url
        $redirectUrl = PPOpenIdSession::getAuthorizationUrl(
            route('paypal.buildToken'),
            array('profile', 'email', 'phone'),
            null,
            null,
            null,
            $apiContext
        );

        return View::make('auth.connect',
            array(
                'redirect_url' => $redirectUrl
            )
        );
    }


    /*
    |===================================================
    | <POST> | doConnect: updates user service data
    |===================================================
    */
    public function doConnect()
    {
        // Validation
        $rules = array(
            'stripe' => 'min:16|max:64',
            'paypal' => 'min:16|max:64',
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
            if (Input::get('stripe')) {
                try {
                    // trying to login with this key
                    Stripe::setApiKey(Input::get('stripe'));
                    $balance = Stripe_Balance::retrieve(); // catchable line
                    // success
                    $returned_object = json_decode(strstr($balance, '{'), true);

                    // updating the user
                    $user = Auth::user();

                    $user->stripe_key = Input::get('stripe');
                    $user->balance = $returned_object['available'][0]['amount'];

                    // saving user
                    $user->save();

                } catch(Stripe_AuthenticationError $e) {
                    // code was invalid
                    return Redirect::back()->withErrors(
                        array('stripe' => "Authentication unsuccessful!")
                    );
                }
            } else if (Input::get('paypal')) {

            } else {
                return Redirect::back()->withErrors(
                    array(
                        'stripe' => "This field is required",
                    )
                );
            }

            // redirect to stripe page
            return Redirect::route('dev.stripe');

        }
    }
    /*
    |===================================================
    | <GET> | showSinglestat: renders the single stats page
    |===================================================
    */
    public function showSinglestat()
    {
        return View::make('auth.single_stat');
    }

}
