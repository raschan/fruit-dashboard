<?php

/*
|--------------------------------------------------------------------------
| DemoController: Handles the demo sites
|--------------------------------------------------------------------------
*/

class DemoController extends BaseController
{
    /*
    |===================================================
    | <GET> | showDashboard: renders the dashboard page
    |===================================================
    */
    public function showDashboard()
    {
        if (Auth::check()) {
            return Redirect::route('auth.connect');
        } 
        else {
            try { 
                $user = User::find(1);
                Auth::login($user);

                $allMetrics = array();

                // get the metrics we are calculating right now
                $currentMetrics = Calculator::currentMetrics();

                $metricValues = Metric::where('user', Auth::user()->id)
                                        ->where('date','<',Carbon::now())
                                        ->orderBy('date','desc')
                                        ->take(31)
                                        ->get();
                foreach ($currentMetrics as $statID => $statDetails) {

                    $metricsArray = array();
                    foreach ($metricValues as $metric) {
                        $metricsArray[$metric->date] = $metric->$statID;
                    }
                    $allMetrics[] = $statDetails['metricClass']::show($metricsArray);
                }


                return View::make(
                    'demo.dashboard',
                    array(
                        'allFunctions' => $allMetrics,
                        'events' => Calculator::formatEvents(Auth::user()),
                        Auth::logout()
                    )
                );
            }

            catch (Exception $e) {
                Auth::logout();
                Log::error($e);
                return Redirect::route('auth.signup')
                        ->with('error', 'Something went wrong, we will return shortly.');
            }

        }
    }

    /*
    |===================================================
    | <GET> | showSinglestat: renders the single stats page
    |===================================================
    */
    public function showSinglestat($statID)
    {   if (Auth::check()) {
            return Redirect::route('auth.connect');
        } 
        else {
            try {
                $user = User::find(1);
                Auth::login($user);

                $currentMetrics = Calculator::currentMetrics();
                $metricValues = Metric::where('user', Auth::user()->id)
                                        ->where('date','<',Carbon::now())
                                        ->orderBy('date','desc')
                                        ->take(31)
                                        ->get();
                foreach ($currentMetrics as $metricID => $statClassName) {
                    if($metricID == $statID){
                        $metricsArray = array();
                        foreach ($metricValues as $metric) {
                            $metricsArray[$metric->date] = $metric->$metricID;
                        }
                        ksort($metricsArray);
                        $allMetrics[$metricID] = $metricsArray;
                    }
                }
                if (isset($currentMetrics[$statID]))
                {
                    return View::make('demo.single_stat',
                        array(
                            'data' => $currentMetrics[$statID]['metricClass']::show($allMetrics[$statID],true),
                            Auth::logout()
                        )
                    );
                }

                return Redirect::route('demo.dashboard')
                ->with('error', 'Statistic does not exist.');
            }

            catch (Exception $e) {
                Auth::logout();
                Log::error($e);
                return Redirect::route('demo.dashboard')
                        ->with('error', 'Something went wrong, we will return shortly.');
            }
        }
    }
    
}