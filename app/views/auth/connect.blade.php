@extends('meta.base-user')

  @section('pageContent')
    <div id="content-wrapper">
      <div class="page-header text-center">
        <h1><i class="fa fa-link page-header-icon"></i>&nbsp;&nbsp;Connect a service</h1>
      </div> <!-- / .page-header -->

      <div class="col-md-10 col-md-offset-1">

      {{-- 
        <!-- hidden for development, will not be rendered on client side -->   
        <!-- PayPal connect-->

        <div class="row">
          <div class="paypal-form-wrapper">
            <div class="panel-body paypal-form bordered">
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
                <button class='btn btn-warning btn-xs btn-flat sm-pull-right'>Disconnect</button>
                </a>
                @else
                <a href="{{ $redirect_url }}">
                    {{ Form::submit('Connect', array(
                        'id' => 'id_submit',
                        'class' => 'btn btn-primary btn-lg btn-flat sm-pull-right')) }}
                </a>
                @endif
              </div>

            </div> <!-- /. panel-body paypal-form -->
          </div> <!-- /. col-sm-6 paypal-form-wrapper -->
        </div> <!-- /. row -->

        <!-- /PayPal connect-->
        <!-- / hidden for development, will not be rendered on client side -->   
      --}}

        <!-- Stripe connect -->
        <div class="row">
          <div class="stripe-form-wrapper bordered">
            <div class="panel-body stripe-form">
              <h4>Connect stripe</h4>

              <div class="col-sm-2 text-center">
                <i class="fa icon fa-cc-stripe fa-4x"></i>
              </div> <!-- /. connect-icon -->

              <div class="col-sm-10">
                @if ($stripe_connected)
                  <!-- Modal box -->
                  <div id="modal-sizes-1" class="modal fade" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Warning</h4>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to disconnect stripe from your account? <br>
                          After disconnecting we will not receive any more data from stripe.</div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <a onClick= '_gaq.push(["_trackEvent", "Disconnect", "Stripe disconnected"]);mixpanel.track("Disconnect",{"service":"stripe"});' href="{{ URL::route('auth.disconnect', 'stripe') }}"><button type="button" class="btn btn-danger">Disconnect</button></a>
                      </div>
                      </div> <!-- / .modal-content -->
                    </div> <!-- / .modal-dialog -->
                  </div>
                  <!-- /Modal box -->
                <button class="btn-link sm-pull-right" data-toggle="modal" data-target="#modal-sizes-1">Disconnect</button>
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
                          'class' => 'form-control',
                          'placeholder' => 'sk_live_xxxxxxxxxxxxxxxxxxxxxxxx')) }}
                      </div>

                      <div class="col-sm-2 text-center">
                      {{ Form::submit('Connect', array(
                          'id' => 'id_submit',
                          'class' => 'btn btn-primary btn-lg btn-flat sm-pull-right',
                          'onClick'=> '_gaq.push(["_trackEvent", "Connect", "Connecting Stripe"]);mixpanel.track("Stripe connect");')) }}
                      </div>

                    </div> <!-- / .form-group -->

                {{ Form::close() }}
                <p class="col-sm-7 col-sm-offset-3 text-default">Go to <a href="http://www.stripe.com">www.stripe.com</a>, Your account, Account settings, API keys, Secret key</p>

                @endif

              </div> <!-- /. col-sm-10 -->
            </div> <!-- /. panel-body stripe-from -->
          </div> <!-- /. col-sm-6 stripe-form-wrapper -->
        </div> <!-- /. row -->
        <!-- / Stripe connect -->

        <!-- Suggestion -->
        <div class="row">
          <div class="stripe-form-wrapper bordered">
            <div class="panel-body stripe-form">
              <h4>Using a different payment processor?</h4>
              <p>Please tell us and we'll get in touch with you.</p>

              <div class="col-sm-10 col-sm-offset-2">
              {{ Form::open(array(
                'route'=>'auth.suggest',
                'method' => 'post',
                'id' => 'form-settings',
                'class' => 'form-horizontal',
                'role' => 'form' )) }}

                  <div class="form-group">

                    {{ Form::label('id_suggestion', 'Your payment processor:', array(
                      'class' => 'col-sm-3 control-label text-left-always')) }}
                    <div class="col-sm-7">
                      {{ Form::text('suggestion', '', array(
                        'id' => 'id_suggestion',
                        'class' => 'form-control',
                        'placeholder' => 'e.g: Braintree')) }}
                    </div>

                    <div class="col-sm-2 text-center">
                    {{ Form::submit('Tell us', array(
                        'id' => 'id_submit',
                        'class' => 'btn btn-primary btn-lg btn-flat sm-pull-right',
                        'onClick'=> '_gaq.push(["_trackEvent", "Suggest", "Suggestion sent"]);mixpanel.track("Suggest");')) }}
                    </div>
                  </div> <!-- / .form-group -->

              {{ Form::close() }}

              </div> <!-- /. col-sm-10 -->
            </div> <!-- /. panel-body stripe-from -->
          </div> <!-- /. col-sm-6 stripe-form-wrapper -->
        </div> <!-- /. row -->
        <!-- / Suggestion -->

      </div> <!-- /. col-md-10 col-md-offset-1 -->
    </div> <!-- / #content-wrapper -->

  @stop

  @section('pageScripts')

    <script type="text/javascript">

    </script>

  @stop

