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



Route::auth();

Route::get('/2fa/login', 'Google2FAController@getLogin');
Route::post('/2fa/login', 'Google2FAController@postLogin');


Route::get('/instascan', 'HomeController@instascan');

Route::get('/test', 'HomeController@test');


Route::group(['middleware' => 'csrf', "middleware" => "my_currency"], function($router)
{

    Route::get('/2fa/enable', ['middleware' => 'auth', 'uses' => 'Google2FAController@enableTwoFactor']);
    Route::post('/2fa/enable', ['middleware' => 'auth', 'uses' => 'Google2FAController@storeTwoFactor']);

    Route::get('/', 'WalletController@getWallet');
    Route::get('/home', 'WalletController@getWallet');
    Route::get('/wallet', 'WalletController@getWallet');
    Route::get('/history', 'WalletController@getHistory');
    Route::get('/send', 'WalletController@getSend');
    Route::post('/send', 'WalletController@postSend');
});



