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
        /*
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
        */
        // selecting logged in user
        $user = Auth::user();

        // prepare stuff for google drive auth
        $client = GoogleSpreadsheetHelper::setGoogleClient();

        // returning view
        return View::make('connect.connect',
            array(
                //'redirect_url' => $redirectUrl,
                //'paypal_connected' => $user->isPayPalConnected(),
                'stripe_connected'      => $user->isStripeConnected(),
                'stripeButtonUrl'       => OAuth2::getAuthorizeURL(),
                'googlespreadsheet_connected'      => $user->isGoogleSpreadsheetConnected(),
                'googleSpreadsheetButtonUrl'       => $client->createAuthUrl(),
            )
        );
    }

    /*
    |===================================================
    | <ANY> | connectProvider: return route for connecting a provider
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

                    // saving user
                    $user->save();

                    IntercomHelper::connected($user,'stripe');

                    Queue::push('CalculateFirstTime', array('userID' => $user->id));
            	    
    			} else if (isset($response['error'])) {

    				Log::error($response['error_description']);
    				return Redirect::route('connect.connect')
    					->with('error', 'Something went wrong, try again later');
    			} else {

    				Log::error("Something went wrong with stripe connect, don't know what");
    				return Redirect::route('connect.connect')
    					->with('error', 'Something went wrong, try again later');
    			}

    		} else if (Input::has('error')) {
    			// there was an error in the request

                Log::error(Input::get('error_description'));
    			return Redirect::route('connect.connect')
    				->with('error',Input::get('error_description'));
    		} else {
    			// we don't know what happened
                Log::error('Unknown error with user: '.$user->email);
    			return Redirect::route('connect.connect')
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

                    # save the widget

                    $widget_data = array(
                        'googleSpreadsheetId'   =>  Session::get('spreadsheetId'),
                        'googleWorksheetName'     =>  Input::get('worksheetName')
                    );
                    $widget_json = json_encode($widget_data);

                    $widget = new Widget;
                    $widget->widget_name = Session::get('spreadsheetName').' - Google Spreadsheet';
                    $widget->widget_type = 'google-spreadsheet-linear';
                    $widget->widget_source = $widget_json;
                    $widget->dashboard_id = $user->dashboards()->first()->id;
                    $widget->save();

                    return Redirect::route('auth.dashboard')
                      ->with('success', ucfirst($provider).' connected.');
                }                
            }
        }

  	return Redirect::route('connect.connect')
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
            $user->ready = 'notConnected';

            $servicename = 'Stripe';

        } else if ($service == "braintree") {
            // disconnecting paypal

            // removing paypal refresh token
            $user->paypal_key = "";

            $servicename = 'Paypal';

        } else if ($service == "googlespreadsheet") {

            $client = new GuzzleHttp\Client();
            $response = $client->get("https://accounts.google.com/o/oauth2/revoke?token=".$user->googleSpreadsheetRefreshToken);

            $user->googleSpreadsheetRefreshToken = "";
            $user->googleSpreadsheetCredentials = "";
            $user->googleSpreadsheetEmail = "";

            $servicename = 'Google Spreadsheet';

        }

        // saving modification on user
        $user->save();

        // redirect to connect
        return Redirect::route('connect.connect')
        	->with('success', 'Disconnected from ' . $servicename . '.');
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

    /*
    |===================================================
    | <POST> | doSaveSuggestion: updates user service data stripe only
    |===================================================
    */
    public function doSaveSuggestion()
    {
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

        return Redirect::route('auth.dashboard')
                        ->with(array('success' => "Widget deleted."));
    }


}


