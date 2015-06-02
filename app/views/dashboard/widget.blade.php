@if ($widget_data['widget_type']=='google-spreadsheet-text-cell')
    @include('dashboard.widget-text', ['text' => $widget_data['currentValue'], 'id' => $widget_data['widget_id']])

@elseif ($widget_data['widget_type']=='google-spreadsheet-text-column')
    @include('dashboard.widget-list', ['list' => $widget_data['history'], 'id' => $widget_data['widget_id']])

@elseif ($widget_data['widget_type']=='iframe')
    @include('dashboard.widget-iframe', ['iframeUrl' => json_decode($widget_data["currentValue"], true)['iframeURL'], 'id' => $widget_data['widget_id']])

@endif