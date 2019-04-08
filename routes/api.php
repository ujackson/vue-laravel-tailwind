<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::namespace ('Api')->group(function () {
    Auth::routes(['verify' => true]);
    Route::get('/email/resend/{uuid}', 'Auth\VerificationController@resend');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/users', 'UserController@index');
        Route::get('/user', 'UserController@show');
        Route::post('/user', 'UserController@update');

    });

});
