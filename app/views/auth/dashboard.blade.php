@extends('meta.base-user')

  @section('pageTitle')
    Dashboard
  @stop

  @section('pageStylesheet')
    <script src="{{{ asset('/used_assets/handsontable/dist/handsontable.full.js') }}}"></script>
    <link rel="stylesheet" href="{{{ asset('/used_assets/handsontable/dist/handsontable.full.css') }}}" />  
    <script src="{{{ asset('/used_assets/handsontable//dist/moment/moment.js') }}}"></script>
    <script src="{{{ asset('/used_assets/handsontable//dist/pikaday/pikaday.js') }}}"></script>
    <link rel="stylesheet" href="{{{ asset('/used_assets/handsontable/dist/pikaday/css/pikaday.css') }}}" />
  @stop

  @section('pageContent')

    <div id="content-wrapper">
      <div class="page-header text-center">
        <h1><i class="fa fa-home page-header-icon"></i>&nbsp;&nbsp;Dashboard</h1>
        <a href="{{ URL::route('auth.settings') }}">
          <button id="addGoogleSpreadsheetWidget" class="btn btn-flat btn-info btn-sm pull-right" type="button">Add new widget</button>
        </a>
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

                  @if($allFunctions[$i]['widget_type']=='google-spreadsheet-text-cell')
                    <h4 class="text-center">{{ $allFunctions[$i]['statName'] }}</h4>
                    <br/>
                    <h2 class="text-center">{{ $allFunctions[$i]['currentValue'] }}</h2>
                    <br/>
                  @elseif($allFunctions[$i]['widget_type']=='google-spreadsheet-text-column')
                    <h4 class="text-center">{{ $allFunctions[$i]['statName'] }}</h4>
                    <br/>
                    <ul>
                    @foreach ($allFunctions[$i]['history'] as $value)
                      <li>{{ $value }}</li>
                    @endforeach
                    </ul>
                  @elseif($allFunctions[$i]['widget_type']=='google-spreadsheet-abf-munkaido')
                    <!--div id="example" class="example" style="width:700px;"> </div-->
                    <!--iframe width='800' height='700' frameborder='0' src='https://docs.google.com/spreadsheet/pub?key=0AnUZJzwNC3NkdGRXM28xQUNmclFhbEZuN2cxTGRDa0E&gridlines=false&headers=false&gid=32&range=A1:C10'></iframe-->
                    <iframe width="500" height="300" frameborder="0" src="https://docs.google.com/spreadsheet/pub?key=0AnUZJzwNC3NkdGRXM28xQUNmclFhbEZuN2cxTGRDa0E&single=true&gid=32&range=a1%3Ac1&output=html&widget=true"></iframe>
                  @else

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
                            <span class="text-money up"><i class="fa fa-angle-down"></i>
                          @else
                            <span class="text-money down"><i class="fa fa-angle-up"></i>
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
                    {{--
                    @if (Auth::user()->ready == 'connecting')
                      <div class="chart-connecting">
                        <span class="text-connecting">Importing data <br> just a minute</span>
                      </div>
                    @else
                    --}}
                      <a href="{{ URL::route('auth.single_stat', $allFunctions[$i]['id']) }}">
                        <div class="chart-overlay">
                            <span class="text-overlay">View details <i class="fa fa-angle-right"></i></span>
                        </div>
                      </a>
                    {{--
                    @endif
                    --}}
                    <h4 class="text-center">{{ $allFunctions[$i]['statName'] }}</h4>

                  @endif

                </div> <!-- / .chart-wrapper -->
              </div> <!-- / .chart-box -->
            @if (($i+1) % 3 == 0 || $i >= count($allFunctions) - 1)
            </div> <!-- / .row -->
            @endif
            <!-- /{{ $allFunctions[$i]['statName'] }} -->
          @endfor

      </div> <!-- / .col-sm-8 -->
      <!-- /STATISTICS BOX -->



      @if ($isFinancialStuffConnected == 1)
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
                        @if($events[$i]['provider'] == 'stripe')
                          <i class="icon pf pf-stripe"></i>
                        @elseif($events[$i]['provider'] == 'braintree')
                          <i class='icon pf pf-braintree'></i>
                        @endif
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
                        @if($events[$i]['provider'] == 'stripe')
                          <i class="icon pf pf-stripe"></i>
                        @elseif($events[$i]['provider'] == 'braintree')
                          <i class='icon pf pf-braintree'></i>
                        @endif
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
                        @if($events[$i]['provider'] == 'stripe')
                          <i class="icon pf pf-stripe"></i>
                        @elseif($events[$i]['provider'] == 'braintree')
                          <i class='icon pf pf-braintree'></i>
                        @endif
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
                        @if($events[$i]['provider'] == 'stripe')
                          <i class="icon pf pf-stripe"></i>
                        @elseif($events[$i]['provider'] == 'braintree')
                          <i class='icon pf pf-braintree'></i>
                        @endif
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
                
                @if ($events[$i]['type'] == 'customer.created' && $events[$i]['provider']!='connect')
                  <li class="list-group-item">
                    <span class="badge badge-success">
                      New Customer
                    </span> 
                      <span class="provider">
                        @if($events[$i]['provider'] == 'stripe')
                          <i class="icon pf pf-stripe"></i>
                        @elseif($events[$i]['provider'] == 'braintree')
                          <i class='icon pf pf-braintree'></i>
                        @endif        
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
                        @if($events[$i]['provider'] == 'stripe')
                          <i class="icon pf pf-stripe"></i>
                        @elseif($events[$i]['provider'] == 'braintree')
                          <i class='icon pf pf-braintree'></i>
                        @endif        
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

                @if ($events[$i]['type'] == 'customer.subscription.created' && $events[$i]['provider']!='connect')
                  <li class="list-group-item">
                    <span class="badge badge-info">
                      New subscription
                    </span> 
                      <span class="provider">
                        @if($events[$i]['provider'] == 'stripe')
                          <i class="icon pf pf-stripe"></i>
                        @elseif($events[$i]['provider'] == 'braintree')
                          <i class='icon pf pf-braintree'></i>
                        @endif        
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
                        @if($events[$i]['provider'] == 'stripe')
                          <i class="icon pf pf-stripe"></i>
                        @elseif($events[$i]['provider'] == 'braintree')
                          <i class='icon pf pf-braintree'></i>
                        @endif         
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
                        @if($events[$i]['provider'] == 'stripe')
                          <i class="icon pf pf-stripe"></i>
                        @elseif($events[$i]['provider'] == 'braintree')
                          <i class='icon pf pf-braintree'></i>
                        @endif         
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
                        @if($events[$i]['provider'] == 'stripe')
                          <i class="icon pf pf-stripe"></i>
                        @elseif($events[$i]['provider'] == 'braintree')
                          <i class='icon pf pf-braintree'></i>
                        @endif         
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
                        @if($events[$i]['provider'] == 'stripe')
                          <i class="icon pf pf-stripe"></i>
                        @elseif($events[$i]['provider'] == 'braintree')
                          <i class='icon pf pf-braintree'></i>
                        @endif         
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
                        @if($events[$i]['provider'] == 'stripe')
                          <i class="icon pf pf-stripe"></i>
                        @elseif($events[$i]['provider'] == 'braintree')
                          <i class='icon pf pf-braintree'></i>
                        @endif         
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
      @endif

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

    @for ($i = 0; $i < count($allFunctions); $i++)

      @if ($allFunctions[$i]['widget_type']!='google-spreadsheet-abf-munkaido')

      /* {{ $allFunctions[$i]['statName'] }} */

      data = {
        labels: [@foreach ($allFunctions[$i]['history'] as $date => $value)"", @endforeach],
        datasets: [
            {
                label: "{{ $allFunctions[$i]['statName'] }}",
                fillColor: "rgba(151,187,205,0.4)",
                strokeColor: "rgba(151,187,205,0.6)",
                data: [
                  @foreach ($allFunctions[$i]['history'] as $date => $value)
                    @if (is_numeric($value))
                      @if($value == null)
                        0,
                      @else
                        {{ $value }},
                      @endif 
                    @else
                        '{{ $value }}',
                    @endif
                  @endforeach]
            }
        ]
      };

      ctx = $("#{{$allFunctions[$i]['id']}}").get(0).getContext("2d");
      var Chart{{$allFunctions[$i]['id']}} = new Chart(ctx).Line(data, options);

      /* / {{ $allFunctions[$i]['statName'] }} */

      @endif

    @endfor

       
    </script>

