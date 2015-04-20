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
        <div class='plan-col col-md-4'>
          <div class='plan-header bg-light-green darken'>FREE</div>
          <div class='plan-pricing bg-light-green'>Free of charge</div>
          <ul class='plan-features'>
            <li>public data</li>
            <li>good for you</li>
            <a href='/plans/free' class='bg-light-green darker'>ORDER NOW</a>
          </ul>
        </div>
        <!-- /Free Plan -->

        <!-- Basic Plan -->
        <button class="btn-link sm-pull-right">Disconnect</button>
        <!-- /Basic Plan -->

        <!-- Elite Plan -->
        <button class="btn-link sm-pull-right">Disconnect</button>
        <!-- /Elite Plan -->
      </div> <!-- /.plans-container -->
    </div> <!-- /.plans-panel -->
  </div> <!-- /.content-wrapper -->
  @stop

  @section('pageScripts')

  @stop