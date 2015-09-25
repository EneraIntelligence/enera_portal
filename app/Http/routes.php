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

Route::get('/', ['as' => 'welcome', 'uses' => 'WelcomeController@index']);

Route::group(['as' => 'campaign::', 'prefix' => 'campaign'], function () {
    Route::get('/{id}', ['as' => 'show', 'uses' => 'CampaignsController@show']);
});

Route::group(['as' => 'interaction::'], function () {

    /* Logs */
    Route::group(['as' => 'logs::', 'middleware' => 'ajax', 'prefix' => 'interaction'], function () {
        Route::group(['prefix' => 'logs'], function () {
            Route::match(['get', 'post'], 'welcome', ['as' => 'welcome', 'uses' => 'InteractionsController@welcome']);
            Route::match(['get', 'post'], 'joined', ['as' => 'joined', 'uses' => 'InteractionsController@joined']);
        });
    });
});

/* ---- routes testing ---- */

Route::get('/fblogin', ['as' => 'fb_login', 'uses' => 'FacebookLoginController@index']);

Route::get('/fb_login_response', ['as' => 'fb_login_response', 'uses' => 'FacebookLoginController@login_response']);