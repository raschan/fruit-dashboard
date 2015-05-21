@extends('emails.meta.meta')
	@section('emailContent')

		<div class="text-center">
			<p class='lead'><strong>Downgraded</strong> from {{ $plan->name }} </p>
			<p>[sad face]</p>
			<p>We love you nevertheless</p>
		</div>

	@stop