@extends('meta.base-user')

  @section('pageContent')

    <div id="content-wrapper">
      <div class="page-header text-center">
        <h1>Connect Braintree</h1>
      </div> <!-- / .page-header -->
      @parent

      <div class="col-md-10 col-md-offset-1">
        {{ Form::open(array(
                'action' => 'ConnectController@doBraintreeConnect',
                'id' => 'form-connect-braintree',
                'role' => 'form',
                'class' => 'form-horizontal' )) }}
          <div class="form-group">
            {{ Form::label('id_environment','Environment:', array(
              'class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-2">
              {{ Form::select('environment',
                // dropdown options
                array(
                  'sandbox' => 'Sandbox', 
                  'production' => 'Production'),
                // highlighted option
                'production',
                array(                                       
                  'id' => 'id_environment',
                  'class' => 'form-control')) }}
            </div>
          </div>
          
          <div class='form-group'>
            {{ Form::label('id_publicKey','Public key:',array(
              'class' => 'col-sm-4 control-label')) }}
            <div class='col-sm-3'>
              {{ Form::text('publicKey','',array(
                'id' => 'id_publicKey',
                'class' => 'form-control')) }}
            </div>
          </div>

          <div class='form-group'>
            {{ Form::label('id_privateKey','Private key:',array(
              'class' => 'col-sm-4 control-label')) }}
            <div class='col-sm-3'>
              {{ Form::text('privateKey','',array(
                'id' => 'id_privateKey',
                'class' => 'form-control')) }}
            </div>
          </div>

          <div class='form-group'>
            {{ Form::label('id_merchantId','Merchant ID:',array(
              'class' => 'col-sm-4 control-label')) }}
            <div class='col-sm-3'>
              {{ Form::text('merchantId','',array(
                'id' => 'id_merchantId',
                'class' => 'form-control')) }}
            </div>
          </div>

          <div class='form-group'>
            <div class='col-sm-2 col-sm-offset-4'>
              {{ Form::submit('Save', array(
                  'id' => 'id_submit',
                  'class' => 'btn btn-primary btn-sm btn-flat',)) }}
            </div>
          </div>
        {{ Form::close() }}

      </div>

    </div>

  @stop

  @section('pageScripts')

    <script type="text/javascript">

    </script>

  @stop
