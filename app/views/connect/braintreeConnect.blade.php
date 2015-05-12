<div class='wizard'>
  <div class='wizard-wrapper'>
    <ul class='wizard-steps' style='left:0px;'>
      <li data-target='#braintree-connect-step-1' @if($stepNumber==1)class='active'@endif>
        <span class='wizard-step-number'>1</span>
        <span class='wizard-step-caption'>Step 1
          <span class='wizard-step-description'>Credentials</span>
        </span>
      </li>
      <li data-target='#braintree-connect-step-2' @if($stepNumber==2)class='active'@endif>
        <span class='wizard-step-number'>2</span>
        <span class='wizard-step-caption'>Step 2
          <span class='wizard-step-description'>Keep synchronized</span>
        </span>
      </li>
      <li data-target='#braintree-connect-step-3'>
        <span class='wizard-step-number'>3</span>
      </li>
    </ul>
  </div> {{-- /wizard-wrapper --}}
  <div class='wizard-content'>
    <div class='wizard-pane' id='braintree-connect-step-1' @if($stepNumber==1)style='display:block;opacity:1;'@endif>
      <div class='row'>
        <div class='col-sm-7'>
          <p class='lead'>First input and save your Braintree API keys</p>
          <p class='text-danger small'>For added security follow the steps on the right to create a read-only API key in your Braintree account</p>
          {{ Form::open(array(
                  'action' => 'ConnectController@doBraintreeConnect',
                  'id' => 'form-connect-braintree',
                  'role' => 'form',
                  'class' => 'form-horizontal' )) }}
            
            <!-- Environment -->
            <div class="form-group">
              {{ Form::label('id_environment','Environment:', array(
                'class' => 'col-sm-3 control-label')) }}
              <div class="col-sm-4">
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
            <!-- /Environment -->
            
            <!-- Public Key -->
            <div class='form-group'>
              {{ Form::label('id_publicKey','Public key:',array(
                'class' => 'col-sm-3 control-label')) }}
              <div class='col-sm-8'>
                {{ Form::text('publicKey',isset($user->btPublicKey)?$user->btPublicKey:'',array(
                  'id' => 'id_publicKey',
                  'class' => 'form-control',)) }}
              </div>
            </div>
            <!-- /Public Key -->

            <!-- Private Key -->
            <div class='form-group'>
              {{ Form::label('id_privateKey','Private key:',array(
                'class' => 'col-sm-3 control-label')) }}
              <div class='col-sm-8'>
                {{ Form::text('privateKey',isset($user->btPrivateKey)?$user->btPrivateKey:'',array(
                  'id' => 'id_privateKey',
                  'class' => 'form-control')) }}
              </div>
            </div>
            <!-- /Private Key -->

            <!-- Merchant Id -->
            <div class='form-group'>
              {{ Form::label('id_merchantId','Merchant ID:',array(
                'class' => 'col-sm-3 control-label')) }}
              <div class='col-sm-8'>
                {{ Form::text('merchantId',isset($user->btMerchantId)?$user->btMerchantId:'',array(
                  'id' => 'id_merchantId',
                  'class' => 'form-control')) }}
              </div>
            </div>
            <!-- /Merchant Id -->

            <!-- Submit -->
            <div class='form-group'>
              <div class='col-sm-1 col-sm-offset-3'>
                {{ Form::submit('Save', array(
                    'id' => 'id_submit',
                    'class' => 'btn btn-primary btn-sm btn-flat',)) }}
              </div>
            </div>
            <!-- /Submit -->
          {{ Form::close() }}

        </div> {{-- /col-sm-7 --}}
        <div class='col-sm-5'>
          @include('help.read-only')
        </div>
      </div> {{-- /row --}}
    </div> {{-- /braintree-connect-step-1 --}}
    
    <div class='wizard-pane' id='braintree-connect-step-2' @if($stepNumber==2)style='display:block;opacity:1;'@endif>
      <div class='row'>
        <div class='col-sm-7'>
          <p class='lead'>Then add this webhook to keep your data synced</p>
          <strong class='well well-sm text-danger'>{{ URL::to('api/braintree').'/'.$user->id }}</strong>
        </div> {{-- /col-sm-7 --}}
        <div class='col-sm-5'>
          @include('help.webhook-permissions')
        </div>
      </div>{{-- /row --}}
    </div>{{-- /braintree-connect-step-2 --}}
  </div> {{-- /wizard-content --}}
</div> {{-- /wizard --}}

