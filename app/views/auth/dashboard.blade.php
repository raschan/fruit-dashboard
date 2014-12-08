@extends('meta.base-user')

  @section('pageContent')
      <!-- <div id="main-menu" role="navigation">
      </div> -->
    <div id="content-wrapper">
      <div class="page-header">
        <h1><i class="fa fa-bar-chart-o page-header-icon"></i>&nbsp;&nbsp;Stat Panels (quick view)</h1>
      </div> <!-- / .page-header -->

      <div class="row panel-padding">
        <div class="col-md-5">
          <div class="stat-panel">
            <!-- Success background, bordered, without top and bottom borders, without left border, without padding, vertically and horizontally centered text, large text -->
            <a href="#" class="stat-cell col-xs-5 bg-success bordered no-border-vr no-border-l no-padding valign-middle text-center text-lg">
              <i class="fa fa-calendar"></i>&nbsp;&nbsp;<strong>11</strong>
            </a> <!-- /.stat-cell -->
            <!-- Without padding, extra small text -->
            <div class="stat-cell col-xs-7 no-padding valign-middle">
              <!-- Add parent div.stat-rows if you want build nested rows -->
              <div class="stat-rows">
                <div class="stat-row">
                  <!-- Success background, small padding, vertically aligned text -->
                  <a href="#" class="stat-cell bg-success padding-sm valign-middle">
                    32 messages
                    <i class="fa fa-envelope-o pull-right"></i>
                  </a>
                </div>
                <div class="stat-row">
                  <!-- Success darken background, small padding, vertically aligned text -->
                  <a href="#" class="stat-cell bg-success darken padding-sm valign-middle">
                    9 issues
                    <i class="fa fa-bug pull-right"></i>
                  </a>
                </div>
                <div class="stat-row">
                  <!-- Success darker background, small padding, vertically aligned text -->
                  <a href="#" class="stat-cell bg-success darker padding-sm valign-middle">
                    47 new users
                    <i class="fa fa-users pull-right"></i>
                  </a>
                </div>
              </div> <!-- /.stat-rows -->
            </div> <!-- /.stat-cell -->
          </div>
        </div>

        <div class="col-md-4 chart-box">
          <a href=""><h4 class="text-default">I have a link col-md-4 :(</h4></a>
          <canvas class="center-block"></canvas>
        </div>

        <div class="col-md-3 chart-box">
          <h4><i class="fa icon fa-arrow-left"></i> I have an icon col-md-3 :(</h4></a>
          <canvas class="center-block"></canvas>
        </div>

      </div> <!-- /.row -->

      <div class="row panel-padding">

        <div class="col-md-4 chart-box">
          <a href=""><h4 class="text-default">I have a link col-md-4 :(</h4></a>
          <canvas class="center-block"></canvas>
        </div>

        <div class="col-md-3 col-md-offset-1 chart-box">
          <h4><i class="fa icon fa-arrow-left"></i> I have an icon :(</h4></a>
          <canvas class="center-block"></canvas>
        </div>

        <div class="col-md-3 col-md-offset-1 chart-box">
          <h4><i class="fa icon fa-arrow-left"></i> I have an icon :(</h4></a>
          <canvas class="center-block"></canvas>
        </div>

      </div> <!-- /.row -->

      <div class="row panel-padding">

        <div class="col-md-4 chart-box">
          <a href=""><h4 class="text-default">I have a link col-md-4 :(</h4></a>
          <canvas class="center-block"></canvas>
        </div>

        <div class="col-md-4 chart-box">
          <h4><i class="fa icon fa-arrow-left"></i> I have an icon :(</h4></a>
          <canvas class="center-block"></canvas>
        </div>

        <div class="col-md-4 chart-box">
          <h4><i class="fa icon fa-arrow-left"></i> I have an icon :(</h4></a>
          <canvas class="center-block"></canvas>
        </div>

      </div> <!-- /.row -->

    </div>  <!-- / #content-wrapper -->

  @stop

  @section('pageScripts')

    <script type="text/javascript">
      var data = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
        {
            label: "My First dataset",
            fillColor: "rgba(220,220,220,0.2)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [65, 59, 80, 81, 56, 55, 40]
        },
        {
            label: "My Second dataset",
            fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: [28, 48, 40, 19, 86, 27, 90]
        }
    ]
};

      $('canvas').each( function () {
        var ctx = $(this).get(0).getContext("2d");
        var myNewChart = new Chart(ctx).Line(data);
      });
    </script>

  @stop

  @section('intercomScript')
  <script>
     
  </script>
  {{ HTML::script('js/intercom_io.js'); }}
  @stop

