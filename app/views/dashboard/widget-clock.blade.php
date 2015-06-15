<li data-id='{{ $widget_data["widget_id"] }}' class="dashboard-widget well no-padding" data-row="{{ $widget_data['position']['row'] }}" data-col="{{ $widget_data['position']['col'] }}" data-sizex="2" data-sizey="2">
	<!--a class='link-button' href='' data-toggle="modal" data-target='#widget-settings-{{ $id }}'><span class="gs-option-widgets"></span></a-->
	<a href="{{ URL::route('connect.deletewidget', $id) }}"><span class="gs-close-widgets"></span></a>
	
	<div id="digitClock" class="textShadow">
		<h1 class="digitTime">{{ $currentTime }}</h1>
	</div>
</li>

@section('pageModals')
	<!-- clock settings -->
	
	@include('settings.widget-settings')

	<!-- /clock settings -->
@append
