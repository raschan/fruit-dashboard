<?php
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;

/*
|--------------------------------------------------------------------------
| ConnectController: Handles the connection related sites
|--------------------------------------------------------------------------
*/

class ConnectController extends BaseController
{
	/*
    |===================================================
    | <GET> | showConnect: renders the connect page
    |===================================================
    */
    public function showConnect()
    {
        // selecting logged in user
        $user = Auth::user();
        
        $braintree_connect_stepNumber = 1;

        if (Session::has('modal'))
        {
            $connectState = Session::get('modal');

            if ($connectState == 'braintree-credentials')
            {
                // this is the first step, this is default
                // there was an authentication error with braintree
            }
            if ($connectState == 'braintree-webhook') 
            {
                // authentication with braintree was successful, 
                // now lets show the webhook url

                $braintree_connect_stepNumber = 2;
            }
            if ($connectState == 'braintree-connect')
            {
                // webhook setup was successful
                // show the 'import your data' step
                $braintree_connect_stepNumber = 3;
            }
        }

        // we want to start on the second step with braintree, 
        // if braintree credentials are okay
        // we only save credentialss that were okay
        if ($user->isBraintreeCredentialsValid())
        {
            $braintree_connect_stepNumber = 2;
        }

        // we want to show the 'import your data' step
        // if webhook is already connected
        if ($user->btWebhookConnected)
        {
            $braintree_connect_stepNumber = 3;
        }
       
        // prepare stuff for google drive auth
        $client = GoogleSpreadsheetHelper::setGoogleClient();
        
        // returning view
        return View::make('connect.connect',
            array(
                'user'                          => $user,
                // stripe stuff
                'stripeButtonUrl'               => OAuth2::getAuthorizeURL(),

                // braintree stuff
                'braintree_connect_stepNumber'  => $braintree_connect_stepNumber,

                // google spreadsheet stuff
                'googleSpreadsheetButtonUrl'    => $client->createAuthUrl(),
            )
        );
    }

    /*
    |===================================================
    | <ANY> | connectProvider: return route for connecting a provider
    | authentication with OAuth2 protocol (favored)
    |===================================================
    */
    public function connectProvider($provider, $step = NULL)
    {
        # we will need the user

        $user = Auth::user();


    	if ($provider == 'stripe') {

            if(Input::has('code'))
            {
    			// get the token with the code
    			$response = OAuth2::getRefreshToken(Input::get('code'));

    			if(isset($response['refresh_token']))
    			{
	    			$user->stripeRefreshToken = $response['refresh_token'];
                    $user->stripeUserId = $response['stripe_user_id'];

	    			Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
    	            $account = Stripe\Account::retrieve($user->stripeUserId);
        	        // success
            	    $returned_object = json_decode(strstr($account, '{'), true);

                    // save user
                    $user->ready = 'connecting';

                    // setting name if is null
                    if (strlen($user->name) == 0) {
                        $user->name = $returned_object['display_name'];
                    }
                    if (strlen($user->zoneinfo) == 0) {
                        $user->zoneinfo = $returned_object['country'];
                    }

                    $user->connectedServices++;
                    // saving user
                    $user->save();

                    IntercomHelper::connected($user,'stripe');

                    Queue::push('CalculateFirstTime', array('userID' => $user->id));
            	    
			    	return Redirect::route('auth.dashboard')
			    		->with('success', ucfirst($provider).' connected.');
    			} else if (isset($response['error'])) {

    				Log::error($response['error_description']);
    				return Redirect::route('auth.settings')
    					->with('error', 'Something went wrong, try again later');
    			} else {

    				Log::error("Something went wrong with stripe connect, don't know what");
    				return Redirect::route('auth.settings')
    					->with('error', 'Something went wrong, try again later');
    			}

    		} else if (Input::has('error')) {
    			// there was an error in the request

                Log::error(Input::get('error_description'));
    			return Redirect::route('auth.settings')
    				->with('error',Input::get('error_description'));
    		} else {
    			// we don't know what happened
                Log::error('Unknown error with user: '.$user->email);
    			return Redirect::route('auth.settings')
    				->with('error', 'Something went wrong, try again');
    		}
    	}

        # if we auth with googlespreadsheet

        if ($provider == 'googlespreadsheet') {

            # we will need a client for spreadsheet feeds + email + offline (to get a refreshtoken)

            $client = GoogleSpreadsheetHelper::setGoogleClient();

            if (!$step){

                # first round -- we got a code in GET from google

                if (Input::has('code')) {

                    # lets get an access token
                    $client->authenticate(Input::get('code'));
                    $credentials = $client->getAccessToken(); // big JSON stuff

                    # lets make it an associative array
                    $tokens_decoded = json_decode($credentials, true);

                    # lets check if we have a refresh token already
                    $refresh_token = $user->googleSpreadsheetRefreshToken;
                    if (strlen($refresh_token)<10) {
                        # nope, let's use the one we got now
                        $refresh_token = $tokens_decoded['refresh_token'];
                    }

                    # database save the access-stuff-JSON and the refresh token
                    $user->googleSpreadsheetCredentials = $credentials;
                    $user->googleSpreadsheetRefreshToken = $refresh_token;
                    $user->save();

                    # good job, notify intercom
                    IntercomHelper::connected($user,'googlespreadsheet');

                    # lets call this route again, but without the code
                    if (Request::secure()) {
                        $redirect = 'https://';
                    } else {
                        $redirect = 'http://';
                    }
                    $redirect .= $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
                    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL)); 
                    exit();
                }

                # second round, prepare the wizard

                $access_token = GoogleSpreadsheetHelper::getGoogleAccessToken($client, $user);

                # get the spreadsheet list
                $serviceRequest = new DefaultServiceRequest($access_token);
                ServiceRequestFactory::setInstance($serviceRequest);
                $spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
                $spreadsheetFeed = $spreadsheetService->getSpreadsheets();

                return View::make('connect.googleSpreadsheetConnect')->with('spreadsheetFeed', $spreadsheetFeed);
            }

