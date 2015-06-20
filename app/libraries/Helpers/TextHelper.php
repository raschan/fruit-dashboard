<?php
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;

class GoogleSpreadsheetHelper {

	public static function wizard($step = NULL){

		if ($step == 'init'){
			return View::make('connect.connect-text/select-source')->with(array(
				'isBackgroundOn' => Auth::user()->isBackgroundOn,
				'dailyBackgroundURL' => Auth::user()->dailyBackgroundURL(),				
			));
		}

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

			return View::make('connect.connect-googlespreadsheet')->with(array(
				'spreadsheetFeed' => $spreadsheetFeed,
				'isBackgroundOn' => Auth::user()->isBackgroundOn,
				'dailyBackgroundURL' => Auth::user()->dailyBackgroundURL(),				
			));
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
				return View::make('connect.connect-googlespreadsheet')->with(
					array(
						'step' => 2,
						'worksheetFeed' => $worksheetFeed,
						'isBackgroundOn' => Auth::user()->isBackgroundOn,
						'dailyBackgroundURL' => Auth::user()->dailyBackgroundURL(),
					)
				);
			}

			# if we are after wizard step #2
			if ($step == 3) {

				# save the worksheet name in SESSION
				Session::put("worksheetName", Input::get('worksheetName'));

				# render wizard step #2
				return View::make('connect.connect-googlespreadsheet')->with(
					array(
						'step' => 3,
						'isBackgroundOn' => Auth::user()->isBackgroundOn,
						'dailyBackgroundURL' => Auth::user()->dailyBackgroundURL(),
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
				$widget->widget_ready = false;
				$widget->dashboard_id = $user->dashboards()->first()->id;
				$widget->position = '{"size_x":3,"size_y":4,"col":1,"row":1}';
				$widget->save();

				return Redirect::route('dashboard.dashboard')
				  ->with('success', 'Google Spreadsheet widget added.');
			}  
		}
	}

	public static function setGoogleClient(){
	    $client = new Google_Client();
	    $client->setClientId($_ENV['GOOGLE_CLIENTID']);
	    $client->setClientSecret($_ENV['GOOGLE_CLIENTSECRET']);
	    $client->setRedirectUri($_ENV['GOOGLE_REDIRECTURL']);
	    $client->setScopes(array('https://spreadsheets.google.com/feeds', 'email'));
	    $client->setAccessType('offline');                
	    $client->setApprovalPrompt('force');
	    return $client;
	}

	public static function getGoogleAccessToken($client, $user){

	    # load the tokens from the database
	    $credentials = $user->googleSpreadsheetCredentials;
	    $refresh_token = $user->googleSpreadsheetRefreshToken;

	    # give it a try
        try {
			$client->setAccessToken($credentials);
        } catch (Exception $e) {
        	# something went wrong, better disconnect the service
        	Log::error($e);
        	exit();
        }

	    # if the token is expired, 
	    if ($client->isAccessTokenExpired()) {

	        # let's get another one with the refreshtoken
	        $refresh_token = $user->googleSpreadsheetRefreshToken;
	        $client->refreshToken($refresh_token);

	        # get new credentials
	        $credentials = $client->getAccessToken();

	        # decode 
	        $tokens_decoded = json_decode($credentials);
	        try {
	            $refresh_token = $tokens_decoded->refresh_token;
	        } catch (Exception $e) {}

	        # save them to the database
	        $user->googleSpreadsheetCredentials = $credentials;
	        $user->googleSpreadsheetRefreshToken = $refresh_token;
	    }

	    # get the real access_token (from the big JSON one)
	    $tokens_decoded = json_decode($credentials);
	    $access_token = $tokens_decoded->access_token;

	    return $access_token;
	}


}