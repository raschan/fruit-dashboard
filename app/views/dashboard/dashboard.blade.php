@extends('meta.base-user')

  @section('pageTitle')
    Dashboard
  @stop

  @section('pageStylesheet')
  @stop

  @section('pageContent')

      <!-- widget list -->
      <div class="container">
        <div class="row">
          <div class="gridster not-visible">
            <ul>
              @for ($i = 0; $i < count($allFunctions); $i++)

                @include('dashboard.widget', ['widget_data' => $allFunctions[$i]])

              @endfor
            </ul>
          </div>
        </div>
      </div>
      <!-- /widget list -->

  @stop

  @section('pageScripts')

    <!-- Grid functions -->
    <script type="text/javascript">
     $(document).ready(function() {
         var gridster;
         var positioning = [];
         var widget_width = $(window).width()/12-15;
         var widget_height = $(window).height()/12-20;

         $(function(){

           gridster = $(".gridster ul").gridster({
             /* widget_base_dimenions - finer resizable steps*/
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
     });
    </script>
    <!-- /Grid functions -->

    {{ HTML::script('js/jquery.color.js') }}
    {{ HTML::script('js/jquery.easing.1.3.js') }}

    <!-- Saving text and settings -->
    <script type="text/javascript">
      $(document).ready(function(){
                  
        function sendText(ev) {
          var text = $(ev.target).val() ? $(ev.target).val() : '';
          text = text.replace(/\n\r?/g, '[%LINEBREAK%]');
          var id = $(ev.target).attr('id');
          
          $.ajax({
            type: 'POST',
            url: '/api/widgets/save-text/' + id + '/' + text
          });
        }

        function saveWidgetName(ev) {
          
          var input = $(ev.target).parent().parent().children('input');
          var newName = input.val();
          var id = input.attr('id');

          if (newName) {
            $.ajax({
              type: 'POST',
              url: '/api/widgets/settings/name/' + id + '/' + newName,
              success:function(message,code){
                var current = input.css('background-color');

                input.animate({'background-color':'LightGreen'},50,'easeInCirc');
                input.animate({'background-color': current},100,'easeOutCirc');
              }
            });            
          }
        }
        // user finished typing
        $('.save-widget-name').click(saveWidgetName);
        $('.note').keyup(_.debounce(sendText,500));
      });
    </script>
    <!-- /Saving text -->

    <!-- script for clock -->
    <script type="text/javascript">
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

        $('.not-visible').fadeIn(500);
      });
    </script>
    <!-- /script for clock -->
    
    <!-- Deciding on proper greeting -->
    <script type="text/javascript">
      $(document).ready(function()
      {
        var hours = new Date().getHours();
        
        if(17 <= hours || hours < 5) { $('.greeting').html('evening'); }
        if(5 <= hours && hours < 13) { $('.greeting').html('morning'); }
        if(13 <= hours && hours < 17) { $('.greeting').html('afternoon'); } 
      });
    </script>
    <!-- /Deciding on proper greeting -->
  @append

