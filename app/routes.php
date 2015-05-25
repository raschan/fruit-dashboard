<?php

/*
|--------------------------------------------------------------------------
| Dev routes (these routes are for testing API-s only)
|--------------------------------------------------------------------------
*/

if(App::environment('local', 'development'))
{
    // braintree development routes

    Route::get('/braintree', array(
        'before' => 'auth|api_key',
        'as' => 'dev.braintree',
        'uses' => 'HelloController@showBraintree'
    ));

    Route::post('/braintree', array(
        'before' => 'auth|api_key',
        'as' => 'dev.braintree',
        'uses' => 'HelloController@doBraintreePayment'
    ));


    Route::get('/users', array(
        'before' => 'auth|api_key',
        'as' => 'dev.users',
        'uses' => 'HelloController@showUsers'
    ));

    Route::get('/paypal', array(
        'before' => 'auth|api_key',
        'as' => 'dev.paypal',
        'uses' => 'HelloController@showPaypal'
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


// dashboard routes
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
    'uses'      => 'AuthController@doCancelSubscription'
));


// connect routes
Route::get('connect', array(
    'before' => 'auth|trial_ended|cancelled',
    'as' => 'connect.connect',
    'uses' => 'ConnectController@showConnect'
));

Route::any('connect/{provider}/{step?}', array(
    'before' => 'auth|trial_ended|cancelled',
    'uses' => 'ConnectController@connectProvider'
));

Route::any('connect.addwidget/{provider?}', array(
    'before' => 'auth',
    'as'    => 'connect.addwidget',
    // 'uses' => 'ConnectController@addWidget'
    'uses' => 'ConnectController@connectProvider'
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

// delete widget
Route::any('connect.deletewidget/{widget_id}', array(
    'before' => 'auth',
    'as' => 'connect.deletewidget',
    'uses' => 'ConnectController@deleteWidget'
));


// subscription routes
Route::get('/plans', array(
    'before'    => 'auth',
    'as'        => 'auth.plan',
    'uses'      => 'AuthController@showPlans'
));

Route::get('/plans/{planName}', array(
    'before'    => 'auth',
    'as'        => 'auth.payplan',
    'uses'      => 'AuthController@showPayPlan'
));

Route::post('/plans/{planName}', array(
    'before'    => 'auth',
    'as'        => 'auth.payplan',
    'uses'      => 'AuthController@doPayPlan'
));


// adding a key to a user
Route::get('addkey', array(
    'as' => 'auth.addkey',
    'before' => 'auth',
    'uses' => 'AuthController@showAddKey'
));

Route::post('addkey', array(
    'as' => 'auth.addkey',
    'before' => 'auth',
    'uses' => 'AuthController@doAddKey'
));

/*
|--------------------------------------------------------------------------
| demo Routes
|--------------------------------------------------------------------------
*/

// single_stat
Route::get('demo/statistics/{statID}', array(
    'as' => 'demo.single_stat',
    'uses' => 'DemoController@showSinglestat'
));

Route::get('demo', array(
    'as' => 'demo.dashboard',
    'uses' => 'DemoController@showDashboard'
));

// dashboard route
Route::get('demo/dashboard', array(
    'as' => 'demo.dashboard',
    'uses' => 'DemoController@showDashboard'
));
