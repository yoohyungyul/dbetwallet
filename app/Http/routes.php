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






Route::group(['middleware' => 'csrf', "middleware" => "my_currency"], function($router)
{

    Route::auth();
    // Route::get('login', 'Auth\AuthController@getLogin');
    // Route::post('login', ['middleware' => 'GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:5,1', 'uses' => 'Auth\AuthController@postLogin']);

	// Route::get('logout', 'Auth\AuthController@getLogout');
	// Route::get('register', 'Auth\AuthController@getRegister');
	// Route::post('register',  ['middleware' => 'GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:5,1', 'uses' => 'Auth\AuthController@postRegister']);
    
    
    
    Route::get('/', 'WalletController@getWallet');
    Route::get('/home', 'HomeController@index');
    Route::get('/wallet', 'WalletController@getWallet');
    Route::get('/history', 'WalletController@getHistory');
    Route::get('/send', 'WalletController@getSend');
});



