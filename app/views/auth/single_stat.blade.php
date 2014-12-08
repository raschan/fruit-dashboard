@extends('meta.base-user')

  @section('pageContent')
    <div id="content-wrapper">

      <div class="page-header">
        <h1><i class="fa fa-bar-chart-o page-header-icon"></i>&nbsp;&nbsp;Stat Panels (single view)</h1>
      </div> <!-- / .page-header -->

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
          <div class="single-statistic">
            <canvas class="center-block"></canvas>
          </div>
          <div class="statistic-description padding-sm-vr">
            <div class="note note-info">
              <h4 class="note-title">Info note title</h4>
              Info note text here.
            </div>
          </div>
        </div> <!-- /.invoice -->
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
      Chart.defaults.global.responsive = true;

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