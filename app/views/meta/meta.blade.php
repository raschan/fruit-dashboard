<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">

    <title>Fruit Analytics | 
      @section('pageTitle')
      @show
    </title>

    @section('stylesheet')
      <!-- Fonts -->
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
      <!-- /Fonts -->

      <!-- Bootstrap core CSS -->
      {{ HTML::style('css/bootstrap.min.css') }}
      <!-- /Bootstrap -->

      <!-- Font Awesome CSS -->
      {{ HTML::style('css/font-awesome.min.css') }}
      <!-- /FontAwesome -->

      <!-- PixelAdmin -->
      {{ HTML::style('css/pixel-admin.min.css') }}
      {{ HTML::style('css/themes.min.css') }}
      {{ HTML::style('css/widgets.min.css') }}
      {{ HTML::style('css/pages.min.css') }}
      <!-- /PixelAdmin -->

      <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <![endif]-->

      <!-- Custom styles -->
      {{ HTML::style('css/custom.css') }}
      <!-- /Custom styles -->

      <script type="text/javascript">
        var init = [];
      </script>
      <!-- /Pixeladmin js init array -->
      
      <!-- GoogleAnalyticsEvents -->
      {{ HTML::script('js/google_events.js'); }}
      <!-- /GoogleAnalyticsEvents -->

      <!-- Mixpanel event -->
      {{ HTML::script('js/mixpanel_event.js') }}
      <!-- / Mixpanel event -->

      <!-- Mixpanel user tracking -->
      {{ HTML::script('js/mixpanel_user.js') }}
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
    {{ HTML::script('js/jquery.js'); }}
    {{ HTML::script('js/bootstrap.min.js'); }}
    {{ HTML::script('js/pixel-admin.min.js'); }}
    {{ HTML::script('js/chart.min.js'); }}
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
    {{ HTML::script('js/google_analytics.js'); }}
    <!-- GoogleAnalytics -->
  @show
     
</html>
