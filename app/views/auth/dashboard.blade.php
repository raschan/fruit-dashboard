@extends('meta.base-user')

  @section('pageContent')
      <!-- <div id="main-menu" role="navigation">
      </div> -->
    <div id="content-wrapper">
      <div class="page-header text-center">
        <h1><i class="fa fa-home page-header-icon"></i>&nbsp;&nbsp;Dashboard</h1>
      </div> <!-- / .page-header -->

      <!-- STATISTICS BOX -->

      <div class="col-md-8 quickstats-box no-padding-hr">

      @for ($i = 0; $i< count($allFunctions); $i++)
        @if($i == 0 || $i % 3 == 0)
        <div class="row">
        <!-- {{ $allFunctions[$i]['statName'] }} -->
        @endif
          <div class="col-md-4 chart-box">
            <div class="chart-wrapper bordered">
              <canvas id="{{ $allFunctions[$i]['id'] }}"></canvas>
              <div class="chart-text-left"> 
                @if($allFunctions[$i]['currentValue'])
                  @if(!str_contains($allFunctions[$i]['currentValue'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                  {{ $allFunctions[$i]['currentValue'] }}
                @else
                  <span class="text-money nochange">
                  --
                @endif
                </span>
              </div>
              <div class="chart-text-right">
                @if($allFunctions[$i]['oneMonthChange'])
                  @if(!str_contains($allFunctions[$i]['oneMonthChange'],'-'))
                    <span class="text-money up"><i class="fa fa-angle-up"></i>
                  @else
                    <span class="text-money down"><i class="fa fa-angle-down"></i>
                  @endif
                  {{ $allFunctions[$i]['oneMonthChange'] }}
                  </span>
                <h6 class="no-margin">Previous 30 days</h6>
                @else
                  <span class="text-money nochange">
                  --
                  </span>
                <h6 class="no-margin">Not enough data</h6>
                @endif
              </div>
              <a href="{{ URL::route('auth.single_stat', $allFunctions[$i]['id']) }}">
                <div class="chart-overlay">
                  <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                </div>
              </a>
              <h4 class="text-center">{{ $allFunctions[$i]['statName'] }}</h4>
            </div> <!-- / .chart-wrapper -->
          </div> <!-- / .chart-box -->
        @if (($i+1) % 3 == 0 || $i >= count($allFunctions) - 1)
        </div> <!-- / .row -->
        @endif
        <!-- /{{ $allFunctions[$i]['statName'] }} -->
      @endfor

      </div> <!-- / .col-sm-8 -->

      <!-- /STATISTICS BOX -->

      <!-- FEED BOX -->
      <div class="row">
        <div class="col-md-4 feed-box">
          <ul class="list-group bordered">
            <li class="list-group-item">
              <h4>Transactions</h4>
            </li>
            <li class="list-group-item">
              <span class="badge badge-success">Charged</span>
              <span class="text-money up">$55</span> Cras justo odio <span class="timestamp">20:44</span>
            </li> <!-- / .list-group-item -->
           
          </ul>
        </div> <!-- / .col-sm-4 -->
      </div>
      <!-- /FEED BOX -->

    <div id="#appendhere" class="col-md-12">

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

    

    @for ($i = 0; $i< count($allFunctions); $i++)

    /* {{ $allFunctions[$i]['statName'] }} */

    data = {
      labels: [@foreach ($allFunctions[$i]['history'] as $date => $value)"", @endforeach],
      datasets: [
          {
              label: "Monthly Recurring Revenue",
              fillColor: "rgba(151,187,205,0.4)",
              strokeColor: "rgba(151,187,205,0.6)",
              data: [@foreach ($allFunctions[$i]['history'] as $date => $value)@if($value == null)0,@else{{ $value }},@endif @endforeach]
          }
      ]
    };

    ctx = $("#{{$allFunctions[$i]['id']}}").get(0).getContext("2d");
    var {{$allFunctions[$i]['id']}}Chart = new Chart(ctx).Line(data, options);

    /* / {{ $allFunctions[$i]['statName'] }} */

    @endfor

       
    </script>

  @stop

  @section('intercomScript')
  <script>

  </script>
  {{ HTML::script('js/intercom_io.js'); }}
  @stop

