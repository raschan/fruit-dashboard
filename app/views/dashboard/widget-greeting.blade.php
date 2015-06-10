<li class="dashboard-widget well no-padding" data-id='{{ $id }}'  data-row="{{ $position['row'] }}" data-col="{{ $position['col'] }}" data-sizex="{{ $position['x'] }}" data-sizey="{{ $position['y'] }}">
	<span class="gs-close-widgets"></span>
	<span class="gs-option-widgets"></span>
	<h3 class='white-text textShadow'>Good <span id='greeting'></span>@if(isset(Auth::user()->name)), {{ Auth::user()->name }}@endif! </h3>
</li>