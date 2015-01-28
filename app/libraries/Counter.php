<?php


class Counter
{

	/**
	* Gets the Average Revenue Per active Users
	*
	* @param Stripe key
	* @param PayPal key
	*
	* @return int
	*/
	public static function getARPU($stripeKey, $paypalKey)
	{
		// get active customer count
		$activeCustomers = self::getActiveCustomers($stripeKey, $paypalKey);

		// get MRR - TEMPORARY SOLUTION!!!
		$mrr = self::getMRR();

		// count and return the ARPU
		$arpu = round($mrr / $activeCustomers);
		return $arpu;
	}


	/*
	|--------------------------------------------------------------
	| Base functions (depend only on data from Stripe/Paypal/Other)
	|--------------------------------------------------------------
	*/
	

	/**
	* MRR - Monthly Recurring Revenue
	* all recurring revenues, per month 
	* (e.g a yearly plan is divided by 12)
	* 
	* Required events/data: 
	* 	- plan details
	* 		- subscription count
	*		- plan cost
	*
	* @return int (cents)
	*/

	/**
	* Retreive data relevant to MRR and calculate the current value
	*
	* @return int (cents)
	*/

	public static function retreiveAndCalculateMRR()
    {
        // getting the plans
        $plans = TailoredData::getPlans();

        // getting current subscriptions (only active subscriptions)
        $current_subscriptions = self::getCurrentSubscriptions();

        // we'll store the relations here
        $plan_subscriptions = array();

        // dividing subscriptions among the plans and summing the mrr
        $mrr = 0;

        // getting each plan's count
        foreach ($current_subscriptions as $subscription) {
            // checking for previous data
            if (isset($plan_subscriptions[$subscription['plan_id']])) {
                // has previous data
                $plan_subscriptions[$subscription['plan_id']]++;
            } else {
                // initializing data
                $plan_subscriptions[$subscription['plan_id']] = 1;
            }
        }

        // counting the mrr
        foreach ($plan_subscriptions as $plan_id => $count) {
            $mrr += $plans[$plan_id]['amount'] * $count;
        }

        // returning int
        return $mrr;
    }

    /**
    * Save the daily MRR in database
    */

    public static function saveMRR()
    {
    	$currentDay = date('Y-m-d', time());

        // checking if we already have data
        $currentDayMRR = DB::table('mrr')
            ->where('date', $currentDay)
            ->where('user', Auth::user()->id)
            ->get();

        if (!$currentDayMRR) {
        	// no previous data
    		$mrrValue = self::retreiveAndCalculateMRR();

    		DB::table('mrr')->insert(
                array(
                    'value' => $mrrValue,
                    'user'  => Auth::user()->id,
                    'date'  => $currentDay
                )
            );
    	}
    }

    
    /**
    * Prepare MRR for statistics
    *
    * @return array
    */

