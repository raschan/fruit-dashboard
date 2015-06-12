<div class='gridster connect'>
  <ul>
    <li class="dashboard-widget well text-center white-background" data-row="1" data-col="1" data-sizex="1" data-sizey="2">
      @if ($user->canConnectMore())
        <a href="{{ URL::route('connect.addwidget', 'clock') }}">
      @else
        <a href="/plans">
      @endif
        <span class="icon fa fa-clock-o fa-3x"></span>
        <p>Clock</p>
      </a>
    </li>
   
    <li class="dashboard-widget well text-center white-background" data-row="1" data-col="2" data-sizex="1" data-sizey="2">
      @if ($user->isGoogleSpreadsheetConnected())
        <a href="{{ URL::route('connect.addwidget', 'googlespreadsheet') }}">
      @elseif($user->canConnectMore())
        <a href="{{ $googleSpreadsheetButtonUrl }}" onclick='_gaq.push(["_trackEvent", "Connect", "Connecting Google Spreadsheet"]);mixpanel.track("Google Spreadsheet connect");'>
      @else
        <a href="/plans">
      @endif
        <span class="icon fa fa-google fa-3x"></span>
        <p>Google Spreadsheet</p>
      </a>
    </li>

    <li class="dashboard-widget well text-center white-background" data-row="1" data-col="3" data-sizex="1" data-sizey="2">
      @if ($user->canConnectMore())
        <a href="{{ URL::route('connect.addwidget', 'iframe') }}">
      @else
        <a href="/plans">
      @endif
        <span class="icon fa fa-file-text-o fa-3x"></span>
        <p>iframe</p>
      </a>
    </li>

    <li class="dashboard-widget well text-center white-background" data-row="1" data-col="4" data-sizex="1" data-sizey="2">
      @if ($user->canConnectMore())
        <a href="{{ URL::route('connect.addwidget', 'quote') }}">
      @else
        <a href="/plans">
      @endif
        <span class="icon fa fa-quote-left fa-3x"></span>
        <p>Quotes</p>
      </a>
    </li>

    <li class="dashboard-widget well text-center white-background" data-row="2" data-col="1" data-sizex="1" data-sizey="2">
      @if ($user->canConnectMore())
        <a href="{{ URL::route('connect.addwidget', 'note') }}">
      @else
        <a href="/plans">
      @endif
        <span class="icon fa fa-pencil fa-3x"></span>
        <p>Notes</p>
      </a>
    </li>

    <li class="dashboard-widget well text-center white-background" data-row="2" data-col="2" data-sizex="1" data-sizey="2">
      @if ($user->canConnectMore())
        <a href="{{ URL::route('connect.addwidget', 'greeting') }}">
      @else
        <a href="/plans">
      @endif
        <span class="icon fa fa-comment-o fa-3x"></span>
        <p>Greetings</p>
      </a>
    </li>

    <li class="dashboard-widget well text-center white-background" data-row="2" data-col="3" data-sizex="1" data-sizey="1">
        <a href="{{ URL::route('connect.editwidget', 'background') }}">
        <span class="icon fa fa-picture-o fa-3x"></span>
        <p>Background</p>
      </a>
    </li>

  </ul>
</div>

@section('pageScripts')
  @parent
  <!-- connect grid -->
  <script type="text/javascript">
    $(document).ready(function() {
      var gridster;
      var widget_width = $(window).width()/6-15;
      var widget_height = $(window).height()/6-20;

      $(function(){

        gridster = $(".connect ul").gridster({
          widget_base_dimensions: [widget_width, widget_height],
          widget_margins: [5, 5],
          helper: 'clone',
          resize: {
            enabled: false,
            max_size: [1, 1],
            min_size: [1, 1]
          }
        }).data('gridster');

      });
    });
  </script>
  <!-- /connect grid -->
@stop
