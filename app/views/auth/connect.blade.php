@extends('meta.base-user')

  @section('pageContent')
    <div id="content-wrapper">
      <div class="page-header text-center">
        <h1><i class="fa fa-link page-header-icon"></i>&nbsp;&nbsp;Connect a service</h1>
      </div> <!-- / .page-header -->

      @if (!Auth::user()->isConnected())
      <div class="alert alert-warning">
        You didn't connect any service yet! This is only a demo site! <a href="{{ URL::route('auth.dashboard') }}" class="pull-right"> Continue in demo</a>
      </div>
      @endif

      <div class="col-md-10 col-md-offset-1">

        <!-- PayPal connect-->

        <div class="row">
          <div class="paypal-form-wrapper">
            <div class="panel-body paypal-form">
              <h4>Connect PayPal</h4>

              <div class="col-sm-2 text-center">
                <i class="fa icon fa-cc-paypal fa-4x"></i>
              </div> <!-- /. col-sm-2 -->

              <div class="col-sm-8">
                <p class="text-muted">Some help text abot what to do. Lorem ipsum</p>
              </div> <!-- /. col-sm-8 -->

              <div class="col-sm-2 text-center">
                @if ($paypal_connected)
                <a href="{{ URL::route('auth.disconnect', 'paypal') }}">
                <button class='btn btn-special btn-lg btn-flat sm-pull-right'>Disconnect</button>
                </a>
                @else
                <a href="{{ $redirect_url }}">
                    {{ Form::submit('Connect', array(
                        'id' => 'id_submit',
                        'class' => 'btn btn-special btn-lg btn-flat sm-pull-right')) }}
                </a>
                @endif
              </div>

            </div> <!-- /. panel-body paypal-form -->
          </div> <!-- /. col-sm-6 paypal-form-wrapper -->
        </div> <!-- /. row -->

        <!-- /PayPal connect-->

        <!-- Stripe connect -->
        <div class="row">
          <div class="stripe-form-wrapper">
            <div class="panel-body stripe-form">
              <h4>Connect Stripe</h4>

              <div class="col-sm-2 text-center">
                <i class="fa icon fa-cc-stripe fa-4x"></i>
              </div> <!-- /. connect-icon -->

              <div class="col-sm-10">
                @if ($stripe_connected)
                <a href="{{ URL::route('auth.disconnect', 'stripe') }}">
                <button class='btn btn-special btn-lg btn-flat sm-pull-right'>Disconnect</button>
                @else
                {{ Form::open(array(
                  'route'=>'auth.connect',
                  'method' => 'post',
                  'id' => 'form-settings',
                  'class' => 'form-horizontal',
                  'role' => 'form' )) }}

                    <div class="form-group">

                      {{ Form::label('id_stripe', 'Your Stripe key:', array(
                        'class' => 'col-sm-3 control-label text-left-always')) }}
                      <div class="col-sm-7">
                        {{ Form::text('stripe', '', array(
                          'id' => 'id_stripe',
                          'class' => 'form-control ')) }}
                      </div>

                      <div class="col-sm-2 text-center">
                      {{ Form::submit('Connect', array(
                          'id' => 'id_submit',
                          'class' => 'btn btn-special btn-lg btn-flat sm-pull-right')) }}
                      </div>

                    </div> <!-- / .form-group -->

                {{ Form::close() }}

                @endif

              </div> <!-- /. col-sm-10 -->
            </div> <!-- /. panel-body stripe-from -->
          </div> <!-- /. col-sm-6 stripe-form-wrapper -->
        </div> <!-- /. row -->
        <!-- / Stripe connect -->

      </div> <!-- /. col-md-10 col-md-offset-1 -->
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
