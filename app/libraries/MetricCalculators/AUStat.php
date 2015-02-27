<?php

use Abf\Event;      // needed because of conflicts with Laravel and Stripe


class AUStat extends BaseStat {

    /**
    * calculate today's AU from yesterday value and changes
    * relevant changes:
    *   - customer created
    *   - customer deleted
    *
    * @param yesterday's value
    * @param today's changes
    * @param direction of calculation (+1 forwards, -1 backwards)
    *
    * @return int
    */

    public static function calculate($baseAU, $events, $direction = 1)
    {
        // return var
        $currentAU = $baseAU;
        // for every event
        foreach ($events as $event) {
            // check, if event is relevant for the value 
            switch ($event->type) {
                case 'customer.created':
                    // new customer created, increase AU
                    $currentAU += $currentAU * $direction;
                    break;
                
                case 'customer.deleted':
                    // customer deleted, decrease AU
                    $currentAU -= $currentAU * $direction;
                    break;

                default:
                    // do nothing
            } // end switch
        } // end foreach

        return $currentAU;
    }

    /**
    * calculates AU history after connection
    * 
    * @param current day's timestamp
    * @param user
    * @param date of first event
    * @param starting point
    *
    * @return array of int
    */

    public static function calculateHistory($timestamp, $user, $firstDate, $baseAU)
    {
        // return array
        $historyAU = array();

        // save the first one
        $historyAU[date('Y-m-d',$timestamp)] = $baseAU;
        
        // change to yesterday
        $timestamp -= 86400;

        while ($timestamp >= strtotime($firstDate)) 
        {
            $currentDate = date('Y-m-d', $timestamp);

            $events = Event::where('user', $user->id)
                            ->where('date', $currentDate)
                            ->get();

            $historyAU[$currentDate] = self::calculate($baseAU, $events, -1);

            // set the new base value
            $baseAU = $historyAU[$currentDate];
            // set the new current time
            $timestamp -= 86400;
        }
        return $historyAU;
    }


    /**
    * Prepare Active Users for statistics
    *
    * @param boolean
    *
    * @return array
    */

    public static function showAU($fullDataNeeded = false) {
        // defaults
        self::$statName = 'Active Users';
        self::$statID = 'au';

        // return array
        $AUData = array();
        $AUData = self::showSimpleStat();

        // full AU data
        if ($fullDataNeeded){

            $AUData = self::showFullStat();

            // data for single stat table
            $AUData['detailData'] = Calculator::getSubscriptionDetails(Auth::user());

        }

        return $AUData;
    }

}
