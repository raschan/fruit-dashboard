<?php

/*
|--------------------------------------------------------------------------
| Dev routes (these routes are for testing API-s only)
|--------------------------------------------------------------------------
*/

Route::get('/rashan', array(
    'before' => 'auth|api_key',
    'as' => 'dev.rashan',
    'uses' => 'HelloController@showRashan'
));

Route::get('/users', array(
    'before' => 'auth|api_key',
    'as' => 'dev.users',
    'uses' => 'HelloController@showUsers'
));

Route::get('/gyt', array(
    'as' => 'dev.gyt',
    'uses' => 'HelloController@showGYT'
));

Route::get('/stripe', array(
    'before' => 'auth|api_key',
    'as' => 'dev.stripe',
    'uses' => 'HelloController@showStripe'
));
Route::post('/stripe', array(
    'before' => 'auth|api_key',
    'as' => 'dev.stripe',
    'uses' => 'HelloController@ajaxGetMrr'
));

Route::get('/paypal', array(
    'before' => 'auth|api_key',
    'as' => 'dev.paypal',
    'uses' => 'HelloController@showPaypal'
));


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

// dashboard route
Route::get('dashboard', array(
    'before' => 'auth',
    'as' => 'auth.dashboard',
    'uses' => 'AuthController@showDashboard'
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

// connect routes

Route::get('connect', array(
    'before' => 'auth',
    'as' => 'auth.connect',
    'uses' => 'AuthController@showConnect'
));

Route::get('connect/{provider}', array(
    'before' => 'auth',
    'uses' => 'AuthController@connectProvider'
));

Route::post('connect', array(
    'before' => 'auth',
    'as' => 'auth.connect',
    'uses' => 'AuthController@doConnect'
));

Route::post('suggest', array(
    'before' => 'auth',
    'as' => 'auth.suggest',
    'uses' => 'AuthController@doSaveSuggestion'
));

// disconnect
Route::get('/disconnect/{service}', array(
    'before' => 'auth|api_key',
    'as' => 'auth.disconnect',
    'uses' => 'AuthController@doDisconnect'
));

// single_stat route

Route::get('statistics/{statID}', array(
    'before' => 'auth',
    'as' => 'auth.single_stat',
    'uses' => 'AuthController@showSinglestat'
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
