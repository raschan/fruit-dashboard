<?php


/*
|--------------------------------------------------------------------------
| PaymentController: Handles the payment related sites and stuff
|--------------------------------------------------------------------------
*/
class PaymentController extends BaseController
{
	// Get the id => name pairs for all plans we currently have
	private function planDictionary()
	{
		$planDict = array();

		$plans = Braintree_Plan::all();

        // find the correct plan to show
        // no way currently to get only one plan
        foreach ($plans as $plan) 
        {
            $planDict[snake_case(camel_case($plan->name))] = $plan;
        }
		return $planDict;
	}

	public function showPlans()
    {
    	$plans = Braintree_Plan::all();

        return View::make('payment.plan',array(
            'plans' => $plans
        ));
    }


    public function showPayPlan($planName)
    {
        try {
            $customer = Braintree_Customer::find('fruit_analytics_user_'.Auth::user()->id);
        }
        catch(Braintree_Exception_NotFound $e) {
            // no such customer yet, lets make it

            $result = Braintree_Customer::create(array(
                'id'        => 'fruit_analytics_user_'.Auth::user()->id,
                'email'     => Auth::user()->email,
                'firstName' => Auth::user()->email,
            ));
            if($result->success)
            {
                $customer = $result->customer;
            } else {
                // needs error handling
            }
        }

        // generate clientToken for the user to make payment
        $clientToken = Braintree_ClientToken::generate(array(
            "customerId" => $customer->id
        ));
        
        $plans = $this->planDictionary();

        return View::make('payment.payplan', array(
            'planName'      =>$plans[$planName]->name,
            'clientToken'   =>$clientToken,
        )); 
    }

	public function doPayPlan($planName)
    {
        if(Input::has('payment_method_nonce'))
        {
            // get the detials of the plan
            $plans = Braintree_Plan::all();

            $user = Auth::user();
            

            // lets see, if the user already has a subscripton
            if ($user->subscriptionId)
            {
                try
                {
                    $result = Braintree_Subscription::cancel($user->subscriptionId);
                }
                catch (Exception $e)
                {
                    return Redirect::route('payment.plan')
                    ->with('error',"Couldn't process subscription, try again later.");
                }
            }   
            
            $plans = $this->planDictionary();

            // create the new subscription
            $result = Braintree_Subscription::create(array(
                'planId'                => $plans[$planName]->id,
                'paymentMethodNonce'    => Input::get('payment_method_nonce'),
            ));
            
            if($result->success)
            {
                // update user plan to subscrition
                $user->plan = $plans[$planName]->id;
                $user->subscriptionId = $result->subscription->id;
                $user->save();

                IntercomHelper::subscribed($user,$plans[$planName]->name);

                return Redirect::route('auth.dashboard')
                    ->with('success','Subscribed to '.$plans[$planName]->name);
            } else {
                return Redirect::route('payment.plan')
                    ->with('error',"Couldn't process subscription, try again later.");
            }
        }
    }


    public function doCancelSubscription()
    {
        $user = Auth::user();

        if ($user->subscriptionId)
        {
            try
            {
                $result = Braintree_Subscription::cancel($user->subscriptionId);
            }
            catch (Exception $e)
            {
                Log::error("Couldn't process cancellation with subscription ID: ".$user->subscriptionId."(user email: ".$user->email);
                return Redirect::back()
                    ->with('error',"Couldn't process cancellation, try again later.");
            }

            $user->subscriptionId = '';
            $user->plan = 'free';

            $user->save();

            IntercomHelper::cancelled($user);

            return Redirect::route('payment.plan')
                ->with('success','Unsubscribed successfully');
        } else {
            Redirect::back()
                ->with('error','No valid subscription');
        }
    }
}