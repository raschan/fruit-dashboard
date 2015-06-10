<li data-id='{{ $widget_data["widget_id"] }}' class="dashboard-widget well" data-row="{{ $widget_data['position']['row'] }}" data-col="{{ $widget_data['position']['col'] }}" data-sizex="{{ $widget_data['position']['x'] }}" data-sizey="{{ $widget_data['position']['y'] }}">
	<span class="gs-close-widgets"></span>
	<span class="gs-option-widgets"></span>
	<a href="{{ URL::route('connect.deletewidget', $id) }}"><span class="fa fa-times pull-right widget-close"></span></a>
	<ul>
    @foreach ($list as $value)
    	{{ $value }}
    @endforeach
  	</ul>
</li>
