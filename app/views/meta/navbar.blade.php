<div id="main-navbar" class="navbar" role="navigation">
	<!-- Main menu toggle -->
	<button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>
	
	<div class="navbar-inner">
		<!-- Main navbar header -->
		<div class="navbar-header">

			<!-- Logo -->
			@if (Auth::user())
				<a href="{{ URL::route('auth.dashboard') }}" class="navbar-brand">
			@else
				<a href="http://analytics.tryfruit.com" class="navbar-brand">
			@endif
				Fruit Analytics
				</a>

			<!-- Main navbar toggle -->
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>

		</div> <!-- / .navbar-header -->

		<div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
			<div>
				<div class="right clearfix">
					<ul class="nav navbar-nav pull-right right-navbar-nav">

<!-- 3. $NAVBAR_ICON_BUTTONS =======================================================================

						Navbar Icon Buttons

						NOTE: .nav-icon-btn triggers a dropdown menu on desktop screens only. On small screens .nav-icon-btn acts like a hyperlink.

						Classes:
						* 'nav-icon-btn-info'
						* 'nav-icon-btn-success'
						* 'nav-icon-btn-warning'
						* 'nav-icon-btn-danger' 
-->
						
						
<!-- /3. $END_NAVBAR_ICON_BUTTONS -->
						<li>
							<a href="{{ URL::route('auth.settings') }}">
								<i class="dropdown-icon fa fa-cogs"></i>&nbsp;&nbsp;Settings
							</a>
						</li>

						<li>
							<a onClick= '_gaq.push(["_trackEvent", "Signout", "Button Pushed"]);mixpanel.track("Signout");' href="{{ URL::route('auth.signout') }}">
								<i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Sign out
							</a>
						</li>
					</ul> <!-- / .navbar-nav -->
				</div> <!-- / .right -->
			</div>
		</div> <!-- / #main-navbar-collapse -->
	</div> <!-- / .navbar-inner -->
</div> <!-- / #main-navbar -->