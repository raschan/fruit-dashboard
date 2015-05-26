<?php

use Abf\Event;      // needed because of conflicts with Laravel and Stripe

/*
|-------------------------------------------------
| WebhookController: Handles the incoming webhooks
|-------------------------------------------------
*/
class WebhookController extends BaseController
{
	public function braintreeEvents($webhookId)
	{
		if (Input::has('bt_signature') && Input::has('bt_payload'))
		{
			$user = User::where('btWebhookId','=',$webhookId)
					->first();
			Log::info('Incoming webhook for user: '.$user->email);
			
			$notification = Braintree_WebhookNotification::parse(
				Input::get("bt_signature"), Input::get("bt_payload")
		    );

			    $event = array();

			// format the event to the common format
		    $event['created'] = $notification->timestamp->getTimestamp();
		    

		    // converting braintree event types to stripe event types
		    try {
		    	$event['type'] = BraintreeHelper::setEventType($notification->kind);
		    } catch (Exception $e) {
		    	Log::info('New type of event is introduced: '.$notification->kind);
		    	$event['type'] = $notification->kind;
		    }


		    // convert braintree object to stripe object
		    try {
		    	$event['data'] = BraintreeHelper::convertObjectFormat($notification, $event['type'], $user);
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
            $newEvent->original				= json_encode($notification);
            $newEvent->save();
		}
	}

	public function verifyBraintreeWebhook($webhookId)
	{
		if (Input::has('bt_challenge'))
		{
			$user = User::where('btWebhookId','=',$webhookId)
					->first();
			if($user)
			{
				BraintreeHelper::setBraintreeCredentials($user);

				$user->btWebhookConnected = true;
				$user->save();
				echo(Braintree_WebhookNotification::verify(Input::get('bt_challenge')));
			} else {
				echo('no such user');
			}
		} else {
			echo('not a challenge');
		}
	}
}