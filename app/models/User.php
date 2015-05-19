<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;


class User extends Eloquent implements UserInterface
{
    protected $guarded = array();
    use UserTrait;
    /**
     * Testing if the user has connected a stripe account
     *
     * @return boolean
    */
    public function isStripeConnected()
    {
        // at this point validation like this is all right
        if (strlen($this->stripe_key) > 16 
            || strlen($this->stripeUserId) > 1) {
            // long enough key
            return True;
        }
        // no key is given
        return False;
    }

     /**
     * Testing if the user has connected a paypal account
     *
     * @return boolean
    */
    public function isPayPalConnected()
    {
        // at this point validation like this is all right
        if (strlen($this->paypal_key) > 16) {
            // refreshtoken is longer than 16
            return True;
        }
        // no valid refreshtoken is stored
        return False;
    }

    /**
     * Testing if the user has connected at least one account
     *
     * @return boolean
    */
    public function isConnected()
    {
        if ($this->isStripeConnected() 
            || $this->isPayPalConnected()) 
        {
            // connected
            return True;
        }
        // not connected
        return False;
    }

    /*
    |-------------------------------------
    | Trial checking helpers
    |-------------------------------------
    */

    public function isTrialEnded()
    {
        $trialEndDate = Carbon::parse($this->created_at)->addDays($_ENV['TRIAL_ENDS_IN_X_DAYS']);

        if ($this->plan == 'trial_ended' 
            || ($this->plan == 'trial' && $trialEndDate->isPast()))
        {
            return true;
        } else {
            return false;
        }
    }

    public function trialWillEndInDays($days)
    {   
        $daysRemaining = $this->daysRemaining();

        if ($this->plan == 'trial' && $daysRemaining < $days)
        {
            return true;
        } else {
            return false;
        }
    }

    public function trialWillEndExactlyInDays($days)
    {
        $daysRemaining = $this->daysRemaining();

        if (($this->plan == 'trial' || $this->plan == 'trial_ended') && $daysRemaining == $days)
        {
            return true;
        } else {
            return false;
        }
    }

    public function daysRemaining()
    {
        $days = 100;

        $now = Carbon::now();
        $signup = Carbon::parse($this->created_at);

        $days = $now->diffInDays($signup->addDays($_ENV['TRIAL_ENDS_IN_X_DAYS']), false);

        return $days;
    }


    /*
    |------------------------------------------
    | Connected services checking
    |------------------------------------------
    */

    public function canConnectMore()
    {
        if($this->plan != 'free')
        {
            // the user is good paying customer (or trial period, whatever), 
            // let him/her connect more
            return true;
        } elseif($this->connectedServices < $_ENV['MAX_FREE_CONNECTIONS'])
        {
            // not yet reached the maximum number of allowed connections
            return true;
        } else
        {
            // the user is not paying (or trial ended), 
            // and reached maximum number of allowed connections
            // don't let more connections
            return false;
        }
    }
}
