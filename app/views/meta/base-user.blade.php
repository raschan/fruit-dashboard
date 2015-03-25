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
				<!-- Notice on connect -->
				@if (Session::get('connected') || !Auth::user()->ready)
				<div id="pa-page-alerts-box">
					<div class="alert alert-page pa_page_alerts_dark alert-info alert-dark" data-animate="true" style="">
						<button type="button" class="close">×</button><strong>We're now calculating your numbers, it'll be a few minutes. We'll email you when we finished.</strong>
					</div>
				</div>
				@endif
				<!-- / Notice on connect -->
			@show

			@section('footer')
				@include('meta.footer')
			@show

		</div> <!-- / #main-wrapper -->
		@section('intercomScript')
			<!-- Intercom Script -->
			<script>
			    	window.intercomSettings = {
						@if (Auth::user())
					    	name: "{{ Auth::user()->email }}",
					        email: "{{ Auth::user()->email }}",
					        created_at: "{{ Auth::user()->created_at }}",
			    		@else
			    			name: 'Demo',
			    			email: 'Demo',
			    			created_at: {{ strtotime('2015-03-17'); }},
			    		@endif
				    	app_id: "nch9zmp2"
			    	};
			</script>
			{{ HTML::script('js/intercom_io.js'); }}
			<!-- / Intercom Script -->
		@show
		@section('mixpanelUserTracking')
			<script type="text/javascript">
				mixpanel.identify( "{{ Auth::user()->id}}" );
				mixpanel.people.set({
					"$email": "{{ Auth::user()->email }}",    
				    "$created": "{{ Auth::user()->created_at }}",
				    "$last_login": "{{ Carbon::now() }}"        
				});
			</script>
		@show
	</body>

@stop