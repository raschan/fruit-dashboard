
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PayPal testing Page</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Page Content -->
    <!-- /.container -->
    <div>
      {{ Form::open(array('route' => 'paypal.createPlan', 'id' => 'signin-form_id' )) }}
      {{ Form::text('interval', null, array('placeholder' => 'interval')) }}* (`WEEK`, `DAY`, `YEAR`, `MONTH`) <br>
      {{ Form::text('interval_count', null, array('placeholder' => 'interval_count')) }} (Number)<br>
      {{ Form::text('name', null, array('placeholder' => 'name')) }}* <br>
      {{ Form::text('amount', null, array('placeholder' => 'amount')) }}* <br>
      {{ Form::text('currency', null, array('placeholder' => 'currency')) }}* <br>
      {{ Form::submit('Submit!') }}
      {{ Form::close() }}
    </div>
    <div>
        @foreach ($plans as $plan)
            {{ var_dump($plan) }}
            <br>
        @endforeach 
    </div>
    </body>
</html>
