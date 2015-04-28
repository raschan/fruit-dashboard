<?php

/*
|-------------------------------------------------
| WebhookController: Handles the incoming webhooks
|-------------------------------------------------
*/
class WebhookController extends BaseController
{
	public function braintreeEvents($userId)
	{
		if (Input::has('bt_signature') && Input::has('bt_payload'))
		{
			$webhookNotification = Braintree_WebhookNotification::parse(
				Input::get("bt_signature"), Input::get("bt_payload")
		    );

		    Log::info($webhookNotification);
		}
	}

	public function verifyBraintreeWebhook($userId)
	{
		if (Input::has('bt_challenge'))
		{
			echo(Braintree_WebhookNotification::verify(Input::get('bt_challenge')));
		}
	}
}