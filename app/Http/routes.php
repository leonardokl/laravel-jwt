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

Route::get('/', function () {
    return view('index');
});

//Rotas começam com api/
Route::group(['prefix' => 'api'], function()
{
	Route::any('', function() 
	{
		return 'API - Submissões PRPI';
	});
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');

    Route::group(['prefix' => 'user'], function()
    {
    	Route::get('', 'UserController@allUsers');   	

    	Route::get('{id}', 'UserController@getUser');

    	Route::post('', 'UserController@saveUser');

    	Route::put('{id}', 'UserController@updateUser');

    	Route::delete('{id}', 'UserController@deleteUser');
    });
});


/* Testes */
Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});

Route::get('test/{id}', function ($id) {
    return "Test: $id";
});

Route::get('test/opcional/{id?}', function ($id = 'opcional') {
    return "Opcional: $id";
});
