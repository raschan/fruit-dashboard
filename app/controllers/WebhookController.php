<?php

use Abf\Event;      // needed because of conflicts with Laravel and Stripe

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
			$user = User::find($userId);
			Log::info('Incoming webhook for user: '.$user->email);
			
			$webhookNoti = Braintree_WebhookNotification::parse(
				Input::get("bt_signature"), Input::get("bt_payload")
		    );

			// format the event to the common format
		    $event = array();
		    $event['created'] = $webhookNoti->timestamp->getTimestamp();
		    

		    // converting braintree event types to stripe event types
		    try {
		    	$event['type'] = BraintreeHelper::setEventType($webhookNoti->kind);
		    } catch (Exception $e) {
		    	Log::info('New type of event is introduced: '.$webhookNoti->kind);
		    	$event['type'] = $webhookNoti->kind;
		    }


		    // convert braintree object to stripe object
		    try {
		    	$event['data']['object'] = BraintreeHelper::convertObjectFormat($webhookNoti->subject, $event['type']);
		    } catch (Exception $e) {
		    	Log::error($e);
		    	$event['data']['object'] = null;
		    }

		    // save the new event
			$newEvent = new Event;

            $newEvent->date                 = date('Y-m-d', $event['created']);
            $newEvent->eventID              = str_random(32);
            $newEvent->user                 = $user->id;
            $newEvent->created              = date('Y-m-d H:i:s', $event['created']);
            $newEvent->provider             = 'braintree';
            $newEvent->type                 = $event['type'];
            $newEvent->object               = json_encode($event['data']['object']);
            $newEvent->previousAttributes   = isset($event['data']['previous_attributes'])
                                                ? json_encode($event['data']['previous_attributes'])
                                                : null;
            $newEvent->save();

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