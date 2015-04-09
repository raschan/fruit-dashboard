@extends('emails.meta.meta')
	@section('emailContent')
		Hi there,
		<br/>
		@if ($isDaily)
			here are your metrics for yesterday: <br/>
		@else
			here are your metrics for the last week: <br/>
		@endif
		<br/>
		{{-- for every day --}}
		@foreach ($metrics as $date => $metric)
		<strong>{{ $date }}:</strong> <br/>
			{{-- for each calculated metrics --}}
			<table class='table-bordered' style="width:100%">
				<thead>
					<tr>
						<td class='text-center' style="width:60%">Metric</td>
						<td class='text-center' style="width:20%">Yesterday value</td>
						<td class='text-center' style="width:20%">Change in 30 days</td> 
					</tr>
				</thead>
				@foreach ($currentMetrics as $statID => $statDetails)
					<tr @if (($index++)%2 == 0)style='background-color:#f9f9f9' @endif>
						<td><span class='left-space'>{{ HTML::link('/statistics/'.$statID,$statDetails['metricName']) }}</span></td>
						<td class="text-right"><span class='right-space'>{{ $metric->$statID }}</span></td>
						
						@if ($changes[$statID][date('Y-m-d', strtotime($date))]['value'])
							@if ($changes[$statID]['positiveIsGood'])
								@if ($changes[$statID][date('Y-m-d', strtotime($date))]['isBigger'])
									<td class='text-right text-success'> {{--green--}}
								@else
									<td class='text-right text-danger'> {{--red--}}
								@endif
							@else
								@if ($changes[$statID][date('Y-m-d', strtotime($date))]['isBigger'])
									<td class='text-right text-danger'> {{--red--}}
								@else
									<td class='text-right text-success'> {{--green--}}
								@endif
							@endif
								<span class='right-space'>{{ $changes[$statID][date('Y-m-d', strtotime($date))]['value'] }}</span></td>
						@else
							<td class='text-right text-info'><span class='right-space'> -- </span></td> {{--blue--}}
						@endif
					<tr/>
				@endforeach
			</table>
			<br/>
		@endforeach 
	@stop