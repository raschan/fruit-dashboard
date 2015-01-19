
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

    <h2>MRR history</h2>
    @foreach ($data['history'] as $date => $value)
        @if (!is_null($value))
            <p> {{ $date }}: {{ $value }} </p>
        @endif
    @endforeach

    <h2>Plan details</h2>
    @foreach ($data['detailData'] as $details)
        <p> {{$details['name']}}({{ $details['interval'] }}),  {{ $details['amount'] }},  {{ $details['count'] }},   {{$details['mrr']}} </p>
    @endforeach
    </br>


    </div>
    <!-- /.container -->
    </body>
</html>
