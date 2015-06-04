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

          @include('dashboard.widget', ['widget_data' => $allFunctions[$i], 'currentTime' => $currentTime])

        @endfor

      </ul>

    </div> <!-- / #content-wrapper -->
  @stop

  @section('pageScripts')

    <!-- Grid functions -->
    <script type="text/javascript">
<<<<<<< HEAD
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
                  url: "/api/widgets/save/{{Auth::user()->id}}/" + positioning
                });
               }
             },
             draggable: {
               stop: function(e, ui, $widget) {
                 console.log(ui.$helper[0].offsetWidth);
                 positioning = gridster.serialize();
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
=======
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
        });  // /functions
      }); // /document ready
    </script>
    <!-- /Grid functions -->

    <!-- Saving text -->
    <script type="text/javascript">
      $(document).ready(function(){
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
    <!-- /Saving text -->
>>>>>>> 3f65125b048b232cfaaad2e94b27b133a8a661ed

    <!-- script for clock -->
    <script type="text/javascript">
<<<<<<< HEAD
      function startTime() {
          var today = new Date();
          var h = today.getHours();
          var m = today.getMinutes();
          m = checkTime(m);
          document.getElementById('clock').innerHTML = h+":"+m;
          var t = setTimeout(function(){startTime()},500);
      }

<<<<<<< HEAD
    function checkTime(i) {
      if (i<10){i = "0" + i};  // add zero in front of numbers < 10
      return i;
    }

    startTime();
  </script>
  
  <script type="text/javascript">
  /*window.fitText( document.getElementById("clock") );*/
    $(document).ready(function() {
      var x = $(".dashboard-widget well").offsetWidth;
      var y = $(".dashboard-widget well").offsetHeight;
      console.log($(".dashboard-widget well"))
      console.log(x);
      console.log(y);
  });
</script>
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
                   url: "/api/widgets/save/{{Auth::user()->id}}/" + positioning
                 });
                }
              },
              draggable: {
                stop: function(e, ui, $widget) {
                  positioning = gridster.serialize();
                  positioning = JSON.stringify(positioning);
                  $.ajax({
                   type: "POST",
                   url: "/api/widgets/save/{{Auth::user()->id}}/" + positioning
                 });
                }
              }
            }).data('gridster');
=======
      function checkTime(i) {
        if (i<10){i = "0" + i};  // add zero in front of numbers < 10
        return i;
      }
>>>>>>> 3f65125b048b232cfaaad2e94b27b133a8a661ed

      startTime();
    </script>
    
    <script type="text/javascript">
    /*window.fitText( document.getElementById("clock") );*/
      
=======

      $(document).ready(function()
      {
        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            m = checkTime(m);
            $('.digitTime').html(h + ':' + m);
            var t = setTimeout(function(){startTime()},500);
        }

        function checkTime(i) {
          if (i<10){i = "0" + i};  // add zero in front of numbers < 10
          return i;
        }

        startTime();
      });
>>>>>>> 1256642961ec83190a52d60d402a71859a4c143e
    </script>
<<<<<<< HEAD
=======
      
>>>>>>> 3f65125b048b232cfaaad2e94b27b133a8a661ed
  @stop

