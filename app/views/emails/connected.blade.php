@extends('emails.meta.meta')
	@section('emailContent')

		<h2 class='text-center'>Your metrics are ready.</h2>
		<div class='text-center'>
		{{ HTML::link('/dashboard','Visit my dashboard',array('class' => 'btn btn-primary btn-lg')) }}
		</div>

	@stop