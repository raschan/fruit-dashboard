
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Connect with stripe</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-sm-12 text-center">
                <h1>Give us your stripe API key</h1>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-sm-4 col-sm-offset-4 text-center">
                {{ Form::open(array('route' => 'auth.addkey', 'class' => 'panel' )) }}
                <div class="form-group @if ($errors->first('api_key')) has-error @endif">
                  <div class="input-group">
                      <span class="input-group-addon"><strong>@</strong></span>
                      {{ Form::text('api_key', null, array('placeholder' => 'sk_live_A#B#C#1#2#3#', 'class' => 'form-control')) }}
                  </div>
                  <p class="help-block">
                  @if ($errors->first('api_key'))
                    {{ $errors->first('api_key') }}
                  @endif
                  </p>
                </div>
                {{ Form::submit('Upload API key', array(
                    'id' => 'id_sumbit',
                    'class' => 'btn btn-info')) }}

            {{ Form::close() }}

            </div>

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container --></body>
</html>