    public static function showMRR($fullDataNeeded = false)
    {
    	// helpers
    	$currentDay = time();
    	$lastMonthTime = $currentDay - 30*24*60*60;
    	setlocale(LC_MONETARY,"en_US");

    	// return array
    	$mrrData = array();

    	// simple MRR data
    	// basics, what we are
    	$mrrData['id'] = 'mrr';
    	$mrrData['statName'] = 'Monthly Recurring Revenue';

        // building mrr history array
        for ($i = $currentDay-30*86400; $i < $currentDay; $i+=86400) {
        	$date = date('Y-m-d',$i);
            $mrrData['history'][$date] = self::getMRROnDay($i);
        }

        // current value, formatted for money
        $mrrData['currentValue'] = money_format('%n',self::getMRROnDay($currentDay));

        // change in timeframe
        $lastMonthValue = self::getMRROnDay($lastMonthTime);
        // check if data is available, so we don't divide by null
        if ($lastMonthValue) {
			$changeInPercent = (self::getMRROnDay($currentDay) / $lastMonthValue * 100) - 100;
			$mrrData['oneMonthChange'] = $changeInPercent . '%';
        } else {
	        $mrrData['oneMonthChange'] = null;
	    }	

    	if ($fullDataNeeded){
    		
    		// building full mrr history array
    		$firstDay = DB::table('mrr')->orderBy('date', 'asc')->first();
    		
    		$firstDay = strtotime($firstDay->date);
			$mrrData['firstDay'] = date('d-m-Y',$firstDay);	

	        for ($i = $firstDay; $i < $currentDay; $i+=86400) {
	        	$date = date('Y-m-d',$i);
	            $mrrData['fullHistory'][$date] = self::getMRROnDay($i);
	        }

    		//timestamps
    		$twoMonthTime = $currentDay - 2*30*24*60*60;
    		$threeMonthTime = $currentDay - 3*30*24*60*60;
	    	$sixMonthTime = $currentDay - 6*30*24*60*60;
	    	$nineMonthTime = $currentDay - 9*30*24*60*60;
	    	$lastYearTime = $currentDay - 365*24*60*60;
			
			// past values (null if not available)		    
			$twoMonthValue = self::getMRROnDay($twoMonthTime);
			$threeMonthValue = self::getMRROnDay($threeMonthTime);
			$sixMonthValue = self::getMRROnDay($sixMonthTime);
			$nineMonthValue = self::getMRROnDay($nineMonthTime);
			$oneYearValue = self::getMRROnDay($lastYearTime);
	
		    // MRR 30 days ago
		    $mrrData['oneMonth'] = ($lastMonthValue) ? money_format('%n', $lastMonthValue) : null;
		    // MRR 6 months ago
		    $mrrData['sixMonth'] = ($sixMonthValue) ? money_format('%n', $sixMonthValue) : null; 
			// MRR 1 year ago
			$mrrData['oneYear'] = ($oneYearValue) ? money_format('%n', $oneYearValue) : null;

			// check if data is available, so we don't divide by null
			// we have 30 days change
			
			if ($twoMonthValue) {
				$changeInPercent = (self::getMRROnDay($currentDay) / $twoMonthValue * 100) - 100;
				$mrrData['twoMonthChange'] = $changeInPercent . '%';
			} else {
				$mrrData['twoMonthChange'] = null; 
			}

			if ($threeMonthValue) {
				$changeInPercent = (self::getMRROnDay($currentDay) / $threeMonthValue * 100) - 100;
				$mrrData['threeMonthChange'] = $changeInPercent . '%';
			} else {
				$mrrData['threeMonthChange'] = null; 
			}

			if ($sixMonthValue) {
				$changeInPercent = (self::getMRROnDay($currentDay) / $sixMonthValue * 100) - 100;
				$mrrData['sixMonthChange'] = $changeInPercent . '%';
			} else {
				$mrrData['sixMonthChange'] = null; 
			}

			if ($nineMonthValue) {
				$changeInPercent = (self::getMRROnDay($currentDay) / $nineMonthValue * 100) - 100;
				$mrrData['nineMonthChange'] = $changeInPercent . '%';
			} else {
				$mrrData['nineMonthChange'] = null; 
			}

			if ($oneYearValue) {
				$changeInPercent = (self::getMRROnDay($currentDay) / $oneYearValue * 100) - 100;
				$mrrData['oneYearChange'] = $changeInPercent . '%';
			} else {
				$mrrData['oneYearChange'] = null; 
			}

			// time interval for shown statistics
			// right now, only last 30 days
			$startDate = date('d-m-Y',$lastMonthTime);
			$stopDate = date('d-m-Y',$currentDay);

			$mrrData['dateInterval'] = array(
				'startDate' => $startDate,
				'stopDate' => $stopDate
			);

			// get all the plans details
			$mrrData['detailData'] = self::getSubscriptionDetails();

			//converting price and mrr to money format
        	foreach ($mrrData['detailData'] as $id => $planDetail) {
	        	$mrrData['detailData'][$id]['price'] = money_format('%n', $planDetail['price']);
	            $mrrData['detailData'][$id]['mrr'] = money_format('%n', $planDetail['mrr']);
        	}


    	}

    	return $mrrData;
    }

	/**
	* OR - Other Revenues
	* every revenue, which not connected to recurring revenues
	* 
	* Required events/data:
	* 	- charge events
	*
	* @return int (cents)
	*/
	

	/**
	* Refunds
	* refunds on any made charge
	*
	* Required events/data:
	*	- refund events
	*
	* @return int (cents)
	*/


	/**
	* AU - Active Users
	* every user, who has atleast one live subscription
	*
	* Required events/data:
	*	- user/customer details
	*		- subscription data
	*
	* @return pos. int (heads)
	*/

