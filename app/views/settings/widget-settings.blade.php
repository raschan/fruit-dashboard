<div id='widget-settings-{{ $id }}' class='modal fade in' tabindex='-1' role='dialog' style="display:none;" aria-hidden='false'>
  <div class='modal-dialog modal-lg' style='width: 40%;'>
    <div>
      <div class='modal-header'>
        <button type="button" class="close" data-dismiss='modal' aria-hidden='true'>x</button>
        <h4 class='modal-title'>Widget Settings</h4>
      </div>
      <div class='modal-content'>
      	<div class='top-space bottom-space'>

					<div class="row bottom-space-sm">
            <div class='col-sm-3 text-right valign'>
              <label>Name:</label>
            </div>
            <input class='form-control valign col-sm-8' style='width:60%' type='text' id='{{ $id }}-name' value="{{ $widget_data['fullName'] }}" placeholder='Widget Name'>
          </div>

          @if(View::exists('settings.'.$widget_data["widget_type"]))
            @include('settings.'.$widget_data["widget_type"])
          @endif

          <div class="row">
            <div class='col-sm-8 col-sm-offset-6 text-center padding-xs-vr'>
              <button class="btn btn-warning btn-sm btn-flat" type="button" data-dismiss='modal' aria-hidden='true'>Cancel</button>
              <button class='btn btn-primary btn-sm btn-flat save-widget-name'>Save</button>
            </div>
					</div>
	      </div>
      </div>
    </div>
  </div>
</div>