@extends('meta.base-user')

  @section('pageContent')
      <!-- <div id="main-menu" role="navigation">
      </div> -->

      <div id="content-wrapper">
        <div class="page-header">
      <h1><i class="fa fa-bar-chart-o page-header-icon"></i>&nbsp;&nbsp;Stat Panels</h1>
    </div> <!-- / .page-header -->

    <div class="note note-info padding-xs-vr">
      PixelAdmin's <strong>stat panels</strong> are flexible tool to visualize data sets. You can create panels without writing any extra styles. Also you can define height of panels via css (all sub blocks will stretch automatically). See source code.<br><br>
      <strong>NOTE:</strong> This examples uses utility classes defined in the utils.less file.<br><br>
      <button class="btn btn-xs" id="equal-height">Equalize heights</button>
    </div> <!-- / .note -->

    <div class="row">
      <div class="col-sm-5">

<!-- 5. $EXAMPLE_NOTIFICATIONS =====================================================================

        Notifications example
-->
        <div class="stat-panel">
          <!-- Success background, bordered, without top and bottom borders, without left border, without padding, vertically and horizontally centered text, large text -->
          <a href="#" class="stat-cell col-xs-5 bg-success bordered no-border-vr no-border-l no-padding valign-middle text-center text-lg">
            <i class="fa fa-calendar"></i>&nbsp;&nbsp;<strong>11</strong>
          </a> <!-- /.stat-cell -->
          <!-- Without padding, extra small text -->
          <div class="stat-cell col-xs-7 no-padding valign-middle">
            <!-- Add parent div.stat-rows if you want build nested rows -->
            <div class="stat-rows">
              <div class="stat-row">
                <!-- Success background, small padding, vertically aligned text -->
                <a href="#" class="stat-cell bg-success padding-sm valign-middle">
                  32 messages
                  <i class="fa fa-envelope-o pull-right"></i>
                </a>
              </div>
              <div class="stat-row">
                <!-- Success darken background, small padding, vertically aligned text -->
                <a href="#" class="stat-cell bg-success darken padding-sm valign-middle">
                  9 issues
                  <i class="fa fa-bug pull-right"></i>
                </a>
              </div>
              <div class="stat-row">
                <!-- Success darker background, small padding, vertically aligned text -->
                <a href="#" class="stat-cell bg-success darker padding-sm valign-middle">
                  47 new users
                  <i class="fa fa-users pull-right"></i>
                </a>
              </div>
            </div> <!-- /.stat-rows -->
          </div> <!-- /.stat-cell -->
        </div> <!-- /.stat-panel -->
<!-- /5. $EXAMPLE_NOTIFICATIONS -->

      </div>
      <div class="col-sm-4">

<!-- 6. $EXAMPLE_COMMENTS_COUNT ====================================================================

        Comments count example
-->
        <div class="stat-panel">
          <!-- Success background. vertically centered text -->
          <div class="stat-cell bg-danger valign-middle">
            <!-- Stat panel bg icon -->
            <i class="fa fa-comments bg-icon"></i>
            <!-- Extra large text -->
            <span class="text-xlg"><strong>124</strong></span><br>
            <!-- Big text -->
            <span class="text-bg">Comments</span><br>
            <!-- Small text -->
            <span class="text-sm">New comments today</span>
          </div> <!-- /.stat-cell -->
        </div> <!-- /.stat-panel -->
<!-- /6. $EXAMPLE_COMMENTS_COUNT -->

      </div>
      <div class="col-sm-3">

<!-- 7. $EXAMPLE_ICON_PANEL ========================================================================

        Icon panel example
-->
        <div class="stat-panel">
          <div class="stat-row">
            <!-- Info background, without padding, horizontally centered text, super large text -->
            <div class="stat-cell bg-info no-padding text-center text-slg">
              <i class="fa fa-clock-o"></i>
            </div>
          </div> <!-- /.stat-row -->
          <div class="stat-row">
            <!-- Bordered, without top border, horizontally centered text, large text -->
            <div class="stat-cell bordered no-border-t text-center text-lg">
              <strong>4:50</strong>
              <small><small>PM</small></small>
            </div>
          </div> <!-- /.stat-row -->
        </div> <!-- /.stat-panel -->
<!-- /7. $EXAMPLE_ICON_PANEL -->

      </div>
    </div> <!-- / .row -->
    <div class="row">
      <div class="col-sm-3">

<!-- 8. $EXAMPLE_VISITORS_CHART ====================================================================

        Visitors chart example
