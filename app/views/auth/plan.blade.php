@extends('meta.base-user')

  @section('pageContent')

  <div id="content-wrapper" class='page-pricing'>
    <div class="page-header text-center">
      <h1><i class="page-header-icon"></i>Plans and Pricing</h1>
    </div> <!-- / .page-header -->
    @parent
    <div class='plans-panel'>
      <div class='plans-container'>
        <!-- Free Plan -->
        <div class='plan-col col-md-3 col-md-offset-3'>
          <div class='plan-header bg-light-green darken'>{{$plans[1]->name}}</div>
          <div class='plan-pricing bg-light-green'>
            <span class='plan-value'>Free</span>
          </div>
          <ul class='plan-features'>
            <li>Create graphs</li>
            <li>Create dashboards</li>
            <li>100 Mb data storage</li>
            <a href='/plans/free' class='bg-light-green darken'><h4>SIGN UP</h4></a>
          </ul>
        </div>
        <!-- /Free Plan -->

        <!-- Basic Plan -->
        <div class='plan-col col-md-3'>
          <div class='plan-header bg-light-green darker'>{{$plans[0]->name}}</div>
          <div class='plan-pricing bg-light-green darken'>
            <span class='plan-currency'>$</span>
            <span class='plan-value'>9</span>
            <span class='plan-period'>/MO</span>
          </div>
          <ul class='plan-features'>
            <li>Create graphs</li>
            <li>Create dashboards</li>
            <li>1000 Mb data storage</li>
            <li>Control privacy settings</li>
            <li>Add custom logo</li>
            <li>Premium support</li>
            <a href='/plans/basic' class='bg-light-green darker'><h4>SIGN UP</h4></a>
          </ul>
        </div>
        <!-- /Basic Plan -->

        {{--
        <!-- Elite Plan -->
        <!-- /Elite Plan -->
        --}}
      </div> <!-- /.plans-container -->
    </div> <!-- /.plans-panel -->
  </div> <!-- /.content-wrapper -->
  @stop

  @section('pageScripts')

  @stop