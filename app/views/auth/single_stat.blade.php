@extends('meta.base-user')

  @section('pageContent')
    <div id="content-wrapper">

      <!-- <div class="page-header">
        <h1><i class="fa fa-bar-chart-o page-header-icon"></i>&nbsp;&nbsp;Stat Panels (single view)</h1>
      </div> -->

      <div class="row panel-padding">
        <div class="panel invoice">
          <div class="invoice-header">
            <h3>
              <div class="invoice-logo demo-logo"></div>
              <div>
                <small><strong>Pixel</strong>Admin</small><br>
                STATISTIC #244
              </div>
            </h3>
            <address>
              PixelAdmin Ltd.<br>
              Los Angeles, Hoover Street, 32<br>
              90080 CA, USA
            </address>
            <div class="invoice-date">
              <small><strong>Date</strong></small><br>
              February 21, 2013
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
              <div class="invoice-logo demo-logo"></div>
              <div>
                <small><strong>Pixel</strong>Admin</small><br>
                INVOICE #244
              </div>
            </h3>
            <address>
              PixelAdmin Ltd.<br>
              Los Angeles, Hoover Street, 32<br>
              90080 CA, USA
            </address>
            <div class="invoice-date">
              <small><strong>Date</strong></small><br>
              February 21, 2013
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
            <table>
              <thead>
                <tr>
                  <th>
                    Task description
                  </th>
                  <th>
                    Rate
                  </th>
                  <th>
                    Hours
                  </th>
                  <th>
                    Line total
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    Website design and development
                    <div class="invoice-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</div>
                  </td>
                  <td>
                    $50.00
                  </td>
                  <td>
                    50
                  </td>
                  <td>
                    $2,500.00
                  </td>
                </tr>
                <tr>
                  <td>
                    Branding
                    <div class="invoice-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</div>
                  </td>
                  <td>
                    $47.95
                  </td>
                  <td>
                    45
                  </td>
                  <td>
                    $2,157.75
                  </td>
                </tr>
              </tbody>
            </table>
          </div> <!-- / .invoice-table -->
        </div> <!-- /. invoice -->
      </div> <!-- /. row -->
    </div> <!-- / #content-wrapper -->
  @stop

  @section('pageScripts')

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