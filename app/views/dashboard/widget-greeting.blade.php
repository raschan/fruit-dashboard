<li class="dashboard-widget grey-hover no-padding" data-id='{{ $id }}'  data-row="{{ $position['row'] }}" data-col="{{ $position['col'] }}" data-sizex="{{ $position['x'] }}" data-sizey="{{ $position['y'] }}">
	<!--a class='link-button' href='' data-toggle="modal" data-target='#widget-settings-{{ $id }}'><span class="gs-option-widgets"></span></a-->
	<a href="{{ URL::route('connect.deletewidget', $id) }}">
    <span class="gs-close-widgets"></span>
  </a>
  <!-- If user is registered -->
  @if (Auth::user()->id != 1)
  	<p class='greetings-text white-text textShadow text-center'>Good <span class='greeting'></span>
      @if(isset(Auth::user()->name)), <input id="userName" value="{{ Auth::user()->name }}" class="form-control white-text textShadow text-center userName" name="userName" type="text">@endif!
    </p>
  <!-- If user is not registered -->  
  @else 
    <p class='greetings-text white-text textShadow text-center'>
      
      <div class="yourname-form">
      <span id="yourNameId" class="greetings-text white-text textShadow text-center">What's your name?</span>
      <!-- Form -->
      {{ Form::open(array('action' => 'AuthController@doSignupOnDashboard', 'id' => 'signup-form_id' )) }}
        {{ Form::text('name', Input::old('name'), array('autofocus' => true, 'autocomplete' => 'off', 'class' => 'form-control input-lg greetings-text white-text textShadow text-center userName', 'id' => 'username_id')) }}
        <button type="button" id="signup-next" class="btn btn-flat btn-info btn-sm">Next</button>
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
            'class' => 'btn btn-success',
            'onClick' => '_gaq.push(["_trackEvent", "Signup", "Button Pushed"]);mixpanel.track("Signup");')) }}
            <span class="white-text">or <a class="white-text" href="signin">Login here</a></span>
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
    function saveUserName(event) {
      var keycode = (event.keyCode ? event.keyCode : event.which);
      if(keycode == '13'){
        event.preventDefault();  
      }          
      var newName = $(event.target).val();
      if (newName) {
        $.ajax({
          type: 'POST',
          url: '/widgets/settings/username/' + newName,
          success:function(message,code){
          }
        });            
      }
    }
    $('#userName').keyup(_.debounce(saveUserName,1000));
  });
// if user is not registered, signup form
@else 
  init.push(function () {
    @if (Session::get('error'))
      $('.yourname-form').slideUp('fast', function (){
        $('.signup-form').slideDown('fast');
      });
    @endif
    $('#username_id').on('keydown', function (event){
      var keycode = (event.keyCode ? event.keyCode : event.which);
      if(keycode == '13'){
        event.preventDefault();
        $('#signup-next').click();
      }    
    });
    $('#signup-next').on('click', function (){
      $('.yourname-form').slideUp('fast', function (){
        $('.signup-form').slideDown('fast', function() {
          $('#email_id').focus();
        });
      });
    });
  });
@endif
</script> 