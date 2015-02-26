<?php

class AUStat extends BaseStat {

    /**
    * calculate today's AU from yesterday value and changes
    * relevant changes:
    *   - customer created
    *   - customer deleted
    *
    * @param yesterday's value
    * @param today's changes
    *
    * @return int
    */

    public static function calculate($yesterdayAU, $events)
    {
        // return var
        $todayAU = $yesterdayAU;
        // for every event
        foreach ($events as $event) {
            // check, if event is relevant for the value 
            switch ($event->type) {
                case 'customer.created':
                    // new customer created, increase AU
                    $todayAU++;
                    break;
                
                case 'customer.deleted':
                    // customer deleted, decrease AU
                    $todayAU--;
                    break;

                default:
                    // do nothing
            } // end switch
        } // end foreach

        return $todayAU;
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
