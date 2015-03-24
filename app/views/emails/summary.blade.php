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
			Here are your metrics for yesterday: <br/>
		@else
			Here are your metrics for the last week: <br/>
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
							@if ($changes[$statID][Carbon::createFromFormat('Y-m-d, l', $date)->format('Y-m-d')]['value'])
								@if ($changes[$statID]['positiveIsGood'])
									<td style="text-align: right;color: green">
								@else
									<td style="text-align: right;color: red"> 
								@endif
									{{ $changes[$statID][Carbon::createFromFormat('Y-m-d, l', $date)->format('Y-m-d')]['value'] }} </td>
							@else
								<td style="text-align: right;color: blue"> N/A </td>
							@endif
						<tr/>
					@endforeach
				</table>
				<br/>
			@endforeach 
		<br/>
		<a href="http://dashboard.tryfruit.com">Fruit Financial Analytics</a>
		</div>
	</body>
</html>