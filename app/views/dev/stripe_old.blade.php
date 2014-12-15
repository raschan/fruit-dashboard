
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stripe testing Page</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
{{ HTML::script('js/jquery.js'); }}
<script>
jQuery( document ).ready( function( $ ) {

    $('#getevents').on( 'submit', function() {
        //.....
        //show some spinner etc to indicate operation in progress
        //.....

        $.post(
            $( this ).prop( 'action' ),
            {
                "_token": $( this ).find( 'input[name=_token]' ).val()
            },
            function( data ) {
                alert(data);
            },
            'json'
        );

        //.....
        //do anything else you might want to do
        //.....

        //prevent the form from actually submitting in browser
        return false;
    } );

} );

</script>

</head>
<body>
{{ Form::open( array(
    'route' => 'dev.stripe',
    'method' => 'post',
    'id' => 'getevents'
) ) }}

{{ Form::submit( 'Get events', array(
    'id' => 'btn-get-events',
) ) }}

{{ Form::close() }}


    <!-- Page Content -->
    <div class="container">
    <h2 id="mrr_here">{{$mrr}}</h2>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>Your stripe account charges</h1>
                  <table class='table table-bordered table-hover'>
                    <thead>
                      <th>ID</th>
                      <th>Created</th>
                      <th>Amount</th>
                      <th>Paid</th>
                      <th>Captured</th>
                      <th>Description</th>
                      <th>Statement description</th>
                      <th>failure_code</th>
                    </thead>
                    <tbody>
                    @foreach ($charges as $id => $charge)
                    <tr>
                      <td>{{ $id }}</td>
                      <td>{{ gmdate('Y-m-d H:i:s',$charge['created']) }}</td>
                      <td>{{ strtoupper($charge['currency']) }} {{ number_format($charge['amount']/100, 2) }}</td>
                      <td>{{ $charge['paid'] }}</td>
                      <td>{{ $charge['captured'] }}</td>
                      <td>{{ $charge['description'] }}</td>
                      <td>{{ $charge['statement_description'] }}</td>
                      <td>{{ $charge['failure_code'] }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                <h1>Your stripe account events</h1>
                  <table class='table table-bordered table-hover'>
                    <thead>
                      <th>ID</th>
                      <th>Created</th>
                      <th>Type</th>
                      <th>Event id</th>
                    </thead>
                    <tbody>
                    @foreach ($events as $id => $event)
                    <tr>
                      <td>{{ $id }}</td>
                      <td>{{ gmdate('Y-m-d H:i:s',$event['created']) }}</td>
                      <td>{{ strtoupper($event['type']) }}</td>
                      <td>
                      {{ $event['object']['id'] }}
                      </td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
    </body>
</html>
