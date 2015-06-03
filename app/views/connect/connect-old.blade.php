@extends('meta.base-user')

  @section('pageTitle')
    Connect
  @stop

  @section('pageContent')
    
    <div id="content-wrapper">
      <div class="col-md-10 col-md-offset-1">
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

              <div class="col-sm-5 valign">
                @if ($user->isStripeConnected())
                  <!-- Modal box -->
                  <div id="modal-stripe-disconnect" class="modal fade" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
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
                  <button class="btn-link sm-pull-right" data-toggle="modal" data-target="#modal-stripe-disconnect">Disconnect</button>
                @elseif($user->canConnectMore())
                  <a href="{{$stripeButtonUrl}}" class="stripe-connect sm-pull-right" onclick='_gaq.push(["_trackEvent", "Connect", "Connecting Stripe"]);mixpanel.track("Stripe connect");'><span>Connect with Stripe</span></a>
                @else
                  <a href="/plans" class="stripe-connect sm-pull-right"><span>Connect with Stripe</span></a>
                  
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
              <div class="col-sm-5 valign">
                <!-- Braintree details modal box -->
                <div id='modal-braintree-connect' class='modal fade in' tabindex='-1' role='dialog' style="display:none;" aria-hidden='true'>
                  <div class='modal-dialog modal-lg'>
                    <div>
                      <div class='modal-header'>
                        <button type="button" class="close" data-dismiss='modal' aria-hidden='true'>x</button>
                        <h4 class='modal-title'>Connect Braintree</h4>
                      </div>
                      <div class='modal-content' style='background:white;'>
                        @include('connect.braintreeConnect',array('user'=>$user,'stepNumber'=>$braintree_connect_stepNumber))
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /Braintree details modal box -->
                @if ($user->isBraintreeConnected())
                  <!-- Modal box -->
                  <div id="modal-bt-disconnect" class="modal fade" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
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
                  <button class="btn-link sm-pull-right" data-toggle="modal" data-target="#modal-bt-disconnect">Disconnect</button>
                  <button class="btn-link sm-pull-right" data-toggle="modal" data-target="#modal-braintree-connect">Details</button>
                @elseif($user->canConnectMore())
                  @if($user->btWebhookConnected)
                    <button class='btn-link sm-pull-right' data-toggle='modal' data-target='#modal-braintree-connect'>
                      Import your data
                    </button>
                  @elseif($user->isBraintreeCredentialsValid())
                    <button class='btn-link sm-pull-right' data-toggle='modal' data-target='#modal-braintree-connect'>
                      Add webhook to finish connecting
                    </button>
                  @else
                    <button class='btn-link sm-pull-right' data-toggle='modal' data-target='#modal-braintree-connect'>
                      Connect with Braintree
                    </button>
                  @endif
                @else {{-- can't connect more --}}
                  <a href="/plans" class='btn-link sm-pull-right'>Connect with Braintree</a>
                @endif
              </div> <!-- /. col-sm-5 -->

            </div> <!-- /. panel-body braintree-from -->
          </div> <!-- /. col-sm-6 braintree-form-wrapper -->
        </div> <!-- /. row -->
        <!-- / Braintree connect -->
       
        <!-- Google Spreadsheet connect -->
        <div class="row">
          <div class="googlespreadsheet-form-wrapper bordered">
            <div class="panel-body googlespreadsheet-form">
              <div class='col-sm-4'>
                <h4>Connect Google Spreadsheets</h4>
              </div>
              <div class="col-sm-2 col-sm-offset-1 text-center">
                <span class="icon fa fa-google fa-3x"></span>
              </div> <!-- /. connect-icon -->
              <div class="col-sm-5">
                @if ($user->isGoogleSpreadsheetConnected())
                  <!-- Modal box -->
                  <div id="modal-google-ss-disconnect" class="modal fade" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          <h4 class="modal-title">Warning</h4>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to disconnect Google Spreadsheet from your account? <br>
                          After disconnecting we will not receive any more data from Google Spreadsheet.
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <a onClick= '_gaq.push(["_trackEvent", "Disconnect", "Google Spreadsheet disconnected"]);mixpanel.track("Disconnect",{"service":"google spreadsheet"});' href="{{ URL::route('auth.disconnect', 'googlespreadsheet') }}"><button type="button" class="btn btn-danger">Disconnect</button></a>
                        </div>
                      </div> <!-- / .modal-content -->
                    </div> <!-- / .modal-dialog -->
                  </div>
                  <!-- /Modal box -->
                  <button class="btn-link sm-pull-right" data-toggle="modal" data-target="#modal-google-ss-disconnect">Disconnect</button>
                  <a href="{{ URL::route('connect.addwidget', 'googlespreadsheet') }}" class="sm-pull-right"><span>Add new widget</span></a>
                @elseif($user->canConnectMore())
                  <a href="{{ $googleSpreadsheetButtonUrl }}" class="sm-pull-right valign" onclick='_gaq.push(["_trackEvent", "Connect", "Connecting Google Spreadsheet"]);mixpanel.track("Google Spreadsheet connect");'><span>Connect Google Spreadsheets</span></a>
                @else
                  <a href="/plans" class="sm-pull-right valign"><span>Connect Google Spreadsheets</span></a>
                @endif
              </div> <!-- /. col-sm-5 -->
            </div> <!-- /. panel-body googlespreadsheet-from -->
          </div> <!-- /. col-sm-6 googlespreadsheet-form-wrapper -->
        </div> <!-- /. row -->
        <!-- / Google Spreadsheet connect -->

        <!-- iframe connect -->
        <div class="row">
          <div class="googlespreadsheet-form-wrapper bordered">
            <div class="panel-body googlespreadsheet-form">
              <div class='col-sm-4'>
                <h4>Add an iFrame widget</h4>
              </div>
              <div class="col-sm-2 col-sm-offset-1 text-center">
                <span class="icon fa fa-file-text-o fa-3x"></span>
              </div> <!-- /. connect-icon -->
              <div class="col-sm-5">
                  <a href="{{ URL::route('connect.addwidget', 'iframe') }}" class="sm-pull-right"><span>Add new widget</span></a>
              </div> <!-- /. col-sm-5 -->
            </div> <!-- /. panel-body googlespreadsheet-from -->
          </div> <!-- /. col-sm-6 googlespreadsheet-form-wrapper -->
        </div> <!-- /. row -->
        <!-- / iframe connect -->

      </div> <!-- /. col-md-10 col-md-offset-1 -->
    </div> <!-- / #content-wrapper -->

  @stop

  @section('pageScripts')

    @if (Session::has('modal'))
      <script type="text/javascript">
        $('#modal-braintree-connect').modal('show');
      </script>
    @endif

    {{-- scripts for modal wizard--}}
    <script type="text/javascript">
      init.push(function () {
        $('.ui-wizard').pixelWizard({
          onChange: function () {
            console.log('Current step: ' + this.currentStep());
          },
          onFinish: function () {
            // Disable changing step. To enable changing step just call this.unfreeze()
            this.freeze();
            console.log('Wizard is freezed');
            console.log('Finished!');
          }
        });

        $('.wizard-next-step-btn').click(function () {
          $(this).parents('.ui-wizard').pixelWizard('nextStep');
        });

        $('.wizard-prev-step-btn').click(function () {
          $(this).parents('.ui-wizard').pixelWizard('prevStep');
        });

        $('.wizard-go-to-step-btn').click(function () {
          $(this).parents('.ui-wizard').pixelWizard('setCurrentStep', 1);
        });
      });
    </script>
    {{-- /scripts for modal wizard--}}
    
  @stop
