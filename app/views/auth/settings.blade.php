@extends('meta.base-user')

  @section('pageContent')
    <div id="content-wrapper">
      <div class="page-header">
        <h1><i class="fa fa-cogs page-header-icon"></i>&nbsp;&nbsp;Account settings</h1>
      </div> <!-- / .page-header -->

      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-success panel-dark">
          <div class="panel-body">
            <h4>Change your account settings</h4>
          	<div class="col-md-6 settings-form">

              {{ Form::open(array(
                'route'=>'auth.settings',
                'method' => 'post',
                'id' => 'form-settings',
                'class' => 'horizontal-form',
                'role' => 'form',
                'class' => 'panel-padding settings-form' )) }}

                  <div class="form-group">
                    {{ Form::label('id_email', 'Email', array(
                      'class' => 'col-xs-4 control-label')) }}
                    <div class="col-xs-8">
                      {{ Form::email('email', Auth::user()->email, array(
                        'id' => 'id_email',
                        'class' => 'form-control')) }}
                    </div>
                  </div> <!-- / .form-group -->

                  <div class="form-group">
                    {{ Form::label('id_password', 'Password', array(
                      'class' => 'col-xs-4 control-label')) }}
                    <div class="col-xs-8">
                      {{ Form::password('password', array(
                        'id' => 'id_password',
                        'class' => 'form-control')) }}
                    </div>
                  </div> <!-- / .form-group -->

                  <div class="col-xs-2 col-xs-offset-10 padding-xs-vr">
                    {{ Form::submit('Save', array(
                        'id' => 'id_submit',
                        'class' => 'btn btn-success btn-lg btn-flat pull-right')) }}
                  </div>

              {{ Form::close() }}

          	</div> <!-- /. settings-form -->

          	<div class="col-md-6 settings-description">
              <div class="connect-form">
              <h4>Connect a service</h4>
              <div class="services-row">
                <a href="{{ URL::route('auth.connect') }}"><i class="fa icon fa-cc-paypal fa-2x"></i></a>
                <span class="text-success">&nbsp;&nbsp;is connected. </span><a href="{{ URL::route('auth.connect') }}">View settings.</a>
              </div>
              <div class="services-row">
                <a href="{{ URL::route('auth.connect') }}"><i class="fa icon fa-cc-stripe fa-2x"></i></a>
                <span class="text-danger">&nbsp;&nbsp;is not yet connected. </span><a href="{{ URL::route('auth.connect') }}">Connect it now!</a>
              </div>
            </div> <!-- /. connect-form -->
          	</div> <!-- /. settings-description -->
            
            

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