	public static function getActiveCustomers()
	{
		// get all the customers
		$allCustomers = TailoredData::getCustomers();

		// return int
		$activeCustomers = 0;

		// count all, that have at least one subscription
		foreach ($allCustomers as $customer) {
			if ($customer['subscriptions']['total_count'] > 0){
				$activeCustomers++;
			}
		}

		return $activeCustomers;
	}

	/**
    * Save the daily Active Users number in database
    */

    public static function saveAU()
    {
    	$currentDay = date('Y-m-d', time());

        // checking if we already have data
        $currentDayAU = DB::table('au')
            ->where('date', $currentDay)
            ->where('user', Auth::user()->id)
            ->get();

        if (!$currentDayAU) {
        	// no previous data
    		$AUValue = self::getActiveCustomers();

    		DB::table('AU')->insert(
                array(
                    'value' => $AUValue,
                    'user'  => Auth::user()->id,
                    'date'  => $currentDay
                )
            );
    	}
    }



    public static function showActiveUsers($fullDataNeeded = false) {
	// helpers
	$currentDay = time();
	$lastMonthTime = $currentDay - 30*24*60*60;
	setlocale(LC_MONETARY,"en_US");

	// return array
	$AUData = array();

	// simple AU data
	// basics, what we are
	$AUData['id'] = 'au';
	$AUData['statName'] = 'Active Users';

    // building AU history array
    for ($i = $currentDay-30*86400; $i < $currentDay; $i+=86400) {
    	$date = date('Y-m-d',$i);
        $AUData['history'][$date] = self::getAUOnDay($i);
    }

    // current value, formatted for money
    $AUData['currentValue'] = self::getAUOnDay($currentDay);

    // change in timeframe
    $lastMonthValue = self::getAUOnDay($lastMonthTime);
    // check if data is available, so we don't divide by null
    if ($lastMonthValue) {
		$changeInPercent = (self::getAUOnDay($currentDay) / $lastMonthValue * 100) - 100;
		$AUData['oneMonthChange'] = $changeInPercent . '%';
    } else {
        $AUData['oneMonthChange'] = null;
    }	

    // full AU data
	if ($fullDataNeeded){
		//timestamps
		$twoMonthTime = $currentDay - 2*30*24*60*60;
		$threeMonthTime = $currentDay - 3*30*24*60*60;
    	$sixMonthTime = $currentDay - 6*30*24*60*60;
    	$nineMonthTime = $currentDay - 9*30*24*60*60;
    	$lastYearTime = $currentDay - 365*24*60*60;
		
		// past values (null if not available)		    
		$twoMonthValue = self::getAUOnDay($twoMonthTime);
		$threeMonthValue = self::getAUOnDay($threeMonthTime);
		$sixMonthValue = self::getAUOnDay($sixMonthTime);
		$nineMonthValue = self::getAUOnDay($nineMonthTime);
		$oneYearValue = self::getAUOnDay($lastYearTime);

	    // AU 30 days ago
	    $AUData['oneMonth'] = ($lastMonthValue) ?  $lastMonthValue : null;
	    // AU 6 months ago
	    $AUData['sixMonth'] = ($sixMonthValue) ? $sixMonthValue : null; 
		// AU 1 year ago
		$AUData['oneYear'] = ($oneYearValue) ? $oneYearValue : null;

		// check if data is available, so we don't divide by null
		// we have 30 days change
		
		if ($twoMonthValue) {
			$changeInPercent = (self::getAUOnDay($currentDay) / $twoMonthValue * 100) - 100;
			$AUData['twoMonthChange'] = $changeInPercent . '%';
		} else {
			$AUData['twoMonthChange'] = null; 
		}

		if ($threeMonthValue) {
			$changeInPercent = (self::getAUOnDay($currentDay) / $threeMonthValue * 100) - 100;
			$AUData['threeMonthChange'] = $changeInPercent . '%';
		} else {
			$AUData['threeMonthChange'] = null; 
		}

		if ($sixMonthValue) {
			$changeInPercent = (self::getAUOnDay($currentDay) / $sixMonthValue * 100) - 100;
			$AUData['sixMonthChange'] = $changeInPercent . '%';
		} else {
			$AUData['sixMonthChange'] = null; 
		}

		if ($nineMonthValue) {
			$changeInPercent = (self::getAUOnDay($currentDay) / $nineMonthValue * 100) - 100;
			$AUData['nineMonthChange'] = $changeInPercent . '%';
		} else {
			$AUData['nineMonthChange'] = null; 
		}

		if ($oneYearValue) {
			$changeInPercent = (self::getAUOnDay($currentDay) / $oneYearValue * 100) - 100;
			$AUData['oneYearChange'] = $changeInPercent . '%';
		} else {
			$AUData['oneYearChange'] = null; 
		}

		// time interval for shown statistics
		// right now, only last 30 days
		$startDate = date('d-m-Y',$lastMonthTime);
		$stopDate = date('d-m-Y',$currentDay);

		$AUData['dateInterval'] = array(
			'startDate' => $startDate,
			'stopDate' => $stopDate
		);

		// get all the plans details
		$AUData['detailData'] = self::getSubscriptionDetails();

		}

	return $AUData;
	}


