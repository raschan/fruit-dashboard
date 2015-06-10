<li data-id='{{ $id }}' class="dashboard-widget well" data-row="{{ $position['row'] }}" data-col="{{ $position['col'] }}" data-sizex="{{ $position['x'] }}" data-sizey="{{ $position['y'] }}">
	<span class="gs-close-widgets"></span>
	<span class="gs-option-widgets"></span>
	{{Form::textarea('note', $currentValue, array(
		'id' => $id,
		'class' => 'text-fill-note note'
		)
	)}}

</li>