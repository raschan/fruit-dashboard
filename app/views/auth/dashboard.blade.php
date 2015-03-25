@extends('meta.base-user')

  @section('pageContent')
    
    <div id="content-wrapper">
      <div class="page-header text-center">
        <h1><i class="fa fa-home page-header-icon"></i>&nbsp;&nbsp;Dashboard</h1>
      </div> <!-- / .page-header -->
      @parent

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
                  @if($allFunctions[$i]['positiveIsGood'])
                    @if(str_contains($allFunctions[$i]['currentValue'],'-'))
                      <span class="text-money down">
                    @else
                      <span class="text-money up">
                    @endif
                  @else
                    @if(str_contains($allFunctions[$i]['currentValue'],'-'))
                      <span class="text-money up">
                    @else
                      <span class="text-money down">
                    @endif
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
                  @if($allFunctions[$i]['positiveIsGood'])
                    @if(str_contains($allFunctions[$i]['oneMonthChange'],'-'))
                      <span class="text-money down"><i class="fa fa-angle-down"></i>
                    @else
                      <span class="text-money up"><i class="fa fa-angle-up"></i>
                    @endif
                  @else
                    @if(str_contains($allFunctions[$i]['oneMonthChange'],'-'))
                      <span class="text-money up"><i class="fa fa-angle-up"></i>
                    @else
                      <span class="text-money down"><i class="fa fa-angle-down"></i>
                    @endif
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
              @if (Auth::user()->ready)
                <a href="{{ URL::route('auth.single_stat', $allFunctions[$i]['id']) }}">
                  <div class="chart-overlay">
                      <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                  </div>
                </a>
              @else
                <div class="chart-connecting">
                  <span class="text-connecting">We are importing your data <br> just a minute</span>
                </div>
              @endif
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
          <ul class="list-group transasction-list">
            <li class="list-group-item">
              <h4>Transactions</h4>
            </li>
            
            @if($events)

              @for ($i = 0; $i< count($events); $i++)

                <!-- Charge events -->

                @if ($events[$i]['type'] == 'charge.succeeded')
                  <li class="list-group-item">
                    <span class="badge badge-success">
                      Charged
                    </span>
                    <span class="provider">
                      <i class="fa icon fa-cc-stripe"></i>
                    </span>
                    <span class="text-money up">
                      {{ Config::get('constants.' . $events[$i]['currency']) }}{{ $events[$i]['amount'] / 100 }}
                    </span>
                    from <b>{{ $events[$i]['name'] }}</b>
                    @if ($events[$i]['date'])
                    <span class="timestamp">
                      {{ $events[$i]['date'] }}
                    </span>
                    @endif
                  </li> <!-- / .list-group-item -->
                @endif

                @if ($events[$i]['type'] == 'charge.captured')
                  <li class="list-group-item">
                    <span class="badge badge-info">
                      Captured
                    </span>
                    <span class="provider">
                      <i class="fa icon fa-cc-stripe"></i>
                    </span>
                    <span class="text-money up">
                      {{ Config::get('constants.' . $events[$i]['currency']) }}{{ $events[$i]['amount'] / 100 }}
                    </span>
                    from <b>{{ $events[$i]['name'] }}</b>
                    @if ($events[$i]['date'])
                    <span class="timestamp">
                      {{ $events[$i]['date'] }}
                    </span>
                    @endif
                  </li> <!-- / .list-group-item -->
                @endif

                @if ($events[$i]['type'] == 'charge.failed')
                  <li class="list-group-item">
                    <span class="badge badge-danger">
                      Failed
                    </span>
                    <span class="provider">
                      <i class="fa icon fa-cc-stripe"></i>
                    </span>
                    <span class="text-money up">
                      {{ Config::get('constants.' . $events[$i]['currency']) }}{{ $events[$i]['amount'] / 100 }}
                    </span>
                    from <b>{{ $events[$i]['name'] }}</b>
                    @if ($events[$i]['date'])
                    <span class="timestamp">
                      {{ $events[$i]['date'] }}
                    </span>
                    @endif
                  </li> <!-- / .list-group-item -->
                @endif

                @if ($events[$i]['type'] == 'charge.refunded')
                  <li class="list-group-item">
                    <span class="badge badge-warning">
                      Refunded
                    </span>
                    <span class="provider">
                      <i class="fa icon fa-cc-stripe"></i>
                    </span>
                    <span class="text-money up">
                      {{ Config::get('constants.' . $events[$i]['currency']) }}{{ $events[$i]['amount'] / 100 }}
                    </span>
                    refunded to <b>{{ $events[$i]['name'] }}</b>
                    @if ($events[$i]['date'])
                    <span class="timestamp">
                      {{ $events[$i]['date'] }}
                    </span>
                    @endif
                  </li> <!-- / .list-group-item -->
                @endif 

                <!-- / Charge events -->

                <!-- Customer events -->
                
                @if ($events[$i]['type'] == 'customer.created')
                  <li class="list-group-item">
                    <span class="badge badge-success">
                      New Customer
                    </span> 
                    <span class="provider">
                      <i class="fa icon fa-cc-stripe"></i>
                    </span>        
                    <b>{{ $events[$i]['name'] }}</b> signed up
                    @if ($events[$i]['date'])
                    <span class="timestamp">
                      {{ $events[$i]['date'] }}
                    </span>
                    @endif
                  </li> <!-- / .list-group-item -->
                @endif
                
                @if ($events[$i]['type'] == 'customer.deleted')
                  <li class="list-group-item">
                    <span class="badge badge-warning">
                      Customer cancelled
                    </span> 
                    <span class="provider">
                      <i class="fa icon fa-cc-stripe"></i>
                    </span>        
                    <b>{{ $events[$i]['name'] }}</b> left
                    @if ($events[$i]['date'])
                    <span class="timestamp">
                      {{ $events[$i]['date'] }}
                    </span>
                    @endif
                  </li> <!-- / .list-group-item -->
                @endif

                <!-- / Customer events -->

                <!-- Customer Subscription events -->

                @if ($events[$i]['type'] == 'customer.subscription.created')
                  <li class="list-group-item">
                    <span class="badge badge-info">
                      New subscription
                    </span> 
                    <span class="provider">
                      <i class="fa icon fa-cc-stripe"></i>
                    </span>        
                    <b>{{ $events[$i]['name'] }}</b>
                    subscribed to 
                    {{ $events[$i]['plan_name'] }} ({{ $events[$i]['plan_interval'] }}) plan.
                    @if ($events[$i]['date'])
                    <span class="timestamp">
                      {{ $events[$i]['date'] }}
                    </span>
                    @endif
                  </li> <!-- / .list-group-item -->
                @endif

                @if ($events[$i]['type'] == 'customer.subscription.updated'   // this is not enough for plan change
                  && isset($events[$i]['prevPlanID'])  /* we know it's a plan change with this */)  
                  <li class="list-group-item">
                    <span class="badge badge-info">
                      Changed subscription
                    </span>
                    <span class="provider">
                      <i class="fa icon fa-cc-stripe"></i>
                    </span>         
                    <b>{{ $events[$i]['name'] }}</b>
                    changed from <b>{{ $events[$i]['prevPlanName'] }}</b> ({{ $events[$i]['prevPlanInterval']}}) 
                    to <b>{{ $events[$i]['plan_name'] }}</b> ({{ $events[$i]['plan_interval'] }})
                    @if ($events[$i]['date'])
                    <span class="timestamp">
                      {{ $events[$i]['date'] }}
                    </span>
                    @endif
                  </li> <!-- / .list-group-item -->
                @endif

                @if ($events[$i]['type'] == 'customer.subscription.deleted')  
                  <li class="list-group-item">
                    <span class="badge badge-warning">
                      Cancelled subscription
                    </span>
                    <span class="provider">
                      <i class="fa icon fa-cc-stripe"></i>
                    </span>         
                    <b>{{ $events[$i]['name'] }}</b>
                    cancelled <b>{{ $events[$i]['plan_name'] }}</b> ({{ $events[$i]['plan_interval'] }})
                    @if ($events[$i]['date'])
                    <span class="timestamp">
                      {{ $events[$i]['date'] }}
                    </span>
                    @endif
                  </li> <!-- / .list-group-item -->
                @endif                

                <!-- / Customer Subscription events -->

                <!-- Customer Discounts events -->

                <!-- FIXME -->

                @if ($events[$i]['type'] == 'customer.discount.created')  
                  <li class="list-group-item">
                    <span class="badge badge-warning">
                      Coupon used
                    </span>
                    <span class="provider">
                      <i class="fa icon fa-cc-stripe"></i>
                    </span>         
                    <b>{{ $events[$i]['name'] }}</b>
                    used a coupon.
                    @if ($events[$i]['date'])
                    <span class="timestamp">
                      {{ $events[$i]['date'] }}
                    </span>
                    @endif
                  </li> <!-- / .list-group-item -->
                @endif

                @if ($events[$i]['type'] == 'customer.discount.deleted')  
                  <li class="list-group-item">
                    <span class="badge badge-success">
                      Coupon expired
                    </span>
                    <span class="provider">
                      <i class="fa icon fa-cc-stripe"></i>
                    </span>         
                    <b>{{ $events[$i]['name'] }}</b>'s
                    discount ended.                    
                    @if ($events[$i]['date'])
                    <span class="timestamp">
                      {{ $events[$i]['date'] }}
                    </span>
                    @endif
                  </li> <!-- / .list-group-item -->
                @endif

                @if ($events[$i]['type'] == 'customer.discount.updated')  
                  <li class="list-group-item">
                    <span class="badge badge-info">
                      Coupon changed
                    </span>
                    <span class="provider">
                      <i class="fa icon fa-cc-stripe"></i>
                    </span>         
                    <b>{{ $events[$i]['name'] }}</b> changed coupon
                    from <b>{{$events[$i]['prevCoupon']}}</b> to <b>{{$events[$i]['newCoupon']}}</b>              
                    @if ($events[$i]['date'])
                    <span class="timestamp">
                      {{ $events[$i]['date'] }}
                    </span>
                    @endif
                  </li> <!-- / .list-group-item -->
                @endif

                <!-- / Customer Discounts events -->
              @endfor
            @else
            <li class="list-group-item">
             No current data available.
            </li> <!-- / .list-group-item -->
            @endif
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
              data: [@foreach ($allFunctions[$i]['history'] as $date => $value)
                @if($value == null) 0,
                @else{{ $value }},
                @endif 
                @endforeach]
          }
      ]
    };

    ctx = $("#{{$allFunctions[$i]['id']}}").get(0).getContext("2d");
    var {{$allFunctions[$i]['id']}}Chart = new Chart(ctx).Line(data, options);

    /* / {{ $allFunctions[$i]['statName'] }} */

    @endfor

       
    </script>

  @stop

