
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
        <h2> {{ $activeUser }} </h2>
        <h2> {{ $arpu }} </h2>
    </div>
    <!-- /.container -->
    </body>
</html>
