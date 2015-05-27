<?php

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
        
        // returning view
        return View::make('connect.connect',
            array(
                'user'                          => $user,
                // stripe stuff
                'stripeButtonUrl'               => OAuth2::getAuthorizeURL(),

                // braintree stuff
                'braintree_connect_stepNumber'  => $braintree_connect_stepNumber,
            )
        );
    }

    /*
    |===================================================
    | <GET> | connectProvider: return route for connecting a provider
    | authentication with OAuth2 protocol (favored)
    |===================================================
    */
    public function connectProvider($provider)
    {
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
                Log:error('Unknown error with user: '.$user->email);
    			return Redirect::route('connect.connect')
    				->with('error', 'Something went wrong, try again');
    		}
    	}

    	return Redirect::route('connect.connect')
    		->with('error','Invalid payment provider.');
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

        } else if ($service == "braintree") {
            // disconnecting braintree

            $user->btPrivateKey = null;
            $user->btPublicKey = null;
            $user->btEnvironment = null;
            $user->btMerchantId = null;

            $user->btWebhookId = null;
            $user->btWebhookConnected = false;
            
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
        return Redirect::route('connect.connect')
        	->with('success', 'Disconnected from ' . $service . '.');
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
}