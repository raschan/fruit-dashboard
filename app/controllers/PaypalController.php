<?php

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Auth\Openid;

use PayPal\Auth\Openid\PPOpenIdSession;

class PaypalController extends BaseController 
{
	const client_id = 'AXzgsBDDtHj6G0XUF4VFNnZY8hmtGkbB9ywVfGLsdpJCvkpDgwFCJfO_waxf';
	const client_secret = 'EPxI-BCsBeaFaZ99xj6W4_U5UGkX4yaNnUTiHaJyuZ2V0YfGcGdVRd1HV5IA';


	public function showPaypalInfo () 
	{
		
		$apiContext = new ApiContext();		

		$baseUrl = getBaseUrl() . '/UserConsentRedirect.php?success=true';
		$redirectUrl = PPOpenIdSession::getAuthorizationUrl(
    		$baseUrl,
    		array('profile', 'email', 'phone'),
    		null,
    		null,
    		null,
    		$apiContext
);

		return View::make('site.paypalinfo', array(
			'accessToken' => $accessToken
			));
	}

	public function loginWithPaypal ()
	{
	
	}
}