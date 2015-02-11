<?php
use PayPal\Api\OpenIdSession;

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
            return Redirect::route('auth.dashboard');
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

                // check if already connected
                if (Auth::user()->isConnected()) {
                    return Redirect::route('auth.dashboard')->with('success', 'You have been signed in.');
                } else {
                    return Redirect::route('auth.connect')->with('success', 'You have been signed in.');
                }
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
        return Redirect::route('auth.signin')->with('success', 'Sign out was successful.');
    }

    /*
    |===================================================
    | <GET> | showDashboard: renders the dashboard page
    |===================================================
    */
    public function showDashboard()
    {
        return View::make(
            'auth.dashboard',
            array(
                'allFunctions' => array(
                    MrrStat::showMRR(false),
                    AUStat::showAU(false),
                    ArrStat::showARR(false),
                    ArpuStat::showARPU(false)
                ),
                'events' => Counter::formatEvents()
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
        // checking connections for the logged in user
        $user = Auth::user();

        return View::make(
            'auth.settings',
            array(
                'paypal_connected' => $user->isPayPalConnected(),
                'stripe_connected' => $user->isStripeConnected()
            )
        );
    }


    /*
    |===================================================
    | <POST> | doSettings: updates user data
    |===================================================
    */
    public function doSettings()
    {
        // Validation rules
        $rules = array(
            'email' => 'required_with:password|email',
            'password' => 'required_with:email|min:4',
            'oldpassword' => 'required_with: newpassword1, newpassword2|required_with:newpassword1|required_with:newpassword2|min:4',
            'newpassword1' => 'required_with: oldpassword, newpassword2|required_with:oldpassword|required_with:newpassword2|min:4',
            'newpassword2' => 'required_with: oldpassword, newpassword1|required_with:oldpassword|required_with:newpassword1|min:4',
        );
        // run the validation rules on the inputs
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            // validation error -> redirect
            return Redirect::route('auth.settings')
                ->withErrors($validator) // send back errors
                ->withInput(); // sending back data
        } else {
            // validator success -> edit_profile
            // selecting logged in user
            $user = Auth::user();
            // checking actions and updating data
            // checking if submitted email has registered user
            $user_to_check = User::where('email', '=', Input::get('email'))->get()->first();
            // if we do not have data in the email form
            // and validator has no errors, then password change
            if (empty(Input::get('password'))){
                // if we have data from the password change form
                // checking if old password is the old password
                if (Hash::check(Input::get('oldpassword'), $user->password)){
                    // if new passwords are the same
                    if (Input::get('newpassword1') === Input::get('newpassword2')){
                        $user->password = Hash::make(Input::get('newpassword1'));
                    }
                    else {
                        return Redirect::route('auth.settings')
                            ->with('error', 'The new passwords you entered do not match.'); // send back errors
                    }
                }
                else {
                    return Redirect::route('auth.settings')
                        ->with('error', 'The old password you entered is incorrect.'); // send back errors
                }  
            }
            // validator has no errors, and password field is not empty
            // email change
            else {
                // if email is not registered
                if (is_null($user_to_check)) {
                    // we have valid email, we need to check password
                    if (Hash::check(Input::get('password'), $user->password)){
                        $user->email = Input::get('email');
                    }
                    else {
                        return Redirect::route('auth.settings')
                            ->with('error', 'The password you entered is incorrect.') // send back errors
                            ->withInput(); // sending back data
                    }
                } else {
                    // if email is registered and changed
                    if ($user->email != Input::get('email')) {
                        return Redirect::route('auth.settings')
                            ->with('error', 'This email is already registered.') // send back errors
                            ->withInput(); // sending back data
                    }
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
        $redirectUrl = OpenIdSession::getAuthorizationUrl(
            route('paypal.buildToken'),
            array('profile', 'email', 'phone'),
            null,
            null,
            null,
            $apiContext
        );

        // selecting logged in user
        $user = Auth::user();

        // returning view
        return View::make('auth.connect',
            array(
                'redirect_url' => $redirectUrl,
                'paypal_connected' => $user->isPayPalConnected(),
                'stripe_connected' => $user->isStripeConnected()
            )
        );
    }


    /*
    |===================================================
    | <GET> | doDisconnect: disconnects the active user
    |===================================================
    */
    public function doDisconnect($service)
    {
        // NOTE: should we also remove the colleced DB data?

        // selecting the logged in User
        $user = Auth::user();

        if ($service == "stripe") {
            // disconnecting stripe

            // removing stripe key
            $user->stripe_key = "";

        } else if ($service == "paypal") {
            // disconnecting paypal

            // removing paypal refresh token
            $user->paypal_key = "";

        }

        // saving modification on user
        $user->save();

        // redirect to connect
        return Redirect::route('auth.connect')->with('success', 'Disconnected from ' . $service . '.');;
    }


    /*
    |===================================================
    | <POST> | doConnect: updates user service data stripe only
    |===================================================
    */
    public function doConnect()
    {
        // Validation
        $rules = array(
            'stripe' => 'min:16|max:64|required',
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
                Stripe::setApiKey(Input::get('stripe'));
                $account = Stripe_Account::retrieve(); // catchable line
                // success
                $returned_object = json_decode(strstr($account, '{'), true);

                // updating the user
                $user = Auth::user();

                // setting key
                $user->stripe_key = Input::get('stripe');

                // setting name if is null
                if (strlen($user->name) == 0) {
                    $user->name = $returned_object['display_name'];
                }
                if (strlen($user->zoneinfo) == 0) {
                    $user->zoneinfo = $returned_object['country'];
                }

                // saving user
                $user->save();

            } catch(Stripe_AuthenticationError $e) {
                // code was invalid
                return Redirect::back()->withErrors(
                    array('stripe' => "Authentication unsuccessful!")
                );
            }

        // redirect to get stripe
        return Redirect::route('auth.connect')->with('success', 'Stripe connected.');

        }
    }
    /*
    |===================================================
    | <GET> | showSinglestat: renders the single stats page
    |===================================================
    */
    public function showSinglestat($statID = 'mainPage')
    {
        switch($statID){
            case 'mainPage':
            return View::make('auth.single_stat',
                array(
                    'data' => MrrStat::showMRR(true)
                )
            );
            case 'mrr':
            return View::make('auth.single_stat',
                array(
                    'data' => MrrStat::showMRR(true)
                )
            );
            break;
            case 'au':
            return View::make('auth.single_stat',
                array(
                    'data' => AUStat::showAU(true)
                )
            );
            case 'arr':
            return View::make('auth.single_stat',
                array(
                    'data' => ArrStat::showARR(true)
                )
            );
            case 'arpu':
            return View::make('auth.single_stat',
                array(
                    'data' => ArpuStat::showARPU(true)
                )
            );
            default:
                return Redirect::route('auth.dashboard')
                ->with('error', 'Statistic does not exist.');
            break;
        }

    }

}
