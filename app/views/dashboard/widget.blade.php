@if ($widget_data['widget_type'] == 'clock')
  @include('dashboard.widget-clock', [
    'currentTime' => $widget_data['currentValue'],
    'id' => $widget_data['widget_id']
   ])
@endif

@if ($widget_data['widget_type'] =='google-spreadsheet-text-cell')
  @include('dashboard.widget-text', ['text' => $widget_data['currentValue'], 'id' => $widget_data['widget_id']])
@endif

@if ($widget_data['widget_type'] =='google-spreadsheet-text-column')
  @include('dashboard.widget-list', ['list' => $widget_data['history'], 'id' => $widget_data['widget_id']])
@endif

@if ($widget_data['widget_type'] =='iframe')
  @include('dashboard.widget-iframe', [
    'iframeUrl' => json_decode($widget_data["currentValue"], true)['iframeURL'],'id' => $widget_data['widget_id']])
@endif

@if ($widget_data['widget_type'] =='google-spreadsheet-text-column-random')
  @include('dashboard.widget-text', ['text' => $widget_data['currentValue'], 'id' => $widget_data['widget_id']])
@endif

@if ($widget_data['widget_type'] =='quote')
  @include('dashboard.widget-quote', ['quote' => json_decode($widget_data['currentValue'],true)['quote'], 'author' => json_decode($widget_data['currentValue'],true)['author'], 'id' => $widget_data['widget_id']])
@endif

@if($widget_data['widget_type'] == 'note')
  @include('dashboard.widget-note', [
    'id' => $widget_data['widget_id'],
    'currentValue' => $widget_data['currentValue'], 
    'position' => $widget_data['position']
  ])    
@endif

@if($widget_data['widget_type'] == 'greeting')
  @include('dashboard.widget-greeting', [
    'id' => $widget_data['widget_id'],
    'position' => $widget_data['position']
  ])
@endif