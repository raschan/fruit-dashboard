<li class="dashboard-widget grey-hover no-padding" data-id='{{ $id }}'  data-row="{{ $position['row'] }}" data-col="{{ $position['col'] }}" data-sizex="{{ $position['x'] }}" data-sizey="{{ $position['y'] }}">
	<!--a class='link-button' href='' data-toggle="modal" data-target='#widget-settings-{{ $id }}'><span class="gs-option-widgets"></span></a-->
	<a href="{{ URL::route('connect.deletewidget', $id) }}">
    <span class="gs-close-widgets"></span>
  </a>
  <!-- If user is registered -->
  @if (Auth::user()->id != 1)
  	<p class='greetings-text white-text textShadow text-center'>Good <span class='greeting'></span>
      @if(isset(Auth::user()->name)), {{ Auth::user()->name }} <input id="userName" class="form-control" name="userName" type="text">@endif!
    </p>
  <!-- If user is not registered -->  
  @else 
    <p class='greetings-text white-text textShadow text-center'>
      
      <div class="yourname-form">
      What's your name?
      <!-- Form -->
      {{ Form::open(array('action' => 'AuthController@doSignupOnDashboard', 'id' => 'signup-form_id' )) }}
        {{ Form::text('name', Input::old('name'), array('autofocus' => true, 'class' => 'form-control input-lg', 'id' => 'username_id')) }}
        <button type="button" id="signup-next">Next</button>
      </div>

      <div class="signup-form hidden-form">
        <div class="form-group">
          {{ Form::text('email', Input::old('email'), array('placeholder' => 'Email@provider.com', 'class' => 'form-control input-lg', 'id' => 'email_id')) }}
        </div> <!-- / Username -->

        <div class="form-group">
          {{ Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control input-lg', 'id' => 'password_id')) }}
        </div> <!-- / Password -->

        <div class="form-actions">
          {{ Form::submit('Sign up' , array(
            'id' => 'id_submit',
            'class' => 'signin-btn bg-primary',
            'onClick' => '_gaq.push(["_trackEvent", "Signup", "Button Pushed"]);mixpanel.track("Signup");')) }}
            or login here
            <!-- <a href="#" class="forgot-password" id="forgot-password-link">Forgot your password?</a> -->
          </div> <!-- / .form-actions -->
          {{ Form::close() }}
      </div>

    </p>
  @endif
</li>

@section('pageModals')
	<!-- greetings settings -->
	
	@include('settings.widget-settings')

	<!-- /greetings settings -->
@append
<script type="text/javascript">
// if user is registered, saveUserName function
@if (Auth::user()->id != 1)
  init.push(function () {
    function saveUserName(ev) {          
      var newName = $(ev.target).val();
      if (newName) {
        $.ajax({
          type: 'POST',
          url: '/widgets/settings/username/' + newName,
          success:function(message,code){
          }
        });            
      }
    }
    $('#userName').keyup(_.debounce(saveUserName,500));
  });
// if user is not registered, signup form
@else 
  init.push(function () {
    $('#signup-next').on('click', function (){
      $('.yourname-form').slideUp('fast', function (){
        $('.signup-form').slideDown('fast');
      });
    });
  });
@endif
</script> 