-->
        <!-- Javascript -->
        <script>
          init.push(function () {
            $("#stats-sparklines-2").pixelSparkline(
              [275,490,397,487,339,403,402,312,300,294,411,367,319,416,355,416,371,479,279,361,312,269,402,327,474,422,375,283,384,372], {
              type: 'bar',
              height: '50px',
              width: '100%',
              barSpacing: 2,
              zeroAxis: false,
              barColor: '#ffffff'
            });
          });
        </script>
        <!-- / Javascript -->

        <div class="stat-panel">
          <div class="stat-row">
            <!-- Warning background -->
            <div class="stat-cell bg-warning">
              <!-- Big text -->
              <span class="text-bg">15% more</span><br>
              <!-- Small text -->
              <span class="text-sm">Monthly visitor statistics</span>
            </div>
          </div> <!-- /.stat-row -->
          <div class="stat-row">
            <!-- Warning background, small padding, without top padding, horizontally centered text -->
            <div class="stat-cell bg-warning padding-sm no-padding-t text-center">
              <div id="stats-sparklines-2" class="stats-sparklines" style="width: 100%"><canvas width="268" height="50" style="display: inline-block; width: 268px; height: 50px; vertical-align: top;"></canvas></div>
            </div>
          </div> <!-- /.stat-row -->
        </div> <!-- /.stat-panel -->
<!-- /8. $EXAMPLE_VISITORS_CHART -->

      </div>
      <div class="col-sm-4">

<!-- 9. $EXAMPLE_RETWEETS_GRAPH ====================================================================

        Retweets graph example
-->
        <!-- Javascript -->
        <script>
          init.push(function () {
            $("#stats-sparklines-3").pixelSparkline([275,490,397,487,339,403,402,312,300], {
              type: 'line',
              width: '100%',
              height: '50px',
              fillColor: '',
              lineColor: '#fff',
              lineWidth: 2,
              spotColor: '#ffffff',
              minSpotColor: '#ffffff',
              maxSpotColor: '#ffffff',
              highlightSpotColor: '#ffffff',
              highlightLineColor: '#ffffff',
              spotRadius: 4,
              highlightLineColor: '#ffffff'
            });
          });
        </script>
        <!-- / Javascript -->

        <div class="stat-panel">
          <div class="stat-row">
            <!-- Info background, small padding -->
            <div class="stat-cell bg-info padding-sm">
              <!-- Extra small text -->
              <div class="text-xs" style="margin-bottom: 5px;">RETWEETS GRAPH</div>
              <div class="stats-sparklines" id="stats-sparklines-3" style="width: 100%"><canvas width="393" height="50" style="display: inline-block; width: 393px; height: 50px; vertical-align: top;"></canvas></div>
            </div>
          </div> <!-- /.stat-row -->
          <div class="stat-row">
            <!-- Bordered, without top border, horizontally centered text -->
            <div class="stat-counters bordered no-border-t text-center">
              <!-- Small padding, without horizontal padding -->
              <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                <!-- Big text -->
                <span class="text-bg"><strong>312</strong></span><br>
                <!-- Extra small text -->
                <span class="text-xs">TWEETS</span>
              </div>
              <!-- Small padding, without horizontal padding -->
              <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                <!-- Big text -->
                <span class="text-bg"><strong>1000</strong></span><br>
                <!-- Extra small text -->
                <span class="text-xs">FOLLOWERS</span>
              </div>
              <!-- Small padding, without horizontal padding -->
              <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                <!-- Big text -->
                <span class="text-bg"><strong>523</strong></span><br>
                <!-- Extra small text -->
                <span class="text-xs">FOLLOWING</span>
              </div>
            </div> <!-- /.stat-counters -->
          </div> <!-- /.stat-row -->
        </div> <!-- /.stat-panel -->
<!-- /9. $EXAMPLE_RETWEETS_GRAPH -->

      </div>
      <div class="col-sm-5">

<!-- 10. $EXAMPLE_EARNINGS_GRAPH ===================================================================

        Earnings graph example
-->
        <!-- Javascript -->
        <script>
          init.push(function () {
            $("#stats-sparklines-1").pixelSparkline(
              [210,244,210,221,205,217,213,246,234,236,225,242,216,205,233,233,221,201,235,237,224,247,200,245,216,204,205,216,218,247], {
              type: 'line',
              width: '100%',
              height: '80px',
              lineColor: 'rgba(0,0,0,0)',
              fillColor: 'rgba(0,0,0,.18)',
              lineWidth: 0,
              spotColor: '',
              minSpotColor: '',
              maxSpotColor: '',
              highlightSpotColor: '',
              highlightLineColor: '#ffffff',
              spotRadius: 1.8,
              chartRangeMin: 150
            });
          });
        </script>
        <!-- / Javascript -->

        <div class="stat-panel">
          <!-- Bordered, without right border, right aligned text -->
          <div class="stat-cell col-xs-5 bordered no-border-r text-right">
            <!-- Stat panel bg icon -->
            <i class="fa fa-trophy bg-icon bg-icon-left"></i>
            <!-- Extra small text -->
            <span class="text-xs">TODAY'S EARNINGS</span><br>
            <!-- Extra large text -->
            <span class="text-xlg"><small><small>$</small></small><strong>247</strong></span>
          </div> <!-- /.stat-cell -->
          <!-- Success darken background, without padding, vertically centered text -->
          <div class="stat-cell col-xs-7 bg-success no-padding valign-bottom">
            <div class="stats-sparklines" id="stats-sparklines-1" style="width: 100%"><canvas width="311" height="80" style="display: inline-block; width: 311px; height: 80px; vertical-align: top;"></canvas></div>
          </div>
        </div> <!-- /.stat-panel -->
