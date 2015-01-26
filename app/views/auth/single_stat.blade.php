@extends('meta.base-user')

  @section('pageContent')
    <div id="content-wrapper">

      <!-- <div class="page-header text-center">
        <h1><i class="fa fa-bar-chart-o page-header-icon"></i>&nbsp;&nbsp;Stat Panels (single view)</h1>
      </div> -->

      <div class="row panel-padding">
        <div class="panel invoice">
          <div class="invoice-header">
            <h3>
              <div>
                <i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;{{ $mrrData['statName'] }} 
              </div>
            </h3>
            <div class="invoice-date">
              <small><strong>Date</strong></small><br>
              {{ $mrrData['dateInterval']['startDate'] }} - {{ $mrrData['dateInterval']['stopDate'] }}
            </div>
          </div> <!-- / .invoice-header -->
          <div class="single-statistic-wrapper">
            <canvas></canvas>
          </div>
          <div class="statistic-description">
            <div class="row">
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>Current</h4></span>
                @if($mrrData['currentValue'])
                  @if(!str_contains($mrrData['currentValue'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                  {{ $mrrData['currentValue'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>30 days ago</h4></span>
                @if($mrrData['oneMonth'])
                  @if(!str_contains($mrrData['oneMonth'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                  {{ $mrrData['oneMonth'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>6 months ago</h4></span>
                @if($mrrData['sixMonth'])
                  @if(!str_contains($mrrData['sixMonth'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                  {{ $mrrData['sixMonth'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>1 year ago</h4></span>
                @if($mrrData['oneYear'])
                  @if(!str_contains($mrrData['oneYear'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                  {{ $mrrData['oneYear'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
            </div> <!-- /.row -->
          </div> <!-- /.statistic-description  -->
        </div> <!-- /.invoice -->
      </div> <!-- /.row -->

      <div class="row panel-padding">
        <div class="panel">
          <div class="statistic-description">
            <div class="row">
              <div class="col-md-2 stat-growth-box">
                <span class="text-date"><h4>30 days growth</h4></span>
                @if($mrrData['oneMonthChange'])
                  @if(!str_contains($mrrData['oneMonthChange'],'-'))
                    <span class="text-money up"><i class="fa fa-angle-up"></i>
                  @else
                    <span class="text-money down"><i class="fa fa-angle-down"></i>
                  @endif
                  {{ $mrrData['oneMonthChange'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
              <div class="col-md-2 stat-growth-box">
                <span class="text-date"><h4>60 days growth</h4></span>
                @if($mrrData['twoMonthChange'])
                  @if(!str_contains($mrrData['twoMonthChange'],'-'))
                    <span class="text-money up"><i class="fa fa-angle-up"></i>
                  @else
                    <span class="text-money down"><i class="fa fa-angle-down"></i>
                  @endif
                  {{ $mrrData['twoMonthChange'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
              <div class="col-md-2 stat-growth-box">
                <span class="text-date"><h4>3 month growth</h4></span>
                @if($mrrData['threeMonthChange'])
                  @if(!str_contains($mrrData['threeMonthChange'],'-'))
                    <span class="text-money up"><i class="fa fa-angle-up"></i>
                  @else
                    <span class="text-money down"><i class="fa fa-angle-down"></i>
                  @endif
                  {{ $mrrData['threeMonthChange'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
              <div class="col-md-2 stat-growth-box">
                <span class="text-date"><h4>6 month growth</h4></span>
                @if($mrrData['sixMonthChange'])
                  @if(!str_contains($mrrData['sixMonthChange'],'-'))
                    <span class="text-money up"><i class="fa fa-angle-up"></i>
                  @else
                    <span class="text-money down"><i class="fa fa-angle-down"></i>
                  @endif
                  {{ $mrrData['sixMonthChange'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
                <div class="col-md-2 stat-growth-box">
                <span class="text-date"><h4>9 month growth</h4></span>
                @if($mrrData['nineMonthChange'])
                  @if(!str_contains($mrrData['nineMonthChange'],'-'))
                    <span class="text-money up"><i class="fa fa-angle-up"></i>
                  @else
                    <span class="text-money down"><i class="fa fa-angle-down"></i>
                  @endif
                  {{ $mrrData['nineMonthChange'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
              <div class="col-md-2 stat-growth-box">
                <span class="text-date"><h4>1 year growth</h4></span>
                @if($mrrData['oneYearChange'])
                  @if(!str_contains($mrrData['oneYearChange'],'-'))
                    <span class="text-money up"><i class="fa fa-angle-up"></i>
                  @else
                    <span class="text-money down"><i class="fa fa-angle-down"></i>
                  @endif
                  {{ $mrrData['oneYearChange'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
            </div> <!-- /.row -->
          </div> <!-- /.statistic-description  -->
        </div> <!-- /.panel -->
      </div> <!-- /.row -->

      <div class="row panel-padding">
        <div class="panel invoice">
          <div class="invoice-header">
            <h3>
              <div>
                {{ $mrrData['statName'] }} datatable
              </div>
            </h3>
            <div class="invoice-date">
              <small><strong>Date</strong></small><br>
              {{ $mrrData['dateInterval']['startDate'] }} - {{ $mrrData['dateInterval']['stopDate'] }}
            </div>
          </div> <!-- / .invoice-header -->
          <div class="invoice-info">
            <div class="invoice-recipient">
              <strong>
                @if(Auth::user()->name)
                {{ Auth::user()->name }}
                @else
                N/A
                @endif
              </strong><br>
              @if(Auth::user()->zoneinfo)
              {{ Auth::user()->zoneinfo }}
              @else
              N/A
              @endif<br>
            </div> <!-- / .invoice-recipient -->
            <div class="invoice-total">
              CURRENT:
              <span>{{ $mrrData['currentValue'] }}</span>
            </div> <!-- / .invoice-total -->
          </div> <!-- / .invoice-info -->
          <hr>
          <div class="invoice-table">
            <div class="table-responsive">
              <table id="sortable" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th class="col-md-6">SOLD ITEM</th>
                    <th>CUSTOMERS</th>
                    <th>CURRENT MRR</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @foreach ($mrrData['detailData'] as $details)
                  <tr>
                  <td>{{$details['name']}} {{ $details['price'] }}</td>
                  <td class="text-center">{{ $details['count'] }}</td>
                  <td class="text-center text-money up"> {{$details['mrr']}} </td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
            </div>
          </div> <!-- / .invoice-table -->
        </div> <!-- /. invoice -->
      </div> <!-- /. row -->
    </div> <!-- / #content-wrapper -->
  @stop

  @section('pageScripts')
    {{ HTML::script('js/JQtable.js'); }}

    <script type="text/javascript">
    var options = {
      responsive: true,
      maintainAspectRatio: false,
      bezierCurveTension : 0.1
    };

    var data = {
      labels: [@foreach ($mrrData['history'] as $date => $value)"", @endforeach],
      datasets: [
          {
              label: "Monthly Recurring Revenue",
              fillColor: "rgba(151,187,205,0.4)",
              strokeColor: "rgba(151,187,205,0.6)",
              data: [@foreach ($mrrData['history'] as $date => $value){{$value}}, @endforeach]
          }
      ]
    };

      $('canvas').each( function () {
        var ctx = $(this).get(0).getContext("2d");
        var myNewChart = new Chart(ctx).Line(data, options);
      });
    </script>

  @stop

  @section('intercomScript')
  <script>
     
  </script>
  {{ HTML::script('js/intercom_io.js'); }}
  @stop