	/**
	* Fees
	* all payed fees
	*
	* Required events/data:
	* 	- all events regarding spending money
	*
	* @return int (cents)
	*/


	/**
	* Cancellations
	* count of cancelled subscriptions 
	*
	* Required events/data:
	*	- cancellation events
	*
	* Must save also:
	* 	- the price difference
	*
	* @return int (pieces)
	*/


	/**
	* Downgrade
	* changing to a smaller plan
	*
	* Required events/data:
	* 	- update events, where plan cost went down
	*
	* Must save also:
	* 	- the price difference
	*
	* @return int (pieces)
	*/

	
	/**
	* Upgrades
	* changing to a bigger plan
	*
	* Required events/data:
	*	- update events, where plan cost went up
	*
	* @return int (pieces)
	*/


	/**
	* CR - Coupons Redeemed
	* income loss due to redeemed coupons
	*
	* Required events/data
	*	- Coupon/Disount data
	*
	* @return int (cents)
	*/ 


	/**
	* FC - Failed Charges
	*
	* Required events/data
	*	- charge events, which failed to be paid
	*
	* @return int (cents)
	*/


	/*
	|--------------------------------------------------------------
	| Derived functions (have dependecies on base functions)
	|--------------------------------------------------------------
	*/


	/**
	* NR - net revenue
	* MRR + OR - refunds
	* 
	* Required functions:
	*	-
	*	- MRR
	*	- Refunds
	* ORR
	* @return int (cents)
	*/


	/**
	* ARR - Annual run rate
	* MRR * 12
	*	
	* Required functions:
	* 	- MRR
	*
	* @return int (cents)
	*/

