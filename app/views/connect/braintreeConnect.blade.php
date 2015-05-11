<div class='modal-body text-center' style='background:white;'>
  <p class='lead'>First input and save your Braintree API keys</p>
  {{ Form::open(array(
          'action' => 'ConnectController@doBraintreeConnect',
          'id' => 'form-connect-braintree',
          'role' => 'form',
          'class' => 'form-horizontal' )) }}
    <div class="form-group">
      {{ Form::label('id_environment','Environment:', array(
        'class' => 'col-sm-5 control-label')) }}
      <div class="col-sm-2">
        {{ Form::select('environment',
          // dropdown options
          array(
            'sandbox' => 'Sandbox', 
            'production' => 'Production'),
          // highlighted option
          isset($user->btEnvironment)?$user->btEnvironment:'production',
          array(                                       
            'id' => 'id_environment',
            'class' => 'form-control')) }}
      </div>
    </div>
    
    <div class='form-group'>
      {{ Form::label('id_publicKey','Public key:',array(
        'class' => 'col-sm-5 control-label')) }}
      <div class='col-sm-3'>
        {{ Form::text('publicKey',isset($user->btPublicKey)?$user->btPublicKey:'',array(
          'id' => 'id_publicKey',
          'class' => 'form-control',)) }}
      </div>
    </div>

    <div class='form-group'>
      {{ Form::label('id_privateKey','Private key:',array(
        'class' => 'col-sm-5 control-label')) }}
      <div class='col-sm-3'>
        {{ Form::text('privateKey',isset($user->btPrivateKey)?$user->btPrivateKey:'',array(
          'id' => 'id_privateKey',
          'class' => 'form-control')) }}
      </div>
    </div>

    <div class='form-group'>
      {{ Form::label('id_merchantId','Merchant ID:',array(
        'class' => 'col-sm-5 control-label')) }}
      <div class='col-sm-3'>
        {{ Form::text('merchantId',isset($user->btMerchantId)?$user->btMerchantId:'',array(
          'id' => 'id_merchantId',
          'class' => 'form-control')) }}
      </div>
    </div>

    <div class='form-group'>
      <div class='text-center'>
        {{ Form::submit('Save', array(
            'id' => 'id_submit',
            'class' => 'btn btn-primary btn-sm btn-flat',)) }}
      </div>
    </div>
  {{ Form::close() }}

  <p class='lead'>Then add this webhook to keep your data synced</p>
  <strong class='well well-sm text-danger'>{{ URL::to('api/braintree').'/'.$user->id }}</strong>
</div>
