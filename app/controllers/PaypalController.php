<?php

use PayPal\Auth\OAuthTokenCredential;

class PaypalController extends BaseController 
{
	public function showPaypalInfo () 
	{
		$oauthCredential = new OAuthTokenCredential("AXzgsBDDtHj6G0XUF4VFNnZY8hmtGkbB9ywVfGLsdpJCvkpDgwFCJfO_waxf"
													,"EPxI-BCsBeaFaZ99xj6W4_U5UGkX4yaNnUTiHaJyuZ2V0YfGcGdVRd1HV5IA");
		$accessToken = $oauthCredential->getAccessToken(array('mode' => 'sandbox'));

		return View::make('site.paypalinfo', array(
			'accessToken' => $accessToken
			));
	}
}