    public static function showARR($fullDataNeeded = false)
    {
    	// helpers
    	$currentDay = time();
    	$lastMonthTime = $currentDay - 30*24*60*60;
    	setlocale(LC_MONETARY,"en_US");

    	// return array
    	$arrData = array();

    	// simple MRR data
    	// basics, what we are
    	$arrData['id'] = 'arr';
    	$arrData['statName'] = 'Annual Run Rate';

        // building arr history array
        for ($i = $currentDay-30*86400; $i < $currentDay; $i+=86400) {
        	$date = date('Y-m-d',$i);
            $arrData['history'][$date] = self::getMRROnDay($i) * 12;
        }

        // current value, formatted for money
        $arrData['currentValue'] = money_format('%n',self::getMRROnDay($currentDay) * 12);

        // change in timeframe
        $lastMonthValue = self::getMRROnDay($lastMonthTime) * 12;
        // check if data is available, so we don't divide by null
        if ($lastMonthValue) {
			$changeInPercent = (self::getMRROnDay($currentDay) * 12 / $lastMonthValue * 100) - 100;
			$arrData['oneMonthChange'] = $changeInPercent . '%';
        } else {
	        $arrData['oneMonthChange'] = null;
	    }	

	    // full MRR data
    	if ($fullDataNeeded){
    		//timestamps
    		$twoMonthTime = $currentDay - 2*30*24*60*60;
    		$threeMonthTime = $currentDay - 3*30*24*60*60;
	    	$sixMonthTime = $currentDay - 6*30*24*60*60;
	    	$nineMonthTime = $currentDay - 9*30*24*60*60;
	    	$lastYearTime = $currentDay - 365*24*60*60;
			
			// past values (null if not available)		    
			$twoMonthValue = self::getMRROnDay($twoMonthTime) * 12;
			$threeMonthValue = self::getMRROnDay($threeMonthTime) * 12;
			$sixMonthValue = self::getMRROnDay($sixMonthTime) * 12;
			$nineMonthValue = self::getMRROnDay($nineMonthTime) * 12;
			$oneYearValue = self::getMRROnDay($lastYearTime) * 12;
	
		    // MRR 30 days ago
		    $arrData['oneMonth'] = ($lastMonthValue) ? money_format('%n', $lastMonthValue * 12) : null;
		    // MRR 6 months ago
		    $arrData['sixMonth'] = ($sixMonthValue) ? money_format('%n', $sixMonthValue * 12) : null; 
			// MRR 1 year ago
			$arrData['oneYear'] = ($oneYearValue) ? money_format('%n', $oneYearValue * 12) : null;

			// check if data is available, so we don't divide by null
			// we have 30 days change
			
			if ($twoMonthValue) {
				$changeInPercent = (self::getMRROnDay($currentDay) * 12 / $twoMonthValue * 100) - 100;
				$arrData['twoMonthChange'] = $changeInPercent . '%';
			} else {
				$arrData['twoMonthChange'] = null; 
			}

			if ($threeMonthValue) {
				$changeInPercent = (self::getMRROnDay($currentDay) * 12 / $threeMonthValue * 100) - 100;
				$arrData['threeMonthChange'] = $changeInPercent . '%';
			} else {
				$arrData['threeMonthChange'] = null; 
			}

			if ($sixMonthValue) {
				$changeInPercent = (self::getMRROnDay($currentDay) * 12 / $sixMonthValue * 100) - 100;
				$arrData['sixMonthChange'] = $changeInPercent . '%';
			} else {
				$arrData['sixMonthChange'] = null; 
			}

			if ($nineMonthValue) {
				$changeInPercent = (self::getMRROnDay($currentDay) * 12 / $nineMonthValue * 100) - 100;
				$arrData['nineMonthChange'] = $changeInPercent . '%';
			} else {
				$arrData['nineMonthChange'] = null; 
			}

			if ($oneYearValue) {
				$changeInPercent = (self::getMRROnDay($currentDay) * 12 / $oneYearValue * 100) - 100;
				$arrData['oneYearChange'] = $changeInPercent . '%';
			} else {
				$arrData['oneYearChange'] = null; 
			}

			// time interval for shown statistics
			// right now, only last 30 days
			$startDate = date('d-m-Y',$lastMonthTime);
			$stopDate = date('d-m-Y',$currentDay);

			$arrData['dateInterval'] = array(
				'startDate' => $startDate,
				'stopDate' => $stopDate
			);

			// get all the plans details
			$arrData['detailData'] = self::getSubscriptionDetails();

			//converting price and mrr to money format
        	foreach ($arrData['detailData'] as $id => $planDetail) {
	        	$arrData['detailData'][$id]['price'] = money_format('%n', $planDetail['price']);
	            $arrData['detailData'][$id]['mrr'] = money_format('%n', $planDetail['mrr'] * 12);
        	}

    	}

    	return $arrData;
    }

	/**
	* ARPU - Average Revenue Per active Users
	* MRR / active users
	*
	* Required functions:
	*	- MRR
	*	- AU
	*
	* @return int (cents)
	*/

