<div id='widget-settings-{{ $id }}' class='modal fade in' tabindex='-1' role='dialog' style="display:none;" aria-hidden='false'>
  <div class='modal-dialog modal-lg'>
    <div>
      <div class='modal-header'>
        <button type="button" class="close" data-dismiss='modal' aria-hidden='true'>x</button>
        <h4 class='modal-title'>Widget Settings</h4>
      </div>
      <div class='modal-content'>
      	<div class='top-space bottom-space'>
					<div class="row bottom-space-sm">
            <div class='col-sm-2 text-right valign'>
              <label>Name:</label>
            </div>
            <input class='widget-name valign col-sm-8' type='text' id='{{ $id }}-name' value="{{ $widget_data['fullName'] }}" placeholder='Widget Name'>
            <div class='col-sm-2'>
              <button class='btn btn-primary btn-sm btn-flat save-widget-name'>Save</button>
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