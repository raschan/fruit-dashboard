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
            try { 
                return View::make(
                    'demo.dashboard',
                    array(
                        'allFunctions' => array(
                            MrrStat::showMRR(),
                            AUStat::showAU(),
                            ArrStat::showARR(),
                            ArpuStat::showARPU(),
                            CancellationStat::showCancellation(),
                            UserChurnStat::showUserChurn()
                        ),
                        'events' => Counter::formatEvents(Auth::user()),
                        Auth::logout()
                    )
                );
            }
            catch (Exception $e) {
                Auth::logout();
            return Redirect::to('auth.signup')
                    ->with('error', 'Something went wrong, we will return shortly.');
            }
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
            try { 
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
            catch (Exception $e) {
                Auth::logout();
                return Redirect::route('auth.signup')
                        ->with('error', 'Something went wrong, we will return shortly.');
            }
        }
    }
    
}