	public static function showARPU($fullDataNeeded = false)
    {
    	// helpers
    	$currentDay = time();
    	$lastMonthTime = $currentDay - 30*24*60*60;
    	setlocale(LC_MONETARY,"en_US");

    	// return array
    	$arpuData = array();

    	// simple arpu data
    	// basics, what we are
    	$arpuData['id'] = 'arpu';
    	$arpuData['statName'] = 'Average Revenue Per User';

        // building arpu history array
        for ($i = $currentDay-30*86400; $i < $currentDay; $i+=86400) {
        	$date = date('Y-m-d',$i);
            $arpuData['history'][$date] = self::getarpuOnDay($i);
        }

        // current value, formatted for money
        $arpuData['currentValue'] = money_format('%n',self::getarpuOnDay($currentDay));

        // change in timeframe
        $lastMonthValue = self::getarpuOnDay($lastMonthTime);
        // check if data is available, so we don't divide by null
        if ($lastMonthValue) {
			$changeInPercent = (self::getarpuOnDay($currentDay) / $lastMonthValue * 100) - 100;
			$arpuData['oneMonthChange'] = $changeInPercent . '%';
        } else {
	        $arpuData['oneMonthChange'] = null;
	    }	

	    // full arpu data
    	if ($fullDataNeeded){
    		//timestamps
    		$twoMonthTime = $currentDay - 2*30*24*60*60;
    		$threeMonthTime = $currentDay - 3*30*24*60*60;
	    	$sixMonthTime = $currentDay - 6*30*24*60*60;
	    	$nineMonthTime = $currentDay - 9*30*24*60*60;
	    	$lastYearTime = $currentDay - 365*24*60*60;
			
			// past values (null if not available)		    
			$twoMonthValue = self::getarpuOnDay($twoMonthTime);
			$threeMonthValue = self::getarpuOnDay($threeMonthTime);
			$sixMonthValue = self::getarpuOnDay($sixMonthTime);
			$nineMonthValue = self::getarpuOnDay($nineMonthTime);
			$oneYearValue = self::getarpuOnDay($lastYearTime);
	
		    // arpu 30 days ago
		    $arpuData['oneMonth'] = ($lastMonthValue) ? money_format('%n', $lastMonthValue) : null;
		    // arpu 6 months ago
		    $arpuData['sixMonth'] = ($sixMonthValue) ? money_format('%n', $sixMonthValue) : null; 
			// arpu 1 year ago
			$arpuData['oneYear'] = ($oneYearValue) ? money_format('%n', $oneYearValue) : null;

			// check if data is available, so we don't divide by null
			// we have 30 days change
			
			if ($twoMonthValue) {
				$changeInPercent = (self::getarpuOnDay($currentDay) / $twoMonthValue * 100) - 100;
				$arpuData['twoMonthChange'] = $changeInPercent . '%';
			} else {
				$arpuData['twoMonthChange'] = null; 
			}

			if ($threeMonthValue) {
				$changeInPercent = (self::getarpuOnDay($currentDay) / $threeMonthValue * 100) - 100;
				$arpuData['threeMonthChange'] = $changeInPercent . '%';
			} else {
				$arpuData['threeMonthChange'] = null; 
			}

			if ($sixMonthValue) {
				$changeInPercent = (self::getarpuOnDay($currentDay) / $sixMonthValue * 100) - 100;
				$arpuData['sixMonthChange'] = $changeInPercent . '%';
			} else {
				$arpuData['sixMonthChange'] = null; 
			}

			if ($nineMonthValue) {
				$changeInPercent = (self::getarpuOnDay($currentDay) / $nineMonthValue * 100) - 100;
				$arpuData['nineMonthChange'] = $changeInPercent . '%';
			} else {
				$arpuData['nineMonthChange'] = null; 
			}

			if ($oneYearValue) {
				$changeInPercent = (self::getarpuOnDay($currentDay) / $oneYearValue * 100) - 100;
				$arpuData['oneYearChange'] = $changeInPercent . '%';
			} else {
				$arpuData['oneYearChange'] = null; 
			}

			// time interval for shown statistics
			// right now, only last 30 days
			$startDate = date('d-m-Y',$lastMonthTime);
			$stopDate = date('d-m-Y',$currentDay);

			$arpuData['dateInterval'] = array(
				'startDate' => $startDate,
				'stopDate' => $stopDate
			);

			// get all the plans details
			$arpuData['detailData'] = self::getSubscriptionDetails();

			//converting price and arpu to money format
        	foreach ($arpuData['detailData'] as $id => $planDetail) {
	        	$arpuData['detailData'][$id]['price'] = money_format('%n', $planDetail['price']);
	            $arpuData['detailData'][$id]['mrr'] = money_format('%n', $planDetail['mrr']);
        	}


    	}

    	return $arpuData;
    }


	/**
	* UC - User Churn
	* Cancellations / (Last month Active Users) * 100
	*
	* Required functions:
	*	- Cancellations
	* 	- AU 30 days before
	*
	* @return int (percent)
	*/


	/** 
	* LV - Lifetime Value
	* the average 'usefullness' of users
	* (Average Revenue Per User) / (User Churn)
	*
	* Required functions:
	*	- ARPU
	*	- UC
	*
	* @return int (cents/percent) 
	*/


