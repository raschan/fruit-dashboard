@extends('meta.base-user-signout')

@section('navbar')
@stop

@section('pageContent')
  @include('meta.pageAlerts')

<body class="theme-asphalt page-signin" style="">
  <!-- Page background -->
  <div id="page-signin-bg">
    <!-- Background overlay -->
    <div class="overlay"></div>
    {{ HTML::image('img/backgrounds/advertise_background.jpg','', array('class' => 'image')) }}
  </div>
  <!-- / Page background -->

  <!-- Container -->
  <div class="signin-container">

    <!-- Left side -->
    <div class="signin-info">
      <a href="/" class="logo">
        Startup Dashboard
      </a> <!-- / .logo -->
      <div class="slogan">
        Simple. Flexible. Powerful.
      </div> <!-- / .slogan -->
      <ul>
        <li><i class="fa fa-sitemap signin-icon"></i> Flexible modular structure</li>
        <li><i class="fa fa-file-text-o signin-icon"></i> LESS &amp; SCSS source files</li>
        <li><i class="fa fa-outdent signin-icon"></i> RTL direction support</li>
        <li><i class="fa fa-heart signin-icon"></i> Crafted with love</li>
      </ul> <!-- / Info list -->
    </div>
    <!-- / Left side -->

    <!-- Right side -->
    <div class="signin-form">

      <!-- Form -->
      {{ Form::open(array('route' => 'auth.signin', 'id' => 'signin-form_id' )) }}
        <div class="signin-text">
          <span>Sign In to your account</span>
        </div> <!-- / .signin-text -->

        <div class="form-group w-icon">
          {{ Form::text('email', Input::old('email'), array('placeholder' => 'Email@provider.com', 'class' => 'form-control input-lg', 'id' => 'username_id')) }}
          <span class="fa fa-user signin-form-icon"></span>
        </div> <!-- / Username -->

        <div class="form-group w-icon">
          {{ Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control input-lg', 'id' => 'password_id')) }}
          <span class="fa fa-lock signin-form-icon"></span>
        </div> <!-- / Password -->

        <div class="form-actions">
          {{ Form::submit('Submit!' , array(
            'id' => 'id_submit',
            'class' => 'signin-btn bg-primary')) }}
          <a href="#" class="forgot-password" id="forgot-password-link">Forgot your password?</a>
        </div> <!-- / .form-actions -->
      {{ Form::close() }}
      <!-- / Form -->

      <!-- Password reset form -->
      <div class="password-reset-form" id="password-reset-form">
        <div class="header">
          <div class="signin-text">
            <span>Password reset</span>
            <div class="close">×</div>
          </div> <!-- / .signin-text -->
        </div> <!-- / .header -->
        
        <!-- Form -->
        <form action="index.html" id="password-reset-form_id" novalidate="novalidate">
          <div class="form-group w-icon">
            <input type="text" name="password_reset_email" id="p_email_id" class="form-control input-lg" placeholder="Enter your email">
            <span class="fa fa-envelope signin-form-icon"></span>
          </div> <!-- / Email -->

          <div class="form-actions">
            <input type="submit" value="SEND PASSWORD RESET LINK" class="signin-btn bg-primary">
          </div> <!-- / .form-actions -->
        </form>
        <!-- / Form -->
      </div>
      <!-- / Password reset form -->
    </div>
    <!-- Right side -->
  </div>
  <!-- / Container -->

  <div class="not-a-member">
    Not a member? <a href="{{ URL::route('auth.signup') }}">Sign up now</a>
  </div>
</body>

@stop

@section('pageScripts')

<script type="text/javascript">
  // Resize BG
  init.push(function () {
    var $ph  = $('#page-signin-bg'),
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


