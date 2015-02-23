@extends('meta.base-user')

  @section('pageContent')
    <div id="content-wrapper">
      <div class="page-header text-center">
        <h1><i class="fa fa-cogs page-header-icon"></i>&nbsp;&nbsp;Account settings</h1>
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
        <div class="row">
        	<div class="col-sm-6 account-form-wrapper">
            <div class="panel-body account-form bordered getHeight">
              <h4><i class="fa fa-cog"></i>&nbsp;&nbsp;Change your account settings</h4>
              {{ Form::open(array(
                'route'=>'auth.settings',
                'method' => 'post',
                'id' => 'form-settings',
                'role' => 'form',
                'class' => 'panel-padding form-horizontal' )) }}

                <div class="form-group">
                  {{ Form::label('id_name', 'Name', array(
                    'class' => 'col-sm-4 control-label')) }}
                  <div class="col-sm-8">
                    <p class="form-control-static">
                      @if(Auth::user()->name)
                      {{ Auth::user()->name }}
                      @else 
                      N/A
                      @endif
                    </p>
                  </div>
                </div> <!-- / .form-group -->

                <div class="form-group">
                  {{ Form::label('id_country', 'Country', array(
                    'class' => 'col-sm-4 control-label')) }}
                  <div class="col-sm-8">
                    <p class="form-control-static">
                      @if(Auth::user()->zoneinfo)
                      {{ Auth::user()->zoneinfo }}
                      @else 
                      N/A
                      @endif
                    </p>
                  </div>
                </div> <!-- / .form-group -->

                <div class="form-group" id="editEmailForm">
                  {{ Form::label('id_emailedit', 'Email', array(
                    'class' => 'col-sm-4 control-label')) }}
                  <div class="col-sm-8">
                    <p class="form-control-static">
                      {{ Auth::user()->email }}
                      <button id="editEmail" class="btn btn-flat btn-info btn-sm pull-right" type="button">Edit</button>
                    </p>
                  </div>
                </div> <!-- / .form-group -->

                <!-- hidden email change form -->

                <div id="changeEmailForm" class="hidden-form">

                  <div class="form-group @if ($errors->first('email')) has-error @endif">
                    {{ Form::label('id_email', 'New email', array(
                      'class' => 'col-sm-4 control-label')) }}
                    <div class="col-sm-8">
                      {{ Form::text('email', '', array(
                        'id' => 'id_email',
                        'class' => 'form-control')) }}
                    </div>
                  </div> <!-- / .form-group -->

                  <div class="form-group @if ($errors->first('password')) has-error @endif">
                    {{ Form::label('id_password', 'Your password', array(
                      'class' => 'col-sm-4 control-label')) }}
                    <div class="col-sm-8">
                      {{ Form::password('password', array(
                        'id' => 'id_password',
                        'class' => 'form-control')) }}
                    </div>
                  </div> <!-- / .form-group -->

                  <div class="col-sm-8 col-sm-offset-4 text-center padding-xs-vr">
                  {{ Form::submit('Save', array(
                      'id' => 'id_submit',
                      'class' => 'btn btn-primary btn-sm btn-flat')) }}
                  </div>

                </div>

                <!-- / hidden email change form -->

                <div id="editPasswordForm">
                  <div class="form-group">
                    {{ Form::label('id_passwordedit', 'Password', array(
                      'class' => 'col-sm-4 control-label')) }}
                    <div class="col-sm-8">
                      <p class="form-control-static">********
                        <button id="editPassword" class="btn btn-flat btn-info btn-sm pull-right" type="button">Edit</button>
                      </p>
                    </div>
                  </div> <!-- / .form-group -->
                </div>

                <!-- hidden password change form -->

                <div id="changePasswordForm" class="hidden-form">
                  <div class="form-group @if ($errors->first('oldpassword')) has-error @endif">
                    {{ Form::label('id_oldpassword', 'Old password', array(
                      'class' => 'col-sm-4 control-label')) }}
                    <div class="col-sm-8">
                      {{ Form::password('oldpassword', array(
                        'id' => 'id_oldpassword',
                        'class' => 'form-control')) }}
                    </div>
                  </div> <!-- / .form-group -->

                  <div class="form-group @if ($errors->first('newpassword1')) has-error @endif">
                    {{ Form::label('id_newpassword1', 'New password', array(
                      'class' => 'col-sm-4 control-label')) }}
                    <div class="col-sm-8">
                      {{ Form::password('newpassword1', array(
                        'id' => 'id_newpassword1',
                        'class' => 'form-control')) }}
                    </div>
                  </div> <!-- / .form-group -->

                  <div class="form-group @if ($errors->first('newpassword2')) has-error @endif">
                    {{ Form::label('id_newpassword2', 'New password again', array(
                      'class' => 'col-sm-4 control-label')) }}
                    <div class="col-sm-8">
                      {{ Form::password('newpassword2', array(
                        'id' => 'id_newpassword2',
                        'class' => 'form-control')) }}
                    </div>
                  </div> <!-- / .form-group -->

                  <div class="col-sm-8 col-sm-offset-4 text-center padding-xs-vr">
                  {{ Form::submit('Save', array(
                      'id' => 'id_submit',
                      'class' => 'btn btn-primary btn-sm btn-flat')) }}
                  </div>

                </div>

                <!-- hidden password change form -->

                

              {{ Form::close() }}
            </div> <!-- / .panel-body -->
          </div> <!-- / .col-sm-6 -->

          <!-- /Account settings -->

          <!-- Connect a service  -->

        	<div class="col-sm-6 connect-form">
            <div class="panel-body bordered sameHeight">
              <h4><i class="fa fa-link"></i>&nbsp;&nbsp;Select a service to connect</h4>
              <div class="list-group">
                <a href="{{ URL::route('auth.connect') }}" class="list-group-item">
                  <i class="fa icon fa-cc-paypal fa-4x pull-left"></i>
                  <h4 class="list-group-item-heading">PayPal</h4>
                  <p class="list-group-item-text">
                    @if($paypal_connected)
                      <span class="up">Connected.</span>
                    @else 
                      <span class="down">Not connected.</span>
                    @endif
                  </p>
                </a> <!-- / .list-group-item -->
                <a href="{{ URL::route('auth.connect') }}" class="list-group-item">
                  <i class="fa icon fa-cc-stripe fa-4x pull-left"></i>
                  <h4 class="list-group-item-heading">Stripe</h4>
                  <p class="list-group-item-text">
                    @if($stripe_connected)
                      <span class="up">Connected.</span>
                    @else
                      <span class="down">Not connected.</span>
                    @endif
                  </p>
                </a> <!-- / .list-group-item -->
              </div> <!-- / .list-group -->
            </div> <!-- / .panel-body -->
        	</div> <!-- / .col-sm-6 -->
        </div> <!-- / .row -->
        <!-- /Connect a service  -->

      </div> <!-- /. col-md-10 -->
    </div> <!-- / #content-wrapper -->
  @stop

  @section('pageScripts')


    @if (Session::get('errors') || Session::get('error'))
    <script type="text/javascript">
    init.push(function () {
        // if error slide down
        $('#editEmailForm').slideUp('fast', function (){
          $('#changeEmailForm').slideDown('fast');
        });
        $('#editPasswordForm').slideUp('fast', function (){
          $('#changePasswordForm').slideDown('fast');
        });
    });
    </script>
    @endif 

    <script type="text/javascript">
    init.push(function () {
      // event listeners for hidden forms
      $('#editEmail').on('click', function (){
        $('#editEmailForm').slideUp('fast', function (){
          $('#changeEmailForm').slideDown('fast');
        });
      })
      $('#editPassword').on('click', function (){
        $('#editPasswordForm').slideUp('fast', function (){
          $('#changePasswordForm').slideDown('fast');
        });
      })
    });

    </script>

  @stop

  @section('intercomScript')
  <script>
     
  </script>
  {{ HTML::script('js/intercom_io.js'); }}
  @stop