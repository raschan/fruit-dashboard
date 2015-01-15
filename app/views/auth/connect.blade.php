@extends('meta.base-user')

  @section('pageContent')
    <div id="content-wrapper">
      <div class="page-header text-center">
        <h1><i class="fa fa-link page-header-icon"></i>&nbsp;&nbsp;Connect a service</h1>
      </div> <!-- / .page-header -->

      @if (!Auth::user()->isConnected())
      <div class="alert alert-warning">
        No key is provided! You are currently viewing the site in demo mode! <a href="{{ URL::route('auth.dashboard') }}" class="pull-right"> Continue in demo</a>
      </div>
      @endif

      <div class="col-md-10 col-md-offset-1">

        <!-- PayPal connect-->

        <div class="row">
          <div class="paypal-form-wrapper">
            <div class="panel-body paypal-form">
              <h4>Connect PayPal</h4>

              <div class="col-md-2 text-center">
                <i class="fa icon fa-cc-paypal fa-4x"></i>
              </div> <!-- /. col-md-2 -->

              <div class="col-md-8">
                <p class="text-muted">Some help text abot what to do. Lorem ipsum</p>
              </div> <!-- /. col-md-8 -->

              <div class="col-md-2">
                <a href="{{ $redirect_url }}">
                    {{ Form::submit('Connect', array(
                        'id' => 'id_submit',
                        'class' => 'btn btn-success btn-lg btn-flat pull-right')) }}          
                </a>
              </div> <!-- /. col-md-2 -->

            </div> <!-- /. panel-body -->
          </div> <!-- /. col-md-6 paypal-form-wrapper -->
        </div> <!-- /. row -->

        <!-- /PayPal connect-->

        <!-- Stripe connect -->
        <div class="row">
          <div class="stripe-form-wrapper">          
            <div class="panel-body stripe-form">
              <h4>Connect Stripe</h4>

              <div class="col-md-2 text-center">
                <i class="fa icon fa-cc-stripe fa-4x"></i>
              </div> <!-- /. connect-icon -->

              <div class="col-md-10">
                {{ Form::open(array(
                  'route'=>'auth.connect',
                  'method' => 'post',
                  'id' => 'form-settings',
                  'class' => 'form-horizontal',
                  'role' => 'form' )) }}

                    <div class="form-group">
                      {{ Form::label('id_stripe', 'Your Stripe key:', array(
                        'class' => 'col-xs-3 control-label text-left-always')) }}
                      <div class="col-xs-7">
                        {{ Form::text('stripe', '', array(
                          'id' => 'id_stripe',
                          'class' => 'form-control')) }}
                      </div>

                      <div class="col-xs-2">
                      {{ Form::submit('Connect', array(
                          'id' => 'id_submit',
                          'class' => 'btn btn-success btn-lg btn-flat pull-right')) }}
                    </div>
                    </div> <!-- / .form-group -->

                    

                {{ Form::close() }}
              </div> <!-- /. connect-form -->
            </div> <!-- /. panel-body -->
          </div> <!-- /. col-md-6 stripe-form-wrapper -->
        </div> <!-- /. row -->
        <!-- / Stripe connect -->

      </div> <!-- /. col-md-10 -->
    </div> <!-- / #content-wrapper -->

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