	/** 
	* RC - Revenue Churn
	* (MRR loss due to cancellations and downgrades) / (last month MRR) * 100
	*
	* Required functions:
	* 	- MRR (30 days before)
	*	- price difference of cancellations
	*	- price difference of downgrades
	*
	* @return int (percent)
	*/


	/*
	|------------------------------------------------------------
	| Other helper functions
	|------------------------------------------------------------
	*/

	/**
    * Get Average Revenue Per Users on given day
    *
    * @param timestamp, current day timestamp
    * 
    * @return int (cents) or null if data not exist
    */

	private static function getarpuOnDay($timestamp)
    {
    	if (self::getAUOnDay($timestamp)){
    		return self::getMRROnDay($timestamp) / self::getAUOnDay($timestamp);
    	}
    	else {
    		return null;
    	}
    	
    }

	/**
    * Get Active User details
    *
    * 
    * @return array
    */

    private static function getAUDetails()
    {
    	$day = date('Y-m-d', $timestamp);

    	$au = DB::table('au')
    		->where('date',$day)
    		->where('user', Auth::user()->id)
    		->get();

    	if($au){
    		return $au[0]->value;
    	} else {
			return null;
    	}
    }

	/**
    * Get Active Users on given day
    *
    * @param timestamp, current day timestamp
    * 
    * @return int (cents) or null if data not exist
    */

    private static function getAUOnDay($timestamp)
    {
    	$day = date('Y-m-d', $timestamp);

    	$au = DB::table('au')
    		->where('date',$day)
    		->where('user', Auth::user()->id)
    		->get();

    	if($au){
    		return $au[0]->value;
    	} else {
			return null;
    	}
    }

	/**
    * Get MRR on given day
    *
    * @param timestamp, current day timestamp
    * 
    * @return int (cents) or null if data not exist
    */

    private static function getMRROnDay($timestamp)
    {
    	$day = date('Y-m-d', $timestamp);

    	$mrr = DB::table('mrr')
    		->where('date',$day)
    		->where('user', Auth::user()->id)
    		->get();

    	if($mrr){
    		return $mrr[0]->value;
    	} else {
			return null;
    	}
    }

	/**
     * Getting all the subscriptions.
     *
     * @return an array with the active subscriptions
    */
    private static function getCurrentSubscriptions()
    {
        // intializing out array
        $active_subscriptions = array();

        // getting the customers
        $customers = TailoredData::getCustomers();

        // getting the active subscriptions for a customer
        foreach ($customers as $customer) {

            // going through each subscription if any
            if ($customer['subscriptions']['total_count'] > 0) {
                // there are some subs
                foreach ($customer['subscriptions']['data'] as
                         $subscription) {
                    // updating array

                    /*
                    plan
                        id - string
                    start       - timestamp, subscription start date
                    status      - string, possible values are: 
                                    'trialing'
                                    'active'
                                    'past_due'
                                    'canceled'
                                    'unpaid'
                    quantity    - int
                    */

                    // only count subscriptions, that are active
                    if ($subscription['status'] == 'active')
                    {
	                    $active_subscriptions[$subscription['id']] =
	                        array(
	                            'plan_id'  => $subscription['plan']['id']
	                        );
	                }
                } // foreach subscriptions
            } // if subscriptions
        } // foreach customer

        return $active_subscriptions;
    }

    private static function getSubscriptionDetails()
    {
    	// get all active subscriptions
    	$currentSubscriptions = self::getCurrentSubscriptions();

    	// get all plans
    	$plans = TailoredData::getPlans();

    	// we'll store the details here
        $planDetails = array();

        // getting plan details
        foreach ($plans as $id => $plan) {
        	$planDetails[$id] = array(
        		'name' => $plan['name'],
        		'price' => $plan['amount'],
        		'currency' => $plan['currency'],
        		'interval' => $plan['interval'],
        		'count' => 0,
        		'mrr' => 0
        	);
        }
        // getting each plan's count and mrr contribution
        foreach ($currentSubscriptions as $subscription) {
        	$planDetail = $planDetails[$subscription['plan_id']];
            $planDetail['count']++;
            $planDetail['mrr'] = $planDetail['price'] * $planDetail['count'];
            $planDetails[$subscription['plan_id']] = $planDetail;
        }

	    // returning int
        return $planDetails;
    }
}