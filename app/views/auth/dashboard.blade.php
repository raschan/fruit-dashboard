@extends('meta.base-user')

  @section('pageContent')
      <!-- <div id="main-menu" role="navigation">
      </div> -->
    <div id="content-wrapper">
      <div class="page-header">
        <h1><i class="fa fa-bar-chart-o page-header-icon"></i>&nbsp;&nbsp;Stat Panels (quick view)</h1>
      </div> <!-- / .page-header -->

      <div class="row panel-padding">

        <div class="col-md-8 quickstats-box">
          <div class="col-md-4 chart-box">
            <a href=""><h4 class="text-default">I have a link :(</h4></a>
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
        </div> <!-- /. col-md-8 -->

        <div class="col-md-4 feed-box">
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

        </div> <!-- /. col-md-4 -->

      </div> <!-- /.row -->

    </div>  <!-- / #content-wrapper -->

  @stop

  @section('pageScripts')

    <script type="text/javascript">
      Chart.defaults.global.responsive = true;
      var data = {
    labels: ["", "", "", "", "", "", ""],
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

