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
              serialize_params: function ($w, wgd) {
                  return {
                    id: $w.data().id,
                    col: wgd.col,
                    row: wgd.row,
                    size_x: wgd.size_x,
                    size_y: wgd.size_y,
                  };
                },
              resize: {
                enabled: true,
                max_size: [4, 4],
                min_size: [1, 1],
                stop: function(e, ui, $widget) {
                  positioning = gridster.serialize();
                  positioning = JSON.stringify(positioning);
                  $.ajax({
                   type: "POST",
                   url: "/api/widgets/save-position/{{Auth::user()->id}}/" + positioning
                 });
                }
              },
              draggable: {
                stop: function(e, ui, $widget) {
                  positioning = gridster.serialize();
                  positioning = JSON.stringify(positioning);
                  $.ajax({
                   type: "POST",
                   url: "/api/widgets/save-position/{{Auth::user()->id}}/" + positioning
                 });
                }
              }
            }).data('gridster');

          });
          $(function() {
            
            function sendText(ev) {
              var text = $(ev.target).val() ? $(ev.target).val() : '';
              var id = $(ev.target).attr('id');
              
              $.ajax({
                type: 'POST',
                url: '/api/widgets/save-text/' + id + '/' + text
              });
              
            }

            $('.note').keyup(_.debounce(sendText,500));
          });
      });
    </script>
  @stop

