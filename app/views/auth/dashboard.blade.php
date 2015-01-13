@extends('meta.base-user')

  @section('pageContent')
      <!-- <div id="main-menu" role="navigation">
      </div> -->
    <div id="content-wrapper">
      <div class="page-header">
        <h1><i class="fa fa-bar-chart-o page-header-icon"></i>&nbsp;&nbsp;Quick statistics</h1>
      </div> <!-- / .page-header -->

      <!-- STATISTICS BOX -->

      <div class="col-md-8 quickstats-box no-padding-hr">
        <div class="row">
          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas id="mrr"></canvas>
              <div class="chart-text-left">
                <span class="text-money up">$1234,45</span>
              </div>
              <div class="chart-text-right">
                <span class="text-money up"><i class="fa fa-angle-up"></i> 55%</span>
                <h6 class="no-margin">Previous 31 days</h6>
              </div>
              <a href="{{ URL::route('auth.single_stat') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">Monthly Recurring Revenue</h4>
            </div>
          </div>

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas></canvas>
              <div class="chart-text-left">
                <span class="text-money up">$1313,15</span>
              </div>
              <div class="chart-text-right">
                <span class="text-money up"><i class="fa fa-angle-up"></i> 155%</span>
                <h6 class="no-margin">Previous 31 days</h6>
              </div>
              <a href="{{ URL::route('auth.single_stat') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">Net Revenue</h4>
            </div>
          </div>

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas></canvas>
              <div class="chart-text-left">
                <span class="text-money up">$866</span>
              </div>
              <div class="chart-text-right">
                <span class="text-money up"><i class="fa fa-angle-up"></i> 0.2%</span>
                <h6 class="no-margin">Previous 31 days</h6>
              </div>
              <a href="{{ URL::route('auth.single_stat') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">Fees</h4>
            </div>
          </div>
        </div> <!-- / .row   -->

        <div class="row">

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
                <canvas></canvas>
                <div class="chart-text-left">
                  <span class="text-money nochange">$0</span>
                  <h6 class="no-margin">Previous 31 days</h6>
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

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
                <canvas></canvas>
                <div class="chart-text-left">
                  <span class="text-money up">$66</span>
                </div>
                <div class="chart-text-right">
                  <span class="text-money up"><i class="fa fa-angle-up"></i> 0.2%</span>
                  <h6 class="no-margin">Previous 31 days</h6>
                </div>
                <a href="{{ URL::route('auth.single_stat') }}">
                  <div class="chart-overlay">
                    <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                  </div>
                </a>
                <h4 class="text-center">Average Revenue Per User</h4>
            </div>
          </div>

          <div class="col-md-4 chart-box">
            <div class="chart-wrapper">
              <canvas></canvas>
              <div class="chart-text-left">
                <span class="text-money down">-$99</span>
              </div>
              <div class="chart-text-right">
                <span class="text-money down"><i class="fa fa-angle-down"></i> -133%</span>
                <h6 class="no-margin">Previous 31 days</h6>
              </div>
              <a href="{{ URL::route('auth.single_stat') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">Annual Run Rate</h4>
            </div>
          </div>

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

    /*Monthly Recurring Revenue*/

    var data = {
      labels: [@foreach ($mrr_history as $mrr)"", @endforeach],
      datasets: [
          {
              label: "Monthly Recurring Revenue",
              fillColor: "rgba(151,187,205,0.4)",
              strokeColor: "rgba(151,187,205,0.6)",
              pointColor: "rgba(151,187,205,1)",
              pointStrokeColor: "#fff",
              pointHighlightFill: "#fff",
              data: [@foreach ($mrr_history as $mrr){{$mrr}}, @endforeach]
          }
      ]
    };

    var ctx = $('#mrr').get(0).getContext("2d");
    var MRRChart = new Chart(ctx).Line(data, options);
       
    </script>

  @stop

  @section('intercomScript')
  <script>

  </script>
  {{ HTML::script('js/intercom_io.js'); }}
  @stop

