<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array(
	'as' => 'hello',
	'uses' => 'HelloController@showHello'
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
