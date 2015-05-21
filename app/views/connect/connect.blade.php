@extends('meta.base-user')

  @section('pageContent')
    
    <div id="content-wrapper">
      <div class="page-header text-center">
        <h1><i class="fa fa-link page-header-icon"></i>&nbsp;&nbsp;Connect a service</h1>
      </div> <!-- / .page-header -->
      @parent

      <div class="col-md-10 col-md-offset-1">

        {{--
        <!-- SSL cert. -->
        <div class="row">
          <div class="certificate-wrapper bordered">
            <div class="panel-body certificate">
              <span class="lead col-sm-6">Don't worry we're using secure protocols here.</span>
              <a href="https://www.positivessl.com" class='sm-pull-right text-center'>
                <img src="https://www.positivessl.com/images-new/PositiveSSL_tl_white2.png" alt="SSL Certificate" title="SSL Certificate" border="0"/>
              </a>
            </div>
          </div>
        </div>
        <!-- /SSL cert. -->
        --}}
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
              <div class='col-sm-4'>
                <h4>Connect Stripe</h4>
              </div>
              <div class="col-sm-2 col-sm-offset-1 text-center">
                <span class="icon pf-big pf-stripe"></span>
              </div> <!-- /. connect-icon -->

              <div class="col-sm-5">
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
                          Are you sure you want to disconnect Stripe from your account? <br>
                          After disconnecting we will not receive any more data from Stripe.</div>
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
                  <a href="{{$stripeButtonUrl}}" class="stripe-connect sm-pull-right" onclick='_gaq.push(["_trackEvent", "Connect", "Connecting Stripe"]);mixpanel.track("Stripe connect");'><span>Connect with Stripe</span></a>
                  
                  <!--
                  <div style='display:none;'>
                    {{ Form::open(array(
                      'route'=>'connect.connect',
                      'method' => 'post',
                      'id' => 'form-settings',
                      'class' => 'form-horizontal',
                      'role' => 'form' )) }}

                        <div class="form-group">
                          {{ Form::label('id_stripe', 'Your Stripe secret key:', array(
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
                        </div>
                    {{ Form::close() }}
                    <p class="col-sm-7 col-sm-offset-3 text-default">Go to <a href="http://www.stripe.com">www.stripe.com</a>, Your account, Account settings, API keys and copy your secret key</p>
                  </div>
                  -->
              @endif
              </div> <!-- /. col-sm-5 -->

            </div> <!-- /. panel-body stripe-from -->
          </div> <!-- /. col-sm-6 stripe-form-wrapper -->
        </div> <!-- /. row -->
        <!-- / Stripe connect -->

        {{-- 
        <!-- Braintree connect -->
        <div class="row">
          <div class="braintree-form-wrapper bordered">
            <div class="panel-body braintree-form">
              <div class='col-sm-4'>
                <h4>Connect Braintree</h4>
              </div>
              <div class="col-sm-2 col-sm-offset-1 text-center">
                <span class="icon pf-big pf-braintree"></span>
              </div> <!-- /. connect-icon -->
              @if ($braintree_connected)
                <div class="col-sm-5">
                    <!-- Modal box -->
                    <div id="modal-sizes-1" class="modal fade" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          <h4 class="modal-title">Warning</h4>
                          </div>
                          <div class="modal-body">
                            Are you sure you want to disconnect Braintree from your account? <br>
                            After disconnecting we will not receive any more data from Braintree.</div>
                          <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <a onClick= '_gaq.push(["_trackEvent", "Disconnect", "Braintree disconnected"]);mixpanel.track("Disconnect",{"service":"braintree"});' href="{{ URL::route('auth.disconnect', 'braintree') }}"><button type="button" class="btn btn-danger">Disconnect</button></a>
                        </div>
                        </div> <!-- / .modal-content -->
                      </div> <!-- / .modal-dialog -->
                    </div>
                    <!-- /Modal box -->
                  <button class="btn-link sm-pull-right" data-toggle="modal" data-target="#modal-sizes-1">Disconnect</button>
              @else
                <div class="col-sm-5">
                  <a href="" class="sm-pull-right" onclick='_gaq.push(["_trackEvent", "Connect", "Connecting Braintree"]);mixpanel.track("Braintree connect");'><span>Connect with Braintree</span></a>
              @endif
              </div> <!-- /. col-sm-10 -->

            </div> <!-- /. panel-body braintree-from -->
          </div> <!-- /. col-sm-6 braintree-form-wrapper -->
        </div> <!-- /. row -->
        <!-- / Braintree connect -->
        --}}

        <!-- Google Spreadsheet connect -->
        <div class="row">
          <div class="googlespreadsheet-form-wrapper bordered">
            <div class="panel-body googlespreadsheet-form">
              <div class='col-sm-4'>
                <h4>Connect Google Spreadsheets</h4>
              </div>
              <div class="col-sm-2 col-sm-offset-1 text-center">
                <span class="icon pf-big pf-googlespreadsheet"></span>
              </div> <!-- /. connect-icon -->
              @if ($googlespreadsheet_connected)
                <div class="col-sm-5">
                    <!-- Modal box -->
                    <div id="modal-sizes-1" class="modal fade" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          <h4 class="modal-title">Warning</h4>
                          </div>
                          <div class="modal-body">
                            Are you sure you want to disconnect Google Spreadsheet from your account? <br>
                            After disconnecting we will not receive any more data from Google Spreadsheet.</div>
                          <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <a onClick= '_gaq.push(["_trackEvent", "Disconnect", "Google Spreadsheet disconnected"]);mixpanel.track("Disconnect",{"service":"google spreadsheet"});' href="{{ URL::route('auth.disconnect', 'braintree') }}"><button type="button" class="btn btn-danger">Disconnect</button></a>
                        </div>
                        </div> <!-- / .modal-content -->
                      </div> <!-- / .modal-dialog -->
                    </div>
                    <!-- /Modal box -->
                  <button class="btn-link sm-pull-right" data-toggle="modal" data-target="#modal-sizes-1">Disconnect</button>
              @else
                <div class="col-sm-5">
                    <!-- Modal box -->
                    <div id="modal-sizes-x" class="modal fade" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
                      hello
                    </div>
                    <!-- /Modal box -->
                  <button class="btn-link sm-pull-right" data-toggle="modal" data-target="#modal-sizes-x">Disconnect</button>

                <div class="col-sm-5">
                  <a href="{{$googleSpreadsheetButtonUrl}}" class="sm-pull-right" onclick='_gaq.push(["_trackEvent", "Connect", "Connecting Google Spreadsheet"]);mixpanel.track("Google Spreadsheet connect");'><span>Connect Google Spreadsheets</span></a>
              @endif
              </div> <!-- /. col-sm-10 -->

            </div> <!-- /. panel-body googlespreadsheet-from -->
          </div> <!-- /. col-sm-6 googlespreadsheet-form-wrapper -->
        </div> <!-- /. row -->
        <!-- / Google Spreadsheet connect -->


        <!-- Suggestion -->
        <div class="row">
          <div class="suggestion-form-wrapper bordered">
            <div class="panel-body suggestion-form">
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
                        'placeholder' => 'e.g: PayPal')) }}
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
            </div> <!-- /. panel-body suggestion-from -->
          </div> <!-- /. col-sm-6 suggestion-form-wrapper -->
        </div> <!-- /. row -->
        <!-- / Suggestion -->

      </div> <!-- /. col-md-10 col-md-offset-1 -->
    </div> <!-- / #content-wrapper -->

  @stop

  @section('pageScripts')

    <script type="text/javascript">

    </script>

  @stop

