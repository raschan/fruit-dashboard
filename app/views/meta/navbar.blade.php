<div class="btn-group" id="settingsIcon">
	@if(!isset($onDashboard))<a id="homeButton" href="/"><i class="fa fa-2x fa-home"></i></a>@endif
	<i class="dropdown-icon fa fa-2x fa-cog" id="rightDropDown" data-toggle="dropdown" aria-expanded="true"></i>
	<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="rightDropDown">
		<li role="presentation">
			<a href='' data-toggle='modal' data-target='#modal-new-widget'>
				<i class="dropdown-icon fa fa-plus-circle"></i>&nbsp;&nbsp;Add New Widget (modal)
			</a>
		</li>
		<li role="presentation">
			<a href="https://fruitdashboard.uservoice.com/">
				<i class="dropdown-icon fa fa-bullhorn"></i>&nbsp;&nbsp;Feedback
			</a>
		<li role="presentation">
			<a href="{{ URL::route('settings.settings') }}">
				<i class="dropdown-icon fa fa-cogs"></i>&nbsp;&nbsp;Settings
			</a>
		</li>
		<li role="presentation">
			<a onClick= '_gaq.push(["_trackEvent", "Signout", "Button Pushed"]);mixpanel.track("Signout");' href="{{ URL::route('auth.signout') }}">
				<i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Sign out
			</a>
		</li>
	</ul>
</div>