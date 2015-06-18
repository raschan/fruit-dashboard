<?php

class GoogleSpreadsheetHelper {

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

			// $client = GoogleSpreadsheetHelper::setGoogleClient();
			// $access_token = GoogleSpreadsheetHelper::getGoogleAccessToken($client, $user);
			// $guzzle_client = new GuzzleHttp\Client();
			// $response = $guzzle_client->get("https://accounts.google.com/o/oauth2/revoke?token=".$user->googleSpreadsheetRefreshToken);

			$user->googleSpreadsheetRefreshToken = "";
			$user->googleSpreadsheetCredentials = "";
			$user->googleSpreadsheetEmail = "";
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