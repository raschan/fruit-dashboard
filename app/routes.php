<?php

/*
|--------------------------------------------------------------------------
| Dev routes (these routes are for testing API-s only)
|--------------------------------------------------------------------------
*/

if(!App::environment('production'))
{
    // braintree development routes

    Route::get('/braintree', array(
        'before' => 'api_key',
        'as' => 'dev.braintree',
        'uses' => 'DevController@showBraintree'
    ));

    Route::post('/braintree', array(
        'before' => 'auth|api_key',
        'as' => 'dev.braintree',
        'uses' => 'DevController@doBraintreePayment'
    ));


    Route::get('/users', array(
        'before' => 'auth|api_key',
        'as' => 'dev.users',
        'uses' => 'DevController@showUsers'
    ));

    Route::get('/test', array(
        'uses' => 'DevController@show'
    ));

    Route::get('test', array(
        'as'    => 'dev.test',
        'uses'  => 'HelloController@showTest'
    ));
}

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function()
{
    return Redirect::route('auth.dashboard');
});


// sign up routes
Route::get('signup', array(
    'as' => 'auth.signup',
    'uses' => 'AuthController@showSignup'
));

Route::post('signup', array(
    'as' => 'auth.signup',
    'uses' => 'AuthController@doSignup'
));


// sign in routes
Route::get('signin', array(
    'as' => 'auth.signin',
    'uses' => 'AuthController@showSignin'
));

Route::post('signin', array(
    'as' => 'auth.signin',
    'uses' => 'AuthController@doSignin'
));


// sign out route
Route::any('signout', array(
    'as' => 'auth.signout',
    'uses' => 'AuthController@doSignout'
));


// metric graph routes
Route::get('dashboard', array(
    'before' => 'auth|trial_ended|cancelled|api_key',
    'as' => 'auth.dashboard',
    'uses' => 'AuthController@showDashboard'
));

Route::get('statistics/{statID}', array(
    'before' => 'auth|trial_ended|cancelled|api_key',
    'as' => 'auth.single_stat',
    'uses' => 'AuthController@showSinglestat'
));


// settings routes
Route::get('settings', array(
    'before' => 'auth',
    'as' => 'auth.settings',
    'uses' => 'AuthController@showSettings'
));

Route::post('settingsName', array(
    'before' => 'auth',
    'uses' => 'AuthController@doSettingsName'
));

Route::post('settingsCountry', array(
    'before' => 'auth',
    'uses' => 'AuthController@doSettingsCountry'
));

Route::post('settingsEmail', array(
    'before' => 'auth',
    'uses' => 'AuthController@doSettingsEmail'
));

Route::post('settingsPassword', array(
    'before' => 'auth',
    'uses' => 'AuthController@doSettingsPassword'
));

Route::post('settingsFrequency', array(
    'before' => 'auth',
    'uses' => 'AuthController@doSettingsFrequency'
));



Route::post('cancelSubscription', array(
    'before'    => 'auth',
    'uses'      => 'PaymentController@doCancelSubscription'
));


// connect routes
Route::get('connect', array(
    'before' => 'auth|trial_ended|cancelled',
    'as' => 'connect.connect',
    'uses' => 'ConnectController@showConnect'
));

Route::get('connect/{provider}', array(
    'before' => 'auth|trial_ended|cancelled',
    'uses' => 'ConnectController@connectProvider'
));

Route::post('connectBraintree',array(
    'before'    => 'auth',
    'uses'      => 'ConnectController@doBraintreeConnect'
));

Route::any('import/{provider}',array(
    'before'    => 'auth',
    'uses'      => 'ConnectController@doImport'
));

Route::post('connect', array(
    'before' => 'auth',
    'as' => 'connect.connect',
    'uses' => 'ConnectController@doConnect'
));

Route::post('suggest', array(
    'before' => 'auth',
    'as'    => 'auth.suggest',
    'uses' => 'ConnectController@doSaveSuggestion'
));


// disconnect
Route::get('/disconnect/{service}', array(
    'before' => 'auth|api_key',
    'as' => 'auth.disconnect',
    'uses' => 'ConnectController@doDisconnect'
));


// subscription routes
Route::get('/plans', array(
    'before'    => 'auth',
    'as'        => 'payment.plan',
    'uses'      => 'PaymentController@showPlans'
));

Route::get('/plans/{planName}', array(
    'before'    => 'auth',
    'as'        => 'payment.payplan',
    'uses'      => 'PaymentController@showPayPlan'
));

Route::post('/plans/{planName}', array(
    'before'    => 'auth',
    'as'        => 'payment.payplan',
    'uses'      => 'PaymentController@doPayPlan'
));


// webhook endpoints
Route::get('/api/events/braintree/{webhookId}', array(
    'uses'      => 'WebhookController@verifyBraintreeWebhook',
));

Route::post('/api/events/braintree/{webhookId}', array(
    'uses'      => 'WebhookController@braintreeEvents',
));

/*
|--------------------------------------------------------------------------
| demo Routes
|--------------------------------------------------------------------------
*/

Route::get('demo', array(
    'as' => 'demo.dashboard',
    'uses' => 'DemoController@showDashboard'
));

Route::get('demo/dashboard', array(
    'as' => 'demo.dashboard',
    'uses' => 'DemoController@showDashboard'
));

Route::get('demo/statistics/{statID}', array(
    'as' => 'demo.single_stat',
    'uses' => 'DemoController@showSinglestat'
));
