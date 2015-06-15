<li data-id='{{ $widget_data["widget_id"] }}' class="dashboard-widget well" data-row="{{ $widget_data['position']['row'] }}" data-col="{{ $widget_data['position']['col'] }}" data-sizex="6" data-sizey="8">
	<a href="{{ URL::route('connect.deletewidget', $id) }}"><span class="fa fa-times pull-right widget-close"></span></a>
	<!--a class='link-button' href='' data-toggle="modal" data-target='#widget-settings-{{ $id }}'><span class="gs-option-widgets"></span></a-->
	<a href="{{ URL::route('connect.deletewidget', $id) }}"><span class="gs-close-widgets"></span></a-->

	<iframe width="100%" height="100%" frameborder="0" src="{{ $iframeUrl }}"></iframe>
</li>

@section('pageModals')
	<!-- iframe settings -->
		
	@include('settings.widget-settings')

	<!-- /iframe settings -->
@append