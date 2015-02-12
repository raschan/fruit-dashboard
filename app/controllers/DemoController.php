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
        return View::make(
            'auth.dashboard',
            array(
                'allFunctions' => array(
                    MrrStat::showMRR(false),
                    AUStat::showAU(false),
                    ArrStat::showARR(false),
                    ArpuStat::showARPU(false)
                ),
                'events' => Counter::formatEvents(Auth::user())
            )
        );
    }

    /*
    |===================================================
    | <GET> | showSinglestat: renders the single stats page
    |===================================================
    */
    public function showSinglestat($statID = 'mainPage')
    {
        switch($statID){
            case 'mainPage':
            return View::make('auth.single_stat',
                array(
                    'data' => MrrStat::showMRR(true)
                )
            );
            case 'mrr':
            return View::make('auth.single_stat',
                array(
                    'data' => MrrStat::showMRR(true)
                )
            );
            break;
            case 'au':
            return View::make('auth.single_stat',
                array(
                    'data' => AUStat::showAU(true)
                )
            );
            case 'arr':
            return View::make('auth.single_stat',
                array(
                    'data' => ArrStat::showARR(true)
                )
            );
            case 'arpu':
            return View::make('auth.single_stat',
                array(
                    'data' => ArpuStat::showARPU(true)
                )
            );
            default:
                return Redirect::route('auth.dashboard')
                ->with('error', 'Statistic does not exist.');
            break;
        }
    }
    
}