@extends('meta.base-user')

  @section('pageContent')
      <!-- <div id="main-menu" role="navigation">
      </div> -->
    <div id="content-wrapper">
      <div class="page-header text-center">
        <h1><i class="fa fa-home page-header-icon"></i>&nbsp;&nbsp;Dashboard</h1>
      </div> <!-- / .page-header -->

      <!-- STATISTICS BOX -->

      <!-- Monthly Recurring Revenue -->

      <div class="col-md-8 quickstats-box no-padding-hr">
        <div class="row">
          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas id="{{ $mrrData['id'] }}"></canvas>
              <div class="chart-text-left"> 
                @if($mrrData['currentValue'])
                  @if(!str_contains($mrrData['currentValue'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                  {{ $mrrData['currentValue'] }}
                @else
                  <span class="text-money nochange">
                  --
                @endif
                </span>
              </div>
              <div class="chart-text-right">
                @if($mrrData['oneMonthChange'])
                  @if(!str_contains($mrrData['oneMonthChange'],'-'))
                    <span class="text-money up"><i class="fa fa-angle-up"></i>
                  @else
                    <span class="text-money down"><i class="fa fa-angle-down"></i>
                  @endif
                  {{ $mrrData['oneMonthChange'] }}
                  </span>
                <h6 class="no-margin">Previous 30 days</h6>
                @else
                  <span class="text-money nochange">
                  --
                  </span>
                <h6 class="no-margin">Not enough data</h6>
                @endif
              </div>
              <a href="{{ URL::route('auth.single_stat', '{{ $mrrData['id'] }}') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">{{ $mrrData['statName'] }}</h4>
            </div>
          </div>

          <!-- /Monthly Recurring Revenue -->

          <!-- Net Revenue -->

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas></canvas>
              <div class="chart-text-left">
                <span class="text-money up">$1313,15</span>
              </div>
              <div class="chart-text-right">
                <span class="text-money up"><i class="fa fa-angle-up"></i> 155%</span>
                <h6 class="no-margin">Previous 30 days</h6>
              </div>
              <a href="{{ URL::route('auth.single_stat') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">Net Revenue</h4>
            </div>
          </div>

          <!-- /Net Revenue -->

          <!-- Fees -->

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas></canvas>
              <div class="chart-text-left">
                <span class="text-money up">$866</span>
              </div>
              <div class="chart-text-right">
                <span class="text-money up"><i class="fa fa-angle-up"></i> 0.2%</span>
                <h6 class="no-margin">Previous 30 days</h6>
              </div>
              <a href="{{ URL::route('auth.single_stat') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">Fees</h4>
            </div>
          </div>

          <!-- /Fees -->

        </div> <!-- / .row   -->

        <div class="row">

          <!-- Other Revenue -->

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
                <canvas></canvas>
                <div class="chart-text-left">
                  <span class="text-money nochange">$0</span>
                  <h6 class="no-margin">Previous 30 days</h6>
                </div>
                <div class="chart-text-right">
                  <span class="text-money nochange"> --</span>
                </div>
                <a href="{{ URL::route('auth.single_stat') }}">
                  <div class="chart-overlay">
                    <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                  </div>
                </a>
                <h4 class="text-center">Other Revenue</h4>
            </div>
          </div>

          <!-- /Other Revenue -->

          <!-- Average Revenue Per User -->

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
                <canvas></canvas>
                <div class="chart-text-left">
                  <span class="text-money up">$66</span>
                </div>
                <div class="chart-text-right">
                  <span class="text-money up"><i class="fa fa-angle-up"></i> 0.2%</span>
                  <h6 class="no-margin">Previous 30 days</h6>
                </div>
                <a href="{{ URL::route('auth.single_stat') }}">
                  <div class="chart-overlay">
                    <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                  </div>
                </a>
                <h4 class="text-center">Average Revenue Per User</h4>
            </div>
          </div>

          <!-- /Average Revenue Per User -->

          <!-- Annual Run Rate -->

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas></canvas>
              <div class="chart-text-left">
                <span class="text-money down">$99</span>
              </div>
              <div class="chart-text-right">
                <span class="text-money down"><i class="fa fa-angle-down"></i> -133%</span>
                <h6 class="no-margin">Previous 30 days</h6>
              </div>
              <a href="{{ URL::route('auth.single_stat') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">Annual Run Rate</h4>
            </div>
          </div>

        </div> <!-- / .row   -->

        <div class="row">

          <!-- Lifetime Value -->

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas></canvas>
              <div class="chart-text-left">
                <span class="text-money down">$99</span>
              </div>
              <div class="chart-text-right">
                <span class="text-money down"><i class="fa fa-angle-down"></i> -133%</span>
                <h6 class="no-margin">Previous 30 days</h6>
              </div>
              <a href="{{ URL::route('auth.single_stat') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">Lifetime Value</h4>
            </div>
          </div>

          <!-- /Lifetime Value -->

          <!-- User Churn -->

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas></canvas>
              <div class="chart-text-left">
                <span class="text-money down">99%</span>
              </div>
              <div class="chart-text-right">
                <span class="text-money down"><i class="fa fa-angle-down"></i> -133%</span>
                <h6 class="no-margin">Previous 30 days</h6>
              </div>
              <a href="{{ URL::route('auth.single_stat') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">User Churn</h4>
            </div>
          </div>

          <!-- /User Churn -->

          <!-- Revenue Churn -->

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas></canvas>
              <div class="chart-text-left">
                <span class="text-money down">99%</span>
              </div>
              <div class="chart-text-right">
                <span class="text-money down"><i class="fa fa-angle-down"></i> -133%</span>
                <h6 class="no-margin">Previous 30 days</h6>
              </div>
              <a href="{{ URL::route('auth.single_stat') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">Revenue Churn</h4>
            </div>
          </div>

          <!-- /Revenue Churn -->

        </div> <!-- / .row   -->

        <div class="row">

          <!-- Customers -->

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas></canvas>
              <div class="chart-text-left">
                <span class="text-money down">99</span>
              </div>
              <div class="chart-text-right">
                <span class="text-money down"><i class="fa fa-angle-down"></i> -133%</span>
                <h6 class="no-margin">Previous 30 days</h6>
              </div>
              <a href="{{ URL::route('auth.single_stat') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">Customers</h4>
            </div>
          </div>

          <!-- /Customers -->

          <!-- Upgrades -->

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas></canvas>
              <div class="chart-text-left">
                <span class="text-money down">99</span>
              </div>
              <div class="chart-text-right">
                <span class="text-money down"><i class="fa fa-angle-down"></i> -133%</span>
                <h6 class="no-margin">Previous 30 days</h6>
              </div>
              <a href="{{ URL::route('auth.single_stat') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">Upgrades</h4>
            </div>
          </div>

          <!-- /Upgrades -->

          <!-- Coupons -->

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas></canvas>
              <div class="chart-text-left">
                <span class="text-money down">$99</span>
              </div>
              <div class="chart-text-right">
                <span class="text-money down"><i class="fa fa-angle-down"></i> -133%</span>
                <h6 class="no-margin">Previous 30 days</h6>
              </div>
              <a href="{{ URL::route('auth.single_stat') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">Coupons</h4>
            </div>
          </div>

          <!-- /Coupons -->

        </div> <!-- / .row   -->

        <div class="row">

          <!-- Failed Charges -->

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas></canvas>
              <div class="chart-text-left">
                <span class="text-money down">99</span>
              </div>
              <div class="chart-text-right">
                <span class="text-money down"><i class="fa fa-angle-down"></i> -133%</span>
                <h6 class="no-margin">Previous 30 days</h6>
              </div>
              <a href="{{ URL::route('auth.single_stat') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">Failed Charges</h4>
            </div>
          </div>

          <!-- /Failed Charges -->

          <!-- Refunds -->

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas></canvas>
              <div class="chart-text-left">
                <span class="text-money down">$99</span>
              </div>
              <div class="chart-text-right">
                <span class="text-money down"><i class="fa fa-angle-down"></i> -133%</span>
                <h6 class="no-margin">Previous 30 days</h6>
              </div>
              <a href="{{ URL::route('auth.single_stat') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">Refunds</h4>
            </div>
          </div>

          <!-- /Refunds -->

        </div> <!-- / .row -->
      </div> <!-- / .col-sm-8 -->

      <!-- /STATISTICS BOX -->

      <!-- FEED BOX -->

      <div class="col-md-4 feed-box">
        <ul class="list-group">
          <li class="list-group-item">
            <h4>Transactions</h4>
          </li>
          <li class="list-group-item">
            <span class="badge badge-success">Charged</span>
            <span class="text-money up">$55</span> Cras justo odio <span class="timestamp">20:44</span>
          </li> <!-- / .list-group-item -->
          <li class="list-group-item">
            <span class="badge badge-success">Charged</span>
            <span class="text-money up">$55</span> Cras justo odio <span class="timestamp">20:44</span>
          </li> <!-- / .list-group-item -->
          <li class="list-group-item">
            <span class="badge badge-success">Charged</span>
            <span class="text-money up">$55</span> Cras justo odio <span class="timestamp">20:44</span>
          </li> <!-- / .list-group-item -->
          <li class="list-group-item">
            <span class="badge badge-success">Charged</span>
            <span class="text-money up">$55</span> Cras justo odio <span class="timestamp">20:44</span>
          </li> <!-- / .list-group-item -->
          <li class="list-group-item">
            <span class="badge badge-success">Charged</span>
            <span class="text-money up">$55</span> Cras justo odio <span class="timestamp">20:44</span>
          </li> <!-- / .list-group-item -->
          <li class="list-group-item">
            <span class="badge badge-danger">FAILED</span>
            <span class="text-money nochange">$55</span> Dapibus ac facilisis in <span class="timestamp">20:44</span>
          </li> <!-- / .list-group-item -->
          <li class="list-group-item">
            <span class="badge badge-info">Downgrade</span>
            Morbi leo risus <span class="timestamp">20:44</span>
          </li> <!-- / .list-group-item -->
        </ul>
      </div> <!-- / .col-sm-4 -->

      <!-- /FEED BOX -->

    </div>  <!-- / #content-wrapper -->

  @stop

  @section('pageScripts')

    <script type="text/javascript">

    /*chart.js options*/

    var options = {
      responsive: true,
      maintainAspectRatio: false,
      showScale: false,
      showTooltips: false,
      pointDot: false,
      tooltipXOffset: 0
    };

    var data, ctx;

    /* Monthly Recurring Revenue */

    data = {
      labels: [@foreach ($mrrData['history'] as $date => $value)"", @endforeach],
      datasets: [
          {
              label: "Monthly Recurring Revenue",
              fillColor: "rgba(151,187,205,0.4)",
              strokeColor: "rgba(151,187,205,0.6)",
              data: [@foreach ($mrrData['history'] as $date => $value)@if($value == null)0,@else{{ $value }},@endif @endforeach]
          }
      ]
    };

    ctx = $('#mrr').get(0).getContext("2d");
    var MRRChart = new Chart(ctx).Line(data, options);


       
    </script>

  @stop

  @section('intercomScript')
  <script>

  </script>
  {{ HTML::script('js/intercom_io.js'); }}
  @stop

