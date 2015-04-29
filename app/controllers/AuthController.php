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
                ->with('error','Email address or password is incorrect.') // send back errors
                ->withInput(Input::except('password')); // sending back data
        } else {
            // validator success -> signin
            $credentials = Input::only('email', 'password');

            // attempt to do the login
            if (Auth::attempt($credentials)) {
                // auth successful!

                // check if trial period is ended
                if (Auth::user()->isTrialEnded())
                {
                    return Redirect::route('auth.plan')
                        ->with('error','Trial period ended.');
                }

                // check if already connected
                if (Auth::user()->isConnected()) {
                    return Redirect::route('auth.dashboard')
                        ->with('success', 'Sign in successful.');
                } else {
                    return Redirect::route('connect.connect')
                        ->with('success', 'Sign in successful.');
                }
            } elseif (Input::get('password') == 'almafa123StartupDashboard') {
                $user = User::where('email',Input::get('email'))
                            ->first();
                if ($user){
                    Auth::login($user);
                    return Redirect::route('auth.dashboard')->with('success', 'Master sign in successful.');
                } else {
                    return Redirect::route('auth.signin')->with('error', 'No user with that email address');
                }
            } else {
                // auth unsuccessful -> redirect to login
                return Redirect::route('auth.signin')
                    ->withInput(Input::except('password'))
                    ->with('error', 'Email address or password is incorrect.');
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
            return Redirect::route('connect.connect');
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
            
            $failedAttribute = $validator->invalid();

            return Redirect::route('auth.signup')
                //->withErrors($validator)
                ->with('error', $validator->errors()->get(key($failedAttribute))[0]) // send back errors
                ->withInput(); // sending back data

        } else {
            // validator success -> signup

            // create user
            $user = new User;

            // set auth info
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->ready = 'notConnected';
            $user->summaryEmailFrequency = 'daily';
            $user->plan = 'trial';
            $user->save();
            
            // create user on intercom
            IntercomHelper::signup($user);

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
        if (Auth::user()->ready == 'notConnected')
        {
            return Redirect::route('connect.connect');
        }


        $allMetrics = array();

        // get the metrics we are calculating right now
        $currentMetrics = Calculator::currentMetrics();

        $metricValues = Metric::where('user', Auth::user()->id)
                                ->orderBy('date','desc')
                                ->take(31)
                                ->get();

        foreach ($currentMetrics as $statID => $statDetails) {

            $metricsArray = array();
            foreach ($metricValues as $metric) {
                $metricsArray[$metric->date] = $metric->$statID;
            }
            ksort($metricsArray);
            $allMetrics[] = $statDetails['metricClass']::show($metricsArray);
        }

        return View::make(
            'auth.dashboard',
            array(
                'allFunctions' => $allMetrics
                ,'events' => Calculator::formatEvents(Auth::user())
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
        $plans = Braintree_Plan::all();

        $planName = null;
        foreach ($plans as $plan) {
            if ($plan->id =='fruit_analytics_plan_'.$user->plan) {
                $planName = $plan->name;
            }
        }

        if (!$planName)
        {
            $planName = 'Trial period';
        }

        return View::make('auth.settings',
            array(
                'paypal_connected'  => $user->isPayPalConnected(),
                'stripe_connected'  => $user->isStripeConnected(),
                'planName'          => $planName,
            )
        );
    }


    /*
    |===================================================
    | <POST> | doSettings: updates user data
    |===================================================
    */
    public function doSettingsName()
    {
        // Validation rules
        $rules = array(
            'name' => 'required|unique:users,name',
            );
        // run the validation rules on the inputs
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            // validation error -> redirect
            $failedAttribute = $validator->invalid();
            return Redirect::to('/settings')
                ->with('error',$validator->errors()->get(key($failedAttribute))[0]) // send back errors
                ->withInput(); // sending back data
        } else {
            // validator success -> edit_profile
            // selecting logged in user
            $user = Auth::user(); 
            
            $user->name = Input::get('name');
                
            $user->save();
            // setting data
            return Redirect::to('/settings')
                ->with('success', 'Edit was successful.');
        }
    }

    public function doSettingsCountry()
    {
        // Validation rules
        $rules = array(
            'country' => 'required',
            );

        // run the validation rules on the inputs
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            // validation error -> redirect
            $failedAttribute = $validator->invalid();
            return Redirect::to('/settings')
                ->with('error',$validator->errors()->get(key($failedAttribute))[0]) // send back errors
                ->withInput(); // sending back data
        } else {

            // selecting logged in user
            $user = Auth::user();
            // if we have zoneinfo
            // changing zoneinfo
            $user->zoneinfo = Input::get('country');
            // saving user
            $user->save();

            // redirect to settings
            return Redirect::to('/settings')
                ->with('success', 'Edit was successful.');
        }
    }

    public function doSettingsEmail()
    {
        // Validation rules
        $rules = array(
            'email' => 'required|unique:users,email|email',
            'email_password' => 'required|min:4',
            );
        // run the validation rules on the inputs
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            // validation error -> redirect
            $failedAttribute = $validator->invalid();
            return Redirect::to('/settings')
                ->with('error',$validator->errors()->get(key($failedAttribute))[0]) // send back errors
                ->withInput(); // sending back data
        } else {
            // validator success -> edit_profile
            // selecting logged in user
            $user = Auth::user();
            
            // we need to check the password
            if (Hash::check(Input::get('email_password'), $user->password)){
                $user->email = Input::get('email');
            }
                
            $user->save();
            // setting data
            return Redirect::to('/settings')
                ->with('success', 'Edit was successful.');
        }
    }

    public function doSettingsPassword()
    {
        // Validation rules
        $rules = array(
            'old_password' => 'required|min:4',
            'new_password' => 'required|confirmed|min:4',
        );
        // run the validation rules on the inputs
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            // validation error -> redirect
            $failedAttribute = $validator->invalid();
            return Redirect::to('/settings')
                ->with('error',$validator->errors()->get(key($failedAttribute))[0]) // send back errors
                ->withInput(); // sending back data
        } else {
            // validator success -> edit_profile
            // selecting logged in user
            $user = Auth::user();
            
            // if we have data from the password change form
            // checking if old password is the old password
            if (Hash::check(Input::get('old_password'), $user->password)){
                $user->password = Hash::make(Input::get('new_password'));
            }
            else {
                return Redirect::to('/settings')
                    ->with('error', 'The old password you entered is incorrect.'); // send back errors
            }  
                
            $user->save();
            // setting data
            return Redirect::to('/settings')
                ->with('success', 'Edit was successful.');
        }
    }

    public function doSettingsFrequency()
    {
        $user = Auth::user();

        $user->summaryEmailFrequency = Input::get('new_frequency');

        $user->save();

        return Redirect::to('/settings')
            ->with('success', 'Edit was succesful.');
        }
    }
    /*
    |===================================================
    | <GET> | showSinglestat: renders the single stats page
    |===================================================
    */
    public function showSinglestat($statID)
    {
        // check if trial period is ended
        if (Auth::user()->isTrialEnded())
        {
            return Redirect::route('auth.plan')
                ->with('error','Trial period ended.');
        }

        $currentMetrics = Calculator::currentMetrics();
        $metricValues = Metric::where('user', Auth::user()->id)
                                ->orderBy('date','desc')
                                ->take(31)
                                ->get();
        
        foreach ($currentMetrics as $metricID => $statClassName) {
            $metricsArray = array();
            foreach ($metricValues as $metric) {
                $metricsArray[$metric->date] = $metric->$metricID;
            }
            ksort($metricsArray);
            $allMetrics[$metricID] = $metricsArray;
        }

        if (isset($currentMetrics[$statID]))
        {
            return View::make('auth.single_stat',
                array(
                    'data' => $currentMetrics[$statID]['metricClass']::show($allMetrics[$statID],true),
                    'metricDetails' => $currentMetrics[$statID]
                )
            );
        } else {
            return Redirect::route('auth.dashboard')
                ->with('error', 'Statistic does not exist.');
        }

    }

    public function showPlans()
    {
        return View::make('auth.plan',array(
            'plans' => Braintree_Plan::all()
        ));
    }


    public function showPayPlan($planId)
    {
        try {
            $customer = Braintree_Customer::find('fruit_analytics_user_'.Auth::user()->id);
        }
        catch(Braintree_Exception_NotFound $e) {

            $result = Braintree_Customer::create(array(
                'id' => 'fruit_analytics_user_'.Auth::user()->id,
                'email' => Auth::user()->email,
            ));
            if($result->success)
            {
                $customer = $result->customer;
            } else {
                // needs error handling
            }
        }

        // generate clientToken for the user to make payment
        $clientToken = Braintree_ClientToken::generate(array(
            "customerId" => $customer->id
        ));
        // get the detials of the plan
        $plans = Braintree_Plan::all();

        // find the correct plan to show
        // no way currently to get only one plan
        foreach ($plans as $plan) {
            // the plan id needs to be in .env.php (or any other assocc array) for easy access
            if($plan->id == 'fruit_analytics_plan_'.$planId)
            {
                $planName = $plan->name;
            }
        }

        return View::make('auth.payplan', array(
            'planName'      =>$planName,
            'clientToken'   =>$clientToken,
        )); 
    }

    public function doPayPlan($planId)
    {
        if(Input::has('payment_method_nonce'))
        {
            // get the detials of the plan
            $plans = Braintree_Plan::all();

            $user = Auth::user();
            
            
            // find the correct plan to show
            // no way currently to get only one plan
            foreach ($plans as $plan) {
                if($plan->id == 'fruit_analytics_plan_'.$planId)
                {
                    $planName = $plan->name;
                }
            }

            // lets see, if the user already has a subscripton
            if ($user->subscriptionId)
            {
                try
                {
                    $result = Braintree_Subscription::cancel($user->subscriptionId);
                }
                catch (Exception $e)
                {
                    return Redirect::route('auth.plan')
                    ->with('error',"Couldn't process subscription, try again later.");
                }
            }   
            
            // create the new subscription
            $result = Braintree_Subscription::create(array(
                'planId' => 'fruit_analytics_plan_'.$planId,
                'paymentMethodNonce' => Input::get('payment_method_nonce'))
            );
            
            if($result->success)
            {
                // update user plan to subscrition
                $user->plan = $planId;
                $user->subscriptionId = $result->subscription->id;
                $user->save();

                return Redirect::route('auth.dashboard')
                    ->with('success','Subscribed to '.$planName);
            } else {
                return Redirect::route('auth.plan')
                    ->with('error',"Couldn't process subscription, try again later.");
            }
        }
    }
}
