<?php

class QuoteHelper {

	public static function wizard($step = NULL){

		if (!$step){
			return View::make('connect.connect-quote')
				->with(array(
					'isBackgroundOn' => Auth::user()->isBackgroundOn,
					'dailyBackgroundURL' => Auth::user()->dailyBackgroundURL(),
				)
			);
		}

		if ($step == 2) {
			
			$type = Input::get('type');
			$refresh = Input::get('refresh');
			$language = Input::get('language');                

			# save the widget
			$widget_data = array(
				'type'      =>  $type,
				'refresh'   =>  $refresh,
				'language'   =>  $language
			);
			$widget_json = json_encode($widget_data);

			$widget = new Widget;
			$widget->widget_name = 'quote widget';
			$widget->widget_type = 'quote';
			$widget->widget_source = $widget_json;
			$widget->dashboard_id = Auth::user()->dashboards()->first()->id;
			$widget->position = '{"size_x":6,"size_y":2,"col":1,"row":1}';
			$widget->save();

			return Redirect::route('dashboard.dashboard')
			  ->with('success', 'Quote widget added.');
		}
	}
}