@for ($i = 0; $i < count($allFunctions); $i++)
  @if($allFunctions[$i]['widget_type']=='google-spreadsheet-abf-munkaido')

    <script>

    var data = [
      @foreach ($allFunctions[$i]['history'] as $array)
        [
        @foreach ($array as $key => $value)
          @if ($key != 'data_key')
            '{{ $value }}',
          @endif
        @endforeach
        ],
      @endforeach
    ];

    var backgroundData = {
      @foreach ($allFunctions[$i]['history'] as $key => $value)
        {{ $key }}:
        [ 
        @foreach ($value as $key2 => $value2)
          '{{ $value2 }}',
        @endforeach
        ],
      @endforeach
    };

    Object.size = function(obj) {
        var size = 0, key;
        for (key in obj) {
            if (obj.hasOwnProperty(key)) size++;
        }
        return size;
    };

    var container = document.getElementById("example");

    var hot = new Handsontable(container, {
      data: data,
      height: 200,
      colHeaders: ['date', 'start', 'end', 'length', 'role', 'project', 'comment', 'h13'], 
      columns: [
        {
          type: 'date',
          dateFormat: 'YYYY.MM.DD.',
          correctFormat: true
        },
        {},
        {},
        {},
        {
          type: 'autocomplete',
          source: ["architekt", "bizdev", "board", "custdev", "EMK", "fejlesztő", "gazdaságis", "hr", "irodavezető", "marketing", "meta", "pm", "PM", "rendszeradminisztrátor", "sales", "szakmai vezető", "szoftvertervező", "tanulás", "team lead", "ügyfélkapcsolat", "ügyvezető"],
          strict: false
        },
        {
          type: 'autocomplete',
          source: ["ABF", "PATH", "NEVES", "BEGONIA", "BELLA", "BELLA-INDA", "Moment", "Bedtime", "Interactive", "AppXplorer", "StartupDashboard", "Kutatás", "EMK", "TrackR", "KönyvScanner", "Rendszeradmin", "EMK üzemeltetés", "IT oktatás"],
          strict: false
        },
        {},
        {}
      ],
      rowHeaders: false,
      stretchH: 'all',
      minSpareRows: 1,
      afterChange: function (change, source) {

        rowOfChange = change[0][0];
        columnOfChange = change[0][1];
        valueOfChange = change[0][3];

        if (rowOfChange <= (Object.size(backgroundData)-1)) {
          backgroundData[rowOfChange][columnOfChange+1] = valueOfChange;
        } else {
          newLineCounter = Object.size(backgroundData);
          backgroundDataCounter = parseInt(backgroundData[rowOfChange-1][0])+1;
          newLine = [backgroundDataCounter,'','','','','','','',''];
          backgroundData[newLineCounter] = newLine;
          backgroundData[rowOfChange][columnOfChange+1] = valueOfChange;
        }

        updatedData = backgroundData[rowOfChange];

        $.ajax({
            type: "POST",
            url: "{{ URL::route('modifyAbfWidget') }}",
            data: {
                'data': JSON.stringify({ updatedData }),
                'widget_id': {{ $allFunctions[$i]['widget_id'] }}
            },
            success: function() {
            }
          });
      },
      cells: function (row, col, prop) {
        var cellProperties = {};
        cellProperties.className = 'htMiddle htCenter';
        return cellProperties;
      },
    });

    hot.setDataAtCell(0, 0, 'new value');

    </script>

  @endif
@endfor

  @stop

