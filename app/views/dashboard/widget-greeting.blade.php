<li class="dashboard-widget well no-padding" data-id='{{ $id }}'  data-row="{{ $position['row'] }}" data-col="{{ $position['col'] }}" data-sizex="{{ $position['x'] }}" data-sizey="{{ $position['y'] }}">
	<a class='link-button' href='' data-toggle="modal" data-target='#widget-settings-{{ $id }}'><span class="gs-option-widgets"></span></a>
	<a href="{{ URL::route('connect.deletewidget', $id) }}"><span class="gs-close-widgets"></span></a>
	
	<h3 class='white-text textShadow'>Good <span id='greeting'></span>@if(isset(Auth::user()->name)), {{ Auth::user()->name }}@endif! </h3>
</li>

@section('pageModals')
	<!-- greetings settings -->
	<div id='widget-settings-{{ $id }}' class='modal fade in' tabindex='-1' role='dialog' style="display:none;" aria-hidden='false'>
	  <div class='modal-dialog modal-sm'>
	    <div>
	      <div class='modal-header'>
	        <button type="button" class="close" data-dismiss='modal' aria-hidden='true'>x</button>
	        <h4 class='modal-title'>Settings</h4>
	      </div>
	      <div class='modal-content'>
	      	<div class='top-space bottom-space'>
	      		<span class='left-space'>Widget Name: </span><input class='widget-name' type='text' id='{{ $id }}' value="{{ $widget_data['fullName'] }}" placeholder='Widget Name'>
	      	</div>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- /greetings settings -->
@append