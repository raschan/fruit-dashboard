<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface
{
    use UserTrait;

    /**
     * Getting all the charges from
     *
     * @return an array with the charges
    */
    public function getCharges()
    {
        $out_charges = array();
        // the function has two
        if ($this->stripe_key) {
            // telling stripe who we are
            Stripe::setApiKey($this->stripe_key);

            // getting the charges
            $returned_object = Stripe_Charge::all();

            // extractin json (this is not the best approach)
            $charges = json_decode(strstr($returned_object, '{'), true);

            // getting relevant fields
            foreach ($charges['data'] as $charge) {
                // updating array
                array_push(
                    $out_charges,
                    array(
                        'id' => $charge['id'],
                        'created' => $charge['created'],
                        'amount' => $charge['amount'],
                        'currency' => $charge['currency'],
                        'paid' => $charge['paid'],
                        'captured' => $charge['captured'],
                        'description' => $charge['description'],
                        'statement_description' => $charge['statement_description'],
                        'failure_code' => $charge['failure_code']
                    )
                );
            }
        } else {
            // paypal
        }
        // returning object
        return $out_charges;
    }
}
