@extends('meta.base-user')

  @section('pageContent')
      <!-- <div id="main-menu" role="navigation">
      </div> -->
    <div id="content-wrapper">
      <div class="page-header">
        <h1><i class="fa fa-bar-chart-o page-header-icon"></i>&nbsp;&nbsp;Stat Panels (quick view)</h1>
      </div> <!-- / .page-header -->

      <div class="row">

        <div class="col-sm-8 quickstats-box no-padding-hr">
          <div class="col-sm-4 chart-box">
            <div class="chart-wrapper">
                <canvas></canvas>
                <div class="chart-text-left">
                  <span class="text-money up">$1234,45</span>
                </div>
                <div class="chart-text-right">
                  <span class="text-money up"><i class="fa fa-angle-up"></i> 55%</span>
                </div>

                <a class="chart-wrapper" href="{{ URL::route('auth.dashboard') }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
                <h4 class="text-center">Monthly recurring revenue</h4>
            </div>
          </div>

          <div class="col-sm-4 chart-box">
            <div class="chart-wrapper">
                <canvas></canvas>
                <div class="chart-text-left">
                  <span class="text-money up">$1234,45</span>
                </div>
                <div class="chart-text-right">
                  <span class="text-money up"><i class="fa fa-angle-up"></i> 55%</span>
                </div>
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
                <h4 class="text-center">Monthly recurring revenue</h4>
            </div>
          </div>

          <div class="col-sm-4 chart-box">
            <div class="chart-wrapper">
                <canvas></canvas>
                <div class="chart-text-left">
                  <span class="text-money up">$1234,45</span>
                </div>
                <div class="chart-text-right">
                  <span class="text-money up"><i class="fa fa-angle-up"></i> 55%</span>
                </div>
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
                <h4 class="text-center">Monthly recurring revenue</h4>
            </div>
          </div>

        </div> <!-- /. col-sm-8 -->

        <div class="col-sm-4 feed-box">
          <ul class="list-group">
            <li class="list-group-item">
              <h4>Feed</h4>
            </li>
            <li class="list-group-item">
              <span class="badge badge-success">Charged</span>
              Cras justo odio
            </li> <!-- / .list-group-item -->
            <li class="list-group-item">
              <span class="badge badge-danger">FAILED</span>
              Dapibus ac facilisis in
            </li> <!-- / .list-group-item -->
            <li class="list-group-item">
              <span class="badge badge-info">Downgrade</span>
              Morbi leo risus
            </li> <!-- / .list-group-item -->
          </ul>

        </div> <!-- /. col-sm-4 -->

      </div> <!-- /.row -->

      <div class="row">

        <div class="col-sm-8 quickstats-box no-padding-hr">
          <div class="col-sm-4 chart-box">
            <div class="chart-wrapper">
                <canvas></canvas>
                <div class="chart-text-left">
                  <span class="text-money up">$1234,45</span>
                </div>
                <div class="chart-text-right">
                  <span class="text-money up"><i class="fa fa-angle-up"></i> 55%</span>
                </div>
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
                <h4 class="text-center">Monthly recurring revenue</h4>
            </div>
          </div>

          <div class="col-sm-4 chart-box">
            <div class="chart-wrapper">
                <canvas></canvas>
                <div class="chart-text-left">
                  <span class="text-money up">$1234,45</span>
                </div>
                <div class="chart-text-right">
                  <span class="text-money up"><i class="fa fa-angle-up"></i> 55%</span>
                </div>
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
                <h4 class="text-center">Monthly recurring revenue</h4>
            </div>
          </div>

          <div class="col-sm-4 chart-box">
            <div class="chart-wrapper">
                <canvas></canvas>
                <div class="chart-text-left">
                  <span class="text-money up">$1234,45</span>
                </div>
                <div class="chart-text-right">
                  <span class="text-money up"><i class="fa fa-angle-up"></i> 55%</span>
                </div>
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
                <h4 class="text-center">Monthly recurring revenue</h4>
            </div>
          </div>
          
        </div> <!-- /. col-sm-12 -->

    </div>  <!-- / #content-wrapper -->

  @stop

  @section('pageScripts')

    <script type="text/javascript">
    var options = {
      responsive: true,
      maintainAspectRatio: false,
      showScale: false,
      showTooltips: false,
      pointDot: false
    };

      var data = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
        {
            label: "My Second dataset",
            fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,0.4)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: [28, 48, 40, 19, 86, 27, 90, 75]
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

