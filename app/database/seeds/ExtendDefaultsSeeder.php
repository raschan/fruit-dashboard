<?php

class ExtendDefaultsSeeder extends Seeder
{
	public function run()
	{
		$users = User::all();

		foreach ($users as $user) 
		{
			// default background
			$user->isBackgroundOn = true;
			$user->save();

			$dashboard = $user->dashboards()->first();
			if (!$dashboard)
			{
				// create first dashboard for user
	            $dashboard = new Dashboard;
	            $dashboard->dashboard_name = "Dashboard #1";
	            $dashboard->save();
	            // attach dashboard & user
	            $user->dashboards()->attach($dashboard->id, array('role' => 'owner'));

	            $user->save();				
			}

			$hasClock = false;
			$widgets = $user->dashboards()->first()->widgets;

			foreach ($widgets as $widget) 
			{
				if($widget->widget_type == 'clock')
				{	
					$widget->widget_source = '{}';
					$widget->position = '{"size_x":4,"size_y":1,"col":1,"row":1}';
					$widget->save();
					$hasClock = true;
					break;
				}
			}

            //
            // create default widgets
			if(!$hasClock)
			{
	            // clock widget
	            $widget = new Widget;
	            $widget->widget_name = 'clock';
	            $widget->widget_type = 'clock';
	            $widget->widget_source = '{}';
	            $widget->position = '{"size_x":4,"size_y":1,"col":1,"row":1}';
	            $widget->dashboard_id = $user->dashboards()->first()->id;
	            $widget->save();
			}
		}
	}
}