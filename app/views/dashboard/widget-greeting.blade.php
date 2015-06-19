<li class="dashboard-widget grey-hover no-padding" data-id='{{ $id }}'  data-row="{{ $position['row'] }}" data-col="{{ $position['col'] }}" data-sizex="{{ $position['x'] }}" data-sizey="{{ $position['y'] }}">
	<!--a class='link-button' href='' data-toggle="modal" data-target='#widget-settings-{{ $id }}'><span class="gs-option-widgets"></span></a-->
	<a href="{{ URL::route('connect.deletewidget', $id) }}"><span class="gs-close-widgets"></span></a>
	<p class='greetings-text white-text textShadow text-center'>Good <span class='greeting'></span>@if(isset(Auth::user()->name)), {{ Auth::user()->name }}@endif!</p>
</li>

@section('pageModals')
	<!-- greetings settings -->
	
	@include('settings.widget-settings')

	<!-- /greetings settings -->
@append
