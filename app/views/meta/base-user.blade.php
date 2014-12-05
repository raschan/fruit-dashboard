@extends('meta.meta')

@section('body')

  <body class="theme-asphalt main-menu-animated page-invoice main-navbar-fixed main-menu-fixed no-main-menu">
  	<div id="main-wrapper">

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

		</div> <!-- / #main-wrapper -->
	</body>

@stop