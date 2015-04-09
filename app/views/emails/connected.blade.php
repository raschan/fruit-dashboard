@extends('emails.meta.meta')
	@section('emailContent')

		<p class='text-center lead'>You're metrics are ready.</p>
		<div class='text-center'>
		{{ HTML::link('/dashboard','Visit my dashboard',array('class' => 'btn btn-primary btn-lg')) }}
		</div>

	@stop