<!-- /10. $EXAMPLE_EARNINGS_GRAPH -->

      </div>
    </div> <!-- / .row -->
    <div class="row">
      <div class="col-sm-4">

<!-- 11. $EXAMPLE_ACCOUNT_OVERVIEW =================================================================

        Account overview example
-->
        <div class="stat-panel">
          <div class="stat-row">
            <!-- Success darker background -->
            <div class="stat-cell bg-success darker">
              <!-- Stat panel bg icon -->
              <i class="fa fa-lightbulb-o bg-icon" style="font-size:60px;line-height:80px;height:80px;"></i>
              <!-- Big text -->
              <span class="text-bg">Overview</span><br>
              <!-- Small text -->
              <span class="text-sm">Your account statistics</span>
            </div>
          </div> <!-- /.stat-row -->
          <div class="stat-row">
            <!-- Success background, without bottom border, without padding, horizontally centered text -->
            <div class="stat-counters bg-success no-border-b no-padding text-center">
              <!-- Small padding, without horizontal padding -->
              <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                <!-- Big text -->
                <span class="text-bg"><strong>12</strong></span><br>
                <!-- Extra small text -->
                <span class="text-xs">PURCHASES</span>
              </div>
              <!-- Small padding, without horizontal padding -->
              <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                <!-- Big text -->
                <span class="text-bg"><strong>17</strong></span><br>
                <!-- Extra small text -->
                <span class="text-xs">REVIEWS</span>
              </div>
              <!-- Small padding, without horizontal padding -->
              <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                <!-- Big text -->
                <span class="text-bg"><strong>49</strong></span><br>
                <!-- Extra small text -->
                <span class="text-xs">LIKES</span>
              </div>
            </div> <!-- /.stat-counters -->
          </div> <!-- /.stat-row -->
          <div class="stat-row">
            <!-- Success background, without bottom border, without padding, horizontally centered text -->
            <div class="stat-counters bg-success no-border-b no-padding text-center">
              <!-- Small padding, without horizontal padding -->
              <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                <!-- Big text -->
                <span class="text-bg"><strong>203</strong></span><br>
                <!-- Extra small text -->
                <span class="text-xs">FRIENDS</span>
              </div>
              <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                <!-- Big text -->
                <span class="text-bg"><strong>1056</strong></span><br>
                <!-- Extra small text -->
                <span class="text-xs">POINTS</span>
              </div>
              <!-- Success background, small padding, without left and right padding, vertically centered text -->
              <a href="#" class="stat-cell col-xs-4 bg-success padding-sm no-padding-hr valign-middle">
                <!-- Extra small text -->
                <span class="text-xs">MORE&nbsp;&nbsp;<i class="fa fa-caret-right"></i></span>
              </a>
            </div> <!-- /.stat-counters -->
          </div> <!-- /.stat-row -->
        </div> <!-- /.stat-panel -->
<!-- /11. $EXAMPLE_ACCOUNT_OVERVIEW -->

      </div>
      <div class="col-sm-8">

<!-- 12. $EXAMPLE_UPLOAD_STATISTICS ================================================================

        Upload statistics example
