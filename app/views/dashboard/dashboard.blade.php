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
          var positioning = [];
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
                min_size: [1, 1],
                stop: function(e, ui, $widget) {
                  positioning = gridster.serialize();

                  for (var j = positioning.length - 1; j >= 0; j--) {
                    $.extend(positioning[j], {widget_id:$widget[0].attributes[0].nodeValue});
                  };

                  positioning = JSON.stringify(positioning);
                  $.ajax({
                   type: "POST",
                   url: "/api/widgets/save/{{Auth::user()->id}}/" + positioning
                 });
                }
              },
              draggable: {
                stop: function(e, ui, $widget) {
                  positioning = gridster.serialize();

                  for (var j = positioning.length - 1; j >= 0; j--) {

                    $.extend(positioning[j], {widget_id:$widget[0].attributes[0].nodeValue});
                  };

                  positioning = JSON.stringify(positioning);
                  $.ajax({
                   type: "POST",
                   url: "/api/widgets/save/{{Auth::user()->id}}/" + positioning
                 });
                }
              }
            }).data('gridster');

          });
      });
    </script>
  @stop

