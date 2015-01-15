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
                <i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;STATISTIC NAME
              </div>
            </h3>
            <div class="invoice-date">
              <small><strong>DATE</strong></small><br>
              February 11, 2012 - February 21, 2013
            </div>
          </div> <!-- / .invoice-header -->
          <div class="single-statistic-wrapper">
            <canvas></canvas>
          </div>
          <div class="statistic-description">
            <div class="row">
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>Current</h4></span>
                <span class="text-money up">$23,444</span>
              </div>
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>30 days ago</h4></span>
                <span class="text-money up">$23,444</span>
              </div>
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>6 months ago</h4></span>
                <span class="text-money up">$23,444</span>
              </div>
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>1 year ago</h4></span>
                <span class="text-money up">$23,444</span>
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
                <span class="text-money down"><i class="fa fa-angle-down"></i> 5%</span>
              </div>
              <div class="col-md-2 stat-growth-box">
                <span class="text-date"><h4>60 days growth</h4></span>
                <span class="text-money down"><i class="fa fa-angle-down"></i> 5%</span>
              </div>
              <div class="col-md-2 stat-growth-box">
                <span class="text-date"><h4>3 month growth</h4></span>
                <span class="text-money up"><i class="fa fa-angle-up"></i> 10%</span>
              </div>
              <div class="col-md-2 stat-growth-box">
                <span class="text-date"><h4>6 month growth</h4></span>
                <span class="text-money up"><i class="fa fa-angle-up"></i> 55%</span>
              </div>
                <div class="col-md-2 stat-growth-box">
                <span class="text-date"><h4>9 month growth</h4></span>
                <span class="text-money up"><i class="fa fa-angle-up"></i> 178%</span>
              </div>
              <div class="col-md-2 stat-growth-box">
                <span class="text-date"><h4>1 year growth</h4></span>
                <span class="text-money up"><i class="fa fa-angle-up"></i> 1%</span>
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
                STATISTIC NAME DATATABLE
              </div>
            </h3>
            <div class="invoice-date">
              <small><strong>DATE</strong></small><br>
              February 11, 2012 - February 21, 2013
            </div>
          </div> <!-- / .invoice-header -->
          <div class="invoice-info">
            <div class="invoice-recipient">
              <strong>Mr. John Smith</strong><br>
              New York, Pass Avenue, 109<br>
              10012 NY, USA
            </div> <!-- / .invoice-recipient -->
            <div class="invoice-total">
              TOTAL:
              <span>$4,657.75</span>
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
                    <th>DATE</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>TOHOTOM</td>
                    <td class="text-center">5</td>
                    <td class="text-center text-money up">$711</td>
                    <td class="timestamp">2015.01.01. 20:11</td>
                  </tr>
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
        var myNewChart = new Chart(ctx).Line(data, options);
      });
    </script>

  @stop

  @section('intercomScript')
  <script>
     
  </script>
  {{ HTML::script('js/intercom_io.js'); }}
  @stop