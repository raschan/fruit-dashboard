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
	 * Save widget position.
	 *
	 * @param  int  $userId
	 * @param  string $positions
	 * @return Response
	 */
	public function saveWidgetPosition($userId, $json)
	{
		$user = User::where('id','=',$userId)->first();

		if ($user)
		{
			Log::info($json);
			$widgetPositions = json_decode($json);

			foreach ($widgetPositions as $widgetPosition) 
			{
				$widget = Widget::find($widgetPosition->id);

				if($widget)
				{
					$pos = [
						"col" 		=> $widgetPosition->col,
						"row" 		=> $widgetPosition->row,
						"size_x" 	=> $widgetPosition->size_x,
						"size_y" 	=> $widgetPosition->size_y
					];
					$widget->position = json_encode($pos);
					$widget->save();
				}
			}

			return Response::make('everything okay',200);

		} else {
			// no such user
			return Response::json(array('error' => 'no such user'));
		}
	}

	/**
	 * Save widget text.
	 *
	 * @param  int  $widgetId
	 * @param  string $text
	 * @return Response
	 */

	public function saveWidgetText($widgetId, $text = '')
	{
		$widgetData = Data::where('widget_id', $widgetId)->first();

		if ($widgetData)
		{
			$widgetData->data_object = $text;
			$widgetData->save();

			return Response::make('everything okay',200);		
		} else {
			return Response::json(array('error' => 'bad widget id'));
		}
	}
}
