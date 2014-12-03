<?php

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Auth\Openid;

use PayPal\Auth\Openid\PPOpenIdSession;
use PayPal\Auth\Openid\PPOpenIdTokeninfo;

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
			$scope = $_GET['scope'];

			// Obtain Authorization Code from Code, Client ID and Client Secret
			$accessToken = PPOpenIdTokeninfo::createFromAuthorizationCode(array(
				'code' => $code), 
				null, 
				null, 
				$apiContext
			);
			
			// return with the extracted data	
			return View::make('dev.paypaluserinfo', array(
				'accessToken' => $accessToken,
				'scope' => $scope,
				'code' => $code
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