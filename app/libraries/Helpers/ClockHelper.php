<?php

class ClockHelper {

	public static function wizard($step = NULL){

		// save the widget
		$widgetData = array();
		$widgetJson = json_encode($widgetData);

		$widget = new Widget;
		$widget->widget_name = 'clock widget';
		$widget->widget_type = 'clock';
		$widget->widget_source = $widgetJson;
		$widget->dashboard_id = $user->dashboards()->first()->id;
		$widget->position = '{"size_x":3,"size_y":2,"col":1,"row":1}';
		$widget->save();

		return Redirect::route('dashboard.dashboard')
		  ->with('success', 'Clock widget added.');
	}
}
