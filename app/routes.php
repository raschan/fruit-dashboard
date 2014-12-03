<?php

/*
|--------------------------------------------------------------------------
| Dev routes (these routes are for testing API-s only)
|--------------------------------------------------------------------------
*/
Route::get('/', array(
    'as' => 'hello',
    'uses' => 'HelloController@showHello'
));

Route::get('/stripe', array(
    'before' => 'auth|api_key',
    'as' => 'dev.stripe',
    'uses' => 'HelloController@showStripe'
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