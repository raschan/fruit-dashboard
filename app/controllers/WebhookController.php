<?php

/*
|-------------------------------------------------
| WebhookController: Handles the incoming webhooks
|-------------------------------------------------
*/
class AuthController extends BaseController
{
	public function braintreeEvents($userId)
	{
		$user = Auth::find($userId);
	}

	public function verifyBraintreeWebhook($userId)
	{
		if (Input::has('bt_challenge'))
		{
			echo(Braintree_WebhookNotification::verify(Input::get('bt_challenge')));
		}
	}
}