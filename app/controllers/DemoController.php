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
                                        ->orderBy('date','desc')
                                        ->take(31)
                                        ->get();
                foreach ($currentMetrics as $statID => $statClassName) {

                    $metricsArray = array();
                    foreach ($metricValues as $metric) {
                        $metricsArray[$metric->date] = $metric->$statID;
                    }
                    $allMetrics[] = $statClassName::show($metricsArray);
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
                                        ->orderBy('date','desc')
                                        ->take(31)
                                        ->get();
                
                foreach ($currentMetrics as $statID => $statClassName) {

                    $metricsArray = array();
                    foreach ($metricValues as $metric) {
                        $metricsArray[$metric->date] = $metric->$statID;
                    }
                    $allMetrics[$statID] = $metricsArray;
                }

                if (isset($currentMetrics[$statID]))
                {
                    return View::make('demo.single_stat',
                        array(
                            'data' => $currentMetrics[$statID]::show($allMetrics[$statID],true)
                        )
                    );
                } else {
                    return Redirect::route('demo.dashboard')
                        ->with('error', 'Statistic does not exist.');
                }
                return Redirect::route('demo.dashboard')
                ->with('error', 'Statistic does not exist.');
            }

            catch (Exception $e) {
                Auth::logout();
                return Redirect::route('auth.signup')
                        ->with('error', 'Something went wrong, we will return shortly.');
            }
            
        }
    }
    
}