<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<div>
		Hi there,

		Here are your yesterday numbers: <br/>
		<br/>

		<!-- for each calculated metrics -->
		@foreach ($currentMetrics as $statID => $statDetails)
			<b>{{ $statDetails['metricName'] }}:</b> {{ $metrics->$statID }}
			<br/>
		@endforeach
		</div>
	</body>
</html>