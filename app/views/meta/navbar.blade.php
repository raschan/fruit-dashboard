<div id="main-navbar" class="navbar navbar-inverse" role="navigation">
	<!-- Main menu toggle -->
	<button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>
	
	<div class="navbar-inner">
		<!-- Main navbar header -->
		<div class="navbar-header">

			<!-- Logo -->
			<a href="{{ URL::route('auth.dashboard') }}" class="navbar-brand">
				Startup Dashboard
			</a>

			<!-- Main navbar toggle -->
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>

		</div> <!-- / .navbar-header -->

		<div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
			<div>
				<ul class="nav navbar-nav">
					<li>
						<a href="{{ URL::route('auth.dashboard') }}">Home</a>
					</li>
					<li>
						<a href="{{ URL::route('auth.single_stat') }}">Statistics</a>
					</li>
				</ul> <!-- / .navbar-nav -->

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
								Settings
							</a>
						</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown">
								<span>John Doe</span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL::route('auth.signout') }}"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Log Out</a></li>
							</ul>
						</li>
					</ul> <!-- / .navbar-nav -->
				</div> <!-- / .right -->
			</div>
		</div> <!-- / #main-navbar-collapse -->
	</div> <!-- / .navbar-inner -->
</div> <!-- / #main-navbar -->