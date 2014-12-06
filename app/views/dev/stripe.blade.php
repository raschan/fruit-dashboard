
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stripe testing Page</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Page Content -->
    <div class="container">

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
                    @foreach ($charges as $id=>$charge)
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
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container --></body>
</html>
