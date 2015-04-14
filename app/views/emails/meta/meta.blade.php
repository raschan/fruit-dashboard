<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<div class='email-container'>
		{{-- Turn this into a table --}}
		{{-- 3x3 size, 1st and 3rd column are just for correct middle alignment --}}
			
			{{-- header, 1st row of table --}}
			<div class='text-center'>
				{{ HTML::image('img/fruit_logo.png','',array('class'=>'header-image')) }}
			</div>
			<div class='text-right'>
				{{ Carbon::now()->format('l, F j, Y') }}
			</div>
			{{-- /header --}}
			
			{{-- content, 2nd row of table --}}
			@section('emailContent')
			@show
			{{-- /content --}}
			
			{{-- footer, 3rd row of table --}}
			<div class='text-center'>
				<h3>{{ HTML::link('/dashboard','Fruit Analytics') }}</h3>
				<p>Copyright © {{Carbon::now()->year}} All rights reserved</p>
				<small class='text-muted'>You can change your notification settings {{ HTML::link('/settings','here')}}.</small>
			</div>
			{{-- /footer --}}
		</div>
	</body>