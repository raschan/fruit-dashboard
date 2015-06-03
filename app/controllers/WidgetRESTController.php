<?php

class WidgetRESTController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$dashboard = Dashboard::where('user_id','=',$id);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Save widget position on specified dashboard.
	 *
	 * @param  int  $userId
	 * @param  string $positions
	 * @return Response
	 */
	public function saveWidgetPosition($userId, $position)
	{
		$dashboard = User::where('id','=',$userId)
						->first()
						->dashboards()
						->first();
		if ($dashboard)
		{
			$dashboard->widgetPosition = $position;
			$dashboard->save();

			return Response::make(null,200);
			
		} else {
			// we dont have a dashboard for that user, something is bad
			return Response::json(array('error' => 'no such user'));
		}
	}
}
