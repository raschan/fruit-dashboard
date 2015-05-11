<?php

class BraintreeHelper {

	public static function saveSecondaryEvent($notification)
	{

	}

	public static function setEventType($kind)
	{
		Log::info('setting event type');
		switch ($kind) 
		{
	    	case 'subscription_expired':
	    		return 'customer.subscription.updated';
	    		break;

	    	case 'subscription_canceled':
	    		return 'customer.subscription.deleted';
	    		break;

	    	case 'subscription_trial_ended':
	    		return 'customer.subscription.trial_ended';
	    		break;

	    	case 'subscription_charged_successfully':
	    		return 'charge.succeeded';
	    		break;

	    	case 'subscription_charged_unsuccessfully':
	    		return 'charge.failed';
	    		break;

	    	case 'subscription_went_past_due':
	    		return 'customer.subscription.updated';
	    		break;
	    	
	    	case 'dispute_opened':
	    		return 'charge.dispute.created';
	    		break;

	    	case 'dispute_lost':
	    		return 'charge.dispute.funds_withdrawn';
	    		break;

	    	case 'dispute_won':
	    		return 'charge.dispute.funds_reinstated';
	    		break;

	    	case 'disbursement':
	    		return 'charge.succeeded';
	    		break;

	    	default:
	    		throw new Exception("New event type", 1);
	       		break;
	    }
	    Log::info('Event type set');
	}

	public static function convertObjectFormat($notification, $type, $user);
	{
		$object = array();

		switch ($type) {
			case 'customer.subscription.trial_ended':
			case 'customer.subscription.created':
			case 'customer.subscription.deleted':

				// get the plan the user is subscribed for
				$plan = self::getPlan($notification->subject->subscription->planId, $user);

				$object['object']['plan'] = array(
					'currency' 	=> $plan->currencyIsoCode,
					'interval' 	=> 'monthly',
					'name'		=> $plan->name,
					'id'		=> $plan->id,
					'amount'	=> $notification->subject->subscription->price * 100 //braintree prices are in float, e.g: 9.99
				);
				break;
			case 'charge.succeeded':
			case 'charge.failed':
				switch ($notification->kind)
					case 'disbursement':
						$object['object'] = array(
							'id' 		=> $notification->subject->disbursement->id,
							'amount' 	=> $notification->subject->disbursement->amount,
							'currency'	=> Braintree_Transaction::find($notification->subject->disbursement->transactionIds[0])
												->currencyIsoCode,
							'kind'		=> 'disbursement',
						);
						break;
					case 'subscription_charged_successfully':
					case 'subscription_charged_unsuccessfully':

						$plan = self::getPlan($notification->subject->subscription->planId, $user);
						$object['object'] = array(
							'id'		=> $notification->subject->subscription->id,
							'amount'	=> $notification->subject->subscription->price * 100,
							'currency'  => $plan->currencyIsoCode,
							'kind'		=> 'subscription',
						);
						break;
					default:
						break;
				break;
			default:
				break;
		}

		return $object;
	}

	private static function getPlan($planId, $user)
	{
		Braintree_Configuration::environment($user->btEnvironment);
    	Braintree_Configuration::merchantId($user->btPublicKey);
    	Braintree_Configuration::publicKey($user->btPrivateKey);
    	Braintree_Configuration::privateKey($user->btMerchantId);

    	$plans = Braintree_Plan::all();

        // find the correct plan to show
        // no way currently to get only one plan
        foreach ($plans as $plan) 
        {
            if($plan->id == $planId)
            {
                return $plan;
            }
        }

        return null;
	}
}