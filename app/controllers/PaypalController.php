<?php

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Auth\Openid;

use PayPal\Auth\Openid\PPOpenIdSession;
use PayPal\Auth\Openid\PPOpenIdTokeninfo;
use PayPal\Auth\Openid\PPOpenIdUserInfo;

use PayPal\Validation\JsonValidator;

class PaypalController extends BaseController 
{
	const client_id = 'AXzgsBDDtHj6G0XUF4VFNnZY8hmtGkbB9ywVfGLsdpJCvkpDgwFCJfO_waxf';
	const client_secret = 'EPxI-BCsBeaFaZ99xj6W4_U5UGkX4yaNnUTiHaJyuZ2V0YfGcGdVRd1HV5IA';


/*
	test for connecting to Paypal servers through the API
	returns the access token in the view
*/
	public function showPaypalInfo () 
	{
		
		// make API context
		$apiContext = $this->getApiContext();
		$accessToken = $apiContext->getCredential()->getAccessToken(array('mode'=>'sandbox'));
		return View::make('dev.paypalinfo', array(
			'accessToken' => $accessToken
			));
	}
/*
	gets user consent
*/

	public function loginWithPaypal ()
	{
		$apiContext = $this->getApiContext();

		// building the return link
		$baseUrl = $this->getBaseUrl() . '/paypaluserinfo?success=true';
		$redirectUrl = PPOpenIdSession::getAuthorizationUrl(
    		$baseUrl,
    		array('profile', 'email', 'phone'),
    		null,
    		null,
    		null,
    		$apiContext
		);

		return Redirect::secure($redirectUrl);

	}

/*
	user consent redirect url, and show user information
*/
	public function showUserInfo ()
	{
		$apiContext = $this->getApiContext();

		if (isset($_GET['success']) && $_GET['success'] == 'true') {

			$code = $_GET['code'];

			$user = Auth::user();
			$user->paypal_key = $code;
			$user->save();

			/*
			get access_token - start
			*/
			
			// Obtain Authorization Code from Code, Client ID and Client Secret
			$tokenInfo = PPOpenIdTokeninfo::createFromAuthorizationCode(array(
				'code' => $user->paypal_key), 
				null, 
				null, 
				$apiContext
			);

			if(!is_array($tokenInfo) && JsonValidator::validate($tokenInfo))
			{
				// tokenInfo is not Array and is Json
				$tokenInfoArray = json_decode($tokenInfo,true);
			}

			/*
			get access_token - stop
			*/
			
			// get user information
			$user = PPOpenIdUserinfo::getUserinfo(
				array(
					'access_token' => $tokenInfoArray['access_token']
				), $apiContext
			);

			if(!is_array($user) && JsonValidator::validate($user))
			{
				// tokenInfo is not Array and is Json
				$userArray = json_decode($user,true);
			}

			// return with the extracted data	
			return View::make('dev.paypaluserinfo', array(
				'user_info' => $userArray
			));
		}
	}

/* returns the app's base URL */
	private function getBaseUrl()
	{
		return 'http://localhost:8001';
	}

/* return the apiContext */
	private function getApiContext()
	{
		$apiContext = new ApiContext(new OAuthTokenCredential(self::client_id,self::client_secret));
		$apiContext->setConfig(
	    	array(
	    		'mode' => 'sandbox',
	    		'http.ConnectionTimeOut' => 30,
	    		'log.LogEnabled' => true,
	    		'log.FileName' => '../PayPal.log',
	    		'log.LogLevel' => 'FINE',
	    		'validation.level' => 'log'
		));

		return $apiContext;
	}
}
