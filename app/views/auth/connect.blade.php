@extends('meta.base-user')

  @section('pageContent')
    <div id="main-wrapper">
    	<div class="col-md-4 col-md-offset-1 connect-description">
    	</div> <!-- /. connect-description -->
    	<div class="col-md-6 connect-form">
    	</div> <!-- /. connect-form -->
    </div> <!-- / #main-wrapper -->
  @stop

  @section('pageScripts')

    <script type="text/javascript">
    
    </script>

  @stop

  @section('intercomScript')
  <script>
     
  </script>
  {{ HTML::script('js/intercom_io.js'); }}
  @stop