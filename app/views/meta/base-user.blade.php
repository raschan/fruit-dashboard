@extends('meta.meta')

@section('body')

	<body class="theme-asphalt main-menu-animated page-invoice main-navbar-fixed main-menu-fixed no-main-menu">
  		<div id="main-wrapper">

			@section('navbar')
				@include('meta.navbar')
			@show

			@section ('pageAlert')
				@include('meta.pageAlerts')
			@show

			@section('pageContent')
			@show

			@section('footer')
				@include('meta.footer')
			@show

		</div> <!-- / #main-wrapper -->
		@section('intercomScript')
			<!-- Intercom Script -->
			<script>
		    	window.intercomSettings = {
			    	name: "{{ Auth::user()->email }}",
			        email: "{{ Auth::user()->email }}",
			        created_at: "{{ Auth::user()->created_at }}",
			    	app_id: "nch9zmp2"
		    	};
			</script>
			{{ HTML::script('js/intercom_io.js'); }}
			<!-- / Intercom Script -->
		@show
	</body>

@stop