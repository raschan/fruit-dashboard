@extends('meta.base-user')

  @section('pageContent')

  <div id="content-wrapper">
    @parent
  	<div class='col-md-6 col-md-offset-3'>
  		<form id="checkout" method="post" action="">
	  		<div id="dropin"></div>
	  		<input class='btn btn-info center' type="submit" value="Subscribe">
		  </form>
  	</div>
  </div> <!-- /.content-wrapper -->
  @stop

  @section('pageScripts')
 	<!-- Braintree JS library -->
    {{ HTML::script('https://js.braintreegateway.com/v2/braintree.js') }}
  
    <script type="text/javascript">
      braintree.setup(
        '{{ $clientToken }}',
        'dropin', {
          container: 'dropin'
      });
    </script>
  @stop


