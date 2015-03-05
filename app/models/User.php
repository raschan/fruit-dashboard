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
        if (strlen($this->stripe_key) > 16) {
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
}
