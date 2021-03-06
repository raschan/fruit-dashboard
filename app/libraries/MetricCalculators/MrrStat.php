<?php

use Abf\Event;      // needed because of conflicts with Laravel and Stripe

class MrrStat extends BaseStat {

    const POSITIVE_IS_GOOD = true;
    /**
    * calculate today's MRR from yesterday value and changes
    * relevant changes:
    *   - subscription created
    *   - subscription cancelled
    *   - subscription updated
    *
    * @param base value
    * @param current day's changes
    * @param direction of calculation (+1 forwards, -1 backwards)
    *
    * @return int
    */

    public static function calculate($baseMRR, $events, $direction = 1)
    {
        // return var
        $currentMRR = $baseMRR;

        // for every event
        foreach ($events as $event) {
            // check, if event is relevant for the value 
            switch ($event->type) {
                case 'customer.subscription.created':
                    // subscription created, increase MRR
                    $tempArray = json_decode(strstr($event->object, '{'), true);
                    $changeValue = Calculator::getMRRContribution($tempArray['plan']);

                    // check if there is a problem
                    if (!is_null($changeValue))
                    {
                        // no problems here, add the contribution to yesterdayMRR
                        $currentMRR += $changeValue * $direction;
                    } else {
                        // do some error handling here
                    }
                    break;
                
                case 'customer.subscription.deleted':
                    // subscription deleted, decrease MRR
                    $tempArray = json_decode(strstr($event->object, '{'), true);

                    $changeValue = Calculator::getMRRContribution($tempArray['plan']);

                    // check if there is a problem
                    if (!is_null($changeValue))
                    {
                        // no problems here, add the contribution to yesterdayMRR
                        $currentMRR -= $changeValue * $direction;
                    } else {
                        // do some error handling here
                    }
                    break;

                case 'customer.subscription.updated':
                    // subscription changed
                    $newValues = json_decode(strstr($event->object, '{'), true);
                    $previousValues = json_decode(strstr($event->previousAttributes, '{'), true);

                    // check, if its a change in subscription, or just a renewal
                    if(isset($previousValues['plan']))
                    {
                        // decrease MRR with previous amount
                        $changeValue = Calculator::getMRRContribution($previousValues['plan']);
                        // check if there is a problem
                        if (!is_null($changeValue))
                        {
                            // no problems here, decrease MRR with previous value
                            $currentMRR -= $changeValue * $direction;
                        } else {
                            // do some error handling here
                        }

                        // increase MRR with new amount
                        $changeValue = Calculator::getMRRContribution($newValues['plan']);
                        // check if there is a problem
                        if (!is_null($changeValue))
                        {
                            // no problems here, increase MRR with new value
                            $currentMRR += $changeValue * $direction;
                        } else {
                            // do some error handling here
                        }
                    }
                    break;

                default:
                    // do nothing
            } // end switch
        } // end foreach

        return $currentMRR;
    }



    /**
    * calculate today's MRR for the first time
    * @param customers array
    *
    * @return int
    */

    public static function calculateFirstTime($customers)
    {
        // return value
        $currentMRR = 0;

        // go through each customer
        foreach ($customers as $customer) {
            // go through a customers each subscription
            foreach ($customer['subscriptions'] as $subscription) {
                // get the MRR contribution of the subscription, and
                // add it to the total
                $currentMRR += Calculator::getMRRContribution($subscription['plan']);   
            }
        }

        return $currentMRR;
    }

    /**
    * calculates MRR history after connection
    * 
    * @param current day's timestamp
    * @param user
    * @param date of first event
    * @param starting point
    *
    * @return array of int
    */

    public static function calculateHistory($timestamp, $user, $firstDate, $baseMRR)
    {
        // return array
        $historyMRR = array();

        $currentDate = date('Y-m-d', $timestamp);
        // save the first one
        $historyMRR[date('Y-m-d',$timestamp)] = $baseMRR;
        
        while ($timestamp >= strtotime($firstDate)) 
        {

            $events = Event::where('user', $user->id)
                            ->where('date', $currentDate)
                            ->get();

            // set the new current time
            $timestamp -= 86400;
            $currentDate = date('Y-m-d', $timestamp);
            $historyMRR[$currentDate] = self::calculate($baseMRR, $events, -1);

            // set the new base value
            $baseMRR = $historyMRR[$currentDate];
        }
        return $historyMRR;
    }

    /**
    * Prepare MRR for statistics
    *
    * @param boolean
    *
    * @return array
    */

    public static function show($metrics, $fullDataNeeded = false)
    {
        // defaults
        self::$statName = 'Monthly Recurring Revenue';
        self::$statID = 'mrr';


    	$data = array();

        // full MRR data
    	if ($fullDataNeeded){

    		$data = self::showFullStat($metrics);

            // correction of the money to dollars from cents
            foreach($data['fullHistory'] as $date => $value)
            {   
                if ($value) {
                    $data['fullHistory'][$date] = $value / 100;
                }
            }

            
    	} else {
            $data = self::showSimpleStat($metrics);
        }

        if (isset($data['history']))
        {
            foreach($data['history'] as $date => $value)
            {   
                if ($value) {
                    $data['history'][$date] = $value / 100;
                }
            }
        } else {
            $data['history'] = array();
        }
        
        // converting to money format
        $data = self::toMoneyFormat($data, $fullDataNeeded);
    	
        return $data;
    }

}
