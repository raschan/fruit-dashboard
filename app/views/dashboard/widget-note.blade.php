<li data-id='{{ $widget_data["widget_id"] }}' class="dashboard-widget well" data-row="{{ $widget_data['position']['row'] }}" data-col="{{ $widget_data['position']['col'] }}" data-sizex="{{ $widget_data['position']['x'] }}" data-sizey="{{ $widget_data['position']['y'] }}">

	{{Form::textarea('note', $currentValue, array(
		'id' => $widget_data['widget_id'],
		'class' => 'textShadow text-fill-note'
		))}}

</li>