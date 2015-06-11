<div id='widget-settings-{{ $id }}' class='modal fade in' tabindex='-1' role='dialog' style="display:none;" aria-hidden='false'>
  <div class='modal-dialog modal-sm'>
    <div>
      <div class='modal-header'>
        <button type="button" class="close" data-dismiss='modal' aria-hidden='true'>x</button>
        <h4 class='modal-title'>Widget Settings</h4>
      </div>
      <div class='modal-content'>
      	<div class='top-space bottom-space'>
					<div class="row bottom-space-sm">
            <div class='col-sm-4 text-right valign'>
              <label>Name:</label>
            </div>
            <div class='col-sm-8'>
  						<input class='widget-name valign' type='text' id='{{ $id }}' value="{{ $widget_data['fullName'] }}" placeholder='Widget Name'>
            </div>
					</div>
          @if(View::exists('settings.'.$widget_data["widget_type"]))
            @include('settings.'.$widget_data["widget_type"])
          @endif
	      </div>
      </div>
    </div>
  </div>
</div>