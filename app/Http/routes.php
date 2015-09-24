<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'step_1', 'uses' => 'WelcomeController@index']);

Route::get('/fblogin', ['as'=>'fb_login', 'uses'=> 'FacebookLoginController@index']);

Route::get('/fb_login_response', ['as'=>'fb_login_response', 'uses'=> 'FacebookLoginController@login_response']);