{{ $widget_data['widget_type'] }}
{{ $widget_data['currentValue'] }}

@if ($widget_data['widget_type']=='google-spreadsheet-text-cell')
    @include('dashboard.widget-text', ['text' => $widget_data['currentValue']])

@elseif ($widget_data['widget_type']=='google-spreadsheet-text-column')
    @include('dashboard.widget-list', ['list' => $widget_data['history']])


@elseif ($widget_data['widget_type']=='iframe')
    @include('dashboard.widget-iframe', ['iframeUrl' => json_decode($widget_data["currentValue"], true)['iframeURL']])

@endif