<?php

/*
|--------------------------------------------------------------------------
| Dev routes (these routes are for testing API-s only)
|--------------------------------------------------------------------------
*/
Route::get('/', function()
{
    return Redirect::route('auth.dashboard');
});

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

Route::get('/paypal/buildToken', array(
    'before' => 'auth',
    'as' => 'paypal.buildToken',
    'uses' => 'PaypalController@createRefreshToken'
));

Route::get('/paypal/createplan', array(
    'before' => 'auth|api_key',
    'as' => 'paypal.createPlan',
    'uses' => 'PaypalController@showCreatePlan'
));

Route::post('/paypal/createplan', array(
    'before' => 'auth|api_key',
    'as' => 'paypal.createPlan',
    'uses' => 'PaypalController@doCreatePlan'
));

Route::get('/paypal/deleteplan/{id}', array(
    'before' => 'auth|api_key',
    'as' => 'paypal.deleteplan',
    'uses' => 'PaypalController@doDeletePlan'
));

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

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

Route::post('settings', array(
    'before' => 'auth',
    'as' => 'auth.settings',
    'uses' => 'AuthController@doSettings'
));

// connect routes

Route::get('connect', array(
    'before' => 'auth',
    'as' => 'auth.connect',
    'uses' => 'AuthController@showConnect'
));

Route::post('connect', array(
    'before' => 'auth',
    'as' => 'auth.connect',
    'uses' => 'AuthController@doConnect'
));

// single_stat route

Route::get('statistics', array(
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
| Paypal Routes
|--------------------------------------------------------------------------
*/

// get paypal information
Route::get('paypalinformation', array(
    'before' => 'auth',
    'as' => 'dev.paypalinfo',
    'uses' => 'PaypalController@showPaypalInfo'
));

// go to paypal login
Route::get('paypallogin', array(
    'as' => 'dev.paypallogin',
    'uses' => 'PaypalController@loginWithPaypal'
));

// get paypal user information
Route::get('paypaluserinfo', array(
    'as' => 'dev.paypaluserinfo',
    'uses' => 'PaypalController@showUserInfo'
));
