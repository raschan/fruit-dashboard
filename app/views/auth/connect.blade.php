@extends('meta.base-user')

  @section('pageContent')
    <div id="content-wrapper">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-success panel-dark">
          <div class="panel-heading">
            <span class="panel-title">Connect</span>
          </div>
          <div class="panel-body">

            <!-- PayPal connect-->
            <div class="row">
              <div class="col-md-4 connect-description">
                <div class="service-icon">
                  <a href="http://paypal.com"><i class="fa icon fa-cc-paypal"></i></a>
                </div>
              </div> <!-- /. connect-description -->

              <div class="col-md-8 connect-form">
                {{ Form::open(array(
                  'route'=>'auth.connect',
                  'method' => 'post',
                  'id' => 'form-settings',
                  'class' => 'horizontal-form',
                  'role' => 'form',
                  'class' => 'panel-padding settings-form' )) }}

                    <div class="form-group">
                      {{ Form::label('id_paypal', 'Paypal key:', array(
                        'class' => 'col-xs-4 control-label')) }}
                      <div class="col-xs-8">
                        {{ Form::text('paypal', '', array(
                          'id' => 'id_paypal',
                          'class' => 'form-control')) }}
                      </div>
                    </div> <!-- / .form-group -->

                    <div class="col-xs-2 col-xs-offset-10 padding-xs-vr">
                      {{ Form::submit('Connect', array(
                          'id' => 'id_submit',
                          'class' => 'btn btn-success btn-lg btn-flat pull-right')) }}
                    </div>

                {{ Form::close() }}
              </div> <!-- /. connect-form -->
            </div> <!-- /. row -->
            <!-- /PayPal connect-->

            <!-- stripe connect -->
            <div class="row">
              <div class="col-md-4 connect-description">
                <div class="service-icon">
                  <a href="http://stripe.com"><i class="fa icon fa-cc-stripe"></i></a>
                </div>
              </div> <!-- /. connect-description -->

              <div class="col-md-8 connect-form">
                {{ Form::open(array(
                  'route'=>'auth.connect',
                  'method' => 'post',
                  'id' => 'form-settings',
                  'class' => 'horizontal-form',
                  'role' => 'form',
                  'class' => 'panel-padding settings-form' )) }}

                    <div class="form-group">
                      {{ Form::label('id_stripe', 'Stripe key:', array(
                        'class' => 'col-xs-4 control-label')) }}
                      <div class="col-xs-8">
                        {{ Form::text('stripe', '', array(
                          'id' => 'id_stripe',
                          'class' => 'form-control')) }}
                      </div>
                    </div> <!-- / .form-group -->

                    <div class="col-xs-2 col-xs-offset-10 padding-xs-vr">
                      {{ Form::submit('Connect', array(
                          'id' => 'id_submit',
                          'class' => 'btn btn-success btn-lg btn-flat pull-right')) }}
                    </div>

                {{ Form::close() }}
              </div> <!-- /. connect-form -->
            </div> <!-- /. row -->
            <!-- / stripe connect -->

          </div> <!-- /. panel-body -->
        </div> <!-- /. panel -->
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