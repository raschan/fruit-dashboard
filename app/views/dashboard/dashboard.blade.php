@extends('meta.base-user')

  @section('pageTitle')
    Dashboard
  @stop

  @section('pageStylesheet')
  @stop

  @section('pageContent')

    <div id="content-wrapper" class="gridster">
      <ul>

        @for ($i = 0; $i < count($allFunctions); $i++)

          @include('dashboard.widget', ['widget_data' => $allFunctions[$i]])

        @endfor

      </ul>

    </div> <!-- / #content-wrapper -->
  @stop

  @section('pageScripts')
    <script type="text/javascript">
      $(document).ready(function() {
          var gridster;
          var widget_width = $(window).width()/6-15;
          var widget_height = $(window).height()/6-20;

          $(function(){

            gridster = $(".gridster ul").gridster({
              widget_base_dimensions: [widget_width, widget_height],
              widget_margins: [5, 5],
              helper: 'clone',
              resize: {
                enabled: true,
                max_size: [4, 4],
                min_size: [1, 1]
              }
            }).data('gridster');

          });
      });
    </script>
  @stop

