@extends('meta.meta')

@section('body')

  <body class="theme-default theme-dashboard">

	@section ('pageAlert')
		@include('meta.pageAlerts-desktop')
	@show

  @section('navbar')
		@include('meta.navbar')
  @show

  @section('pageContent')
  @show

  @section('footer')
		@include('meta.footer')
  @show
	
	</body>

@stop