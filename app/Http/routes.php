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

Route::group(['as' => 'welcome::', 'prefix' => 'welcome'], function () {
    Route::get('response', ['as' => 'response', 'uses' => 'WelcomeController@response']);
});

Route::group(['as' => 'campaign::', 'prefix' => 'campaign'], function () {
    Route::get('/{id}', ['as' => 'show', 'uses' => 'CampaignsController@show']);

    Route::group(['as' => 'action::', 'prefix' => 'action'], function () {
        Route::get('savemail', ['as' => 'save_mail', 'uses' => 'CampaignsController@saveMail']);
    });
});

Route::group(['as' => 'interaction::'], function () {

    /* Logs */
    Route::group(['as' => 'logs::', 'middleware' => 'ajax', 'prefix' => 'interaction'], function () {
        Route::group(['prefix' => 'logs'], function () {
            // Route::match(['get', 'post'], 'welcome', ['as' => 'welcome', 'uses' => 'InteractionsController@welcome']);
            Route::match(['get', 'post'], 'joined', ['as' => 'joined', 'uses' => 'InteractionsController@joined']);
            Route::match(['get', 'post'], 'requested', ['as' => 'requested', 'uses' => 'InteractionsController@requested']);
            Route::match(['get', 'post'], 'loaded', ['as' => 'loaded', 'uses' => 'InteractionsController@loaded']);
            Route::match(['get', 'post'], 'completed', ['as' => 'completed', 'uses' => 'InteractionsController@completed']);
        });
    });
});

/* ---- routes testing ---- */

Route::get('/fblogin', ['as' => 'fb_login', 'uses' => 'FacebookLoginController@index']);
Route::get('/captcha', ['as' => 'step_2', 'uses' => 'CampaignsController@captcha']);
Route::get('/fb_login_response', ['as' => 'fb_login_response', 'uses' => 'FacebookLoginController@login_response']);

//Route::get('/banner/{id_campaign}', ['as' => 'step_3', 'uses' => 'InteractionsController@requested']);
Route::get('/banner/{id_campaign}', ['as' => 'step_3', 'uses' => 'CampaignsController@prueba']);
Route::get('/mailing/{id_campaign}', ['as' => 'mailing', 'uses' => 'CampaignsController@pruebaMailing']);

