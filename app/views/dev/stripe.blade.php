
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
    <h2>Your current MRR (or something like that) is: ${{number_format($mrr/100, 2) }}</h2>
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
                      @if(isset($event['object']['id']))
                        {{ $event['object']['id'] }}
                      @else
                      <td></td>
                      @endif
                      </td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container --></body>
</html>
