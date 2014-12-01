<?php

use PayPal\Auth\OAuthTokenCredential;

class PaypalController extends BaseController 
{
	const client_id = 'AXzgsBDDtHj6G0XUF4VFNnZY8hmtGkbB9ywVfGLsdpJCvkpDgwFCJfO_waxf';
	const client_secret = 'EPxI-BCsBeaFaZ99xj6W4_U5UGkX4yaNnUTiHaJyuZ2V0YfGcGdVRd1HV5IA';


	public function showPaypalInfo () 
	{
		$oauthCredential = new OAuthTokenCredential(self::client_id,self::client_secret);
		$accessToken = $oauthCredential->getAccessToken(array('mode' => 'sandbox'));

		return View::make('site.paypalinfo', array(
			'accessToken' => $accessToken
			));
	}

	public function loginWithPaypal ()
	{
	
	}
}