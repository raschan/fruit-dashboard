@extends('meta.base-user-signout')

@section('navbar')
@stop

@section('pageContent')

<body class="theme-asphalt page-signup" style="">

  <!-- Page background -->
  <div id="page-signup-bg">
    <!-- Background overlay -->
    <div class="overlay"></div>
    {{ HTML::image('img/backgrounds/advertise_background.jpg','', array('class' => 'image')) }}
  </div>
  <!-- / Page background -->

  <!-- Container -->
  <div class="signup-container">
    <!-- Header -->
    <div class="signup-header">
      <a href="http://analytics.tryfruit.com" class="logo">
        Fruit Analytics
      </a> <!-- / .logo -->
      <div class="slogan">
        Understand your business better.
      </div> <!-- / .slogan -->
    </div>
    <!-- Form -->
    <div class="signup-form">
      {{ Form::open(array('route' => 'auth.signin', 'id' => 'signin-form_id' )) }}        
        <div class="signup-text">
          <span>Sign In to your account</span>
        </div>

        <div class="form-group w-icon">
          {{ Form::text('email', Input::old('email'), array('placeholder' => 'Email@provider.com', 'class' => 'form-control input-lg', 'id' => 'email_id')) }}
          <span class="fa fa-envelope signup-form-icon"></span>
        </div>

        <div class="form-group w-icon">
          {{ Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control input-lg', 'id' => 'password_id')) }}
          <span class="fa fa-lock signup-form-icon"></span>
        </div>

        <!-- <div class="form-group" style="margin-top: 20px;margin-bottom: 20px;">
          <label class="checkbox-inline">
            <input type="checkbox" name="signup_confirm" class="px" id="confirm_id">
            <span class="lbl">I agree with the <a href="#" target="_blank">Terms and Conditions</a></span>
          </label>
        </div> -->

        <div class="form-actions">
          {{ Form::submit('Sign in' , array(
            'id' => 'id_submit',
            'class' => 'signup-btn bg-primary',
            'onClick' => '_gaq.push(["_trackEvent", "Signup", "Button Pushed"]);mixpanel.track("Signup");' )) }}
        </div>
      {{ Form::close() }}
    </div>
    <!-- / Form -->
  </div>
  <!-- / Container -->

  <div class="have-account">
    Not a member yet? <a href="{{ URL::route('auth.signup') }}">Sign Un now</a>
    or check the <a href="{{ URL::route('demo.dashboard') }}">Demo</a>
  </div>

</body>

@stop

@section('pageScripts')

<script type="text/javascript">
  // Resize BG
  init.push(function () {
    var $ph  = $('#page-signup-bg'),
        $img = $ph.find('> img');

    $(window).on('resize', function () {
      $img.attr('style', '');
      if ($img.height() < $ph.height()) {
        $img.css({
          height: '100%',
          width: 'auto'
        });
      }
    });
  });

  // Show/Hide password reset form on click
  init.push(function () {
    $('#forgot-password-link').click(function () {
      $('#password-reset-form').fadeIn(400);
      return false;
    });
    $('#password-reset-form .close').click(function () {
      $('#password-reset-form').fadeOut(400);
      return false;
    });
  });

</script>

@stop


