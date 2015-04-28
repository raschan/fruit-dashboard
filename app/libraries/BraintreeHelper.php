<?php

class BraintreeHelper {

	public static function saveSecondaryEvent($notification)
	{

	}

	public static function setEventType($kind)
	{
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
	    		return 'customer.subscription.updated';
	    		break;

	    	case 'subscription_charged_unsuccessfully':
	    		return 'customer.subscription.updated';
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
	}

	public static function convertObjectFormat($subject, $type);
	{
		$formatted_object = null;

		switch ($type) {
			case 'customer.subscription.deleted':
				$formatted_object = json_encode($subject);
				break;
			
			default:
				# code...
				break;
		}

		return $formatted_object;
	}
}