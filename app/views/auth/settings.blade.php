@extends('meta.base-user')

  @section('pageContent')
    <div id="content-wrapper">
      <div class="page-header">
        <h1 class="text-center"><i class="fa fa-cogs page-header-icon"></i>&nbsp;&nbsp;Account settings</h1>
      </div> <!-- / .page-header -->
<!-- 
    {{ $errors->first('email') }}
         {{ var_dump($errors) }}
        @foreach ($errors->all() as $error)
        <div>hello</div>
          <div>{{ $error }}</div>
        
        @endforeach -->
      <div class="col-md-10 col-md-offset-1">

        <!-- Account settings -->

      	<div class="col-md-6 account-form-wrapper">
          <div class="panel-body account-form">
            <h4>Change your account settings</h4>
            {{ Form::open(array(
              'route'=>'auth.settings',
              'method' => 'post',
              'id' => 'form-settings',
              'class' => 'horizontal-form',
              'role' => 'form',
              'class' => 'panel-padding' )) }}
              <div class="form-group @if ($errors->first('email')) has-error @endif">
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

              <div class="col-xs-2 col-xs-offset-5 padding-xs-vr">
                {{ Form::submit('Save', array(
                    'id' => 'id_submit',
                    'class' => 'btn btn-success btn-lg btn-flat')) }}
              </div>

            {{ Form::close() }}
          </div> <!-- /. panel-body -->
        </div> <!-- /. col-md-6 -->

        <!-- /Account settings -->

        <!-- Connect a service  -->

      	<div class="col-md-6">
          <div class="panel-body connect-form">
            <h4>Select a service to connect</h4>
            <div class="list-group">
              <a href="{{ URL::route('auth.connect') }}" class="list-group-item">
                <i class="fa icon fa-cc-paypal fa-4x pull-left"></i>
                <h4 class="list-group-item-heading">PayPal</h4>@if($paypal_connected)@else <span class="badge badge-info">Connect it now!</span>@endif
                <p class="list-group-item-text">
                  @if($paypal_connected)
                    <span class="text-success">Connected.</span>
                  @else 
                    <span class="text-danger">Not connected.</span>
                  @endif
                </p>
              </a> <!-- / .list-group-item -->
              <a href="{{ URL::route('auth.connect') }}" class="list-group-item">
                <i class="fa icon fa-cc-stripe fa-4x pull-left"></i>
                <h4 class="list-group-item-heading">Stripe</h4>@if($stripe_connected)@else <span class="badge badge-info">Connect it now!</span>@endif
                <p class="list-group-item-text">
                  @if($stripe_connected)
                    <span class="text-success">Connected.</span>
                  @else
                    <span class="text-danger">Not connected.</span>
                  @endif
                </p>
              </a> <!-- / .list-group-item -->
            </div> <!-- /. list-group -->
          </div> <!-- /. panel-body -->
      	</div> <!-- /. col-md-6 -->

        <!-- /Connect a service  -->

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