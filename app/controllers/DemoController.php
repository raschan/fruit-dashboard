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
    }

    /*
    |===================================================
    | <GET> | showSinglestat: renders the single stats page
    |===================================================
    */
    public function showSinglestat($statID = 'mainPage')
    {   if (Auth::check()) {
            return Redirect::route('auth.connect');
        } 
        else {
            $user = User::find(1);
            Auth::login($user);

            switch($statID){
                case 'mainPage':
                return View::make('demo.single_stat',
                    array(
                        'data' => MrrStat::showMRR(true), Auth::logout()
                    )
                );
                case 'mrr':
                return View::make('demo.single_stat',
                    array(
                        'data' => MrrStat::showMRR(true), Auth::logout()
                    )
                );
                break;
                case 'au':
                return View::make('demo.single_stat',
                    array(
                        'data' => AUStat::showAU(true), Auth::logout()
                    )
                );
                case 'arr':
                return View::make('demo.single_stat',
                    array(
                        'data' => ArrStat::showARR(true), Auth::logout()
                    )
                );
                case 'arpu':
                return View::make('demo.single_stat',
                    array(
                        'data' => ArpuStat::showARPU(true), Auth::logout()
                    )
                );
                case 'cancellations':
                return View::make('demo.single_stat',
                    array(
                        'data' => CancellationStat::showCancellation(true), Auth::logout()
                    )
                );case 'uc':
                return View::make('demo.single_stat',
                    array(
                        'data' => UserChurnStat::showUserChurn(true), Auth::logout()
                    )
                );
                default:
                    return Redirect::route('demo.dashboard')
                    ->with('error', 'Statistic does not exist.');
                break;
            }
        }
    }
    
}