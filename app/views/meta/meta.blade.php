<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">

    <title>
      Fruit Analytics
      @if (trim($__env->yieldContent('pageTitle')))
        | @yield('pageTitle')
      @endif
    </title>

    @section('stylesheet')
      <!-- Fonts -->
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
      <!-- /Fonts -->

      <!-- Bootstrap core CSS -->
      <link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
      <!-- /Bootstrap -->

      <!-- Font Awesome CSS -->
      <link rel="stylesheet" type="text/css" href="dist/css/font-awesome.min.css">
      <!-- /FontAwesome -->

      <!-- PaymentFonts CSS -->
      <link rel="stylesheet" type="text/css" href="dist/css/paymentfont.min.css">
      <!-- /PaymentFonts CSS -->

      <!-- PixelAdmin -->
      <link rel="stylesheet" type="text/css" href="dist/css/pixel-admin.min.css">
      <link rel="stylesheet" type="text/css" href="dist/css/themes.min.css">
      <link rel="stylesheet" type="text/css" href="dist/css/widgets.min.css">
      <link rel="stylesheet" type="text/css" href="dist/css/pages.min.css">
      <!-- /PixelAdmin -->

      <!-- Gridster -->
      <link rel="stylesheet" type="text/css" href="dist/css/jquery.gridster.min.css">
      <!-- /Gridster -->

      <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <![endif]-->

      <!-- Custom styles -->
      <link rel="stylesheet" type="text/css" href="dist/css/custom.css">
      <!-- /Custom styles -->

      <script type="text/javascript">
        var init = [];
      </script>
      <!-- /Pixeladmin js init array -->
      
      <!-- GoogleAnalyticsEvents -->
      <script type="text/javascript" src="dist/js/google_events.js"></script>
      <!-- /GoogleAnalyticsEvents -->

      <!-- Mixpanel event -->
      <script type="text/javascript" src="dist/js/mixpanel_event.js"></script>
      <!-- / Mixpanel event -->

      <!-- Mixpanel user tracking -->
      <script type="text/javascript" src="dist/js/mixpanel_user.js"></script>
      <!-- / Mixpanel user tracking -->

      <!-- Page specific stylesheet -->
      @section('pageStylesheet')
      @show
      <!-- /Page specific stylesheet -->
    @show
  </head>

  
  @section('body')
    
  @show

  @section('scripts')
    <!-- Base scripts -->
    <script type="text/javascript" src="dist/js/jquery.min.js"></script>
    <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="dist/js/pixel-admin.min.js"></script>
    <script type="text/javascript" src="dist/js/chart.min.js"></script>
    <script type="text/javascript" src="dist/js/jquery.gridster.with-extras.min.js"></script>
    <script type="text/javascript" src="dist/js/underscore-min.js"></script>
    <!-- /Base scripts -->

    <!-- Pagealert timeout -->
    <script type="text/javascript">
      $(document).ready(function(){

      });
    </script>
    <!-- /Pagealert timeout -->

    
    <!-- Page specific scripts -->
    @section('pageScripts')
    @show
    <!-- /Page specific scripts -->

    <!-- PixelAdmin js start -->
    <script type="text/javascript">
      window.PixelAdmin.start(init);
    </script>
    <!-- /PixelAdmin js start -->

    <!-- GoogleAnalytics -->
    <script type="text/javascript" src="dist/js/google_analytics.js"></script>
    <!-- GoogleAnalytics -->
  @show
     
</html>