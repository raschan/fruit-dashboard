<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<div>
		Hi there,

		Here are your metrics for yesterday: <br/>
		<br/>

		<!-- for each calculated metrics -->
		@foreach ($currentMetrics as $statID => $statDetails)
			<b>{{ $statDetails['metricName'] }}:</b> {{ $metrics->$statID }}
			<br/>
		@endforeach
		<br/>
		<a href="http://startupdashboard.abfinformatika.hu">Startup Dashboard</a>
		</div>
	</body>
</html>