<?php

class AUStat extends BaseStat {

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
                $AUData['detailData'] = Counter::getSubscriptionDetails(Auth::user());

            }

        return $AUData;
        }

}
