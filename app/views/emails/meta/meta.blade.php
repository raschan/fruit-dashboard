<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		{{-- header --}}
		<h3 class='text-center'>{{ HTML::image('img/fruit_logo.png','',array('class'=>'header-image')) }}</h3>
		<p class='text-right'>{{ Carbon::now()->format('l, F j, Y') }}</p>
		{{-- /header --}}
		{{-- content --}}
		@section('emailContent')
		@show
		{{-- /content --}}
		
		{{-- footer --}}
		<h3 class='text-center lead'>{{ HTML::link('/dashboard','Fruit Analytics') }}</h3>
		<p class='text-center'>Copyright © {{Carbon::now()->year}} All rights reserved</p>
		{{-- /footer --}}
	</body>