@extends('meta.base-user-signout')

@section('pageContent')
  <!-- login form box -->
  <div class="container">
    @include('meta.pageAlerts')
    <div class="row">
      <div class="col-sm-4 col-sm-offset-4">
        <h1 class="text-center text-white padding-sm-vr">Start Up Dashboard</h1>
      	  {{ Form::open(array('route' => 'auth.signin', 'class' => 'panel' )) }}
            <div class="login-text">
              <span>Sign in</span><span class="pull-right">or <a href="{{ URL::route('auth.signup') }}">sign up</a></span>
            </div>
            <div class="form-group @if ($errors->first('email')) has-error @endif">
              <div class="input-group">
                  <span class="input-group-addon"><strong>@</strong></span>
                  {{ Form::text('email', Input::old('email'), array('placeholder' => 'youremail@yourprovider.com', 'class' => 'form-control')) }}
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
			    {{ Form::password('password', array('placeholder' => 'password', 'class' => 'form-control')) }}
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


