<?php


/*
|--------------------------------------------------------------------------
| ApiController: Handles the API
|--------------------------------------------------------------------------
*/
class ApiController extends BaseController
{
	/*
	|===================================================
	| <GET> | showDashboard: renders the dashboard page
	|===================================================
	*/
	public function saveApiData($apiVersion = NULL)
	{
		Log::info($apiVersion);
		Log::info('hello');
	}
}
