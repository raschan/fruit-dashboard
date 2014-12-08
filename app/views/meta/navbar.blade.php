<div id="main-navbar" class="navbar navbar-inverse" role="navigation">
	<!-- Main menu toggle -->
	<button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>
	
	<div class="navbar-inner">
		<!-- Main navbar header -->
		<div class="navbar-header">

			<!-- Logo -->
			<a href="{{ URL::route('auth.dashboard') }}" class="navbar-brand">
				Start Up Dashboard
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
						<li class="nav-icon-btn nav-icon-btn-danger dropdown">
							<a href="#notifications" class="dropdown-toggle" data-toggle="dropdown">
								<span class="label">5</span>
								<i class="nav-icon fa fa-bullhorn"></i>
								<span class="small-screen-text">Notifications</span>
							</a>

							<!-- NOTIFICATIONS -->
							

							<div class="dropdown-menu widget-notifications no-padding" style="width: 300px">
								<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 250px;"><div class="notifications-list" id="main-navbar-notifications" style="overflow: hidden; width: auto; height: 250px;">

									<div class="notification">
										<div class="notification-title text-danger">SYSTEM</div>
										<div class="notification-description"><strong>Error 500</strong>: Syntax error in index.php at line <strong>461</strong>.</div>
										<div class="notification-ago">12h ago</div>
										<div class="notification-icon fa fa-hdd-o bg-danger"></div>
									</div> <!-- / .notification -->

									<div class="notification">
										<div class="notification-title text-info">STORE</div>
										<div class="notification-description">You have <strong>9</strong> new orders.</div>
										<div class="notification-ago">12h ago</div>
										<div class="notification-icon fa fa-truck bg-info"></div>
									</div> <!-- / .notification -->

									<div class="notification">
										<div class="notification-title text-default">CRON DAEMON</div>
										<div class="notification-description">Job <strong>"Clean DB"</strong> has been completed.</div>
										<div class="notification-ago">12h ago</div>
										<div class="notification-icon fa fa-clock-o bg-default"></div>
									</div> <!-- / .notification -->

									<div class="notification">
										<div class="notification-title text-success">SYSTEM</div>
										<div class="notification-description">Server <strong>up</strong>.</div>
										<div class="notification-ago">12h ago</div>
										<div class="notification-icon fa fa-hdd-o bg-success"></div>
									</div> <!-- / .notification -->

									<div class="notification">
										<div class="notification-title text-warning">SYSTEM</div>
										<div class="notification-description"><strong>Warning</strong>: Processor load <strong>92%</strong>.</div>
										<div class="notification-ago">12h ago</div>
										<div class="notification-icon fa fa-hdd-o bg-warning"></div>
									</div> <!-- / .notification -->

								</div><div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div> <!-- / .notifications-list -->
								<a href="#" class="notifications-link">MORE NOTIFICATIONS</a>
							</div> <!-- / .dropdown-menu -->
						</li>
						
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