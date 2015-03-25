<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<div>
		Hi there,
		<br/>
		@if ($isDaily)
			here are your metrics for yesterday: <br/>
		@else
			here are your metrics for the last week: <br/>
		@endif
			<br/>
			<!-- for every day -->
			@foreach ($metrics as $date => $metric)
			<strong>{{ $date }}:</strong> <br/>
				<!-- for each calculated metrics -->
				<table>
					@foreach ($currentMetrics as $statID => $statDetails)
						<tr style="padding-top: 10px">
							<td style="padding: 0;">{{ $statDetails['metricName'] }}</td>
							<td style="text-align: right;margin: 0 10px;">{{ $metric->$statID }}</td>
							
							@if ($changes[$statID][date('Y-m-d', strtotime($date))]['value'])
								@if ($changes[$statID]['positiveIsGood'])
									@if ($changes[$statID][date('Y-m-d', strtotime($date))]['isBigger'])
										<td style="text-align: right;color: #27ae60"> {{--green--}}
									@else
										<td style="text-align: right;color: #c0392b"> {{--red--}}
									@endif
								@else
									@if ($changes[$statID][date('Y-m-d', strtotime($date))]['isBigger'])
										<td style="text-align: right;color: #c0392b"> {{--red--}}
									@else
										<td style="text-align: right;color: #27ae60"> {{--green--}}
									@endif
								@endif

									{{ $changes[$statID][date('Y-m-d', strtotime($date))]['value'] }} </td>
							@else
								<td style="text-align: right;color: #3498db"> -- </td> {{--blue--}}
							@endif
						<tr/>
					@endforeach
				</table>
				<br/>
			@endforeach 
		<br/>
		<a href="http://dashboard.tryfruit.com">Fruit Analytics</a>
		</div>
	</body>
</html>