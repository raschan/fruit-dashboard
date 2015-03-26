@extends('meta.base-user')

  @section('pageContent')

    <div id="content-wrapper">
      @parent
      <div class="col-md-12">

        <div class="row no-margin-hr panel-padding stat-header bordered">

          <div class="col-md-4 col-lg-5">
              <small><strong>CHOOSE A METRIC:</strong></small><br>
              <select class="form-control input-lg" onChange="window.location.href=this.value">
                <option value="{{ URL::route('auth.single_stat', 'au') }}" @if($data['id'] == "au") selected @endif>Active Users</option>
                <option value="{{ URL::route('auth.single_stat', 'arr') }}" @if($data['id'] == "arr") selected @endif>Annual Run Rate</option>
                <option value="{{ URL::route('auth.single_stat', 'arpu') }}" @if($data['id'] == "arpu") selected @endif>Average Revenue Per User</option>
                <option value="{{ URL::route('auth.single_stat', 'cancellations') }}" @if($data['id'] == "cancellations") selected @endif>Cancellations</option>
                <option value="{{ URL::route('auth.single_stat', 'mrr') }}" @if($data['id'] == "mrr") selected @endif>Monthly Recurring Revenue</option>
                <option value="{{ URL::route('auth.single_stat', 'uc') }}" @if($data['id'] == "uc") selected @endif>User Churn</option>
              </select>
          </div>
                  
          <div class="col-md-8 col-lg-6 col-lg-offset-1">
            <small><strong>DATE</strong></small><br>
            <form class="form-inline stat-date">
              <div class="form-group col-md-5 no-padding-hr">
                <div class="input-group date" id="startDateStat">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control input-lg" value="{{ $data['dateInterval']['startDate'] }}">
                </div>
              </div>
              <div class="form-group dash col-md-1 no-padding-hr text-center">
                &ndash;
              </div>
              <div class="form-group col-md-5 no-padding-hr">
                <div class="input-group date" id="stopDateStat">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control input-lg" value="{{ $data['dateInterval']['stopDate'] }}">
                </div>
              </div>
            </form>
          </div>

        </div> <!-- / .stat-header -->

        <!-- Statistics graph -->
        <div class="row panel-body bordered">
          <div class="single-statistic-wrapper">
            <canvas id="singleStat"></canvas>
          </div>
        </div> <!-- / .row .panel-body -->

        <!-- Change numbers -->
        <div class="row panel-body margin-vr-sm bordered">
          <div class="statistic-description">
            <div class="row">
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>Current</h4></span>
                @if($data['currentValue'])
                  @if($data['positiveIsGood'])
                    @if(str_contains($data['currentValue'],'-'))
                      <span class="text-money down">
                    @else
                      <span class="text-money up">
                    @endif
                  @else
                    @if(str_contains($data['currentValue'],'-'))
                      <span class="text-money up">
                    @else
                      <span class="text-money down">
                    @endif
                  @endif
                  {{ $data['currentValue'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>30 days ago</h4></span>
                @if($data['oneMonth'])
                  @if($data['positiveIsGood'])
                    @if(str_contains($data['oneMonth'],'-'))
                      <span class="text-money down">
                    @else
                      <span class="text-money up">
                    @endif
                  @else
                    @if(str_contains($data['oneMonth'],'-'))
                      <span class="text-money up">
                    @else
                      <span class="text-money down">
                    @endif
                  @endif
                  {{ $data['oneMonth'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>6 months ago</h4></span>
                @if($data['sixMonth'])
                 @if($data['positiveIsGood'])
                    @if(str_contains($data['sixMonth'],'-'))
                      <span class="text-money down">
                    @else
                      <span class="text-money up">
                    @endif
                  @else
                    @if(str_contains($data['sixMonth'],'-'))
                      <span class="text-money up">
                    @else
                      <span class="text-money down">
                    @endif
                  @endif
                  {{ $data['sixMonth'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
              <div class="col-md-3 stat-description-box">
                <span class="text-date"><h4>1 year ago</h4></span>
                @if($data['oneYear'])
                 @if($data['positiveIsGood'])
                    @if(str_contains($data['oneYear'],'-'))
                      <span class="text-money down">
                    @else
                      <span class="text-money up">
                    @endif
                  @else
                    @if(str_contains($data['oneYear'],'-'))
                      <span class="text-money up">
                    @else
                      <span class="text-money down">
                    @endif
                  @endif
                  {{ $data['oneYear'] }}
                @else
                  <span class="text-money down">
                  N/A
                @endif
                </span>
              </div>
            </div> <!-- / .row -->
          </div> <!-- / .statistic-description -->
        
          <div class="statistic-description">
            <div class="col-md-2 stat-growth-box">
              <span class="text-date"><h4>30 days growth</h4></span>
              @if($data['oneMonthChange'])
                @if($data['positiveIsGood'])
                  @if(str_contains($data['oneMonthChange'],'-'))
                    <span class="text-money down">
                  @else
                    <span class="text-money up">
                  @endif
                @else
                  @if(str_contains($data['oneMonthChange'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                @endif
                {{ $data['oneMonthChange'] }}
              @else
                <span class="text-money down">
                N/A
              @endif
              </span>
            </div>
            <div class="col-md-2 stat-growth-box">
              <span class="text-date"><h4>60 days growth</h4></span>
              @if($data['twoMonthChange'])
                @if($data['positiveIsGood'])
                  @if(str_contains($data['twoMonthChange'],'-'))
                    <span class="text-money down">
                  @else
                    <span class="text-money up">
                  @endif
                @else
                  @if(str_contains($data['twoMonthChange'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                @endif
              {{ $data['twoMonthChange'] }}
              @else
                <span class="text-money down">
                N/A
              @endif
              </span>
            </div>
            <div class="col-md-2 stat-growth-box">
              <span class="text-date"><h4>3 month growth</h4></span>
              @if($data['threeMonthChange'])
                @if($data['positiveIsGood'])
                  @if(str_contains($data['threeMonthChange'],'-'))
                    <span class="text-money down">
                  @else
                    <span class="text-money up">
                  @endif
                @else
                  @if(str_contains($data['threeMonthChange'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                @endif
              {{ $data['threeMonthChange'] }}
              @else
                <span class="text-money down">
                N/A
              @endif
              </span>
            </div>
            <div class="col-md-2 stat-growth-box">
              <span class="text-date"><h4>6 month growth</h4></span>
              @if($data['sixMonthChange'])
                @if($data['positiveIsGood'])
                  @if(str_contains($data['sixMonthChange'],'-'))
                    <span class="text-money down">
                  @else
                    <span class="text-money up">
                  @endif
                @else
                  @if(str_contains($data['sixMonthChange'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                @endif
              {{ $data['sixMonthChange'] }}
              @else
                <span class="text-money down">
                N/A
              @endif
              </span>
            </div>
              <div class="col-md-2 stat-growth-box">
              <span class="text-date"><h4>9 month growth</h4></span>
              @if($data['nineMonthChange'])
                @if($data['positiveIsGood'])
                  @if(str_contains($data['nineMonthChange'],'-'))
                    <span class="text-money down">
                  @else
                    <span class="text-money up">
                  @endif
                @else
                  @if(str_contains($data['nineMonthChange'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                @endif
              {{ $data['nineMonthChange'] }}
              @else
                <span class="text-money down">
                N/A
              @endif
              </span>
            </div>
            <div class="col-md-2 stat-growth-box">
              <span class="text-date"><h4>1 year growth</h4></span>
              @if($data['oneYearChange'])
                @if($data['positiveIsGood'])
                  @if(str_contains($data['oneYearChange'],'-'))
                    <span class="text-money down">
                  @else
                    <span class="text-money up">
                  @endif
                @else
                  @if(str_contains($data['oneYearChange'],'-'))
                    <span class="text-money up">
                  @else
                    <span class="text-money down">
                  @endif
                @endif
              {{ $data['oneYearChange'] }}
              @else
                <span class="text-money down">
                N/A
              @endif
              </span>
            </div>
          </div> <!-- /.statistic-description  -->
        </div> <!-- /.row -->


        <!-- Metric description -->
        <div class="row panel-body margin-vr-sm bordered">
          <div class="col-md-4">
            <span class="text-date"><h4>{{ $metricDetails['metricName'] }}</h4></span>
          </div>
          <div class="col-md-11">
            <span>{{ $metricDetails['metricDescription'] }}</span>            
          </div>
        </div>

      {{--    

        <!-- hidden for development, will not be rendered on client side -->        
  
        <div class="row no-margin-hr panel-padding stat-header bordered">

          <div class="col-md-4 col-lg-5">
            <div>
              <h3>
              {{ $data['statName'] }} datatable
              </h3>
            </div>
          </div>

          <div class="col-md-8 col-lg-6 col-lg-offset-1">
            <small><strong>DATE</strong></small><br>
            <form class="form-inline">
              <div class="form-group date">
                <input type="text" class="form-control stat-input" id="startDatetable" value="{{ $data['dateInterval']['startDate'] }}">
              </div>
              <div class="form-group dash">
                -
              </div>
              <div class="form-group date">
                <input type="text" class="form-control stat-input" id="stopDatetable" value="{{ $data['dateInterval']['stopDate'] }}">
              </div>
            </form>
          </div> 

        </div> <!-- / .row .stat-header   -->

        <div class="row panel-body bordered">
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
              <span>{{ $data['currentValue'] }}</span>
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
                  
                  @foreach ($data['detailData'] as $details)
                  <tr>
                  <td>{{$details['name']}} <span class="badge">{{ $details['price'] }}&nbsp;/&nbsp;{{ $details['interval'] }}</span></td>
                  <td class="text-center">{{ $details['count'] }}</td>
                  <td class="text-center text-money up"> {{$details['mrr']}} </td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
            </div>
          </div> <!-- / .invoice-table -->
        </div> <!-- /. row -->
        
        <!-- / hidden for development, will not be rendered on client side -->    
         
      --}}
      
      </div> <!-- . col-md-12 -->
    </div> <!-- / #content-wrapper -->
  @stop

  @section('pageScripts')
    {{ HTML::script('js/JQtable.js'); }}

    <script type="text/javascript">
    // datepicker start
    init.push(function () {
      $('#startDateStat').datepicker({
        startDate: "{{ $data['firstDay'] }}",
        endDate: "{{ $data['dateInterval']['stopDate'] }}", 
        format: "dd-mm-yyyy",
        autoclose: true
      });
      $('#stopDateStat').datepicker({
        startDate: "{{ $data['firstDay'] }}",
        endDate: "{{ $data['dateInterval']['stopDate'] }}",
        format: "dd-mm-yyyy",
        forceParse: true,
        todayHighlight: true,
        autoclose: true
      });

      var selectedStartDate, selectedStopDate,arrayStartKey, arrayStopKey;

      // datepicker event listeners, needs work, methods doesnt work
      $('#startDateStat').datepicker().on("changeDate", function(e){
        // getting the input
        selectedStartDate = $('#startDateStat').prop("value");
        selectedStopDate = $('#stopDateStat').prop("value");
        
        // formatting for array keys
        arrayStartKey = getFormattedDate(selectedStartDate);
        arrayStopKey = getFormattedDate(selectedStopDate);

        // if start date is bigger than end date
        if (getFormattedDate(arrayStartKey, "unix") > getFormattedDate(arrayStopKey, "unix")){
          // update start datepicker to end datepicker value
          $(this).datepicker('update', new Date(arrayStopKey));
          //$(this).prop("value",selectedStopDate);
          // growl
          $.growl.warning({
            message: "The starting date must be before the ending date.",
            size: "large",
            duration: 5000
          });
        }
        // if start date is valid
        else {
          //METHOD DOESNT WORK, WHY?
          // update end datepicker first selectable value to start datepicker value
          $('#stopDateStat').datepicker('setStartDate', new Date(arrayStartKey));
          // create new chart
          createNewChart(arrayStartKey, arrayStopKey);

          // send event to analytics
          _gaq.push(["_trackEvent", "{{ $data['statName'].' date interval' }}" , "Start date changed"]);
          mixpanel.track('{{$data["statName"]. " start date changed"}}');
        }

      });

      $('#stopDateStat').datepicker().on("changeDate", function(e){
        selectedStartDate = $('#startDateStat').prop("value");
        selectedStopDate = $('#stopDateStat').prop("value");

        // formatting for array keys
        arrayStartKey = getFormattedDate(selectedStartDate);
        arrayStopKey = getFormattedDate(selectedStopDate);

        // if start date is bigger than end date
        if (getFormattedDate(arrayStartKey, "unix") > getFormattedDate(arrayStopKey, "unix")){
          // update end datepicker to start datepicker value
          $(this).datepicker('update', new Date(arrayStartKey));
          //$(this).prop("value",selectedStartDate);
          // growl
          $.growl.warning({
            message: "The ending date must be after the starting date.",
            size: "large",
            duration: 5000
          });

        }
        // if end date is valid
        else {
          //METHOD DOESNT WORK, WHY?
          // update start datepicker last selectable value to end datepicker value
          $('#startDateStat').datepicker('setEndDate', new Date(arrayStopKey));
          // create new chart
          createNewChart(arrayStartKey, arrayStopKey);

          // send event to analytics
          _gaq.push(["_trackEvent", "{{ $data['statName'] .' date interval' }}" , "Stop date changed"]);
          mixpanel.track('{{$data["statName"]. " stop date changed"}}');
        }
      });

      // datepicker bugfix

      
      
      // CHART.JS
      //options
      var options = {
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: false,
        scaleFontFamily: "'Arial', sans-serif",
        responsive: true,
        maintainAspectRatio: false,
        bezierCurveTension : 0.1,
        pointHitDetectionRadius : 5
        @if ($data['id'] == 'mrr' || $data['id'] == 'arpu' || $data['id'] == 'arr')
          ,tooltipTemplate: "<%if (label){%><%=label%>: $<%}%><%= value %>"
        @endif
        @if ($data['id'] == 'uc')
          ,tooltipTemplate: "<%if (label){%><%=label%>:<%}%> <%= value %>%"
        @endif
      };
      var ctx = $('#singleStat').get(0).getContext("2d");
      // all labels
      var labels = [@foreach ($data['fullHistory'] as $date => $value)"{{ $date }}", @endforeach];
      // all data value
      var data = [@foreach ($data['fullHistory'] as $date => $value)@if($value == null)0,@else{{ $value }},@endif @endforeach];

      // for default view
      var data30 = {
        labels: [@foreach ($data['history'] as $date => $value)"{{ $date }}", @endforeach],
        datasets: [
            {
                label: "{{$data['statName']}}",
                fillColor: "rgba(151,187,205,0.4)",
                strokeColor: "rgba(151,187,205,0.6)",
                data: [@foreach ($data['history'] as $date => $value)@if($value == null)0,@else{{ $value }},@endif @endforeach]
            }
        ]
      };

      // drawing default chart.js
      var singleStat = new Chart(ctx).Line(data30, options);

      // creating new chart
      function createNewChart(arrayStart, arrayStop){
      if (arrayStart && arrayStop){
          // search all labels for selected data interval's start and end index value in array
          for (var i=0;labels.length;i++){
            if (arrayStart == labels[i]){
              arrayStart = i;
            }
            if (arrayStop == labels[i]){
              arrayStop = i;
              break;
            }
          }
          
          arrayStop = parseInt(arrayStop);
          arrayStart = parseInt(arrayStart);
          var newLabel = [];
          var newData = [];
          
          // updating label array with selected index array value
          for(i = arrayStart;i<=arrayStop;i++){
            newLabel.push(labels[i]);  
          }
          // updating data array with selected index array value
          for(i = arrayStart;i<=arrayStop;i++){
            newData.push(data[i]);  
          }

          // if dataset bigger than 30
          var finalData = [];
          var finalLabel = [];
          if (newData.length > 30){
            // find modulus for 30 points in dataset, with equal distance
            var modulus = Math.floor((newLabel.length) / 30);
            
            for(i=0; i<newData.length; i++){
              // first dataset and where modulus equals zero goes into final data
              if (i === 0 || i % modulus === 0){
                finalData.push(newData[i]);
                finalLabel.push(newLabel[i]);
              }
              if (finalData.length === 30){
                break;
              }
            }

          }
          else {
            finalData = newData;
            finalLabel = newLabel;
          }
          
          // destroying stat
          singleStat.destroy();
          

          // for updated view
          var dataFinal = {
            labels: finalLabel,
            datasets: [
                {
                    fillColor: "rgba(151,187,205,0.4)",
                    strokeColor: "rgba(151,187,205,0.6)",
                    data: finalData
                }
            ]
          };
          // creating updated stat
          ctx = $('#singleStat').get(0).getContext("2d");
          singleStat = new Chart(ctx).Line(dataFinal, options);
        }
      }

      function getFormattedDate(date,format){
        var formattedDate, d, m, y;

        if (format == "unix"){
          formattedDate = new Date(date);
          d = formattedDate.getDate();
          m =  formattedDate.getMonth();
          m += 1;  // JavaScript months are 0-11
          y = formattedDate.getFullYear();
          formattedDate = Date.UTC(y,m,d);
        }

        else {
          formattedDate = date.split('-');
          formattedDate = formattedDate.reverse().join('-');
        }

        return formattedDate;
      }

    });

    </script>

    <!-- Analytics -->
    <script type="text/javascript">
      _gaq.push(["_trackEvent", "Metrics", '{{ $data["statName"]." opened" }}' ]);
      mixpanel.track("{{ $data['statName']. ' opened' }}");
    </script>
    <!-- / Analytics -->

  @stop