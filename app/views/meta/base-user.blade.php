@extends('meta.meta')

@section('body')

	<body @if(isset($isBackgroundOn)) @if($isBackgroundOn) style="background: url({{$dailyBackgroundURL}}) no-repeat center center fixed" @endif @endif class='theme-asphalt no-main-menu'>
  		<div id='main-wrapper'>

			@section('navbar')
				@include('meta.navbar')
			@show

			@section ('pageAlert')
				@include('meta.pageAlerts')
			@show
			
			@section('pageContent')
				@if(Auth::user())
					<!-- Notice on connect -->
					@if (Session::get('connected') || Auth::user()->ready == 'connecting')
						<div id="pa-page-alerts-box">
							<div class="alert alert-page pa_page_alerts_dark alert-info alert-dark" data-animate="true">
								<button type="button" class="close">×</button><strong>We're now calculating your numbers, it'll be a few minutes. We'll email you when we finished.</strong>
							</div>
						</div>
					@endif
					<!-- / Notice on connect -->
					<!-- Notice if trial is ending -->
					@if (Auth::user()->trialWillEndInDays(4) && !Auth::user()->isTrialEnded())
						<div id='pa-page-alerts-box'>
              <div class='alert alert-page alert-warning alert-dark' data-animate='true'>
                <button type='button' class='close'>x</button><strong>Your trial period will end in {{Auth::user()->daysRemaining()}} days. <a href="{{URL::route('payment.plan')}}" class='demo-link'>Click here to subscribe now</a></strong>
              </div>      
            </div>
					@endif
					<!-- /Notice if trial is ending -->
				@endif
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
				@if(Auth::user())
					mixpanel.identify( "{{ Auth::user()->id}}" );
					mixpanel.people.set({
						"$email": "{{ Auth::user()->email }}",    
					    "$created": "{{ Auth::user()->created_at }}",
					    "$last_login": "{{ Carbon::now() }}"        
					});
				@else
					mixpanel.identify( "Demo" );
				@endif
			</script>
		@show
	</body>

@stop