-->
        <!-- Javascript -->
        <script>
          init.push(function () {
            var uploads_data = [
              { day: '2014-03-10', v: 20 },
              { day: '2014-03-11', v: 10 },
              { day: '2014-03-12', v: 15 },
              { day: '2014-03-13', v: 12 },
              { day: '2014-03-14', v: 5  },
              { day: '2014-03-15', v: 5  },
              { day: '2014-03-16', v: 20 }
            ];
            Morris.Line({
              element: 'hero-graph',
              data: uploads_data,
              xkey: 'day',
              ykeys: ['v'],
              labels: ['Value'],
              lineColors: ['#fff'],
              lineWidth: 2,
              pointSize: 4,
              gridLineColor: 'rgba(255,255,255,.5)',
              resize: true,
              gridTextColor: '#fff',
              xLabels: "day",
              xLabelFormat: function(d) {
                return ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov', 'Dec'][d.getMonth()] + ' ' + d.getDate(); 
              },
            });
          });
        </script>
        <!-- / Javascript -->

        <div class="stat-panel">
          <div class="stat-row">
            <!-- Bordered, without right border, top aligned text -->
            <div class="stat-cell col-sm-4 bordered no-border-r padding-sm-hr valign-top">
              <!-- Small padding, without top padding, extra small horizontal padding -->
              <h4 class="padding-sm no-padding-t padding-xs-hr"><i class="fa fa-cloud-upload text-primary"></i>&nbsp;&nbsp;Uploads</h4>
              <!-- Without margin -->
              <ul class="list-group no-margin">
                <!-- Without left and right borders, extra small horizontal padding -->
                <li class="list-group-item no-border-hr padding-xs-hr">
                  Documents <span class="label pull-right">34</span>
                </li> <!-- / .list-group-item -->
                <!-- Without left and right borders, extra small horizontal padding -->
                <li class="list-group-item no-border-hr padding-xs-hr">
                  Audio <span class="label pull-right">128</span>
                </li> <!-- / .list-group-item -->
                <!-- Without left and right borders, without bottom border, extra small horizontal padding -->
                <li class="list-group-item no-border-hr no-border-b padding-xs-hr">
                  Videos <span class="label pull-right">12</span>
                </li> <!-- / .list-group-item -->
              </ul>
            </div> <!-- /.stat-cell -->
            <!-- Primary background, small padding, vertically centered text -->
            <div class="stat-cell col-sm-8 bg-primary padding-sm valign-middle">
              <div id="hero-graph" class="graph" style="height: 180px;"><svg height="180" version="1.1" width="548" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.2</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text x="26.5" y="141" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#ffffff" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text><path fill="none" stroke="#ffffff" d="M39,141H523" stroke-opacity="0.5" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="26.5" y="112" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#ffffff" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">5</tspan></text><path fill="none" stroke="#ffffff" d="M39,112H523" stroke-opacity="0.5" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="26.5" y="83" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#ffffff" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10</tspan></text><path fill="none" stroke="#ffffff" d="M39,83H523" stroke-opacity="0.5" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="26.5" y="54" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#ffffff" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">15</tspan></text><path fill="none" stroke="#ffffff" d="M39,54H523" stroke-opacity="0.5" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="26.5" y="25" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#ffffff" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">20</tspan></text><path fill="none" stroke="#ffffff" d="M39,25H523" stroke-opacity="0.5" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="523" y="153.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#ffffff" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Mar 16</tspan></text><text x="442.3333333333333" y="153.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#ffffff" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Mar 15</tspan></text><text x="361.66666666666663" y="153.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#ffffff" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Mar 14</tspan></text><text x="281" y="153.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#ffffff" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Mar 13</tspan></text><text x="200.33333333333331" y="153.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#ffffff" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Mar 12</tspan></text><text x="119.66666666666666" y="153.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#ffffff" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Mar 11</tspan></text><text x="39" y="153.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#ffffff" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Mar 10</tspan></text><path fill="none" stroke="#ffffff" d="M39,25C59.166666666666664,39.5,99.5,79.375,119.66666666666666,83C139.83333333333331,86.625,180.16666666666666,55.449999999999996,200.33333333333331,54C220.5,52.55,260.8333333333333,64.15,281,71.4C301.16666666666663,78.65,341.5,106.925,361.66666666666663,112C381.8333333333333,117.075,422.16666666666663,122.875,442.3333333333333,112C462.5,101.125,502.8333333333333,46.75,523,25" stroke-width="2" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="39" cy="25" r="4" fill="#ffffff" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="119.66666666666666" cy="83" r="4" fill="#ffffff" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="200.33333333333331" cy="54" r="4" fill="#ffffff" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="281" cy="71.4" r="4" fill="#ffffff" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="361.66666666666663" cy="112" r="4" fill="#ffffff" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="442.3333333333333" cy="112" r="4" fill="#ffffff" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="523" cy="25" r="4" fill="#ffffff" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle></svg><div class="morris-hover morris-default-style" style="left: 471px; top: 35px;"><div class="morris-hover-row-label">2014-03-16</div><div class="morris-hover-point" style="color: #fff">
  Value:
  20
</div></div></div>
            </div>
          </div>
        </div> <!-- /.stat-panel -->
<!-- /12. $EXAMPLE_UPLOAD_STATISTICS -->

      </div>
    </div> <!-- / .row -->

      </div>  <!-- / #content-wrapper -->
    </div> <!-- / #main-wrapper -->
  @stop

  @section('pageScripts')

    <script type="text/javascript">
    
    </script>

  @stop

  @section('intercomScript')
  <script>
     
  </script>
  {{ HTML::script('js/intercom_io.js'); }}
  @stop

