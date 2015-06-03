<li data-id='{{ $widget_data["widget_id"] }}' class="dashboard-widget well" data-row="{{ $widget_data['position']['row'] }}" data-col="{{ $widget_data['position']['col'] }}" data-sizex="{{ $widget_data['position']['x'] }}" data-sizey="{{ $widget_data['position']['y'] }}">
	<p id="quote" class="textShadow">{{ $quote }}</p>
	<p id="author" class="textShadow pull-right">{{ $author }}</p>
</li>