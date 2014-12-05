@extends('meta.base-user-signout')

@section('pageStylesheet')
<!-- Facebook Conversion Code for Katt -->

@stop


@section('pageContent')
	@include('meta.pageAlerts')
	<!-- login form box -->
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<h1 class="page-title">Start up Dashboard</h1>
				{{ Form::open(array('route' => 'auth.signup', 'class' => 'panel' )) }}
				<div class="login-text">
					<span>Sign up</span><span class="pull-right">or <a href="{{ URL::route('auth.signin') }}">sign in</a></span>
				</div>
				<div class="form-group @if ($errors->first('email')) has-error @endif">
					<div class="input-group">
						<span class="input-group-addon"><strong>@</strong></span>
						{{ Form::text('email', Input::old('email'), array('placeholder' => 'Email@provider.com', 'class' => 'form-control')) }}
					</div>
					<p class="help-block">
						@if ($errors->first('email'))
						{{ $errors->first('email') }}
						@endif
					</p>
				</div>

				<div class="form-group @if ($errors->first('password')) has-error @endif">
					<div class="input-group">
						<span class="input-group-addon"><i class="icon fa fa-lock"></i></span>
						{{ Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control')) }}
					</div>
					<p class="help-block">
						@if ($errors->first('password'))
						{{ $errors->first('password') }}
						@endif
					</p>
				</div>

				<div class="text-center">
					{{ Form::submit('Submit!' , array(
						'id' => 'id_submit',
						'class' => 'btn btn-primary btn-lg btn-flat')) }}
					</div>

				{{ Form::close() }}

				<div class="text-center padding-xs-vr footer-copyright">
					<a href="#">&copy; 2014 Start Up Dashboard</a>
				</div>
			</div>
		</div>
	</div>

@stop

