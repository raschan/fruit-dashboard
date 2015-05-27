@extends('meta.base-user')

@section('pageContent')

<div id="content-wrapper">

  <div class="page-header text-center">
    <h1><i class="fa fa-link page-header-icon"></i>&nbsp;&nbsp;Connect a service</h1>
  </div> <!-- / .page-header -->
  @parent

    <!-- Connect a service  -->

    <div class="col-md-10 col-md-offset-1">
      <div class="row">
       <div class="col-sm-6 col-md-offset-3 connect-form">
        <div class="panel-body bordered sameHeight">
          <h4><i class="fa fa-link"></i>&nbsp;&nbsp;Manage connections</h4>
          <div class="list-group">

            {{-- 
            <!-- hidden for development, will not be rendered on client side -->   
            <a href="{{ URL::route('connect.connect') }}" class="list-group-item">
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
            <!-- / hidden for development, will not be rendered on client side -->
            --}}   

            <!-- stripe connect start -->
            <div class="list-group-item">
              <i class="fa icon fa-cc-stripe fa-4x pull-left"></i>
              @if($stripe_connected)
              <a href="{{ URL::route('auth.disconnect', 'stripe') }}">
                <button id="editName" class="btn btn-flat btn-info btn-sm pull-right" type="button">Disconnect</button>
              </a>  
              @else
              <a href="{{ $stripeButtonUrl }}">
                <button id="editName" class="btn btn-flat btn-info btn-sm pull-right" type="button">Connect</button>
              </a>  
              @endif
              <h4 class="list-group-item-heading">Stripe</h4>
              <p class="list-group-item-text">
                @if($stripe_connected)
                <span class="up">Connected.</span>
                @else
                <span class="down">Not connected.</span>
                @endif
              </p>
            </div>
            <!-- stripe connect end -->

            <!-- google spreadsheet connect start -->
            <div class="list-group-item">
              <i class="fa icon fa-google fa-4x pull-left"></i>
              @if($googlespreadsheet_connected)
              <a href="{{ URL::route('auth.disconnect', 'googlespreadsheet') }}">
                <button id="editName" class="btn btn-flat btn-info btn-sm pull-right" type="button">Disconnect</button>
              </a>  
              @else
              <a href="{{ $googleSpreadsheetButtonUrl }}">
                <button id="editName" class="btn btn-flat btn-info btn-sm pull-right" type="button">Connect</button>
              </a>  
              @endif
              <h4 class="list-group-item-heading">Google Spreadsheet</h4>
              <p class="list-group-item-text">
                @if($googlespreadsheet_connected)
                <span class="up">Connected.</span>
                @else
                <span class="down">Not connected.</span>
                @endif
              </p>
            </div>
            <!-- google spreadsheet connect end -->
          </div> <!-- / .list-group -->
        </div> <!-- / .panel-body -->
      </div> <!-- / .col-sm-6 -->
    </div> <!-- / .row -->
    <!-- /Connect a service  -->

    <br/>

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

