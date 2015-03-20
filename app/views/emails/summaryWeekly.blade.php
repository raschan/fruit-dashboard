<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<div>
		Hi there,

		Here are your metrics for the last week: <br/>
		<br/>

		<!-- for every day -->
		@foreach ($metrics as $date => $metric)
		<strong>{{ $date }}:</strong> <br/>
			<!-- for each calculated metrics -->
			@foreach ($currentMetrics as $statID => $statDetails)
				<b>{{ $statDetails['metricName'] }}:</b> {{ $metric->$statID }}
				<br/>
			@endforeach
			<br/>
		@endforeach
		<a href="http://dashboard.tryfruit.com">Fruit Financial Analytics</a>
		</div>
	</body>
</html>