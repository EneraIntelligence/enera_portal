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

Route::match(['post', 'get'], '/', ['as' => 'welcome', 'uses' => 'WelcomeController@index']);
Route::match(['post', 'get'], '/guest', ['as' => 'welcome', 'uses' => 'WelcomeController@index']);
Route::match(['post', 'get'], '/guest/s/default', ['as' => 'welcome', 'uses' => 'WelcomeController@index']);

Route::match(['post', 'get'], '/ads', ['as' => 'ads', 'uses' => 'WelcomeController@ads']);
Route::match(['post', 'get'], '/radius-connect', ['as' => 'radius-connect', 'uses' => 'WelcomeController@radius']);

Route::match(['post', 'get'], '/demo', ['as' => 'demo', 'uses' => 'DemoController@index']);
Route::match(['post', 'get'], '/demo/login', ['as' => 'login', 'uses' => 'DemoController@login']);
Route::match(['post', 'get'], '/demo/like', ['as' => 'like', 'uses' => 'DemoController@like']);
Route::match(['post', 'get'], '/demo/banner_link', ['as' => 'banner_link', 'uses' => 'DemoController@banner_link']);
Route::match(['post', 'get'], '/demo/mailing_list', ['as' => 'mailing_list', 'uses' => 'DemoController@mailing_list']);
Route::match(['post', 'get'], '/demo/captcha', ['as' => 'captcha', 'uses' => 'DemoController@captcha']);
Route::match(['post', 'get'], '/demo/encuesta', ['as' => 'encuesta', 'uses' => 'DemoController@encuesta']);
Route::match(['post', 'get'], '/demo/video', ['as' => 'video', 'uses' => 'DemoController@video']);

Route::match(['post', 'get'], '/auth', ['as' => 'openMeshAuth', 'uses' => 'OpenMeshController@openMeshAuth']);

Route::group(['middleware' => 'FbLogin'], function () {
    Route::group(['as' => 'welcome::', 'prefix' => 'welcome'], function () {
        Route::get('response', ['as' => 'response', 'uses' => 'WelcomeController@response']);
    });

    Route::group(['as' => 'campaign::', 'prefix' => 'campaign'], function () {
        Route::get('/{id}', ['as' => 'show', 'uses' => 'CampaignsController@show']);

        Route::group(['as' => 'action::', 'middleware' => 'ajax', 'prefix' => 'action'], function () {
            Route::match(['get', 'post'], 'saveMail', ['as' => 'saveMail', 'uses' => 'CampaignsController@saveMail']);
            Route::match(['get', 'post'], 'saveUserLike', ['as' => 'saveUserLike', 'uses' => 'CampaignsController@saveUserLike']);
        });
    });
});

Route::group(['as' => 'interaction::'], function () {

    /* Logs */
    Route::group(['as' => 'logs::', 'middleware' => 'ajax', 'prefix' => 'interaction'], function () {
        Route::group(['prefix' => 'logs'], function () {
            Route::match(['get', 'post'], 'welcome_loaded', ['as' => 'welcome_loaded', 'uses' => 'WelcomeController@welcome_loaded']);
            Route::match(['get', 'post'], 'joined', ['as' => 'joined', 'uses' => 'InteractionsController@joined']);
            // Route::match(['get', 'post'], 'requested', ['as' => 'requested', 'uses' => 'InteractionsController@requested']);
            Route::match(['get', 'post'], 'loaded', ['as' => 'loaded', 'uses' => 'InteractionsController@loaded']);
            Route::match(['get', 'post'], 'completed', ['as' => 'completed', 'uses' => 'InteractionsController@completed']);
            Route::match(['get', 'post'], 'accessed', ['as' => 'accessed', 'uses' => 'InteractionsController@accessed']);

            Route::match(['get', 'post'], 'saveUserSurvey', ['as' => 'saveUserSurvey', 'uses' => 'InteractionsController@saveUserSurvey']);

        });
    });
});

/* ---- routes testing ---- */
Route::get('testing', function () {
    dd($var);
});
