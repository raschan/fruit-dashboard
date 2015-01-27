@extends('meta.base-user')

  @section('pageContent')
    <div id="content-wrapper">

      <!-- <div class="page-header text-center">
        <h1><i class="fa fa-bar-chart-o page-header-icon"></i>&nbsp;&nbsp;Stat Panels (single view)</h1>
      </div> -->
      <div class="col-md-12">

        <div class="row no-margin-hr panel-padding stat-header">

          <div class="col-md-4 col-lg-5">
              <small><strong>CHOOSE A STATISTIC:</strong></small><br>
              <select class="form-control stat-input">
                <option>{{ $Data['statName'] }}</option>
                <option>{{ $Data['statName'] }}</option>
                <option>{{ $Data['statName'] }}</option>
              </select>
          </div>
                  
          <div class="col-md-8 col-lg-6 col-lg-offset-1">
            <small><strong>DATE</strong></small><br>
            <form class="form-inline">
              <div class="form-group date">
                <input type="text" class="form-control stat-input" id="startDateStat" value="{{ $Data['dateInterval']['startDate'] }}">
              </div>
              <div class="form-group dash">
                -
              </div>
              <div class="form-group date">
                <input type="text" class="form-control stat-input" id="stopDateStat" value="{{ $Data['dateInterval']['stopDate'] }}">
              </div>
            </form>
          </div>

        </div> <!-- / .stat-header -->

          
        <div class="row panel-body">
          <div class="single-statistic-wrapper">
            <canvas></canvas>
          </div>
          <div class="statistic-description">
            <div class="row">
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>Current</h4></span>
                @if($Data['currentValue'])
                  @if(!str_contains($Data['currentValue'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                  {{ $Data['currentValue'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>30 days ago</h4></span>
                @if($Data['oneMonth'])
                  @if(!str_contains($Data['oneMonth'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                  {{ $Data['oneMonth'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>6 months ago</h4></span>
                @if($Data['sixMonth'])
                  @if(!str_contains($Data['sixMonth'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                  {{ $Data['sixMonth'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>1 year ago</h4></span>
                @if($Data['oneYear'])
                  @if(!str_contains($Data['oneYear'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                  {{ $Data['oneYear'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
            </div> <!-- / .row -->
          </div> <!-- / .statistic-description -->
        </div> <!-- / .row .panel-body -->
           

        <div class="row panel-padding">
          <div class="panel">
            <div class="statistic-description">
              <div class="row">
                <div class="col-md-2 stat-growth-box">
                  <span class="text-date"><h4>30 days growth</h4></span>
                  @if($Data['oneMonthChange'])
                    @if(!str_contains($Data['oneMonthChange'],'-'))
                      <span class="text-money up"><i class="fa fa-angle-up"></i>
                    @else
                      <span class="text-money down"><i class="fa fa-angle-down"></i>
                    @endif
                    {{ $Data['oneMonthChange'] }}
                  @else
                    <span class="text-money down">
                    N/A
                  @endif
                  </span>
                </div>
                <div class="col-md-2 stat-growth-box">
                  <span class="text-date"><h4>60 days growth</h4></span>
                  @if($Data['twoMonthChange'])
                    @if(!str_contains($Data['twoMonthChange'],'-'))
                      <span class="text-money up"><i class="fa fa-angle-up"></i>
                    @else
                      <span class="text-money down"><i class="fa fa-angle-down"></i>
                    @endif
                    {{ $Data['twoMonthChange'] }}
                  @else
                    <span class="text-money down">
                    N/A
                  @endif
                  </span>
                </div>
                <div class="col-md-2 stat-growth-box">
                  <span class="text-date"><h4>3 month growth</h4></span>
                  @if($Data['threeMonthChange'])
                    @if(!str_contains($Data['threeMonthChange'],'-'))
                      <span class="text-money up"><i class="fa fa-angle-up"></i>
                    @else
                      <span class="text-money down"><i class="fa fa-angle-down"></i>
                    @endif
                    {{ $Data['threeMonthChange'] }}
                  @else
                    <span class="text-money down">
                    N/A
                  @endif
                  </span>
                </div>
                <div class="col-md-2 stat-growth-box">
                  <span class="text-date"><h4>6 month growth</h4></span>
                  @if($Data['sixMonthChange'])
                    @if(!str_contains($Data['sixMonthChange'],'-'))
                      <span class="text-money up"><i class="fa fa-angle-up"></i>
                    @else
                      <span class="text-money down"><i class="fa fa-angle-down"></i>
                    @endif
                    {{ $Data['sixMonthChange'] }}
                  @else
                    <span class="text-money down">
                    N/A
                  @endif
                  </span>
                </div>
                  <div class="col-md-2 stat-growth-box">
                  <span class="text-date"><h4>9 month growth</h4></span>
                  @if($Data['nineMonthChange'])
                    @if(!str_contains($Data['nineMonthChange'],'-'))
                      <span class="text-money up"><i class="fa fa-angle-up"></i>
                    @else
                      <span class="text-money down"><i class="fa fa-angle-down"></i>
                    @endif
                    {{ $Data['nineMonthChange'] }}
                  @else
                    <span class="text-money down">
                    N/A
                  @endif
                  </span>
                </div>
                <div class="col-md-2 stat-growth-box">
                  <span class="text-date"><h4>1 year growth</h4></span>
                  @if($Data['oneYearChange'])
                    @if(!str_contains($Data['oneYearChange'],'-'))
                      <span class="text-money up"><i class="fa fa-angle-up"></i>
                    @else
                      <span class="text-money down"><i class="fa fa-angle-down"></i>
                    @endif
                    {{ $Data['oneYearChange'] }}
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

        <div class="row no-margin-hr panel-padding stat-header">

          <div class="col-md-4 col-lg-5">
            <div>
              <h3>
              {{ $Data['statName'] }} datatable
              </h3>
            </div>
          </div>

          <div class="col-md-8 col-lg-6 col-lg-offset-1">
            <small><strong>DATE</strong></small><br>
            <form class="form-inline">
              <div class="form-group date">
                <input type="text" class="form-control stat-input" id="startDatetable" value="{{ $Data['dateInterval']['startDate'] }}">
              </div>
              <div class="form-group dash">
                -
              </div>
              <div class="form-group date">
                <input type="text" class="form-control stat-input" id="stopDatetable" value="{{ $Data['dateInterval']['stopDate'] }}">
              </div>
            </form>
          </div> 

        </div> <!-- / .row .stat-header   -->

        <div class="row panel-body">
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
              <span>{{ $Data['currentValue'] }}</span>
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
                  
                  @foreach ($Data['detailData'] as $details)
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
        </div> <!-- /. row -->
      </div> <!-- . col-md-12 -->
    </div> <!-- / #content-wrapper -->
  @stop

  @section('pageScripts')
    {{ HTML::script('js/JQtable.js'); }}

    <script type="text/javascript">

    init.push(function () {
       $('#startDateStat').datepicker({
           format: "dd-mm-yyyy",
           todayHighlight: true,
           autoclose: true
       });
       $('#stopDateStat').datepicker({
           format: "dd-mm-yyyy",
           todayHighlight: true,
           autoclose: true
       });
     });

    /*for later, event fire catching
    $('yourpickerid').on('changeDate', function(ev){
      $(this).datepicker('hide');
    });*/
    
    var options = {
      scaleShowHorizontalLines: true,
      scaleShowVerticalLines: false,
      scaleFontFamily: "'Arial', sans-serif",
      responsive: true,
      maintainAspectRatio: false,
      bezierCurveTension : 0.1    
    };

    var data = {
      labels: [@foreach ($Data['history'] as $date => $value)"{{ $date }}", @endforeach],
      datasets: [
          {
              label: "Monthly Recurring Revenue",
              fillColor: "rgba(151,187,205,0.4)",
              strokeColor: "rgba(151,187,205,0.6)",
              data: [@foreach ($Data['history'] as $date => $value)@if($value == null)0,@else{{ $value }},@endif @endforeach]
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