            # we are in the wizard

            if ($step) {

                $access_token = GoogleSpreadsheetHelper::getGoogleAccessToken($client, $user);

                # init service
                $serviceRequest = new DefaultServiceRequest($access_token);
                ServiceRequestFactory::setInstance($serviceRequest);

                # if we are after wizard step #1
                if ($step == 2) {

                    # get the spreadsheet they asked for in the POST
                    $spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
                    $spreadsheet = $spreadsheetService->getSpreadsheetById(Input::get('spreadsheetId'));
                    $worksheetFeed = $spreadsheet->getWorksheets();

                    # save the spreadsheet name in SESSION
                    Session::put("spreadsheetId", Input::get('spreadsheetId'));
                    Session::put("spreadsheetName", $spreadsheet->getTitle());
                    
                    # render wizard step #2
                    return View::make('connect.googleSpreadsheetConnect')->with(
                        array(
                            'step' => 2,
                            'worksheetFeed' => $worksheetFeed
                        )
                    );
                }

                # if we are after wizard step #2
                if ($step == 3) {

                    # save the worksheet name in SESSION
                    Session::put("worksheetName", Input::get('worksheetName'));

                    # render wizard step #2
                    return View::make('connect.googleSpreadsheetConnect')->with(
                        array(
                            'step' => 3
                        )
                    );
                }                

                # if we are after wizard step #3
                if ($step == 4) {

                    # save the widget
                    $widget_data = array(
                        'googleSpreadsheetId'   =>  Session::get('spreadsheetId'),
                        'googleWorksheetName'   =>  Session::get('worksheetName')
                    );
                    $widget_json = json_encode($widget_data);

                    $widget = new Widget;
                    $widget->widget_name = Session::get('worksheetName').' - '.Session::get('spreadsheetName');
                    $widget->widget_type = Input::get('type');
                    $widget->widget_source = $widget_json;
                    $widget->dashboard_id = $user->dashboards()->first()->id;
                    $widget->save();

                    return Redirect::route('auth.dashboard')
                      ->with('success', 'Google Spreadsheet widget added.');
                }                
            }
        }

  	return Redirect::route('auth.settings')
   		->with('error', 'Unknown provider.');

    }


    /*
    |===================================================
    | <GET> | doDisconnect: disconnects the active user
    |===================================================
    */
    public function doDisconnect($service)
    {
        // NOTE: should we also remove the collected DB data?

        // selecting the logged in User
        $user = Auth::user();

        if ($service == "stripe") {
            // disconnecting stripe

            // removing stripe key
            $user->stripe_key = "";
            $user->stripeUserId = "";
            $user->stripeRefreshToken = "";

            $servicename = 'Stripe';

        } else if ($service == "braintree") {
            // disconnecting braintree

            $user->btPrivateKey = null;
            $user->btPublicKey = null;
            $user->btEnvironment = null;
            $user->btMerchantId = null;

            $user->btWebhookId = null;
            $user->btWebhookConnected = false;
            
            $servicename = 'Braintree';

        } else if ($service == "googlespreadsheet") {

            $client = GoogleSpreadsheetHelper::setGoogleClient();
            $access_token = GoogleSpreadsheetHelper::getGoogleAccessToken($client, $user);

            $guzzle_client = new GuzzleHttp\Client();
            $response = $guzzle_client->get("https://accounts.google.com/o/oauth2/revoke?token=".$user->googleSpreadsheetRefreshToken);

            $user->googleSpreadsheetRefreshToken = "";
            $user->googleSpreadsheetCredentials = "";
            $user->googleSpreadsheetEmail = "";

            $servicename = 'Google Spreadsheet';

        }

        $user->connectedServices--;
        // saving modification on user
        $user->save();

        if (!$user->isConnected())
        {
        	$user->ready = 'notConnected';
        	$user->save();
        }

        // redirect to connect
        return Redirect::route('auth.settings')
        	->with('success', 'Disconnected from ' . $servicename . '.');
    }


    /*
    |===================================================
    | <POST> | doConnect: updates user service data stripe only
    | connecting with stripe secret key (deprecated)
    |===================================================
    */
    public function doConnect()
    {
        // Validation
        $rules = array(
            'stripe' => 'min:16|max:64|required'
        );

        // run the validation rules on the inputs
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            // validation error -> sending back
            $failedAttribute = $validator->invalid();
            return Redirect::back()
                ->with('error',$validator->errors()->get(key($failedAttribute))[0]) // send back errors
                ->withInput(); // sending back data
        } else {
            // validator success
            try {

                // trying to login with this key
                Stripe\Stripe::setApiKey(Input::get('stripe'));
                $account = Stripe\Account::retrieve(); // catchable line
                // success
                $returned_object = json_decode(strstr($account, '{'), true);

                // updating the user
                $user = Auth::user();
                $user->ready = 'connecting';

                // setting key
                $user->stripe_key = Input::get('stripe');

                // setting name if is null
                if (strlen($user->name) == 0) {
                    $user->name = $returned_object['display_name'];
                }
                if (strlen($user->zoneinfo) == 0) {
                    $user->zoneinfo = $returned_object['country'];
                }

                $user->connectedServices++;
                // saving user
                $user->save();

                IntercomHelper::connected($user,'stripe');

                Queue::push('CalculateFirstTime', array('userID' => $user->id));

            } catch(Stripe\Error\Authentication $e) {
                // code was invalid
                return Redirect::back()->with('error',"Authentication unsuccessful!");
            }

        // redirect to get stripe
        return Redirect::route('auth.dashboard')
                        ->with(array('success' => 'Stripe connected.'));

        }
    }

    public function doBraintreeConnect()
    {
    	// Validation
    	// this one need better checks
    	$rules = array(
    		'publicKey' 	=> 'required',
    		'privateKey'	=> 'required',
    		'merchantId'	=> 'required');

    	// run the validation rules on the inputs
    	$validator = Validator::make(Input::all(), $rules);
	   	
	   	if ($validator->fails()) {
            // validation error -> sending back
            $failedAttribute = $validator->invalid();
            return Redirect::back()
                ->with('error',$validator->errors()->get(key($failedAttribute))[0]) // send back errors
                ->withInput(); // sending back data
        } else {
        	// data validated, now check if its braintree data

            Braintree_Configuration::environment(Input::get('environment'));
        	Braintree_Configuration::merchantId(Input::get('merchantId'));
        	Braintree_Configuration::publicKey(Input::get('publicKey'));
        	Braintree_Configuration::privateKey(Input::get('privateKey'));

        	try
        	{
        		Braintree_Plan::all();
        	} 
        	catch (Exception $e) 
        	{
        		return Redirect::back()
        			->with('error','Authentication failed.')
                    ->with('modal','braintree-credentials');
        	}

        	$user = Auth::user();

        	$user->btEnvironment = Input::get('environment');
        	$user->btPublicKey = Input::get('publicKey');
        	$user->btPrivateKey = Input::get('privateKey');
        	$user->btMerchantId = Input::get('merchantId');

            if($user->btWebhookId == null)
            {
                $user->btWebhookId = str_random(12);            
            }

        	$user->save();

        	return Redirect::route('connect.connect')
        		->with('success','Authentication successful')
                ->with('modal','braintree-webhook');
        }
    }

    public function doImport($provider)
    {
        if ($provider == 'braintree')
        {
            $user = Auth::user();
            $user->ready ='connecting';
            $user->save();

            IntercomHelper::connected($user,'braintree');
            Queue::push('CalculateBraintreeFirstTime', array('userID' => $user->id));

            return Redirect::route('auth.dashboard')
                ->with('success','Braintree connected, importing data');
        }
    }

    /*
    |===================================================
    | <POST> | doSaveSuggestion: saves a suggestion
    |===================================================
    */
    public function doSaveSuggestion()
    {
    	// Validation
        $rules = array(
            'suggestion' => 'required'
            );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            // validation error -> sending back
            $failedAttribute = $validator->invalid();
            return Redirect::back()
                ->with('error',$validator->errors()->get(key($failedAttribute))[0]) // send back errors
                ->withInput(); // sending back data
        } else {
            DB::table('suggestions')->insert(array(
                'suggestion' => Input::get('suggestion'),
                'email' => Auth::user()->email));
        }

        return Redirect::route('connect.connect')
                        ->with(array('success' => "Thank you, we'll get in touch"));
    }

    /*
    |===================================================
    | <ANY> | deleteWidget: delete widget
    |===================================================
    */
    public function deleteWidget($widget_id){

        $widget = Auth::user()->dashboards->first()->widgets()->find($widget_id);
        $success = $widget->delete();
        Log::info($success);

        $data = Data::where("widget_id", "=", $widget_id);
        $success = $data->delete();
        Log::info($success);

        return Redirect::back()
                        ->with(array('success' => "Widget deleted."));
    }

    /*
    |===================================================
    | <ANY> | modifyAbfWidget: saves the changes to the ABF timetracking widget
    |===================================================
    */
    public function modifyAbfWidget()
    {
        $data = json_decode(Input::get('data'), true);
        $widget_id = json_decode(Input::get('widget_id'), true);
        $data_key = $data['updatedData'][0];

        Log::info($data);
        Log::info($widget_id);

        $values = [
            'date'      =>  $data['updatedData'][1],
            'start'     =>  $data['updatedData'][2],
            'end'       =>  $data['updatedData'][3],
            'length'    =>  $data['updatedData'][4],
            'role'      =>  $data['updatedData'][5],
            'project'   =>  $data['updatedData'][6],
            'comment'   =>  $data['updatedData'][7],
            'h13'       =>  $data['updatedData'][8]
        ];

        $db_data = Data::where('widget_id', '=', $widget_id)
            ->where('data_key', '=', $data_key);

        $time = time();

        if ($db_data->count() == 0) {
            # nope, save it

            $maxData = Data::where('widget_id', '=', $widget_id)
                ->orderBy('data_key','desc')
                ->first();
            $newKey = $maxData['data_key']+1;

            Log::info("newKey - ".$newKey);

            $data = new Data;
            $data->data_key = $newKey;
            $data->widget_id = $widget_id;
            $data->data_object = json_encode($values);
            $data->date = date("Y-m-d", $time);
            $data->timestamp = date('Y-m-d H:i:s', $time);
            $data->save();
        } else {
            # yes, update it
            Log::info("data_key - ".$data_key);

            $db_data->update([
                'data_key' => $data_key,
                'data_object' => json_encode($values), 
                'date' => date("Y-m-d", $time), 
                'timestamp' => date('Y-m-d H:i:s', $time)
            ]);
        }

    }

}


