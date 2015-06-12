<li data-id='{{ $widget_data["widget_id"] }}' class="dashboard-widget well" data-row="{{ $widget_data['position']['row'] }}" data-col="{{ $widget_data['position']['col'] }}" data-sizex="{{ $widget_data['position']['x'] }}" data-sizey="{{ $widget_data['position']['y'] }}">    <a href="{{ URL::route('connect.deletewidget', $id) }}"><span class="fa fa-times pull-right widget-close"></span></a>
    <span class="gs-close-widgets"></span>
	<span class="gs-option-widgets"></span>
    <iframe width="100%" height="100%" frameborder="0" src="{{ $iframeUrl }}"></iframe>
</li>